<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	if(isset($_POST['test_id'])&&isset($_POST['col_name'])&&isset($_POST['add_marks'])){
		$test_id=$_POST['test_id'];
		$col_name=$_POST['col_name'];
		$add_marks=$_POST['add_marks'];

		include_once("../classes/db.class.php");
		$dbh=new db("triaasco_omr");
		$dbh->select("scaned_omrs", "id, $col_name, total_score", "test_id='$test_id'", "none", "none");
		if($dbh->sel_count_row>1){
			foreach($dbh->select_res as $test){
				$id=$test['id'];
				$col_marks=$test[$col_name];
				$total_score=$test['total_score'];

				$new_col_marks=$col_marks+$add_marks;
				$new_total_score=$total_score+$add_marks;

				$dbh->update("scaned_omrs", "$col_name='$new_col_marks', total_score='$new_total_score'", "id='$id'", "1");
				
			}
			header("Location:../add-bonus.php?msg=Bonus has been added successfully&msg_clr=green");
			exit();
		}else{
			header("Location:../add-bonus.php?msg=Error! This test ID does not exist&msg_clr=red");
			exit();
		}
	}else{
		header("Location:../add-bonus.php?msg=Error! Please fill all the fields&msg_clr=red");
		exit();
	}
}else{
	header("Location:../admin-login.php");
	exit();
}



?>