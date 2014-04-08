<?php
session_start();

	include_once("classes/main.class.php");
	include_once("classes/db.class.php");
	$main=new main();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	$dbh->select("omrsheets", "id, sheet_name, sub_pattern, no_of_subs, sub_names, sub_qs_dist, col_qs_pattern, marking_pattern, roll_digit, q_opts", "none", "id DESC", "none");
	$omr_list='<table class="table"><thead><tr><th>Sheet Name</th> <th>Perview</th><th>Marking Scheme</th></tr></thead><tbody>';
	if($dbh->sel_count_row>0){
		if($dbh->sel_count_row==1){
			$marking_pattern=$dbh->select_res['marking_pattern'];
			$marking_arr=explode("|", $marking_pattern);
			$mcqs_marking=explode(",", $marking_arr[0]);
			$mcqm_marking=explode(",", $marking_arr[1]);
			$compq_marking=explode(",", $marking_arr[2]);
			$digit1q_marking=explode(",", $marking_arr[3]);
			$matrixq_marking=explode(",", $marking_arr[4]);
			$digitq_marking=explode(",", $marking_arr[5]);
			$arq_marking=explode(",", $marking_arr[6]);
			$tfq_marking=explode(",", $marking_arr[7]);
			$sheet_name=$dbh->select_res['sheet_name'];
			$sub_pattern=$dbh->select_res['sub_pattern'];
			$sub_no=$dbh->select_res['no_of_subs'];
			$roll_digit=$dbh->select_res['roll_digit'];
			$q_opts=$dbh->select_res['q_opts'];
			if($q_opts==''){
				$q_opts=4;
			}
			$sub_names=explode(",", $dbh->select_res['sub_names']);
			$sub_qs_dist=explode(",", $dbh->select_res['sub_qs_dist']);
			$col_qs_pattern=explode(",", $dbh->select_res['col_qs_pattern']);
			$link='<a target="new" href="./view-omrsheet.php?sheet_name='.$sheet_name.'&sub_pattern='.$sub_pattern.'&sub_no='.$sub_no.'&sub1='.$sub_names[0].'&sub2='.$sub_names[1].'&sub3='.$sub_names[2].'&sub4='.$sub_names[3].'&sub5='.$sub_names[4].'&roll_digit='.$roll_digit.'&sub1Qs='.$sub_qs_dist[0].'&sub2Qs='.$sub_qs_dist[1].'&sub3Qs='.$sub_qs_dist[2].'&sub4Qs='.$sub_qs_dist[3].'&sub5Qs='.$sub_qs_dist[4].'&mcqs='.$col_qs_pattern[0].'&mcqm='.$col_qs_pattern[1].'&compq='.$col_qs_pattern[2].'&digit1q='.$col_qs_pattern[3].'&matrixq='.$col_qs_pattern[4].'&digit4q='.$col_qs_pattern[5].'&arq='.$col_qs_pattern[6].'&tfq='.$col_qs_pattern[7].'&mcqsp='.$mcqs_marking[0].'&mcqsn='.$mcqs_marking[1].'&mcqmp='.$mcqm_marking[0].'&mcqmn='.$mcqm_marking[1].'&compqp='.$compq_marking[0].'&compqn='.$compq_marking[1].'&digit1qp='.$digit1q_marking[0].'&digit1qn='.$digit1q_marking[1].'&matrixqp='.$matrixq_marking[0].'&matrixqn='.$matrixq_marking[1].'&digitqp='.$digitq_marking[0].'&digitqn='.$digitq_marking[1].'&arqp='.$arq_marking[0].'&arqn='.$arq_marking[1].'&tfqp='.$tfq_marking[0].'&tfqn='.$tfq_marking[1].'&q_opts='.$q_opts.'"><i class="icon-fullscreen"></i></a>';
			$omr_list='<tr><td><p value="'.$dbh->select_res['id'].'"><a href="#"> '.$dbh->select_res['sheet_name'].' ('.$dbh->select_res['sub_pattern'].') </p></td><td><span>'.$link.'</span></a></td><td></td></tr>';
		}else{
			foreach($dbh->select_res as $sheet){
				$marking_pattern=$sheet['marking_pattern'];
				$marking_arr=explode("|", $marking_pattern);
				if(isset($marking_arr[7])){
					$mcqs_marking=explode(",", $marking_arr[0]);
					$mcqm_marking=explode(",", $marking_arr[1]);
					$compq_marking=explode(",", $marking_arr[2]);
					$digit1q_marking=explode(",", $marking_arr[3]);
					$matrixq_marking=explode(",", $marking_arr[4]);
					$digitq_marking=explode(",", $marking_arr[5]);
					$arq_marking=explode(",", $marking_arr[6]);
					$tfq_marking=explode(",", $marking_arr[7]);
					$sheet_name=$sheet['sheet_name'];
					$sub_pattern=$sheet['sub_pattern'];
					$roll_digit=$sheet['roll_digit'];
					$q_opts=$sheet['q_opts'];
					if($q_opts==''){
						$q_opts=4;
					}
					$sub_no=$sheet['no_of_subs'];
					$sub_names=explode(",", $sheet['sub_names']);
					$sub_qs_dist=explode(",", $sheet['sub_qs_dist']);
					$col_qs_pattern=explode(",", $sheet['col_qs_pattern']);
					$link='<a target="new" href="./view-omrsheet.php?sheet_name='.$sheet_name.'&sub_pattern='.$sub_pattern.'&sub_no='.$sub_no.'&sub1='.$sub_names[0].'&sub2='.$sub_names[1].'&sub3='.$sub_names[2].'&sub4='.$sub_names[3].'&sub5='.$sub_names[4].'&roll_digit='.$roll_digit.'&sub1Qs='.$sub_qs_dist[0].'&sub2Qs='.$sub_qs_dist[1].'&sub3Qs='.$sub_qs_dist[2].'&sub4Qs='.$sub_qs_dist[3].'&sub5Qs='.$sub_qs_dist[4].'&mcqs='.$col_qs_pattern[0].'&mcqm='.$col_qs_pattern[1].'&compq='.$col_qs_pattern[2].'&digit1q='.$col_qs_pattern[3].'&matrixq='.$col_qs_pattern[4].'&digit4q='.$col_qs_pattern[5].'&arq='.$col_qs_pattern[6].'&tfq='.$col_qs_pattern[7].'&mcqsp='.$mcqs_marking[0].'&mcqsn='.$mcqs_marking[1].'&mcqmp='.$mcqm_marking[0].'&mcqmn='.$mcqm_marking[1].'&compqp='.$compq_marking[0].'&compqn='.$compq_marking[1].'&digit1qp='.$digit1q_marking[0].'&digit1qn='.$digit1q_marking[1].'&matrixqp='.$matrixq_marking[0].'&matrixqn='.$matrixq_marking[1].'&digit4qp='.$digitq_marking[0].'&digit4qn='.$digitq_marking[1].'&arqp='.$arq_marking[0].'&arqn='.$arq_marking[1].'&tfqp='.$tfq_marking[0].'&tfqn='.$tfq_marking[1].'&q_opts='.$q_opts.'"><i class="icon-fullscreen"></i></a>';

					$omr_list.='<tr><td><p value="'.$sheet['id'].'"> '.$sheet['sheet_name'].'  ('.$sheet['sub_pattern'].') </p></td><td><span>'.$link.'</span></td><td>MCQ-SA: +'.$mcqs_marking[0].' , -'.$mcqs_marking[1].' | MCQ-MA: +'.$mcqm_marking[0].' , -'.$mcqm_marking[1].' | Comph.: +'.$compq_marking[0].' , -'.$compq_marking[1].'| Digit1Q.: +'.$digit1q_marking[0].' , -'.$digit1q_marking[1].' | Matrix(each option): +'.$matrixq_marking[0].' , -'.$matrixq_marking[1].' | Digit: +'.$digitq_marking[0].' , -'.$digitq_marking[1].'| A/R: +'.$arq_marking[0].' , -'.$arq_marking[1].'| T/F: +'.$tfq_marking[0].' , -'.$tfq_marking[1].'</td></tr>';
				}
			}
		}
	}else{
		$omr_list='<option value="none">No OMR Sheet created yet!</option>';
	}
	$omr_list.="</tbody></table>";
	$main_content='<div class="row-fluid">
            	<div class="span12">
					<h3 class="alignC">List of created OMR Sheets</h3>
            		<hr/>
            	</div>
            	<div class="span12">
            		'.$omr_list.'
            	</div>
            	</div>';
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Vie list of the all created OMR Sheets",
			"title"=>"All OMR Sheets | triaas",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-blank.ta", $vars);

?>