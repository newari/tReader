<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	if(isset($_POST['test_id'])){
		$test_id=$_POST['test_id'];
		include_once("../classes/db.class.php");
		$dbh=new db();
		$dbh->update("tests", "hidden='1'", "id='$test_id'", "none", "1");
		echo "success";
	}else{
		echo "error1";
	}
}else{
	header("Location:../admin-login.php?,sg=Session expired! Please login again.");
}
	

?>