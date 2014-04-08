<?php
if(isset($_POST['test_id'])){
	$test_id=$_POST['test_id'];
	include_once("../classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$dbh->select("tests", "omr_code", "test_id='$test_id'", "none", "1");
	if($dbh->sel_count_row>0){
		echo $dbh->select_res['omr_code'];
	}else{
		echo "error";
	}
}else{
	echo "error";
}


?>