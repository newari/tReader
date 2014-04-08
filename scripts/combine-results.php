<?php
if(isset($_POST['test1_id'])&&isset($_POST['test2_id'])&&isset($_POST['new_name'])&&isset($_POST['type'])){
	$test1_id=$_POST['test1_id'];
	$test2_id=$_POST['test2_id'];
	$new_test_h=$_POST['new_name_h'];
	$new_test_name=$_POST['new_name'];
	$new_id=$test1_id."-".$test2_id;
	$type=$_POST['type'];
	include_once("../classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$dbh->select("tests", "max_score", "test_id='$test1_id'", "none", "1");
	$max1_score=$dbh->select_res['max_score'];

	$dbh->select("tests", "max_score", "test_id='$test2_id'", "none", "1");
	$max2_score=$dbh->select_res['max_score'];
	if($type=="score"){
		$new_max_score=$max1_score+$max2_score;
	}else{
		$new_max_score=$max1_score;
	}
	$dbh->insert("tests", "test_id='$new_id', test_name='$new_test_h', max_score='$new_max_score', minor_name='$new_test_name'");
	
	if($type=="score"){
		$dbh->select("scaned_omrs", "std_roll_no, total_score, col1_score, col2_score, col3_score, col4_score, col5_score", "test_id='$test1_id'", "none", "none");
		if($dbh->sel_count_row>1){
			
			foreach($dbh->select_res as $data){
				$col1_score=0;
				$col2_score=0;
				$col3_score=0;
				$col4_score=0;
				$col5_score=0;
				$total_score=0;
				$roll_no=$data['std_roll_no'];
				$col1_score=$data['col1_score'];
				$col2_score=$data['col2_score'];
				$col3_score=$data['col3_score'];
				$col4_score=$data['col4_score'];
				$col5_score=$data['col5_score'];
				$total_score=$data['total_score'];

				$dbh->select("scaned_omrs", "total_score, col1_score, col2_score, col3_score, col4_score, col5_score", "test_id='$test2_id' AND std_roll_no='$roll_no'", "none", "1");
				if($dbh->sel_count_row>0){
					$col1_score=$col1_score+$dbh->select_res['col1_score'];
					$col2_score=$col2_score+$dbh->select_res['col2_score'];
					$col3_score=$col3_score+$dbh->select_res['col3_score'];
					$col4_score=$col4_score+$dbh->select_res['col4_score'];
					$col4_score=$col4_score+$dbh->select_res['col4_score'];
					$total_score=$total_score+$dbh->select_res['total_score'];

				}

				$dbh->insert("scaned_omrs", "test_id='$new_id', std_roll_no='$roll_no', total_score='$total_score', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col3_score='$col3_score', col4_score='$col4_score', col5_score='$col5_score'");
			}
		}else{
			header("Location:../combine-two-result.php?msg=The result of test ID: ".$test1_id." not evaluated yet. Please try after evaluation of both test.&msg_clr=red");
			exit();
		}
		
	}else if($type=="rank"){
		$dbh->select("scaned_omrs", "std_roll_no, total_score, col1_score, col2_score, col3_score, col4_score, col5_score", "test_id='$test1_id'", "none", "none");
		if($dbh->sel_count_row>1){
			
			foreach($dbh->select_res as $data){
				$col1_score=0;
				$col2_score=0;
				$col3_score=0;
				$col4_score=0;
				$col5_score=0;
				$total_score=0;
				$roll_no=$data['std_roll_no'];
				$col1_score=$data['col1_score'];
				$col2_score=$data['col2_score'];
				$col3_score=$data['col3_score'];
				$col4_score=$data['col4_score'];
				$col5_score=$data['col5_score'];
				$total_score=$data['total_score'];

				$dbh->insert("scaned_omrs", "test_id='$new_id', std_roll_no='$roll_no', total_score='$total_score', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col4_score='$col4_score', col5_score='$col5_score'");
			}
		}else{
			header("Location:../combine-two-result.php?msg=The result of test ID: ".$test1_id." not evaluated yet. Please try after evaluation of both test.&msg_clr=red");
			exit();
		}

		$dbh->select("scaned_omrs", "std_roll_no, total_score, col1_score, col2_score, col3_score, col4_score, col5_score", "test_id='$test2_id'", "none", "none");
		if($dbh->sel_count_row>1){
			
			foreach($dbh->select_res as $data){
				$col1_score=0;
				$col2_score=0;
				$col3_score=0;
				$col4_score=0;
				$col5_score=0;
				$total_score=0;
				$roll_no=$data['std_roll_no'];
				$col1_score=$data['col1_score'];
				$col2_score=$data['col2_score'];
				$col3_score=$data['col3_score'];
				$col4_score=$data['col4_score'];
				$col5_score=$data['col5_score'];
				$total_score=$data['total_score'];

				$dbh->insert("scaned_omrs", "test_id='$new_id', std_roll_no='$roll_no', total_score='$total_score', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col4_score='$col4_score', col5_score='$col5_score'");
			}
		}else{
			header("Location:../combine-two-result.php?msg=The result of test ID: ".$test2_id." not evaluated yet. Please first delete this combined test result and try after evaluation of both test.&msg_clr=red");
			exit();
		}
	}
	

	header("Location:../combine-two-result.php?msg=Results combined successfully. Now view result by test id: ".$new_id.".&msg_clr=green");
	exit();
}else{
	header("Location:../combine-two-result.php?msg=Error! Please fill all the fields!&msg_clr=red");
	exit();
}



?>