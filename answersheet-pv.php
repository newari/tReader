<?php

include_once("./classes/main.class.php");
include_once("./classes/db.class.php");
$dbh=new db("triaasco_omr");
$main=new main();
$main->show_msg();
if(isset($_POST['ansdata'])&&isset($_POST['test_id'])||isset($_GET['seted'])){
	if(isset($_GET['seted'])){
		$test_id=$_GET['test_id'];
	}else{
		$ansdatastring=$_POST['ansdata'];
		$test_id=$_POST['test_id'];
	}
		
	$dbh->select("tests", "sub_pattern, omr_code, answer_data", "test_id='$test_id'", "none", "1");
	$sub_pattern=$dbh->select_res['sub_pattern'];
	$omr_id=$dbh->select_res['omr_code'];
	if($dbh->select_res['answer_data']!=''&&isset($_GET['seted'])){
		$ansdatastring=$dbh->select_res['answer_data'];
	}
	$dbh->select("omrsheets", "sub_pattern, sub_qs_dist", "id='$omr_id'", "none", "1");
	$sub_pattern=$dbh->select_res['sub_pattern'];
	$sub_qs_arr=explode(",", $dbh->select_res['sub_qs_dist']);
	$total_qs=$sub_qs_arr[0]+$sub_qs_arr[1]+$sub_qs_arr[2]+$sub_qs_arr[3]+$sub_qs_arr[4];
	$ansdata=json_decode($ansdatastring, true);
	if($sub_pattern=="crn"){
		$main_content='<div class="row-fluid"><div class="span12">
		<h4 class="alignC">Check Master key answers for Test '.$test_id.'</h4>
		<table class="table table-bordered"><thead>
		<tr>
			<td><b>Q. No.</b></td>
			<td><b>Answers</b></td>
		</tr>
		</thead>';
		$q_no=1;
		foreach($ansdata as $key=> $val){
			foreach ($val['mcqsq'] as $key=>$ans){
				$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$ans.'</td></tr>';
				if($q_no==$total_qs){
					break;
				}
				$q_no++;
			}
		}
		$main_content.="</tbody><table></div>
		<div class='span12 alignC'>
			<form action='./scripts/upload-answersheet.php' method='post'>
			<input type='hidden' value='".$ansdatastring."' name='ansdata'/>
			<input type='hidden' value='".$test_id."' name='test_id'/>
			<input type='submit' value='Save and Upload' class='btn btn-warning'/>
			</form>
		</div>
		</div>

		";
	}else{
		$main_content='<div class="row-fluid"><div class="span12">
		<h4 class="alignC">Check Master key answers for Test '.$test_id.'</h4>
		<table class="table table-bordered"><thead>
		<tr>
			<td><b>Q. No.</b></td>
			<td><b>Subject 1st</b></td>
			<td><b>Subject 2nd</b></td>
			<td><b>Subject 3rd</b></td>
		</tr>
		</thead>';
		$q_no=1;
		foreach($ansdata as $key=> $val){
			$mcqs_content="";
			if($sub_pattern=="cn"){
				foreach ($val['mcqsq'] as $key=>$ans){
					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$ans.'</td><td>'.$ansdata["sub_2"]['mcqsq'][$key].'</td><td>'.$ansdata["sub_3"]['mcqsq'][$key].'</td></tr>';
					$q_no++;
				}
			}else{
				if(isset($val['mcqsq'])){
					foreach ($val['mcqsq'] as $key=>$ans){

						$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$ans.'</td><td>'.$ansdata['sub_2']['mcqsq'][$key].'</td><td>'.$ansdata['sub_3']['mcqsq'][$key].'</td></tr>';
						$q_no++;
					}
				}
				
			}
				
			if(isset($val['mcqmq'])){
				$mcqm_content='';
				foreach ($val['mcqmq'] as $key=>$ans){
					$all_ans1="";
					$all_ans2="";
					$all_ans3="";
					foreach($ans as $subans){
						$all_ans1.=$subans.",";
					}
					foreach($ansdata['sub_2']['mcqmq'][$key] as $subans){
						$all_ans2.=$subans.",";
					}
					foreach($ansdata['sub_3']['mcqmq'][$key] as $subans){
						$all_ans3.=$subans.",";
					}
					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$all_ans1.'</td><td>'.$all_ans2.'</td><td>'.$all_ans3.'</td></tr>';
					$q_no++;
					
				}
			}
			if(isset($val['compq'])){
				foreach ($val['compq'] as $key=>$ans){

					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$ans.'</td><td>'.$ansdata['sub_2']['compq'][$key].'</td><td>'.$ansdata['sub_3']['compq'][$key].'</td></tr>';
					$q_no++;
				}
			}
			if(isset($val['digit1q'])){
				foreach ($val['digit1q'] as $key=>$ans){

					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$ans.'</td><td>'.$ansdata['sub_2']['digit1q'][$key].'</td><td>'.$ansdata['sub_3']['digit1q'][$key].'</td></tr>';
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
					foreach($ans as $subans){
						$sub_ans_set='';
						foreach($subans as $subin_ans){
							$sub_ans_set.=$subin_ans."-";
						}
						$all_ans1.=$sub_ans_set.",";
					}
					foreach($ansdata['sub_2']['matrixq'][$key] as $subans){
						$sub_ans_set='';
						foreach($subans as $subin_ans){
							$sub_ans_set.=$subin_ans."-";
						}
						$all_ans2.=$sub_ans_set.",";
					}
					foreach($ansdata['sub_3']['matrixq'][$key] as $subans){
						$sub_ans_set='';
						foreach($subans as $subin_ans){
							$sub_ans_set.=$subin_ans."-";
						}
						$all_ans3.=$sub_ans_set.",";
					}
					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$all_ans1.'</td><td>'.$all_ans2.'</td><td>'.$all_ans3.'</td></tr>';
					$q_no++;
				}
			}
			if(isset($val['digitq'])){
				$digitq_content='';
				foreach ($val['digitq'] as $key=>$ans) {
					$all_ans1="";
					$all_ans2="";
					$all_ans3="";
					foreach($ans as $subans){
						$all_ans1.=$subans.",";
					}
					foreach($ansdata['sub_2']['digitq'][$key] as $subans){
						$all_ans2.=$subans.",";
					}
					foreach($ansdata['sub_3']['digitq'][$key] as $subans){
						$all_ans3.=$subans.",";
					}
					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$all_ans1.'</td><td>'.$all_ans2.'</td><td>'.$all_ans3.'</td></tr>';
					$q_no++;
					
				}
			}
			if(isset($val['arq'])){
				foreach ($val['arq'] as $key=>$ans){

					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$ans.'</td><td>'.$ansdata['sub_2']['arq'][$key].'</td><td>'.$ansdata['sub_3']['arq'][$key].'</td></tr>';
					$q_no++;
				}
			}
			if(isset($val['tfq'])){
				foreach ($val['tfq'] as $key=>$ans){

					$main_content.='<tr><td><b>'.$q_no.'.</b></td><td>'.$ans.'</td><td>'.$ansdata['sub_2']['tfq'][$key].'</td><td>'.$ansdata['sub_3']['tfq'][$key].'</td></tr>';
					$q_no++;
				}
			}
			break;
		}
		$main_content.="</tbody><table></div>
		<div class='span12 alignC'>
			<form action='./scripts/upload-answersheet.php' method='post'>
			<input type='hidden' value='".$ansdatastring."' name='ansdata'/>
			<input type='hidden' value='".$test_id."' name='test_id'/>
			<input type='submit' value='Save and Upload' class='btn btn-warning'/>
			</form>
		</div>
		</div>

		";
	}
}else{
	$main_content="<h4>Please refresh your page and try again from starting!</h4>";

}
$vars=array(
	"page"=>array(
		"title"=>"Answer Sheet Finelization! | t-Reader",
		"msg"=>$main->msg,
		'msg_cls'=>$main->msg_cls,
		'main_content'=>$main_content
		)
	);
$main->display("./pages/omre-blank.ta", $vars);
?>