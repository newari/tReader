<?php
include_once("../classes/db.class.php");
include_once("../classes/main.class.php");
include_once("../classes/sms.class.php");
$main=new main();
$main->show_msg();
$dbh=new db("triaasco_omr");
$sms=new sms();
$msg_template=$_POST['msg_template'];
$get_var=json_decode($_POST['get_str'], true);
if(isset($get_var['batch'])){
	$batch=$get_var['batch'];
	if($batch=="all"){
		$dbh->select("students", "id, roll_no, father_name, fname, lname, father_name, img_src, batch, mobile, mobile_p", "none", "none", "none");
		if($dbh->sel_count_row==1){
			$vars=$dbh->select_res;
			$vars['name']=$name=ucfirst($dbh->select_res['fname'])." ".ucfirst($dbh->select_res['lname']);
			$sms->send_rand_sms($vars, $msg_template);
		}else if($dbh->sel_count_row>1){
			foreach($dbh->select_res as $student){
				$vars=$student;
				$vars['name']=$name=ucfirst($student['fname'])." ".ucfirst($student['lname']);
				$sms->send_rand_sms($vars, $msg_template);
			}
		}
	}else{
		$batch=$get_var['batch'];
		$dbh->select("students", "roll_no, father_name, fname, lname, img_src, batch, mobile, mobile_p", "batch='$batch'", "none", "none");
		if($dbh->sel_count_row==1){
			$vars=$dbh->select_res;
			$vars['name']=$name=ucfirst($dbh->select_res['fname'])." ".ucfirst($dbh->select_res['lname']);
			$sms->send_rand_sms($vars, $msg_template);
		}else if($dbh->sel_count_row>1){
			$i=0;
			foreach($dbh->select_res as $student){
				$vars=$student;
				$vars['name']=$name=ucfirst($student['fname'])." ".ucfirst($student['lname']);
				$sms->send_rand_sms($vars, $msg_template);
			}
		}

	}
}else if(isset($get_var['roll_no'])){
	$roll_no=$get_var['roll_no'];
	$dbh->select("students", "roll_no, father_name, fname, lname, img_src, batch, mobile, mobile_p", "roll_no LIKE '%$roll_no%'", "none", "none");
	if($dbh->sel_count_row==1){
		$vars=$dbh->select_res;
		$vars['name']=$name=ucfirst($dbh->select_res['fname'])." ".ucfirst($dbh->select_res['lname']);
		$sms->send_rand_sms($vars, $msg_template);
	}else if($dbh->sel_count_row>1){
		foreach($dbh->select_res as $student){
			$vars=$student;
			$vars['name']=$name=ucfirst($student['fname'])." ".ucfirst($student['lname']);
			$sms->send_rand_sms($vars, $msg_template);
		}
	}
}else if(isset($get_var['name'])){
	$name=$get_var['name'];
	$dbh->select("students", "roll_no, father_name, fname, lname, img_src, batch, mobile, mobile_p", "fname LIKE '%$name%'", "none", "none");
	if($dbh->sel_count_row==1){
		$vars=$dbh->select_res;
		$vars['name']=$name=ucfirst($dbh->select_res['fname'])." ".ucfirst($dbh->select_res['lname']);
		$sms->send_rand_sms($vars, $msg_template);
	}else if($dbh->sel_count_row>1){
		foreach($dbh->select_res as $student){
			$vars=$student;
			$vars['name']=$name=ucfirst($student['fname'])." ".ucfirst($student['lname']);
			$sms->send_rand_sms($vars, $msg_template);
		}
	}
}else{
	header("../students.php?msg=Please try again&msg_clr=red");
}




?>