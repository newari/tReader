<?php
session_start();
if(isset($_SESSION['std_id'])){
	include("./classes/main.class.php");
	include("./classes/institute.class.php");
	$main=new main();
	$inst=new institute();
	$main->show_msg();
	$roll_no=$_SESSION['std_id'];
	if(isset($_GET['test_id'])&&isset($_GET['roll_no'])){
		include_once("classes/db.class.php");
		$test_id=$_GET['test_id'];
		$std_roll_no=$_GET['roll_no'];
		$dbh=new db("triaasco_omr");
		$dbh->select("students", "fname, lname, img_src, batch", "roll_no='$roll_no'", "none", "1");
		if($dbh->sel_count_row>0){
			$fname=$dbh->select_res['fname'];
			$lname=$dbh->select_res['lname'];
			$img_src=$dbh->select_res['img_src'];
			$batch=$dbh->select_res['batch'];
			if(file_exists("./images/students/".$img_src)){
				$img_src="./images/students/".$img_src;
			}else{
				$img_src="images/default-pic.jpg";
			}
		}else{
			$fname="Roll No Mistake";
			$img_src="images/default-pic.jpg";
			$batch="---";
		}
		$dbh->select("tests", "test_name, std_type, omr_code", "test_id='$test_id'", "none", "1");
		
		$test_name=$dbh->select_res['test_name'];
		$std_type=$dbh->select_res['std_type'];
		$omr_id=$dbh->select_res['omr_code'];
		$dbh->select("omrsheets", "no_of_subs, sub_names", "id='$omr_id'", "none", "1");
		$total_subs=$dbh->select_res['no_of_subs'];
		$sub_names=explode(",", $dbh->select_res['sub_names']);
		$subs_th="";
		$subs_td="";
		
		$dbh->select("scaned_omrs", "std_roll_no, omr_src, wrong_ans, right_ans, total_score, rank, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, percentage, percentile, omr_src", "test_id='$test_id' AND std_roll_no='$std_roll_no'", "total_score DESC", 'none');
		for($i=0; $i<$total_subs; $i++){
			$sub_no=$i+1;
			$subs_th.='<th>'.$sub_names[$i].'</th>';
			$subs_td.='<td>'.$dbh->select_res["col".$sub_no."_score"].'</td>';
		}
		$main_content='<p><a href="./student-home.php">Back</a></p>
			
				<div class="row-fluid">
					<div class="span12"><h3 class="alignC">Rankwise analysis of student performance!</h3><hr/></div>
					<div class="span12 omr-list">
						<table class="table">
							<thead>
							<tr>
								<th>S.R.</th>
								<th>Test Name</th>
								<th>Student Name</th>
								<th>CLass</th>
								<th>Roll No</th>
								<th>OMR Image</th>
								<th>Student Photo</th>
								<th>Right Q.</th>
								<th>Attemted Q.</th>
								<th>Wrong  Q.</th>
								<th>Total Marks</th>
								'.$subs_th.'
								<th>PER%</th>
								<th>RANK</th>
								<th>PERCENTILE</th>
								<th>More Analysis</th>
							</tr>
							</thead>';
		$std_roll_no=$dbh->select_res['std_roll_no'];
		
		$wrong_ans=$dbh->select_res['wrong_ans'];
		$right_ans=$dbh->select_res['right_ans'];
		$total_score=$dbh->select_res['total_score'];
		$incorrect_filled=$dbh->select_res['incorrect_filled'];
		$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
		$col1_score=$dbh->select_res['col1_score'];
		$col2_score=$dbh->select_res['col2_score'];
		$col3_score=$dbh->select_res['col3_score'];
		$omr_src=$dbh->select_res['omr_src'];
		$rank=$dbh->select_res['rank'];
		$percentage=$dbh->select_res['percentage'];
		$percentile=$dbh->select_res['percentile'];
			$main_content.='<tbody>
			<tr>
			<td>1</td>
			<td>'.$test_name.'</td>
			<td>'.$fname.'</td>
			<td>'.$batch.'</td>
			<td>'.$std_roll_no.'</td>
			<td><a href="'.$omr_src.'" target="new"><img src="images/omrview-demo.jpg"/></a></td>
			<td><img src="'.$img_src.'" width="100px"></td>
			<td>'.$dbh->select_res['right_ans'].'</td>
			<td>'.$attemted_qs.'</td>
			<td>'.$wrong_ans.'</td>
			<td>'.$dbh->select_res['total_score'].'</td>
			'.$subs_td.'
			<td>'.$percentage.'</td>
			<td>'.$rank.'</td>
			<td>'.$percentile.'</td>
			<td><p><a href="./graphical-analysis.php?test_id='.$test_id.'&roll_no='.$roll_no.'">Graphical Analysis</a></p><p><a href="./std-omr-data.php?test_id='.$test_id.'&roll_no='.$roll_no.'">OMR Sheet Data</a></p></td>
			</tr>';
			
			$main_content.='</tbody>
						</table>
					</div>
				</div>';
	}
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
	header("Location:./student-login.php?msg=Please login again.&msg_clr=red");
	exit();
}
	
?>