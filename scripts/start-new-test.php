<?php
	if(isset($_POST['test_name'])&&isset($_POST['test_id'])&&isset($_POST['test_date'])&&isset($_POST['omr_code'])&&isset($_POST['omr_code'])&&isset($_POST['max_score'])){
		$test_name=$_POST['test_name'];
		$minor_name=$_POST['minor_name'];
		$test_id=$_POST['test_id'];
		$test_date=$_POST['test_date'];
		$omr_code=$_POST['omr_code'];
		$max_score=$_POST['max_score'];
		$minor_name=$_POST['minor_name'];
		if(isset($_POST['std_type'])){
			$std_type=$_POST['std_type'];
		}else{
			$std_type="all";
		}
		include_once("../classes/db.class.php");
		$dbh=new db("triaasco_omr");
		$dbh->select("tests", "id", "test_id='$test_id'", "none", "none");
		if($dbh->sel_count_row<1){
			$dbh->insert("tests", "test_id='$test_id', test_name='$test_name', minor_name='$minor_name', test_date='$test_date', omr_code='$omr_code', max_score='$max_score', std_type='$std_type'");
			if(mysql_insert_id()>0){
				header("Location:../index.php?msg=Test seted successfully!.&msg_clr=green");
				exit();
			}
		}else{
			header("Location:../start-new-test.php?msg=Error! This test id already exist. Please change test id.&msg_clr=red");
			exit();
		}
	}else{
		header("Location:../start-new-test.php?msg=Error! Please try again with correct data.&msg_clr=red");
		exit();
	}




?>