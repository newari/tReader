<?php
session_start();

	include_once("classes/main.class.php");
	include_once("classes/db.class.php");
	$main=new main();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	$dbh->select("omrsheets", "id, sheet_name, col_qs_pattern, marking_pattern", "none", "id DESC", "none");
	$omr_list='';
	if($dbh->sel_count_row>0){
		if($dbh->sel_count_row==1){
			$omr_list='<option value="'.$dbh->select_res['id'].'"><a href="#"> '.$dbh->select_res['sheet_name'].' ('.$dbh->select_res['col_qs_pattern'].')</option>';
		}else{
			foreach($dbh->select_res as $sheet){
				$omr_list.='<option value="'.$sheet['id'].'"> '.$sheet['sheet_name'].'  ('.$sheet['col_qs_pattern'].')</option>';
			}
		}
	}else{
		$omr_list='<option value="none">None !</option>';
	}
	$main_content="<div class='row-fluid'><div class='span6 offset2 folder-info'><form class='form-horizontal' action='./scripts/start-new-test.php' method='post'>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Test Name :</label>
		 	<div class='controls'><input type='text' id='testName' name='test_name'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Test Sub-Name :</label>
		 	<div class='controls'><input type='text' id='minor_name' name='minor_name'/><span class='help-inline'>This name will be used in SMS</span></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Test Id : </label>
		 	<div class='controls'><input type='text' name='test_id' id='testId'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Test Date : </label>
		 	<div class='controls'><input type='date' name='test_date' id='testDate'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Max Score: </label>
		 	<div class='controls'><input type='text' name='max_score' id='max_score'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>OMR Sheet : </label>
		 	<div class='controls'><select name='omr_code' id='omrCode'/>".$omr_list."</select></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Test Result shown to : </label>
		 	<div class='controls'><select name='std_type'>
		 	<option value='all'>All</option>
		 	<option value='11m'>11th Math</option>
		 	<option value='12m'>12th Math</option>
		 	<option value='tam'>Target Math</option>
		 	<option value='allm'>All Math</option>
		 	<option value='11b'>11th Bio</option>
		 	<option value='12b'>12th Bio</option>
		 	<option value='tab'>Target Bio</option>
		 	<option value='allb'>All Bio</option>
		 	</select></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label'></label>
		 	<div class='controls'><input type='submit' value='Submit' class='btn btn-success'/></div>
		</div>
		
	</form></div>
	<div class='pb-window hide span11'><h4 class='p1'>Wait...</h4></div>
	<div class='analyz-option span11 hide'>
		<h5>Congratulation! Evaluation has been finished.</h5>
		
	</div>
	</div>";
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Start new test for further omr evaluation.",
			"title"=>"New Test | t-Reader",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-blank.ta", $vars);

?>