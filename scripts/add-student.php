<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){	
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$roll_no=$_POST['roll_no'];
	$batch=strtoupper($_POST['batch']);
	$stream=$_POST['stream'];
	$mobile=$_POST['mobile'];
	$mobile_p=$_POST['mobile_p'];
	$address=$_POST['address'];
	$photo=$_FILES['photo']['tmp_name'];

	if($fname!=""&&$lname!=""&&$roll_no!=""&&$batch!=""){
		include_once("../classes/db.class.php");
		$dbh=new db("triaasco_omr");
		$dbh->select("students", "id", "roll_no='$roll_no'", "none", "none", "none");
		if($dbh->sel_count_row>0){
			header("Location:../add-student.php?msg=This roll no already registered, Please try with another roll no.&msg_clr=red");
			exit();
		}else{
			$crnt_time=time();
			$img_src=$roll_no.".jpg";
			$address=str_replace("'", "", $address);
			$dbh->insert("students", "roll_no='$roll_no', fname='$fname', lname='$lname', img_src='$img_src', batch='$batch', main_stream='$stream', reg_date='$crnt_time', mobile='$mobile', mobile_p='$mobile_p', address='$address'");
			if($_FILES['photo']['size']>0){
				move_uploaded_file($photo, "../images/students/".$roll_no.".jpg");

			}
			header("Location:../add-student.php?msg=Student added successfully!&msg_clr=green");
			exit();
		}
	}else{
		header("Location:../add-student.php?msg=Please fill all the fields correctly&msg_clr=red");
			exit();
	}
}else{
	header("Location:../admin-login.php?msg=Session expired! Please login again&msg_clr=red");
	exit();
}
?>