<?php
session_start();

	include_once("classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$main_content="<div class='row-fluid'><div class='span4 offset3 folder-info'><form class='form-horizontal' action='#' method='post'>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Folder Name :</label>
		 	<div class='controls'><input type='text' id='omrFolder' name='omrFolder'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Test Id : </label>
		 	<div class='controls'><input type='text' name='test_id' id='testId'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label'></label>
		 	<div class='controls'><input type='button' onclick='startEvaluation()' value='Submit' class='btn btn-success'/></div>
		</div>
		
	</form></div>
	<div class='pb-window span11' id='pb-window'><h4 id='p1'></h4></div>
	<div class='analyz-option span11 hide'>
		
	</div>
	<div class=' span11 non-checked'>
		<h4>Name of omrsheets in this folder which did not check by the softwre due to sheet problem:</h4>

	</div>
	</div>";
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Admin login portal.",
			"title"=>"Admin Login | t-Reader",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-evaluation.ta", $vars);

?>