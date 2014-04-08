<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	header("Location:../index.php");
	exit();
}else{
	if(isset($_POST['omr-un'])&&isset($_POST['omr-pas'])){
		$un=$_POST['omr-un'];
		$pas=$_POST['omr-pas'];

		include_once("../classes/db.class.php");
		$dbh=new db("triaasco_omr");
		$dbh->select("omr_admin", "id", "username='$un' AND password='$pas'", "none", "none");
		if($dbh->sel_count_row>0){
			$admin_id=$dbh->select_res['id'];
			$_SESSION['omr-admin-id']=$admin_id;
			header("Location:../index.php");
			exit();
		}else{
			header("Location:../admin-login.php?msg=This username or password does not exist or Incorrcet.&msg_clr=red");
			exit();
		}
	}else{
		header("Location:../admin-login.php?msg=Please fill all the fields correctly.&msg_clr=red");
		exit();
	}
}


?>