<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	include_once("./classes/main.class.php");
	include_once("./classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$fname="";
	$lname="";
	$roll_no="";
	$main=new main();
	$main->show_msg();
	function getCls($x, $y){
		switch($x){
			case "blank":
				$cls="";
				break;
			case array("blank"):
				$cls="";
				break;
			case array("blank", "blank", "blank", "blank", "blank"):
				$cls="";
				break;
			case "wrong":
				$cls="text-warning";
				break;
			case array("wrong"):
				$cls="text-warning";
				break;
			case $y:
				$cls="text-success";
				break;
			default:
				$cls="text-danger";
				break;
		}
		if($y=="blank"||$y==array("blank", "blank", "blank", "blank", "blank")||$y==array("blank")){
			$cls="";
		}
		return $cls;
	}

	if(isset($_GET['test_id'])&&isset($_GET['roll_no'])&&isset($_GET['result_id'])){

		$std_roll_no=$_GET['roll_no'];
		$roll_no=$_GET['roll_no'];
		$result_id=$_GET['result_id'];
		$dbh->select("students", "fname, lname", "roll_no='$roll_no'", "none", "1");
		if($dbh->sel_count_row>0){	
			$fname=$dbh->select_res['fname'];
			$lname=$dbh->select_res['lname'];
		}else{
			$fname="Roll No. mistake";
			$lname="";
		}
		$test_id=$_GET['test_id'];
		$dbh->select("tests", "omr_code, answer_data", "test_id='$test_id'", "none", "1");
		$correct_ans_data=$dbh->select_res['answer_data'];
		$correct_ans_data_arr=json_decode($correct_ans_data, true);
		$omr_id=$dbh->select_res['omr_code'];
		$dbh->select("omrsheets", "sub_pattern, sub_qs_dist, col_qs_pattern", "id='$omr_id'", "none", "1");
		$sub_pattern=$dbh->select_res['sub_pattern'];
		$sheet_pattern_arr=explode(",", $dbh->select_res['col_qs_pattern']);
		$sub_qs_arr=explode(",", $dbh->select_res['sub_qs_dist']);
		$total_q_col1=$sheet_pattern_arr[0]+$sheet_pattern_arr[1]+$sheet_pattern_arr[2]+$sheet_pattern_arr[3]+$sheet_pattern_arr[4];
		$total_qs=$sub_qs_arr[0]+$sub_qs_arr[1]+$sub_qs_arr[2]+$sub_qs_arr[3]+$sub_qs_arr[4];
		$dbh->select("scaned_omrs", "test_data", "id='$result_id'", "none", "1");
		if($dbh->sel_count_row>0){
			$ansdatastring=$dbh->select_res['test_data'];
			if($ansdatastring!=""){
				$ansdata=json_decode($ansdatastring, true);
				$main_content='<div class="row-fluid"><div class="span12">
				<h4 class="alignC">Evaluated OMR data of '.$fname.'</h4>
				<table class="table table-bordered"><thead>
				<tr>
					<td><b>Q. No.</b></td>
					<td><b>Subject 1st<span class="rightAns">Master Key</span></b></td>
					<td><b>Q. No.</b></td>
					<td><b>Subject 2nd<span class="rightAns">Master Key</span></b></td>
					<td><b>Q. No.</b></td>
					<td><b>Subject 3rd<span class="rightAns">Master Key</span></b></td>
				</tr>
				</thead>';
				if($sub_pattern=="crn"){
					$main_content='<div class="row-fluid"><div class="span12">
					<h4 class="alignC">Evaluated OMR data of '.$fname.'</h4>
					<table class="table table-bordered"><thead>
					<tr>
						<td><b>Q. No.</b></td>
						<td><b>Student Answers <span class="rightAns">Master Key</span></b></td>
						</tr>
					</thead>';
				}
				$q_no=1;
				foreach($ansdata as $sub=> $val){
					$mcqs_content="";
					if($sub_pattern=="crn"){
						if(isset($val['mcqsq'])){
							foreach ($val['mcqsq'] as $key=>$ans) {
								$cls1=getCls($ansdata[$sub]['mcqsq'][$key], $correct_ans_data_arr[$sub]['mcqsq'][$key]);
								$q_no_col2=$q_no+$total_q_col1;
								$q_no_col3=$q_no+$total_q_col1*2;
								$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$ans.'<span class="rightAns">'.$correct_ans_data_arr[$sub]['mcqsq'][$key].'</span></td></tr>';
								if($q_no==$total_qs){
									break;
								}
								$q_no++;
							}
						}
					}else if($sub_pattern=="cn"){
						if(isset($val['mcqsq'])){
							foreach ($val['mcqsq'] as $key=>$ans) {
								$cls1=getCls($ansdata['sub_1']['mcqsq'][$key], $correct_ans_data_arr['sub_1']['mcqsq'][$key]);
								$cls2=getCls($ansdata['sub_2']['mcqsq'][$key], $correct_ans_data_arr['sub_2']['mcqsq'][$key]);
								$cls3=getCls($ansdata['sub_3']['mcqsq'][$key], $correct_ans_data_arr['sub_3']['mcqsq'][$key]);
								$q_no_col2=$q_no+$total_q_col1;
								$q_no_col3=$q_no+$total_q_col1*2;
								$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$ans.'<span class="rightAns">'.$correct_ans_data_arr['sub_1']['mcqsq'][$key].'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$ansdata['sub_2']['mcqsq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_2']['mcqsq'][$key].'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$ansdata['sub_3']['mcqsq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_3']['mcqsq'][$key].'</span></td></tr>';
								$q_no++;
							}
						}
						break;
					}else{
						if(isset($val['mcqsq'])){
							foreach ($val['mcqsq'] as $key=>$ans) {

								$cls1=getCls($ansdata['sub_1']['mcqsq'][$key], $correct_ans_data_arr['sub_1']['mcqsq'][$key]);
								$cls2=getCls($ansdata['sub_2']['mcqsq'][$key], $correct_ans_data_arr['sub_2']['mcqsq'][$key]);
								$cls3=getCls($ansdata['sub_3']['mcqsq'][$key], $correct_ans_data_arr['sub_3']['mcqsq'][$key]);
								$q_no_col2=$q_no;
								$q_no_col3=$q_no;
								$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$ans.'<span class="rightAns">'.$correct_ans_data_arr['sub_1']['mcqsq'][$key].'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$ansdata['sub_2']['mcqsq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_2']['mcqsq'][$key].'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$ansdata['sub_3']['mcqsq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_3']['mcqsq'][$key].'</span></td></tr>';
								$q_no++;
							}
						}
					}
						
					if(isset($val['mcqmq'])){
						$mcqm_content='';
						foreach ($val['mcqmq'] as $key=>$ans) {

							$cls1=getCls($ansdata['sub_1']['mcqmq'][$key], $correct_ans_data_arr['sub_1']['mcqmq'][$key]);
							$cls2=getCls($ansdata['sub_2']['mcqmq'][$key], $correct_ans_data_arr['sub_2']['mcqmq'][$key]);
							$cls3=getCls($ansdata['sub_3']['mcqmq'][$key], $correct_ans_data_arr['sub_3']['mcqmq'][$key]);
							
							$all_ans1="";
							$all_ans2="";
							$all_ans3="";

							$all_crct_ans1="";
							$all_crct_ans2="";
							$all_crct_ans3="";
							foreach($ans as $subans){
								$all_ans1.=$subans.",";
							}
							foreach($ansdata['sub_2']['mcqmq'][$key] as $subans){
								$all_ans2.=$subans.",";
							}
							foreach($ansdata['sub_3']['mcqmq'][$key] as $subans){
								$all_ans3.=$subans.",";
							}

							foreach($correct_ans_data_arr['sub_1']['mcqmq'][$key] as $subansc){
								$all_crct_ans1.=$subansc.",";
							}
							foreach($correct_ans_data_arr['sub_2']['mcqmq'][$key] as $subansc){
								$all_crct_ans2.=$subansc.",";
							}
							foreach($correct_ans_data_arr['sub_3']['mcqmq'][$key] as $subansc){
								$all_crct_ans3.=$subansc.",";
							}
							$q_no_col2=$q_no;
							$q_no_col3=$q_no;
							$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$all_ans1.'<span class="rightAns">'.$all_crct_ans1.'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$all_ans2.'<span class="rightAns">'.$all_crct_ans2.'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$all_ans3.'<span class="rightAns">'.$all_crct_ans3.'</span></td></tr>';
							$q_no++;
							
						}
					}
					if(isset($val['compq'])){
						foreach ($val['compq'] as $key=>$ans) {
							$cls1=getCls($ansdata['sub_1']['compq'][$key], $correct_ans_data_arr['sub_1']['compq'][$key]);
							$cls2=getCls($ansdata['sub_2']['compq'][$key], $correct_ans_data_arr['sub_2']['compq'][$key]);
							$cls3=getCls($ansdata['sub_3']['compq'][$key], $correct_ans_data_arr['sub_3']['compq'][$key]);
							$q_no_col2=$q_no;
							$q_no_col3=$q_no;
							$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$ans.'<span class="rightAns">'.$correct_ans_data_arr['sub_1']['compq'][$key].'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$ansdata['sub_2']['compq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_2']['compq'][$key].'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$ansdata['sub_3']['compq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_3']['compq'][$key].'</span></td></tr>';
							$q_no++;
						}
					}
					if(isset($val['digit1q'])){
						foreach ($val['digit1q'] as $key=>$ans) {
							$cls1=getCls($ansdata['sub_1']['digit1q'][$key], $correct_ans_data_arr['sub_1']['digit1q'][$key]);
							$cls2=getCls($ansdata['sub_2']['digit1q'][$key], $correct_ans_data_arr['sub_2']['digit1q'][$key]);
							$cls3=getCls($ansdata['sub_3']['digit1q'][$key], $correct_ans_data_arr['sub_3']['digit1q'][$key]);
							$q_no_col2=$q_no;
							$q_no_col3=$q_no;
							$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$ans.'<span class="rightAns">'.$correct_ans_data_arr['sub_1']['digit1q'][$key].'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$ansdata['sub_2']['digit1q'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_2']['digit1q'][$key].'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$ansdata['sub_3']['digit1q'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_3']['digit1q'][$key].'</span></td></tr>';
							$q_no++;
						}
					}
					if(isset($val['matrixq'])){
						$matrix_content='';
						foreach ($val['matrixq'] as $key=>$ans) {
							$all_ans1="";
							$all_ans2="";
							$all_ans3="";
							$sub_ans_set='';

							$all_cans1="";
							$all_cans2="";
							$all_cans3="";
							$sub_cans_set='';
							foreach($ans as $subkey=>$subans){
								$sub_ans_set='';
								foreach($subans as $subin_ans){
									$sub_ans_set.=$subin_ans."-";
								}
								$cls1=getCls($subans, $correct_ans_data_arr['sub_1']['matrixq'][$key][$subkey]);
								$all_ans1.="<span class='".$cls1."'>".$sub_ans_set."</span>,";
								
								$sub_cans_set='';
								foreach($correct_ans_data_arr['sub_1']['matrixq'][$key][$subkey] as $c_ans){
									$sub_cans_set.=$c_ans."-";
								}
								$all_cans1.=$sub_cans_set.",";
							}
							foreach($ansdata['sub_2']['matrixq'][$key] as $subkey=>$subans){
								$sub_ans_set='';
								foreach($subans as $subin_ans){
									$sub_ans_set.=$subin_ans."-";
								}
								$cls2=getCls($subans, $correct_ans_data_arr['sub_2']['matrixq'][$key][$subkey]);

								$all_ans2.="<span class='".$cls2."'>".$sub_ans_set."</span>,";
								
								$sub_cans_set='';
								foreach($correct_ans_data_arr['sub_2']['matrixq'][$key][$subkey] as $c_ans){
									$sub_cans_set.=$c_ans."-";
								}

								$all_cans2.=$sub_cans_set.",";

							}
							foreach($ansdata['sub_3']['matrixq'][$key] as $subkey=>$subans){
								$sub_ans_set='';
								foreach($subans as $subin_ans){
									$sub_ans_set.=$subin_ans."-";
								}
								$cls3=getCls($subans, $correct_ans_data_arr['sub_3']['matrixq'][$key][$subkey]);
								$all_ans3.="<span class='".$cls3."'>".$sub_ans_set."</span>,";
								
								$sub_cans_set='';
								foreach($correct_ans_data_arr['sub_3']['matrixq'][$key][$subkey] as $c_ans){
									$sub_cans_set.=$c_ans."-";
								}

								$all_cans3.=$sub_cans_set.",";
							}
							$q_no_col2=$q_no;
							$q_no_col3=$q_no;
							
							$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$all_ans1.'<span class="rightAnsMatrix">'.$all_cans1.'</span></td><td><b>'.$q_no_col2.'.</b></td><td>'.$all_ans2.'<span class="rightAns">'.$all_cans2.'</span></td><td><b>'.$q_no_col3.'.</b></td><td>'.$all_ans3.'<span class="rightAns">'.$all_cans3.'</span></td></tr>';
							$q_no++;
						}
					}
					if(isset($val['digitq'])){
						$digitq_content='';
						foreach ($val['digitq'] as $key=>$ans) {
							$all_ans1="";
							$all_ans2="";
							$all_ans3="";

							$all_cans1="";
							$all_cans2="";
							$all_cans3="";
							foreach($ans as $subkey=>$subans){
								$all_ans1.=$subans.",";
								$all_cans1.=$correct_ans_data_arr['sub_1']['digitq'][$key][$subkey].",";
							}

							foreach($ansdata['sub_2']['digitq'][$key] as $subkey=>$subans){
								$all_ans2.=$subans.",";
								$all_cans2.=$correct_ans_data_arr['sub_2']['digitq'][$key][$subkey].",";
							}
							foreach($ansdata['sub_3']['digitq'][$key] as $subkey=>$subans){
								$all_ans3.=$subans.",";
								$all_cans3.=$correct_ans_data_arr['sub_3']['digitq'][$key][$subkey].",";
							}

							$cls1=getCls($ansdata['sub_1']['digitq'][$key], $correct_ans_data_arr['sub_1']['digitq'][$key]);
							$cls2=getCls($ansdata['sub_2']['digitq'][$key], $correct_ans_data_arr['sub_2']['digitq'][$key]);
							$cls3=getCls($ansdata['sub_3']['digitq'][$key], $correct_ans_data_arr['sub_3']['digitq'][$key]);
							$q_no_col2=$q_no;
							$q_no_col3=$q_no;
							$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$all_ans1.'<span class="rightAnsMatrix">'.$all_cans1.'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$all_ans2.'<span class="rightAnsMatrix">'.$all_cans2.'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$all_ans3.'<span class="rightAnsMatrix">'.$all_cans3.'</span></td></tr>';
							$q_no++;
							
						}
						break;
					}

					if(isset($val['arq'])){
						foreach ($val['arq'] as $key=>$ans) {
							$cls1=getCls($ansdata['sub_1']['arq'][$key], $correct_ans_data_arr['sub_1']['arq'][$key]);
							$cls2=getCls($ansdata['sub_2']['arq'][$key], $correct_ans_data_arr['sub_2']['arq'][$key]);
							$cls3=getCls($ansdata['sub_3']['arq'][$key], $correct_ans_data_arr['sub_3']['arq'][$key]);
							$q_no_col2=$q_no;
							$q_no_col3=$q_no;
							$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$ans.'<span class="rightAns">'.$correct_ans_data_arr['sub_1']['arq'][$key].'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$ansdata['sub_2']['arq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_2']['arq'][$key].'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$ansdata['sub_3']['arq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_3']['arq'][$key].'</span></td></tr>';
							$q_no++;
						}
					}

					if(isset($val['tfq'])){
						foreach ($val['tfq'] as $key=>$ans) {
							$cls1=getCls($ansdata['sub_1']['tfq'][$key], $correct_ans_data_arr['sub_1']['tfq'][$key]);
							$cls2=getCls($ansdata['sub_2']['tfq'][$key], $correct_ans_data_arr['sub_2']['tfq'][$key]);
							$cls3=getCls($ansdata['sub_3']['tfq'][$key], $correct_ans_data_arr['sub_3']['tfq'][$key]);
							$q_no_col2=$q_no;
							$q_no_col3=$q_no;
							$main_content.='<tr><td><b>'.$q_no.'.</b></td><td class="'.$cls1.'">'.$ans.'<span class="rightAns">'.$correct_ans_data_arr['sub_1']['tfq'][$key].'</span></td><td><b>'.$q_no_col2.'.</b></td><td class="'.$cls2.'">'.$ansdata['sub_2']['tfq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_2']['tfq'][$key].'</span></td><td><b>'.$q_no_col3.'.</b></td><td class="'.$cls3.'">'.$ansdata['sub_3']['tfq'][$key].'<span class="rightAns">'.$correct_ans_data_arr['sub_3']['tfq'][$key].'</span></td></tr>';
							$q_no++;
						}
					}
						
				}
				$main_content.="</tbody><table></div>
				
				</div>

				";
			}else{
				$main_content="<h4>No data available because your OMR sheet checked manually</h4>";
			}
		}else{
			$main_content="There is some mistake with Student Roll No. OR Test Code! Try with another student data.";
		}
	}else{
		$main_content="<h4>Please refresh your page and try again from starting!</h4>";

	}
	$vars=array(
		"page"=>array(
			"title"=>"Answer Sheet Finelization! | triaas",
			"msg"=>$main->msg,
			'msg_cls'=>$main->msg_cls,
			'main_content'=>$main_content
			),
		"student"=>array(
			'roll_no'=>$roll_no,
			'fname'=>ucfirst($fname),
			'lname'=>ucfirst($lname)

			)
		);
	$main->display("./pages/omre-blank.ta", $vars);
}else{
	header("Location:./admin-login.php?msg=Session expired! Please login again&msg-clr=red");
	exit();
}


?>