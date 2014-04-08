<?php
if(isset($_POST['test_id'])){
	$test_id=$_POST['test_id'];

	include_once("../classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$dbh->delete("scaned_omrs", "test_id='$test_id'");

	header("Location:../remove-test-result.php?msg=Result have deleted successfuly!&msg_clr=green");
	exit();
}{
	header("Location:../remove-test-result.php?msg=Error! Please fill all the fields!&msg_clr=red");
	exit();
}


?>