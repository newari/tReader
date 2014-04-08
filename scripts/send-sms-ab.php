<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	if(isset($_GET['test_id'])&&isset($_GET['batch'])){
		$test_id=$_GET['test_id'];
		$batch=$_GET['batch'];
		include_once("./classes/db.class.php");
		$dbh=new db();
		$dbh->select("tests", "minor_name", "test_id='$test_id'", "none", "1");
		$minor_name=$dbh->select_res['minor_name'];
		$dbh->select("students", "id, fname, roll_no, mobile, mobile_p, sms_sent", "batch='$batch'", "none", "none");
		$total_students=$dbh->sel_count_row;
		$absent_students=0;
		$present_student=0;
		if($total_students>0){
			foreach($dbh->select_res as $std){
				$std_id=$std['id'];
				$roll_no=$std['roll_no'];
				$fname=$std['fname'];
				$img_src=$std['img_src'];
				$mobile=$std['mobile'];
				$mobile_p=$std['mobile_p'];
				$sms_sent=$std['sms_sent'];
				
				$dbh->select("scaned_omrs", "id", "test_id='$test_id' AND std_roll_no='$roll_no'", "none", "1");
				if($dbh->sel_count_row>0){
					$present_student++;
				}else{
					$absent_students++;
					$name_arr=explode(" ", $fname);
					$fname=$name_arr[0];
					$sms_sent_arr=explode(",", $sms_sent);
					if(!in_array($test_id, $sms_sent_arr)){
						$ch = curl_init();
						$user="sunil.newari%40gmail.com:newari%40339";
						$receipientno=$mobile_p.",".$mobile; 
						$senderID="SMRPAN"; 
						$msgtxt='Dear Guardian, Rank of your child '.$fname.' in '.$minor_name.' is '.$rank.' %26 Percentage Marks is '.$percentage.' . Regards Samarpan Career Institute.';
						curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
						$buffer = curl_exec($ch);
						if(empty ($buffer))
						{ $buffer=" buffer is empty ";
							$not_send_list.=$mobile.",";
	                                                   
						 }else{
	                        $new_sms_sent=$sms_sent.",".$test_id;              
	                        $dbh->update("students", "sms_sent='$new_sms_sent'", "id='$std_id'", "1");
						 	$i++;
						 }
						curl_close($ch);
					}
				
					
				}
			}
			header("Location:../check-attendance.php?msg=SMS Sent to total ".$absent_students."(".$i.") students.&msg_clr=green");
			exit();

		}else{
			header("Location:../check-attendance.php?msg=Error! This test ID does not have valid batch name. Mistake during New Test Creation.");
			exit();
		}

	}else{
		header("Location:../check-attendence.php?msg=Please fill all the fields");
		exit();
	}
}else{
	header("Location:../admin-login.php?msg=Session expired&msg_clr=red");
	exit();
}


?>