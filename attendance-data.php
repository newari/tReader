<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	if(isset($_POST['test_id'])&&isset($_POST['batch'])){
		$test_id=$_POST['test_id'];
		$batch=$_POST['batch'];
		include_once("./classes/db.class.php");
		include_once("./classes/main.class.php");
		$main=new main();
		$main->show_msg();
		$dbh=new db("triaasco_omr");
		$batch=strtoupper($batch);
		$dbh->select("students", "fname, lname, roll_no, img_src, mobile, mobile_p", "batch='$batch'", "none", "none");
		$total_students=$dbh->sel_count_row;
		$absent_students=0;
		$present_student=0;
		$absent_list='<table class="table table-bordered"><thead><tr><th>SR</th><th>Student Name</th><th>Roll No</th><th>Photo</th><th>Mobile</th><th>Mobile Parent</th></tr></thead><tbody>';
		if($total_students>0){
			foreach($dbh->select_res as $std){
				$roll_no=$std['roll_no'];
				$fname=$std['fname'];
				$lname=$std['lname'];
				$img_src=$std['img_src'];
				$mobile=$std['mobile'];
				$mobile_p=$std['mobile_p'];
				if(file_exists("./images/studemnts/".$img_src)){
					$img_src="./images/studemnts/".$img_src;
				}else{
					$img_src="./images/default-pic.jpg";
				}
				$dbh->select("scaned_omrs", "id", "test_id='$test_id' AND std_roll_no='$roll_no'", "none", "1");
				if($dbh->sel_count_row>0){
					$present_student++;
				}else{
					$absent_students++;
					$absent_list.='<tr><td>'.$absent_students.'</td><td>'.$fname.'</td><td>'.$roll_no.'</td><td><img src="'.$img_src.'" width="100"></td><td>'.$mobile.'</td><td>'.$mobile_p.'</td></tr>';
				}
			}

			$absent_list.='</tbody></table>';
			$main_content='<div class="row-fluid">
				<div class="span3 well alignC">
					<b>Batch Name of this test:</b> '.$batch.'
				</div>	
				<div class="span3 well alignC">
					<b>Total students in this batch:</b> '.$total_students.'
				</div>	
				<div class="span3 well alignC">	
					<b>Batch present students in this test:</b> '.$present_student.'
				</div>	
				<div class="span3 well alignC">	
					<b>Batch absent students in this test:</b> '.$absent_students.'
				</div>
				<div class="span11 marginl0">
					<h3 class="alignC">Absent students in this test</h3>
				</div>
				<div class="span1 well alignC btn btn-success" onclick=goto("scripts/send-sms-ab.php?test_id='.$test_id.'&batch='.$batch.'")>	
					<b>Send SMS</b>
				</div>
				<div class="span12">
					'.$absent_list.'
				</div>
			</div>';

			$vars=array(
				"page"=>array(
					"msg"=>$main->msg,
					"msg_cls"=>$main->msg_cls,
					"metad"=>"Coaching students.",
					"title"=>"Absent Students | t-Reader",
					"srcext"=>"../../",
					"main_content"=>$main_content,
					)
				);
			$main->display("pages/omre-blank.ta", $vars);
		}else{
			header("Location:./check-attendance.php?msg=Error! This test ID does not have valid batch name. Mistake during New Test Creation.");
			exit();
		}

	}else{
		header("Location:./check-attendence.php?msg=Please fill all the fields");
		exit();
	}
}else{
	header("Location:./admin-login.php?msg=Session expired&msg_clr=red");
	exit();
}


?>