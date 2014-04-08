<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	if(isset($_POST['test_id'])){
		$test_id=$_POST['test_id'];
		include_once("../classes/db.class.php");
		include_once("../classes/sms.class.php");
		$sms=new sms();
		$dbh=new db();
		$dbh->select("tests", "id, test_name, minor_name, max_score, sms_sent", "test_id='$test_id'", "none", "1");
		$not_send_list='';
		if($dbh->sel_count_row>0){
			$test_pid=$dbh->select_res['id'];
			$test_name=$dbh->select_res['test_name'];
			$minor_name=$dbh->select_res['minor_name'];
			$max_score=$dbh->select_res['max_score'];
			$sms_sent=$dbh->select_res['sms_sent'];
			$filename="../SMS Sent Files/".$test_id.".csv";
			$sno=1;
			if($sms_sent<500){
				ini_set('max_execution_time', 1200);
				$dbh->select("scaned_omrs", "id, std_roll_no, total_score, rank", "test_id='$test_id' AND sms_sent='0'", "none", "none");
				if($dbh->sel_count_row>0){
					if($dbh->sel_count_row==1){
						$stds[0]=$dbh->select_res;
					}else{
						$stds=$dbh->select_res;
					}
					$handle = fopen($filename, 'w+');
					fputcsv($handle, array('SR', 'Roll NO', 'STUDENT NAME', 'MOBILE', 'MESSAGE', 'STATUS', 'REF', 'DELIVERED'));
			
					$sent_no=0;
					$i=0;
					$i=0;
					foreach($stds as $std){
                        $id=$std['id'];
						$roll_no=$std['std_roll_no'];
						$total_score=$std['total_score'];
						$rank=" ".$std['rank'];
						$percentage=($total_score/$max_score)*100;
						$percentage=substr($percentage, 0, 5);
						$dbh->select("students", "fname, mobile", "roll_no='$roll_no'", "none", "1");
						if($dbh->sel_count_row>0){
							$name_arr=explode(" ", $dbh->select_res['fname']);
							$fname=$name_arr[0];
							$mobile=$dbh->select_res['mobile'];
							$msgtxt='Dear Guardian, Rank of your child '.$fname.' in '.$minor_name.' is '.$rank.'  & Percentage Marks is '.$percentage.' . Regards Samarpan Career Institute.';

							$vars_arr=array('mobile'=>$mobile, 'name'=>$fname, 'rank'=>$rank, 'per'=>$percentage, 'minor_name'=>$minor_name);
							$res=$sms->send_result_sms($vars_arr);
							print_r($res);
							if($res['type']!='success'){ 
								$not_send_list.=$mobile.",";
								fputcsv($handle, array($sno, $roll_no, $fname, $mobile, $msgtxt, $res['type'], $res['message'], 'NO'));
							 }else{
	                            $dbh->update("scaned_omrs", "sms_sent='1'", "id='$id'", "1");
							 	$i++;
								fputcsv($handle, array($sno, $roll_no, $fname, $mobile, $msgtxt, $res['type'], $res['message'], 'YES'));
							 }
							 curl_close($ch);
						}else{
							fputcsv($handle, array($sno, $roll_no, 'Student of this roll No. Not added yet.', 'Not available', '', 'ERROR: Mobile no does not exist.', 'Mobile no does not exist.', 'NO'));
						}
					 	$sno++;
					}
					$total_sent=$i+$sms_sent;
					$dbh->update("tests", "sms_sent='$total_sent'", "id='$test_pid'", "1");
					header("Location:../send-sms.php?msg=SMS send successfully!&msg_clr=green");
					exit();
				}else{
					header("Location:../send-sms.php?msg=SMS has been sent to all the students of this test already.&msg_clr=green");
					exit();
				}
			}else{
				header("Location:../send-sms.php?msg=SMS Has been sent for this test ID to".$sms_sent." Total ".$sms_sent." Mobile Nos. &msg_clr=orange");
				exit();
			}	
		}else{
			header("Location:../send-sms.php?msg=Error! This test id does not exist. Please try again.");
			exit();
		}
	}else{
        header("Location:../send-sms.php?msg=Error! Test ID Problems. Please try again.");
		exit();
    }
}else{
	header("Location:../admin-login.php?msg=Sessio expired&msg_clr=red");
	exit();
}





?>
