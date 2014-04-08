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
	$dbh->select("students", "fname, lname, batch, main_stream, reg_date, medium, img_src", "roll_no='$roll_no'", "none", "1");
	$fname=$dbh->select_res['fname'];
	$lname=$dbh->select_res['lname'];
	$batch=$dbh->select_res['batch'];
	$stream=$dbh->select_res['main_stream'];

	$reg_date=$dbh->select_res['reg_date'];
	$img_src=$dbh->select_res['img_src'];
	$medium=$dbh->select_res['medium'];

	$dbh->select("scaned_omrs", "test_id, total_score, col1_score, col2_score, col3_score, col4_score, col5_score, rank, percentage", "std_roll_no='$roll_no'", "none", "none");
	
	$test_list="<table class='table'>
		<thead>
			<tr>
				<th>#</th>
				<th>Test Name</th>
				<th>Total Score</th>
				<th>Sub 1st</th>
				<th>Sub 2nd</th>
				<th>Sub 3rd</th>
				<th>Sub 4th</th>
				<th>Sub 5th</th>
				<th>PER%</th>
				<th>Rank</th>
				<th class='printHide'>More</th>
			</tr>
		</thead>
		<tbody>
		";
		$total_test=$dbh->sel_count_row;
	if($total_test==1){
		$test_id=$dbh->select_res['test_id'];

		$total_score=$dbh->select_res['total_score'];
		$rank=$dbh->select_res['rank'];
		$test=$dbh->select_res;
		$dbh->select("tests", "test_name, omr_code", "test_id='$test_id'", "none", "1");
		$test_name=$dbh->select_res['test_name'];
		$omr_id=$dbh->select_res['omr_code'];
		$dbh->select("omrsheets", "no_of_subs, sub_names", "id='$omr_id'", "none", "1");
		$total_subs=$dbh->select_res['no_of_subs'];
		$sub_names=explode(",", $dbh->select_res['sub_names']);
		$subs_td="";
		for($i=0; $i<$total_subs; $i++){
			$sub_no=$i+1;
			$subs_td.="<td><b>".$sub_names[$i].": </b>".$test['col'.$sub_no.'_score']."</td>";
		}
		$left_subs=5-$total_subs;
		for($l=0; $l<$left_subs; $l++){
			$subs_td.='<td>__</td>';
		}
		$test_list.="<tr>
		<td>1.</td>
		<td>".$test_name."</td>
		<td>".$total_score."</td>
		".$subs_td."
		<td>".$test['percentage']."</td>
		<td>".$rank."</td>
		<td><a href='./std-test-report.php?roll_no=".$roll_no."&test_id=".$test_id."'>More details</a></td>
		</tr>";
	}else if($total_test>1){

		$i=0;
		foreach($dbh->select_res as $test){
			$i+=1;
			$dbh->select("tests", "test_name, omr_code", "test_id='$test_id'", "none", "1");
			$test_name=$dbh->select_res['test_name'];
			$omr_id=$dbh->select_res['omr_code'];
			$dbh->select("omrsheets", "no_of_subs, sub_names", "id='$omr_id'", "none", "1");
			$total_subs=$dbh->select_res['no_of_subs'];
			$sub_names=explode(",", $dbh->select_res['sub_names']);
			$subs_td="";
			for($i=0; $i<$total_subs; $i++){
				$sub_no=$i+1;
				$subs_td.="<td><b>".$sub_names[$i].": </b>".$test['col'.$sub_no.'_score']."</td>";
			}
			$left_subs=5-$total_subs;
			for($l=0; $l<$left_subs; $l++){
				$subs_td.='<td>__</td>';
			}
			$test_list.="<tr>
			<td>".$i."</td>
			<td>".$test_name."</td>
			<td>".$test['total_score']."</td>
			".$subs_td."
			<td>".$test['percentage']."</td>
			<td>".$test['rank']."</td>
			<td><a href='./std-test-report.php?roll_no=".$roll_no."&test_id=".$test['test_id']."'>More details</a></td>
			</tr>";
		}
	}else{
		$test_list="<b>No Test participated yet.</b>";
	}
	$test_list.="</tbody>
	</table>";
	if(file_exists("./images/students/".$img_src)){
		$img_src="./images/students/".$img_src;
	}else{
		$img_src="images/default-pic.jpg";
	}
	$main_content='<div class="row-fluid">
	<div class="span6 alignL"><a href="./student-home.php">Back</a></div>
		<div class="span12">
			<h4 class="alignC">'.ucfirst($fname).' '.ucfirst($lname).'</h4>	
			<hr/>
		</div>
		<div class="span12\">
			<div class="span2"><img src="'.$img_src.'" width="100"></div>
			<div class="span8">
			<div class="row-fluid">
			<div class="span6"><p><b>Batch : </b> '.$batch.'</p></div>
			<div class="span6 "><p><b>Medium : </b> '.ucfirst($medium).'</p></div>
			<div class="span6 marginl0"><p><b>Registered on : </b> '.date("D d, M Y", $reg_date).'</p></div>
			<div class="span6 "><p><b>Total test participated (Pen & Paper) : </b> '.$total_test.'</p></div>
			<div class="span6 marginl0"><p><b>Total test participated (Online) : </b> 0</p></div>
			</div>
			
			</div>
		</div>
		<div class="span12 alignC">
		<hr/>
		<h5>All Participated tests</h4>
		'.$test_list.'
		</div>
	</div>';
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Student login portal.",
			"title"=>"Student Login | t-Reader",
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