<?php
session_start();
include_once("classes/main.class.php");

$main=new main();
$main->show_msg();
if(isset($_GET['report'])&&isset($_GET['test_id'])){
	$report_type=$_GET['report'];
	$test_id=$_GET['test_id'];
	if($report_type=="whole"){

		include_once("classes/db.class.php");
		
		$dbh=new db("triaasco_omr");
		$dbh->select("tests", "test_name, std_type, omr_code", "test_id='$test_id'", "none", "1");
		
		$test_name=$dbh->select_res['test_name'];
		$std_type=$dbh->select_res['std_type'];
		$omr_id=$dbh->select_res['omr_code'];
		$dbh->select("omrsheets", "sub_pattern, no_of_subs, sub_names", "id='$omr_id'", "none", "1");
		$sub_pattern=$dbh->select_res['sub_pattern'];
		$total_subs=$dbh->select_res['no_of_subs'];
		$sub_names=explode(",", $dbh->select_res['sub_names']);
		$subs_th="";
		$subs_td="";
		$top_links="";
		for($i=0; $i<$total_subs; $i++){
			$subs_th.='<th>'.$sub_names[$i].'</th>';
			$sub_no=$i+1;
			$top_links.='<div class="span1"><a href="./extra-result-view.php?report_type=sub'.$sub_no.'wise&test_id='.$test_id.'">'.$sub_names[$i].' wise</a></div>';
			
		}
		$dbh->select("scaned_omrs", "id, std_roll_no, wrong_ans, right_ans, total_score, rank, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, percentage, percentile, omr_src", "test_id='$test_id'", "total_score DESC", 'none');

		if($dbh->sel_count_row>1){
			$main_content='<p class="pushL"><a href="./view-result.php">Back</a></p>
			<p class="pushR"><a href="./scripts/set-rank.php?test_id='.$test_id.'&report='.$report_type.'">Set Rank & Percentile</a></p>
			
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<div class="span1"><a href="./extra-result-view.php?report_type=top5&test_id='.$test_id.'">Top 5</a></div>
							<div class="span1"><a href="./extra-result-view.php?report_type=top20&test_id='.$test_id.'">Top 20</a></div>
							'.$top_links.'
							<div class="span2 offset3"><p class="alignR"><a href="./result-print-view.php?test_id='.$test_id.'">Download for print!</a></p></div>
						</div>
					</div>
					<div class="span12"><h3 class="alignC">Rankwise analysis of student performance!</h3><hr/></div>
					<div class="span12 omr-list">
						<table class="table">
							<thead>
							<tr>
								<th>Rank</th>
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
								<th>More </th>
							</tr>
							</thead>';
			foreach($dbh->select_res as $key=>$val){
				$result_id=$val['id'];
						$std_roll_no=$val['std_roll_no'];
						$wrong_ans=$val['wrong_ans'];
						$right_ans=$val['right_ans'];
						$total_score=$val['total_score'];
						$incorrect_filled=$val['incorrect_filled'];
						$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
						$col1_score=$val['col1_score'];
						$col2_score=$val['col2_score'];
						$col3_score=$val['col3_score'];
						$rank=$val['rank'];
						$percentage=$val['percentage'];
						$percentile=$val['percentile'];
						$omr_src=$val['omr_src'];
						// $roll_l=strlen($std_roll_no);
						// $std_old_no=$std_roll_no;
						// $rem_no=6-$roll_l;
						// for($x=0; $x<$rem_no; $x++){
						// 	$std_roll_no="0".$std_roll_no;
						// }
						$subs_td="";
						for($i=1; $i<=$total_subs; $i++){
							$name_id=$i-1;;
							$subs_td.='<td><a class="pointer" title="'.$sub_names[$name_id].'">'.$val["col".$i."_score"].'</a></td>';
						}
						$dbh->select("students", "fname, lname, img_src, batch", "roll_no='$std_roll_no'", "none", "1");
						if($dbh->sel_count_row>0){
							$fname=$dbh->select_res['fname'];
							$lname=$dbh->select_res['lname'];
							$student_name=ucfirst($fname)." ".ucfirst($lname);
							if(file_exists("./images/students/".$dbh->select_res['img_src'])){
								$img_src="./images/students/".$dbh->select_res['img_src'];
							}else{
								$img_src="./images/default-pic.jpg";
							}
							$batch=$dbh->select_res['batch'];
						}else{
							$student_name="Roll No. Mistake";
							$img_src="./images/default-pic.jpg";
							$batch="";
						}
						
						
							$main_content.='<tbody>
							<tr>
							<td>'.$rank.'</td>
							<td>'.$test_name.'</td>
							<td>'.$student_name.'</td>
							<td>'.$batch.'</td>
							<td>'.$std_roll_no.'</td>
							<td><a href="'.$omr_src.'" target="new"><img src="images/omrview-demo.jpg"/></a></td>
							<td><img src="'.$img_src.'" width="100px"></td>
							<td>'.$val['right_ans'].'</td>
							<td>'.$attemted_qs.'</td>
							<td>'.$wrong_ans.'</td>
							<td>'.$val['total_score'].'</td>
							'.$subs_td.'
							<td>'.$percentage.'</td>
							<td>'.$rank.'</td>
							<td>'.$percentile.'</td>
							<td><p><a target="new" href="./graph-report.php?roll_no='.$std_roll_no.'&test_id='.$test_id.'&result_id='.$result_id.'">Graphical Analysis</a></p><p><a target="new" href="./omr-data.php?test_id='.$test_id.'&roll_no='.$std_roll_no.'&result_id='.$result_id.'">OMR Data</a></p><p><a href="./edit-result-info.php?result_id='.$result_id.'">Edit Info</a></p><td>
							</tr>';
			}
			$main_content.='</tbody>
						</table>
					</div>
				</div>';
		}else if($dbh->sel_count_row==1){
			$key=0;
			$main_content='<p class="pushL"><a href="./view-result.php">Back</a></p>
			<p class="pushR"><a href="./scripts/set-rank.php?test_id='.$test_id.'&report='.$report_type.'">Set Rank & Percentile</a></p>
			<div class="row-fluid">
				<div class="span12">
						<div class="row-fluid">
							<div class="span1"><a href="./extra-result-view.php?report_type=top5&test_id='.$test_id.'">Top 5</a></div>
							<div class="span1"><a href="./extra-result-view.php?report_type=top20&test_id='.$test_id.'">Top 20</a></div>
							'.$top_links.'
							<div class="span2 offset3"><p class="alignR"><a href="./result-print-view.php?test_id='.$test_id.'">Download for print!</a></p></div>
						</div>
					</div>
					<div class="span12"><h3 class="alignC">Rankwise analysis of student performance!</h3><hr/></div>
					<div class="span12 omr-list">
						<table class="table">
							<thead>
							<tr>
								<th>Rank</th>
								<th>Test Name</th>
								<th>Student Name</th>
								<th>Batch</th>
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
				        $rank=$key+1;

						$result_id=$dbh->select_res['id'];
						$std_roll_no=$dbh->select_res['std_roll_no'];
						$wrong_ans=$dbh->select_res['wrong_ans'];
						$right_ans=$dbh->select_res['right_ans'];
						$total_score=$dbh->select_res['total_score'];
						$incorrect_filled=$dbh->select_res['incorrect_filled'];
						$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
						$col1_score=$dbh->select_res['col1_score'];
						$col2_score=$dbh->select_res['col2_score'];
						$col3_score=$dbh->select_res['col3_score'];
						$rank=$dbh->select_res['rank'];
						$percentage=$dbh->select_res['percentage'];
						$percentile=$dbh->select_res['percentile'];
						$omr_src=$dbh->select_res['omr_src'];
						for($i=1; $i<=$total_subs; $i++){
							$name_id=$i-1;
							$subs_td.='<td><a class="pointer" title="'.$sub_names[$name_id].'">'.$dbh->select_res["col".$i."_score"].'</a></td>';
						}
						$img_src="";
						$dbh->select("students", "fname, lname, img_src, batch", "roll_no='$std_roll_no'", "none", "1");
						if($dbh->sel_count_row>0){
							$fname=$dbh->select_res['fname'];
							$lname=$dbh->select_res['lname'];
							$student_name=ucfirst($fname)." ".ucfirst($lname);
							if(file_exists("./images/students/".$dbh->select_res['img_src'])){
								$img_src="./images/students/".$dbh->select_res['img_src'];
							}else{
								$img_src="./images/default-pic.jpg";
							}
							$batch=$dbh->select_res['batch'];
						}else{
							$student_name="Roll No. Mistake";
							$img_src="./images/default-pic.jpg";
							$batch="";
						}
							$main_content.='<tbody>
							<tr>
							<td>1.</td>
							<td>'.$test_name.'</td>
							<td>'.$student_name.'</td>
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
							<td><p><a target="new" href="./graph-report.php?roll_no='.$std_roll_no.'&test_id='.$test_id.'&result_id='.$result_id.'">Graphical Analysis</a></p><p><a target="new" href="./omr-data.php?test_id='.$test_id.'&roll_no='.$std_roll_no.'&result_id='.$result_id.'">OMR Data</a></p><p><a href="./edit-result-info.php?result_id='.$result_id.'">Edit Info</a></p><td>
							</tr>';
			
			$main_content.='</tbody>
						</table>
					</div>
				</div>';
		}else{
			$main_content="<h4 clas='alignC'>No records found for this test at present Or it has been combined with other test result!</h4>";
		}
		
		
	}
}else{
	$main_content="
	<div class='row-fluid'>
		<div class='span5 offset3 alignC'>
			<h3 class='alignR'>Analysis of test result :</h3>
			<form class='form-horizontal' action='#' method='get'>
				<input type='hidden' name='report' value='whole'/>
				
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>Test Id : </label>
				 	<div class='controls'><input type='text' name='test_id' id='test_id'/></div>
				</div>
				<div class='control-group'>
				 	<label class='control-label'></label>
				 	<div class='controls'><input type='submit' value='Submit' class='btn btn-success'/></div>
				</div>
				
			</form>
		</div>
		<div class='span12'><hr/></div>
		
	</div>";
}
	$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Admin login portal.",
				"title"=>"Analysis of Result | tReader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("pages/omre-blank.ta", $vars);

?>