<?php
session_start();
if(isset($_SESSION['std_id'])){
	$roll_no=$_SESSION['std_id'];
	include_once("./classes/db.class.php");
	include_once("./classes/main.class.php");
	include_once("./classes/institute.class.php");
	$main=new main();
	$inst=new institute();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	$dbh->select("students", "fname, lname", "roll_no='$roll_no'", "none", "1");
	$fname=$dbh->select_res['fname'];
	$lname=$dbh->select_res['lname'];

	$dbh->select("scaned_omrs", "test_id, total_score, percentage, rank", "std_roll_no='$roll_no'", "none", "none");
	$test_list="<table class='table'>
		<thead>
			<tr>
				<th>#</th>
				<th>Test Name</th>
				<th>Test Id</th>
				<th>Score</th>
				<th>Rank</th>
				<th>PER%</th>
				<th>More</th>
			</tr>
		</thead>
		<tbody>
		";
		$total_test=$dbh->sel_count_row;
	if($total_test==1){
		$test_id=$dbh->select_res['test_id'];
		$total_score=$dbh->select_res['total_score'];
		$rank=$dbh->select_res['rank'];
		$percentage=$dbh->select_res['percentage'];
		$dbh->select("tests", "test_name", "test_id='$test_id'", "none", "1");
		$test_name=$dbh->select_res['test_name'];

		$test_list.="<tr>
		<td>1.</td>
		<td>".$test_name."</td>
		<td>".$test_id."</td>
		<td>".$total_score."</td>
		<td>".$rank."</td>
		<td>".$percentage."</td>
		<td><a href='./std-test-report.php?roll_no=".$roll_no."&test_id=".$test_id."'>Deatails</a></td>
		</tr>";
		$test_list.="</tbody></table>";
	}else if($total_test>1){

		$i=0;
		foreach($dbh->select_res as $test){
			$test_id=$test['test_id'];
			$dbh->select("tests", "test_name", "test_id='$test_id'", "none", "1");
			$test_name=$dbh->select_res['test_name'];
			$i+=1;
			$test_list.="<tr>
			<td>".$i."</td>
			<td>".$test_name."</td>
			<td>".$test['test_id']."</td>
			<td>".$test['total_score']."</td>
			<td>".$test['rank']."</td>
			<td>".$test['percentage']."</td>
			<td><a href='./std-test-report.php?roll_no=".$roll_no."&test_id=".$test['test_id']."'>Details</a></td>
			</tr>";
		}
		$test_list.="</tbody></table>";
	}else{
		$test_list="<h3 class='alignC'>No Test participated yet.</h3>";
	}

	$main_content=$test_list;
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Student login portal.",
			"title"=>"Student Participated Tests | tReader",
			"srcext"=>"../../",
			"main_content"=>$main_content,
			"brand_name"=>$inst->brand_name

			),
		"student"=>array(
			'roll_no'=>$roll_no,
			'fname'=>ucfirst($fname),
			'lname'=>ucfirst($lname)

			)
		);

	$main->display("./pages/std-blank.ta", $vars);
}else{
	header("Location:../student-login.php?msg=Please login again.&msg_clr=red");
	exit();
}


?>