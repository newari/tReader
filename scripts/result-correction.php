<?php
if(isset($_POST['std_roll_no'])&&isset($_POST['test_id'])){
	$test_id=$_POST['test_id'];
	$std_roll_no=$_POST['std_roll_no'];
	include_once("../classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$dbh->select("scaned_omrs", "id", "test_id='$test_id' AND std_roll_no='$std_roll_no'", "none", "1");
	if($dbh->sel_count_row>0){

		if($_POST['p1_score']!=""){
			$col1_score=$_POST['p1_score'];
		}

		if($_POST['p2_score']!=""){
			$col2_score=$_POST['p2_score'];
		}

		if($_POST['p3_score']!=""){
			$col3_score=$_POST['p3_score'];
		}
		if($_POST['p4_score']!=""){
			$col4_score=$_POST['p4_score'];
		}
		if($_POST['p5_score']!=""){
			$col5_score=$_POST['p5_score'];
		}
		$total_score==$col1_score+$col2_score+$col3_score+$col4_score+$col5_score;
		$dbh->update("scaned_omrs", "total_score='$total_score', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col2_score='$col4_score', col3_score='$col5_score'", "test_id='$test_id' AND std_roll_no='$std_roll_no'", "1");

		header("Location:../result-correction.php?msg=Result has been updated successfully!&msg_clr=green");
		exit();
		
		
	}else{

			if($_POST['p1_score']!=""){
				$col1_score=$_POST['p1_score'];
			}

			if($_POST['p2_score']!=""){
				$col2_score=$_POST['p2_score'];
			}

			if($_POST['p3_score']!=""){
				$col3_score=$_POST['p3_score'];
			}
			if($_POST['p4_score']!=""){
				$col4_score=$_POST['p4_score'];
			}
			if($_POST['p5_score']!=""){
				$col5_score=$_POST['p5_score'];
			}
			$total_score==$col1_score+$col2_score+$col3_score+$col4_score+$col5_score;

			$dbh->insert("scaned_omrs", "test_id='$test_id', std_roll_no='$std_roll_no', total_score='$total_score', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col4_score='$col4_score', col5_score='$col5_score'");
			header("Location:../result-correction.php?msg=Result has been updated successfully!&msg_clr=green");
			exit();
			
		
		
	}
	
}else{
	header("Location:../result-correction.php?msg=Error! Please try again with correct data!&msg_clr=red");
	exit();
}


?>