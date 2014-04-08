<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){	
	$fname=$_POST['fname'];
	$roll_no=$_POST['roll_no'];
	$batch=$_POST['batch'];
	$mobile=$_POST['mobile'];
	$mobile_p=$_POST['mobile_p'];
	$address=$_POST['address'];
	$photo=$_FILES['photo']['tmp_name'];

	if($fname!=""&&$roll_no!=""&&$batch!=""){
		include_once("../classes/db.class.php");
		$dbh=new db("triaasco_omr");
		$dbh->select("students", "id", "roll_no='$roll_no'", "none", "none", "1");
		if($dbh->sel_count_row>0){
			$crnt_time=time();
			$img_src=$roll_no.".jpg";
			$dbh->update("students", "roll_no='$roll_no', fname='$fname', batch='$batch', img_src='$img_src', reg_date='$crnt_time', mobile='$mobile', mobile_p='$mobile_p', address='$address'", "roll_no='$roll_no'", "1");
			if($_FILES['photo']['size']>0){
				move_uploaded_file($photo, "../images/students/".$roll_no.".jpg");

			}
			header("Location:../edit-student-profile.php?roll_no=".$roll_no."&msg=Student profile updated successfully.&msg_clr=green");
			exit();
		}else{
			
			header("Location:../edit-student-profile.php?roll_no=".$roll_no."&msg=This roll No did not register yet. Please first add this student!&msg_clr=red");
			exit();
		}
	}else{
		header("Location:../edit-student-profile.php?roll_no=".$roll_no."&msg=Please fill all the fields correctly&msg_clr=red");
			exit();
	}
}else{
	header("Location:../admin-login.php?msg=Session expired! Please login again&msg_clr=red");
	exit();
}
?>