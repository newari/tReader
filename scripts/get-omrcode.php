<?php
if(isset($_POST['test_id'])){
	include_once("../classes/db.class.php");
	$dbh=new db();
	$test_id=$_POST['test_id'];
	$dbh->select("tests", "omr_code", "test_id='$test_id'", "none", "1");
	if($dbh->sel_count_row>0){
		$omr_id=$dbh->select_res['omr_code'];
		$dbh->select("omrsheets", "col_qs_pattern", "id='$omr_id'", "none", "1");
		if($dbh->sel_count_row>0){
			echo $dbh->select_res['col_qs_pattern'];
		}
	}else{
		echo "error";
	}
}else{
	echo "error";
}



?>