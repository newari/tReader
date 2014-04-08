<?php
session_start();

	include_once("classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$main_content="<div class='row-fluid'>
	<div class='span6 alignL'><a href='./add-bonus.php'>Bonus marking</a></div>
	<div class='span6 alignR'><a href='./remove-test-result.php'>Remove whole test result</a></div>
	<h2 class='alignC'>Add or Update student result :</h2>
	<div class='span4 offset3 folder-info'>
	<form class='form-horizontal' action='./scripts/result-correction.php' method='post'>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Student Roll No :</label>
		 	<div class='controls'><input type='text' id='omrFolder' name='std_roll_no'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Test Id : </label>
		 	<div class='controls'><input type='text' name='test_id' id='testId'/></div>
		</div>
		
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>subject 1st Score : </label>
		 	<div class='controls'><input type='text' name='p1_score' id='p1_score'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>subject 2nd Score : </label>
		 	<div class='controls'><input type='text' name='p2_score' id='p2_score'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Subject 3rd Score : </label>
		 	<div class='controls'><input type='text' name='p3_score' id='p3_score'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Subject 4th score: </label>
		 	<div class='controls'><input type='text' name='p4_score' id='p3_score'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Subject 5th Score : </label>
		 	<div class='controls'><input type='text' name='p5_score' id='p3_score'/></div>
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