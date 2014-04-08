<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	include_once("classes/main.class.php");
	include_once("classes/db.class.php");
	$main=new main();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	if(isset($_GET['test_id'])&&isset($_GET['roll_no'])){
		include_once("classes/db.class.php");
		$test_id=$_GET['test_id'];
		$std_roll_no=$_GET['roll_no'];
		$roll_no=$_GET['roll_no'];
		$dbh=new db("triaasco_omr");
		$dbh->select("students", "fname, lname", "roll_no='$roll_no'", "none", "1");
		if($dbh->sel_count_row>0){
			$fname=$dbh->select_res['fname'];
			$lname=$dbh->select_res['lname'];
		}else{
			$fname="Mistake in Name";
			$lname="";
			// header("Location:./view-result.php?test_id=".$test_id."&msg=Error! Roll No. Mistake!");
			// exit();
		}
		$this_std_name=$fname;
		$dbh->select("scaned_omrs", "id", "test_id='$test_id'", "none", "none");
		$total_participants=$dbh->sel_count_row;

		$dbh->select("tests", "test_name, std_type, omr_code", "test_id='$test_id'", "none", "1");
		if($dbh->sel_count_row>0){
			$test_name=$dbh->select_res['test_name'];
			$std_type=$dbh->select_res['std_type'];
			$omr_id=$dbh->select_res['omr_code'];
			$dbh->select("omrsheets", "sub_pattern, no_of_subs, sub_names, sub_qs_dist", "id='$omr_id'", "none", "1");
			$sub_pattern=$dbh->select_res['sub_pattern'];
			$total_subs=$dbh->select_res['no_of_subs'];
			$sub_names=explode(",", $dbh->select_res['sub_names']);
			$qs_dist_arr=explode(",", $dbh->select_res['sub_qs_dist']);
			$total_qs=$qs_dist_arr[0]+$qs_dist_arr[1]+$qs_dist_arr[2]+$qs_dist_arr[3]+$qs_dist_arr[4];
		}else{
			header("Location:./std-test-report.php?msg=Error! Test id error! msg_clr=red");
			exit();
		}
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id' AND std_roll_no='$std_roll_no'", "total_score DESC", '1');
		
		$std_roll_no=$dbh->select_res['std_roll_no'];
		$wrong_ans=$dbh->select_res['wrong_ans'];
		$right_ans=$dbh->select_res['right_ans'];
		$total_score=$dbh->select_res['total_score'];
		$this_std_total_score=$total_score;
		$incorrect_filled=$dbh->select_res['incorrect_filled'];
		$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
		$unattemted_qs=$total_qs-$attemted_qs;
		$sub_scores=array();
		for($i=0; $i<$total_subs; $i++){
			$sub_no=$i+1;
			$sub_scores[$sub_names[$i]]=$dbh->select_res["col".$sub_no."_score"];
		}
		$sub_scores_string=json_encode($sub_scores);
		$omr_src=$dbh->select_res['omr_src'];
		$testdata=array("correct"=>$right_ans, "incorrect"=>$wrong_ans, "wrongf"=>$incorrect_filled);
		$testdata=json_encode($testdata);
		
		$top10data=array();
		$dbh->select("scaned_omrs", "std_roll_no, total_score", "test_id='$test_id'", "total_score DESC", "10");
		if($dbh->select_res>0){
			$total_topper=$dbh->sel_count_row;
			$i=0;
			foreach($dbh->select_res as $data){
				$std_roll_no=$data['std_roll_no'];
				$std_marks=$data['total_score'];
				$dbh->select("students", "fname", "roll_no='$std_roll_no'", "none", "1");
				if($dbh->sel_count_row>0){
					$std_name=$dbh->select_res['fname'];
				}else{
					$std_name="Roll No. Mistake";
				}

				if($i==0){
					$topper_name=$std_name;
					$topper_marks=$std_marks;
					$topper_roll_no=$std_roll_no;
				}
				$i++;
				$top10data[$std_marks]=$std_roll_no;
			}
			$top10data[$this_std_total_score]=$this_std_name;

		}
		$top10data=json_encode($top10data);
		$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Graphical analysis of student performance in the test.",
				"title"=>"Graphical Analysis | tReader",
				"srcext"=>"../../",
				"main_content"=>""

				),
			"student"=>array(
				"fname"=>$fname,
				"lname"=>$lname,
				"roll_no"=>$roll_no,
				"test_id"=>$test_id,
				"top10data"=>$top10data,
				"sub_data"=>$sub_scores_string,
				"testdata"=>$testdata
				),
			"testdata"=>array(
				"total_participants"=>$total_participants,
				"testname"=>$test_name,
				"total_qs"=>$total_qs,
				"correct"=>$right_ans,
				"incorrect"=>$wrong_ans,
				"unattemted"=>$unattemted_qs,
				"wrongf"=>$incorrect_filled,
				"sub_scores_string"=>$sub_scores_string,
				"topper_name"=>$topper_name,
				"topper_marks"=>$topper_marks
				)
			);
		$main->display("pages/graph-analysis.ta", $vars);
	}else{
		header("Location:./index.php?msg=Error! Test id not set, Please try again.&msg_clr=red");
		exit();
	}
	
}else{
	header("Location:./index.php");
		exit();
}
?>