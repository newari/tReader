<?php
session_start();

	include_once("classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$main_content="<div class='row-fluid'>
	<div class='span12 alignR'><a href='./remove-test-result.php'>Remove whole test result</a></div>
	<h2 class='alignC'>Add or Update student result :</h2>
	<div class='span4 offset3 folder-info'>
	<form class='form-horizontal' action='./scripts/add-bonus.php' method='post'>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Test Id : </label>
		 	<div class='controls'><input type='text' name='test_id' id='testId'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Subject Name : </label>
		 	<div class='controls'><select name='col_name'>
		 	<option value='col1_score'>Subject 1st</option>
		 	<option value='col2_score'>Subject 2nd</option>
		 	<option value='col3_score'>Subject 3rd</option>
		 	<option value='col4_score'>Subject 4th</option>
		 	<option value='col5_score'>Subject 5th</option>
		 	</select></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Add marks : </label>
		 	<div class='controls'><input type='text' name='add_marks' id='total_score'/></div>
		</div>
		
		
		<div class='control-group'>
		 	<label class='control-label'></label>
		 	<div class='controls'><input type='submit' value='Update' class='btn btn-success'/></div>
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
			"metad"=>"Admin login portal.",
			"title"=>"Admin Login | CoachingName",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-evaluation.ta", $vars);

?>