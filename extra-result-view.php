<?php
session_start();
include_once("classes/main.class.php");
include_once("classes/institute.class.php");
$inst=new institute();
$main=new main();
$main->show_msg();
if(isset($_GET['test_id'])&&isset($_GET['report_type'])){
	$count=0;
	$test_id=$_GET['test_id'];
	$report_type=$_GET['report_type'];
	include_once("classes/db.class.php");
		
	$dbh=new db("triaasco_omr");
	$dbh->select("tests", "test_name, test_date, std_type, omr_code, sub_pattern, max_score, minor_name", "test_id='$test_id'", "none", "1");
	$test_name=$dbh->select_res['test_name'];
	$std_type=$dbh->select_res['std_type'];
	$sub_pattern=$dbh->select_res['sub_pattern'];
	$minor_name=$dbh->select_res['minor_name'];
	$minor_name="";
	if($dbh->select_res['test_date']!=""){
		$test_date_arr=explode("-", $dbh->select_res['test_date']);
		$test_date=$test_date_arr[2]."-".$test_date_arr[1]."-".$test_date_arr[0];
	}else{
		$test_date="DD-MM-YYYY";
	}
		
	$max_score=$dbh->select_res['max_score'];
	$omr_id=$dbh->select_res['omr_code'];
	$dbh->select("omrsheets", "sub_pattern, no_of_subs, sub_names", "id='$omr_id'", "none", "1");
	$sub_pattern=$dbh->select_res['sub_pattern'];
	$total_subs=$dbh->select_res['no_of_subs'];
	$sub_names=explode(",", $dbh->select_res['sub_names']);
	$subs_th="";
	$subs_td="";
	for($i=0; $i<$total_subs; $i++){
		if($_GET['report_type']=="sub1wise"&&$i==0){
			$subs_th.='<th><b style="color:blue">'.$sub_names[$i].'</b></th>';
		}else if($_GET['report_type']=="sub2wise"&&$i==1){
			$subs_th.='<th><b style="color:blue">'.$sub_names[$i].'</b></th>';
		}else if($_GET['report_type']=="sub3wise"&&$i==2){
			$subs_th.='<th><b style="color:blue">'.$sub_names[$i].'</b></th>';
		}else if($_GET['report_type']=="sub4wise"&&$i==3){
			$subs_th.='<th><b style="color:blue">'.$sub_names[$i].'</b></th>';
		}else if($_GET['report_type']=="sub5wise"&&$i==4){
			$subs_th.='<th><b style="color:blue">'.$sub_names[$i].'</b></th>';
		}else{
			$subs_th.='<th>'.$sub_names[$i].'</th>';
		}
	}
	function cols_td($total_subs, $cols_score_arr, $sub_names_arr){
		$subs_td="";
		for($i=1; $i<=$total_subs; $i++){
			$name_id=$i-1;
			$subs_td.='<td><a class="pointer" title="'.$sub_names_arr[$name_id].'">'.$cols_score_arr["col".$i."_score"].'</a></td>';
		}
		return $subs_td;
	}
	if($report_type=='top5'){
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id'", "total_score DESC", '5');
		$filename="Result excels/".$test_name.".csv";
			 
		$main_content='<div class="row-fluid">
				<div class="span12 alignC"><img src="images/'.$inst->logo_large.'" width="600px"/></div>
				<div class="span12 alignC marginl0"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 alignC  marginl0 marginb20">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							<th>STUDENT PHOTO</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score="";
		if($dbh->sel_count_row<2){
			echo "There are less than two students participatee in this test so no data availabale for this type of reprt! Go back.";
			exit();
		}
		foreach($dbh->select_res as $key=>$val){
			$sr=$key+1;
			if($val['total_score']==$last_score){
				$rank=$rank;
			}else{
				$rank=$rank+1;
			}
			$last_score=$val['total_score'];
			
					$std_roll_no=$val['std_roll_no'];
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);

					$roll_l=strlen($std_roll_no);
						$rem_no=6-$roll_l;
						for($x=0; $x<$rem_no; $x++){
							$std_roll_no="0".$std_roll_no;
						}

						$dbh->select("students", "fname, lname, img_src", "roll_no='$std_roll_no'", "none", "1");
						if($dbh->sel_count_row>0){
							$fname=$dbh->select_res['fname'];
							$lname=$dbh->select_res['lname'];
							$student_name=ucfirst($fname)." ".ucfirst($lname);
							if(file_exists("./images/students/".$dbh->select_res['img_src'])){
								$img_src="./images/students/".$dbh->select_res['img_src'];
							}else{
								$img_src="./images/default-pic.jpg";
							}
						}else{
							$student_name="Roll No. Mistake";
								$img_src="./images/default-pic.jpg";

						}
						
					$omr_src=$val['omr_src'];
						$main_content.='
						<tr class="borderb1">
						<td>'.$sr.'</td>
						<td>'.$std_roll_no.'</td>
						<td><b>'.$student_name.'</b></td>
						<td><img src="'.$img_src.'" width="72"></td>
						'.cols_td($total_subs, $val, $sub_names).'
						<td>'.$val['total_score'].'</td>
						<td>'.$percentage.'%</td>
						<td>'.$rank.'</td>
						</tr>';
						if($count==0){
							if($sr%27==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1 " style="page-break-before:always"><tbody>';
								$count+=1;
							}

						}else if($sr>31){
							if(($sr+5)%32==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1" style="ppage-break-before:always"><tbody>';
								$count+=1;
							}
						}

		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
	
	}else if($report_type=="top20"){
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id'", "total_score DESC", '20');
		$filename="Result excels/".$test_name.".csv";
			 
		$main_content='<div class="row-fluid">
				<div class="span12 alignC"><img src="images/'.$inst->logo_large.'" width="600px"/></div>
				<div class="span12 alignC marginl0"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 alignC  marginl0 marginb20">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							<th>STUDENT PHOTO</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score="";
		if($dbh->sel_count_row<2){
			echo "There are less than two students participatee in this test so no data availabale for this type of reprt! Go back.";
			exit();
		}
		foreach($dbh->select_res as $key=>$val){
			$sr=$key+1;
			if($val['total_score']==$last_score){
				$rank=$rank;
			}else{
				$rank=$rank+1;
			}
			$last_score=$val['total_score'];
			
					$std_roll_no=$val['std_roll_no'];
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);

					$roll_l=strlen($std_roll_no);
						$rem_no=6-$roll_l;
						for($x=0; $x<$rem_no; $x++){
							$std_roll_no="0".$std_roll_no;
						}

						$dbh->select("students", "fname, lname, img_src", "roll_no='$std_roll_no'", "none", "1");
						if($dbh->sel_count_row>0){
							$fname=$dbh->select_res['fname'];
							$lname=$dbh->select_res['lname'];
							$student_name=ucfirst($fname)." ".ucfirst($lname);
							if(file_exists("./images/students/".$dbh->select_res['img_src'])){
								$img_src="./images/students/".$dbh->select_res['img_src'];
							}else{
								$img_src="./images/default-pic.jpg";
							}
						}else{
							$img_src="./images/default-pic.jpg";
							$student_name="Roll No. Mistake";
						}
							
					$omr_src=$val['omr_src'];
						$main_content.='
						<tr class="borderb1">
						<td>'.$sr.'</td>
						<td>'.$std_roll_no.'</td>
						<td><b>'.$student_name.'</b></td>
						<td><img src="'.$img_src.'" width="72"></td>
						'.cols_td($total_subs, $val, $sub_names).'
						<td>'.$val['total_score'].'</td>
						<td>'.$percentage.'%</td>
						<td>'.$rank.'</td>
						</tr>';
						if($count==0){
							if($sr%27==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1 " style="page-break-before:always"><tbody>';
								$count+=1;
							}

						}else if($sr>31){
							if(($sr+5)%32==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1" style="ppage-break-before:always"><tbody>';
								$count+=1;
							}
						}

		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
	
	}else if($report_type=="sub1wise"){
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id'", "col1_score DESC", 'none');
		$filename="Result excels/".$test_name.".csv";
			 
		$main_content='<div class="row-fluid">
				<div class="span12 alignC"><img src="images/'.$inst->logo_large.'" width="600px"/></div>
				<div class="span12 alignC marginl0"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 alignC  marginl0 marginb20">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK('.$sub_names[0].')</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score="";
		if($dbh->sel_count_row<2){
			echo "There are less than two students participate for this test so no data availabale for this type of reprt! Go back.";
			exit();
		}
		foreach($dbh->select_res as $key=>$val){
			$sr=$key+1;
			if($val['col2_score']==$last_score){
				$rank=$rank;
			}else{
				$rank=$rank+1;
			}
			$last_score=$val['col2_score'];
			
					$std_roll_no=$val['std_roll_no'];
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);

					$roll_l=strlen($std_roll_no);
						$rem_no=6-$roll_l;
						for($x=0; $x<$rem_no; $x++){
							$std_roll_no="0".$std_roll_no;
						}

						$dbh->select("students", "fname, lname, img_src", "roll_no='$std_roll_no'", "none", "1");
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
						'.cols_td($total_subs, $val, $sub_names).'
						<td>'.$val['total_score'].'</td>
						<td>'.$percentage.'%</td>
						<td>'.$rank.'</td>
						</tr>';
						if($count==0){
							if($sr%27==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1 " style="page-break-before:always"><tbody>';
								$count+=1;
							}

						}else if($sr>31){
							if(($sr+5)%32==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1" style="ppage-break-before:always"><tbody>';
								$count+=1;
							}
						}

		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
	}else if($report_type=="sub2wise"){
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id'", "col2_score DESC", 'none');
		$filename="Result excels/".$test_name.".csv";
			 
		$main_content='<div class="row-fluid">
				<div class="span12 alignC"><img src="images/'.$inst->logo_large.'" width="600px"/></div>
				<div class="span12 alignC marginl0"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 alignC  marginl0 marginb20">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK('.$sub_names[1].')</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score="";
		if($dbh->sel_count_row<2){
			echo "There are less than two students participate for this test so no data availabale for this type of reprt! Go back.";
			exit();
		}
		foreach($dbh->select_res as $key=>$val){
			$sr=$key+1;
			if($val['col1_score']==$last_score){
				$rank=$rank;
			}else{
				$rank=$rank+1;
			}
			$last_score=$val['col1_score'];
			
					$std_roll_no=$val['std_roll_no'];
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);

					$roll_l=strlen($std_roll_no);
						$rem_no=6-$roll_l;
						for($x=0; $x<$rem_no; $x++){
							$std_roll_no="0".$std_roll_no;
						}

						$dbh->select("students", "fname, lname, img_src", "roll_no='$std_roll_no'", "none", "1");
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
						'.cols_td($total_subs, $val, $sub_names).'
						<td>'.$val['total_score'].'</td>
						<td>'.$percentage.'%</td>
						<td>'.$rank.'</td>
						</tr>';
						if($count==0){
							if($sr%27==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1 " style="page-break-before:always"><tbody>';
								$count+=1;
							}

						}else if($sr>31){
							if(($sr+5)%32==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1" style="ppage-break-before:always"><tbody>';
								$count+=1;
							}
						}

		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
	}else if($report_type=="sub3wise"){
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id'", "col3_score DESC", 'none');
		$filename="Result excels/".$test_name.".csv";
			 
		$main_content='<div class="row-fluid">
				<div class="span12 alignC"><img src="images/'.$inst->logo_large.'" width="600px"/></div>
				<div class="span12 alignC marginl0"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 alignC  marginl0 marginb20">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK('.$sub_names[2].')</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score="";
		if($dbh->sel_count_row<2){
			echo "There are less than two students participate for this test so no data availabale for this type of reprt! Go back.";
			exit();
		}
		foreach($dbh->select_res as $key=>$val){
			$sr=$key+1;
			if($val['col3_score']==$last_score){
				$rank=$rank;
			}else{
				$rank=$rank+1;
			}
			$last_score=$val['col3_score'];
			
					$std_roll_no=$val['std_roll_no'];
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);

					$roll_l=strlen($std_roll_no);
						$rem_no=6-$roll_l;
						for($x=0; $x<$rem_no; $x++){
							$std_roll_no="0".$std_roll_no;
						}

						$dbh->select("students", "fname, lname, img_src", "roll_no='$std_roll_no'", "none", "1");
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
						'.cols_td($total_subs, $val, $sub_names).'
						<td>'.$val['total_score'].'</td>
						<td>'.$percentage.'%</td>
						<td>'.$rank.'</td>
						</tr>';
						if($count==0){
							if($sr%27==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1 " style="page-break-before:always"><tbody>';
								$count+=1;
							}

						}else if($sr>31){
							if(($sr+5)%32==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1" style="ppage-break-before:always"><tbody>';
								$count+=1;
							}
						}

		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
	}else if($report_type=="sub4wise"){
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id'", "col4_score DESC", 'none');
		$filename="Result excels/".$test_name.".csv";
			 
		$main_content='<div class="row-fluid">
				<div class="span12 alignC"><img src="images/'.$inst->logo_large.'" width="600px"/></div>
				<div class="span12 alignC marginl0"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 alignC  marginl0 marginb20">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK('.$sub_names[4].')</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score="";
		if($dbh->sel_count_row<2){
			echo "There are less than two students participate for this test so no data availabale for this type of reprt! Go back.";
			exit();
		}
		foreach($dbh->select_res as $key=>$val){
			$sr=$key+1;
			if($val['col3_score']==$last_score){
				$rank=$rank;
			}else{
				$rank=$rank+1;
			}
			$last_score=$val['col3_score'];
			
					$std_roll_no=$val['std_roll_no'];
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);

					$roll_l=strlen($std_roll_no);
						$rem_no=6-$roll_l;
						for($x=0; $x<$rem_no; $x++){
							$std_roll_no="0".$std_roll_no;
						}

						$dbh->select("students", "fname, lname, img_src", "roll_no='$std_roll_no'", "none", "1");
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
						'.cols_td($total_subs, $val, $sub_names).'
						<td>'.$val['total_score'].'</td>
						<td>'.$percentage.'%</td>
						<td>'.$rank.'</td>
						</tr>';
						if($count==0){
							if($sr%27==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1 " style="page-break-before:always"><tbody>';
								$count+=1;
							}

						}else if($sr>31){
							if(($sr+5)%32==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1" style="ppage-break-before:always"><tbody>';
								$count+=1;
							}
						}

		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
	}else if($report_type=="sub5wise"){
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score, omr_src", "test_id='$test_id'", "col5_score DESC", 'none');
		$filename="Result excels/".$test_name.".csv";
			 
		$main_content='<div class="row-fluid">
				<div class="span12 alignC"><img src="images/'.$inst->logo_large.'" width="600px"/></div>
				<div class="span12 alignC marginl0"><a class="pushL printHide" href="view-result.php?test_id='.$test_id.'&report=whole">Back</a><b>'.$minor_name.' (DATE: '.$test_date.') </b><a class="pushR pointer printHide" onclick="printPage()">Print</a></div>
				<div class="span12"><h3 class="alignC">'.$test_name.'</h3><hr/></div>
				<div class="span12 alignC  marginl0 marginb20">
					<table class="table table-bordered borderb1">
						<thead>
						<tr class="borderb1">
							<th>SR</th>
							
							<th>ROLL NO</th>
							<th>STUDENT NAME</th>
							'.$subs_th.'
							<th>TOTAL</th>
							<th>PER%</th>
							<th>RANK('.$sub_names[4].')</th>
						</tr>
						</thead><tbody>';
						$rank=0;
						$last_score="";
		if($dbh->sel_count_row<2){
			echo "There are less than two students participatee in this test so no data availabale for this type of reprt! Go back.";
			exit();
		}
		foreach($dbh->select_res as $key=>$val){
			$sr=$key+1;
			if($val['col3_score']==$last_score){
				$rank=$rank;
			}else{
				$rank=$rank+1;
			}
			$last_score=$val['col3_score'];
			
					$std_roll_no=$val['std_roll_no'];
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);

					$roll_l=strlen($std_roll_no);
						$rem_no=6-$roll_l;
						for($x=0; $x<$rem_no; $x++){
							$std_roll_no="0".$std_roll_no;
						}

						$dbh->select("students", "fname, lname, img_src", "roll_no='$std_roll_no'", "none", "1");
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
						'.cols_td($total_subs, $val, $sub_names).'
						<td>'.$val['total_score'].'</td>
						<td>'.$percentage.'%</td>
						<td>'.$rank.'</td>
						</tr>';
						if($count==0){
							if($sr%27==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1 " style="page-break-before:always"><tbody>';
								$count+=1;
							}

						}else if($sr>31){
							if(($sr+5)%32==0){
								$main_content.='</tbody></table><table class="table table-bordered borderb1" style="ppage-break-before:always"><tbody>';
								$count+=1;
							}
						}

		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
	}else{
		header("Location:./result-print-view.php?test_id=".$test_id);
		exit();
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
	</div>";
}
// / The w+ parameter will wipe out and overwrite any existing file with the same name
			
			// Write all the user records to the spreadsheet
			// foreach($dbh->select_res as $row){
			// }
			
			 
			// Finish writing the file
	$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Test result of evaluated OMR Sheets.",
				"title"=>"Test result | t-Reader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("pages/blank.ta", $vars);

?>