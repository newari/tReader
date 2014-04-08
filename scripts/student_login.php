<?php
if(isset($_POST['roll_no'])&&$_POST['roll_no']!=""){
	$roll_no=$_POST['roll_no'];
	include_once("../classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$dbh->select("students", "id", "roll_no='$roll_no'", "none", "1");
	if($dbh->sel_count_row==1){
		session_start();
		$_SESSION['std_id']=$roll_no;
		header("Location:../student-home.php");
		exit();
	}else{
		header("Location:../student-login.php?msg=This Roll No. not registered yet or incorrect. Please try with correct information or contact to the coaching.&msg_clr=red");
	exit();
	}
}else{
	header("Location:../student-login.php?msg=Please fill the field correctly.&msg_clr=red");
	exit();
}



?>