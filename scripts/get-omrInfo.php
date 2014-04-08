<?php
if(isset($_POST['test_id'])){
	include_once("../classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$test_id=$_POST['test_id'];
	$dbh->select("tests", "omr_code", "test_id='$test_id'", "none", "1");
	if($dbh->sel_count_row>0){
		$omr_id=$dbh->select_res['omr_code'];
		$dbh->select("omrsheets", "col_qs_pattern, q_opts", "id='$omr_id'", "none", "1");
		if($dbh->sel_count_row>0){
			$qs_pattern=$dbh->select_res['col_qs_pattern'];
			$qs_pattern_arr=explode(",", $qs_pattern);
			$qs_pattern_arr[]=$qs_pattern;
			$qs_pattern_arr[]=$dbh->select_res['q_opts'];
			$omr_info_string=json_encode($qs_pattern_arr);
			echo $omr_info_string;
		}else{
			echo "error";
		}
	}else{
		echo "error";
	}
}else{
	echo "error";
}



?>