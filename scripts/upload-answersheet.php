<?php
if(isset($_POST['ansdata'])&&isset($_POST['test_id'])){
	$ansdata=$_POST['ansdata'];
	$test_id=$_POST['test_id'];
	include_once("../classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$dbh->select("tests", "id", "test_id='$test_id'", "none", "none");
	if($dbh->sel_count_row==1){
		$dbh->update("tests", "answer_data='$ansdata'", "test_id='$test_id'", "1");
		header("Location:../index.php?msg=Answersheet succesfully uploaded. Now start evaluation.&msg_clr=green");
		exit();
	}else{
		header("Location:../set-answersheet.php?msg=Error! Test ID does not exist.&msg_clr=red");
		exit();
	}

}else{
	header("Location:../set-answersheet.php?msg=Error! Please try again after refreshing the page.&msg_clr=red");
	exit();
}


?>