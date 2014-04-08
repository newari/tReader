<?php
session_start();
include_once("classes/main.class.php");
include_once("classes/institute.class.php");
$inst=new institute();
$main=new main();
$main->show_msg();
if(isset($_GET['test_id'])){
	$count=0;
	$test_id=$_GET['test_id'];
		include_once("classes/db.class.php");
		
		$dbh=new db("triaasco_omr");
		$dbh->select("tests", "test_name, test_date, std_type, omr_code, max_score, minor_name", "test_id='$test_id'", "none", "1");
		
		$test_name=$dbh->select_res['test_name'];
		$std_type=$dbh->select_res['std_type'];
		$omr_id=$dbh->select_res['omr_code'];
		$test_date_arr=explode("-", $dbh->select_res['test_date']);
		if(isset($test_date_arr[2])&&isset($test_date_arr[1])){
			$test_date=$test_date_arr[2]."-".$test_date_arr[1]."-".$test_date_arr[0];

		}else{
			$test_date=$dbh->select_res['test_date'];
		}
		$max_score=$dbh->select_res['max_score'];
		$minor_name=$dbh->select_res['minor_name'];
		$dbh->select("omrsheets", "sub_pattern, no_of_subs, sub_names", "id='$omr_id'", "none", "1");
		$sub_pattern=$dbh->select_res['sub_pattern'];
		$total_subs=$dbh->select_res['no_of_subs'];
		$sub_names=explode(",", $dbh->select_res['sub_names']);
		$subs_th="";
		$subs_td="";
		for($i=0; $i<$total_subs; $i++){
			$subs_th.='<th>'.$sub_names[$i].'</th>';
		}
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, rank, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, percentage, percentile, omr_src", "test_id='$test_id'", "total_score DESC", 'none');
		$data=$dbh->select_res;
		$total_rows=$dbh->sel_count_row;
		$filename="Result excels/".$test_name.".csv";
		$handle = fopen($filename, 'w+');
			 
		fputcsv($handle, array('SR', 'Roll NO', 'STUDENT NAME', $sub_names[0], $sub_names[1], $sub_names[2], $sub_names[3], $sub_names[4], 'TOTAL SCORE', 'PER%', "RANK", "PERCENTILE"));
		$toppers='';
		foreach($data as $key=>$val){
				$sr=$key+1;
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
				$subs_td="";
				for($i=1; $i<=$total_subs; $i++){
					$name_id=$i-1;;
					$subs_td.='<td><a class="pointer" title="'.$sub_names[$name_id].'">'.$val["col".$i."_score"].'</a></td>';
				}
						// $roll_l=strlen($std_roll_no);
						// 	$rem_no=6-$roll_l;
						// 	for($x=0; $x<$rem_no; $x++){
						// 		$std_roll_no="0".$std_roll_no;
						// 	}

				$dbh->select("students", "fname, lname", "roll_no='$std_roll_no'", "none", "1");
				if($dbh->sel_count_row>0){
					$fname=$dbh->select_res['fname'];
				$lname=$dbh->select_res['lname'];
				$student_name=ucfirst($fname)." ".ucfirst($lname);
				}else{
					$student_name="Roll No. Mistake";
				}
				if($sr==3){
					break;
				}
				if(file_exists("./images/students/".$std_roll_no.".jpg")){
					$img_src="./images/students/".$std_roll_no.".jpg";
				}else{
					$img_src="./images/default-pic.jpg";
				}
				$toppers.='<div class="span2 topper-name">
							<p><img src="'.$img_src.'"></p>
							<p>'.$student_name.'</p>
							<p>'.$std_roll_no.'</p>
						</div>
						<div class="span2 topper-rank">
							<p>'.$rank.'</p>
							<p>Rank</p>
						</div>';
		}
		$main_content='<div class="row-fluid">
				<div class="span12 alignC "><img src="./images/'.$inst->logo_large.'" width="600px"/> </div>
				<div class="span12 alignC"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 marginl0">
					<div class="row-fluid toppers">'.$toppers.'</div>
					<hr/>
				</div>
				<div class="page">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK</th>
							<th>PERCENTILE</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score=0;
		if($total_rows>1){
			foreach($data as $key=>$val){
				$sr=$key+1;
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
				$subs_td="";
				for($i=1; $i<=$total_subs; $i++){
					$name_id=$i-1;;
					$subs_td.='<td><a class="pointer" title="'.$sub_names[$name_id].'">'.$val["col".$i."_score"].'</a></td>';
				}
						// $roll_l=strlen($std_roll_no);
						// 	$rem_no=6-$roll_l;
						// 	for($x=0; $x<$rem_no; $x++){
						// 		$std_roll_no="0".$std_roll_no;
						// 	}

						$dbh->select("students", "fname, lname", "roll_no='$std_roll_no'", "none", "1");
						if($dbh->sel_count_row>0){
							$fname=$dbh->select_res['fname'];
						$lname=$dbh->select_res['lname'];
						$student_name=ucfirst($fname)." ".ucfirst($lname);
						}else{
							$student_name="Roll No. Mistake";
						}
						$omr_src=$val['omr_src'];
							$main_content.='
							<tr class="borderb1">
							<td>'.$sr.'</td>
							<td>'.$std_roll_no.'</td>
							<td><b>'.$student_name.'</b></td>
							'.$subs_td.'
							<td>'.$val['total_score'].'</td>
							<td>'.$percentage.'%</td>
							<td>'.$rank.'</td>
							<td>'.$percentile.'</td>
							</tr>';
							if($count==0){
								if($sr%26==0){
									$main_content.='</tbody></table></div><div class="page"><table class="table table-bordered borderb1"><tbody>';
									$count+=1;
								}

							}else if($sr>30){
								if(($sr+5)%31==0){
									$main_content.='</tbody></table></div><div class="page"><table class="table table-bordered borderb1 page"><tbody>';
									$count+=1;
								}
							}
				    fputcsv($handle, array($sr, $val['std_roll_no'], $student_name, $val['col1_score'], $val['col2_score'], $val['col3_score'], $val['total_score'], $percentage, $rank, $percentile));
			}
		}else if($total_rows==1){
			$sr=1;
				$std_roll_no=$data['std_roll_no'];
				$wrong_ans=$data['wrong_ans'];
				$right_ans=$data['right_ans'];
				$total_score=$data['total_score'];
				$incorrect_filled=$data['incorrect_filled'];
				$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
				$col1_score=$data['col1_score'];
				$col2_score=$data['col2_score'];
				$col3_score=$data['col3_score'];
				$rank=$data['rank'];
				$percentage=$data['percentage'];
				$percentile=$data['percentile'];
				$omr_src=$data['omr_src'];
				$total_score=$data['total_score'];
				$val=$data;
				for($i=1; $i<=$total_subs; $i++){
					$name_id=$i-1;;
					$subs_td.='<td><a class="pointer" title="'.$sub_names[$name_id].'">'.$data["col".$i."_score"].'</a></td>';
				}
						// $roll_l=strlen($std_roll_no);
						// 	$rem_no=6-$roll_l;
						// 	for($x=0; $x<$rem_no; $x++){
						// 		$std_roll_no="0".$std_roll_no;
						// 	}

						$dbh->select("students", "fname, lname", "roll_no='$std_roll_no'", "none", "1");
						if($dbh->sel_count_row>0){
							$fname=$dbh->select_res['fname'];
						$lname=$dbh->select_res['lname'];
						$student_name=ucfirst($fname)." ".ucfirst($lname);
						}else{
							$student_name="Roll No. Mistake";
						}
						
							$main_content.='
							<tr class="borderb1">
							<td>'.$sr.'</td>
							<td>'.$std_roll_no.'</td>
							<td><b>'.$student_name.'</b></td>
							'.$subs_td.'
							<td>'.$total_score.'</td>
							<td>'.$percentage.'%</td>
							<td>'.$rank.'</td>
							<td>'.$percentile.'</td>
							</tr>';
							if($count==0){
								if($sr%26==0){
									$main_content.='</tbody></table></div><div class="page"><table class="table table-bordered borderb1"><tbody>';
									$count+=1;
								}

							}else if($sr>30){
								if(($sr+5)%31==0){
									$main_content.='</tbody></table></div><div class="page"><table class="table table-bordered borderb1 page"><tbody>';
									$count+=1;
								}
							}
				    fputcsv($handle, array($sr, $val['std_roll_no'], $student_name, $val['col1_score'], $val['col2_score'], $val['col3_score'], $val['col4_score'], $val['col5_score'],  $val['total_score'], $percentage, $rank, $percentile));
			
		}else{
			echo "Error! Try Again";
			exit();
		}
		$main_content.='</tbody>
					</table></div>
			</div>';
	
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
	</div>";
}
// / The w+ parameter will wipe out and overwrite any existing file with the same name
			
			// Write all the user records to the spreadsheet
			// foreach($dbh->select_res as $row){
			// }
			
			 
			// Finish writing the file
			fclose($handle);
	$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Test result of evaluated OMR Sheets.",
				"title"=>"Test result | tReader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("pages/blank.ta", $vars);

?>