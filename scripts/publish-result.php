<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	include_once("../classes/db.class.php");
	include_once("../classes/odb.class.php");
	$test_id=$_POST['test_id'];
	$dbh=new db();
	$dbh->select("tests", "test_name, test_date, std_type, omr_code, batch, max_score, sub_pattern, answer_data, minor_name, total_stds, topper, sms_sent", "test_id='$test_id'", "none", "1");
	$test_name=$dbh->select_res['test_name'];
	$test_date=$dbh->select_res['test_date'];
	$std_type=$dbh->select_res['std_type'];
	$omr_id=$dbh->select_res['omr_code'];
	$batch=$dbh->select_res['batch'];
	$max_score=$dbh->select_res['max_score'];
	$sub_pattern=$dbh->select_res['sub_pattern'];
	$answer_data=$dbh->select_res['answer_data'];
	$minor_name=$dbh->select_res['minor_name'];
	$total_stds=$dbh->select_res['total_stds'];
	$topper=$dbh->select_res['topper'];
	$sms_sent=$dbh->select_res['sms_sent'];
	$test_count=$dbh->sel_count_row;

	$dbh->select("omrsheets", "sheet_name, sub_pattern, no_of_subs, sub_names, col_qs_pattern, sub_qs_dist, marking_pattern, roll_digit, js_file, q_opts", "id='$omr_id'", "none", "1");
	if($dbh->sel_count_row>0){
		$sheet_name=$dbh->select_res['sheet_name'];
		$sub_pattern=$dbh->select_res['sub_pattern'];
		$no_of_subs=$dbh->select_res['no_of_subs'];
		$sub_names=$dbh->select_res['sub_names'];
		$col_qs_pattern=$dbh->select_res['col_qs_pattern'];
		$sub_qs_dist=$dbh->select_res['sub_qs_dist'];
		$marking_pattern=$dbh->select_res['marking_pattern'];
		$roll_digit=$dbh->select_res['roll_digit'];
		$js_file=$dbh->select_res['js_file'];
		$q_opts=$dbh->select_res['q_opts'];
	}
	if($test_count>0){
		ini_set('max_execution_time', "1800");
		$odb=new odb();
		$odb->select("tests", "id", "test_id='$test_id'", "none", "1");
		if($odb->sel_count_row>0){
			$odb->update("tests", "test_name='$test_name', test_date='$test_date', std_type='$std_type', omr_code='$omr_id', batch='$batch', max_score='$max_score', sub_pattern='$sub_pattern', answer_data='$answer_data', minor_name='$minor_name', total_stds='$total_stds', topper='$topper', sms_sent='$sms_sent'", "test_id='$test_id'", "1");
			$odb->select("omrsheets", "sheet_name", "id='$omr_id'", "none", "1");
			if($odb->sel_count_row>0){
				$odb->update("omrsheets", "sheet_name='$sheet_name', sub_pattern='$sub_pattern', no_of_subs='$no_of_subs', sub_names='$sub_names', col_qs_pattern='$col_qs_pattern', sub_qs_dist='$sub_qs_dist', marking_pattern='$marking_pattern', js_file='$js_file'", "id='$omr_id'", "1");
			}else{
				$odb->insert("omrsheets", "id='$omr_id', sheet_name='$sheet_name', sub_pattern='$sub_pattern', no_of_subs='$no_of_subs', sub_names='$sub_names', col_qs_pattern='$col_qs_pattern', sub_qs_dist='$sub_qs_dist', marking_pattern='$marking_pattern', roll_digit='$roll_digit', q_opts='$q_opts', js_file='$js_file'");
			}
		}else{
			$odb->insert("tests", "test_id='$test_id', test_name='$test_name', test_date='$test_date', std_type='$std_type', omr_code='$omr_id', batch='$batch', max_score='$max_score', sub_pattern='$sub_pattern', answer_data='$answer_data', minor_name='$minor_name', total_stds='$total_stds', topper='$topper', sms_sent='$sms_sent'");
			if($odb->sel_count_row>0){
				$odb->update("omrsheets", "sheet_name='$sheet_name', sub_pattern='$sub_pattern', no_of_subs='$no_of_subs', sub_names='$sub_names', col_qs_pattern='$col_qs_pattern', sub_qs_dist='$sub_qs_dist', marking_pattern='$marking_pattern', js_file='$js_file'", "1");
			}else{
				$odb->insert("omrsheets", "id='$omr_id', sheet_name='$sheet_name', sub_pattern='$sub_pattern', no_of_subs='$no_of_subs', sub_names='$sub_names', col_qs_pattern='$col_qs_pattern', sub_qs_dist='$sub_qs_dist', marking_pattern='$marking_pattern', js_file='$js_file'");
			}
		}

		$dbh=new db();
		$dbh->select("scaned_omrs", "id, std_roll_no, test_data, scaned_time, wrong_ans, right_ans, total_score, rank, incorrect_filled, correct_match, incorrect_match, col1_score, col2_score, col3_score, col4_score, col5_score, percentage, percentile, omr_src, sms_sent", "test_id='$test_id'", "none", "none");
		$odb=new odb();
		foreach($dbh->select_res as $data){
			$id=$data['id'];
			$std_roll_no=$data['std_roll_no'];
			$test_data=$data['test_data'];
			$scaned_time=$data['scaned_time'];
			$wrong_ans=$data['wrong_ans'];
			$right_ans=$data['right_ans'];
			$total_score=$data['total_score'];
			$rank=$data['rank'];
			$incorrect_filled=$data['incorrect_filled'];
			$correct_match=$data['correct_match'];
			$incorrect_match=$data['incorrect_match'];
			$col1_score=$data['col1_score'];
			$col2_score=$data['col2_score'];
			$col3_score=$data['col3_score'];
			$col4_score=$data['col4_score'];
			$col5_score=$data['col5_score'];
			$percentage=$data['percentage'];
			$percentile=$data['percentile'];
			$omr_src=$data['omr_src'];
			$sms_sent=$data['sms_sent'];
			$odb->select("scaned_omrs", "id", "std_roll_no='$std_roll_no' AND test_id='$test_id'", "none", "1");
			if($odb->sel_count_row>0){
			$col3_score=$data['col3_score'];
			$col3_score=$data['col3_score'];
				$odb->update("scaned_omrs", "wrong_ans='$wrong_ans', right_ans='$right_ans', total_score='$total_score', rank='$rank', incorrect_filled='$incorrect_filled', correct_match='$correct_match', incorrect_match='$incorrect_match', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col4_score='$col4_score', col5_score='$col5_score', percentage='$percentage', percentile='$percentile', omr_src='$omr_src'", "std_roll_no='$std_roll_no' AND test_id='$test_id'", "1");
			}else{
				$odb->insert("scaned_omrs", "std_roll_no='$std_roll_no', test_id='$test_id', scaned_time='$scaned_time', test_data='$test_data', wrong_ans='$wrong_ans', right_ans='$right_ans', total_score='$total_score', rank='$rank', incorrect_filled='$incorrect_filled', correct_match='$correct_match', incorrect_match='$incorrect_match', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col4_score='$col4_score', col5_score='$col5_score', percentage='$percentage', percentile='$percentile', omr_src='$omr_src'");
			}
		}

		header("Location:../show_info.php?info=Result has been published successfully!");
		exit();
	}else{
		exit();
		header("Location:../publish-result.php?msg=This test ID does not exist!");
		exit();
	}
}else{
	header("Location:../admin-login.php?msg=Session expired. Login again!");
	exit();
}


?>