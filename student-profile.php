<?php
if(isset($_GET['roll_no'])){
	$roll_no=$_GET['roll_no'];
	include_once("./classes/db.class.php");
	include_once("./classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$dbh=new db();
	$crnt_date=date('d M\, Y', time());
	$dbh->select("students", "fname, lname, batch, main_stream, reg_date", "roll_no='$roll_no'", "none", "1");
	$fname=$dbh->select_res['fname'];
	$lname=$dbh->select_res['lname'];
	$batch=$dbh->select_res['batch'];
	$stream=$dbh->select_res['main_stream'];
	$reg_date=$dbh->select_res['reg_date'];

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
				<th>Per%</th>
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
		$percentage=$dbh->select_res['percentage'];
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
			$subs_td.="<td>".$sub_names[$i].": <b>".$test['col'.$sub_no.'_score']."</b></td>";
		}
		$left_subs=5-$total_subs;
		for($ls=0; $ls<$left_subs; $ls++){
			$subs_td.='<td>__</td>';
		}
		$test_list.="<tr>
		<td>1.</td>
		<td>".$test_name."</td>
		<td>".$total_score."</td>
		".$subs_td."
		<td>".$percentage."</td>
		<td>".$rank."</td>
		<td class='printHide'><a href='./test-report.php?roll_no=".$roll_no."&test_id=".$test_id."'>More details</a></td>
		</tr>";
	}else if($total_test>1){

		$i=0;
		foreach($dbh->select_res as $test){
			$i+=1;
			$dbh->select("tests", "test_name, omr_code", "test_id='$test[test_id]'", "none", "1");
			$test_name=$dbh->select_res['test_name'];
			$omr_id=$dbh->select_res['omr_code'];
			$dbh->select("omrsheets", "no_of_subs, sub_names", "id='$omr_id'", "none", "1");
			$total_subs=$dbh->select_res['no_of_subs'];
			$sub_names=explode(",", $dbh->select_res['sub_names']);
			$subs_td="";
			for($i=0; $i<$total_subs; $i++){
				$sub_no=$i+1;
				$subs_td.="<td>".$sub_names[$i].": <b>".$test['col'.$sub_no.'_score']."</b></td>";
			}
			for($ls=0; $ls<$left_subs; $ls++){
				$subs_td.='<td>__</td>';
			}
			$test_list.="<tr>
			<td>".$i."</td>
			<td>".$test_name."</td>
			<td>".$test['total_score']."</td>
			".$subs_td."
			<td>".$test['percentage']."</td>
			<td>".$test['rank']."</td>
			<td  class='printHide'><a href='./test-report.php?roll_no=".$roll_no."&test_id=".$test['test_id']."'>More details</a></td>
			</tr>";
		}
	}else{
		$test_list="<b>No Test participated yet.</b>";
	}

	$test_list.="</tbody>
	</table>";
	if(file_exists("./images/students/".$roll_no.".jpg")){
		$img_src="./images/students/".$roll_no.".jpg";
	}else{
		$img_src="images/default-pic.jpg";
	}
	$main_content='<div class="row-fluid">
		<div class="span3 alignL"><a class="printHide" href="./students.php">Back</a></div>
		<div class="span6">
			<p class="alignC"><img src="./images/logo_large.jpg"></p>
			<h4 class="alignC">Test Report ('.$crnt_date.')</h4>
		</div>
		<div class="span3 alignR printHide"><p><a href="./students.php?batch=all">View All student</a></p><p><a class="pointer" onClick="printPage()">Print</a></p></div>
		<div class="span12">
		<hr/>
			<div class="span2"><p><img src="'.$img_src.'" width="100"></p><p><h5>'.ucfirst($fname).' '.ucfirst($lname).'</h5></p></div>
			<div class="span8">
			<div class="row-fluid">
			<div class="span6"><p><b>Batch : </b> '.$batch.'</p></div>
			<div class="span6 "><p><b>Registered on : </b> '.$reg_date.'</p></div>
			<div class="span6 marginl0"><p><b>Total test participated (offline) : </b> '.$total_test.'</p></div>
			<div class="span6"><p><b>Total test participated (Online) : </b> 0</p></div>
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
			"metad"=>"students profile data",
			"title"=>$fname."'s Test report",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-blank.ta", $vars);
}else{
	header("Location:./student-home.php?msg=Roll no error&msg_clr=red");
	exit();
}	


	
?>