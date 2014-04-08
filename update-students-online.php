<?php
session_start();

	include_once("classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$main_content="<div class='row-fluid'>
	<div class='span4 alignL'><a href='./students.php'>Back</a></div>
	<div class='span8 alignR'>
		<p><a href='./students.php?batch=all'>View All student</a>  &nbsp; &nbsp; &nbsp;|  &nbsp; &nbsp; &nbsp;<a href='./add-student.php'>Add New student</a>
		</p>
	</div>
	<h2 class='alignC'>Update student data Online :</h2>
	<div class='span4 offset3 folder-info'>
	<form class='form-horizontal' action='./scripts/update-students-online.php' method='get'>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Student Roll No : </label>
		 	<div class='controls'><input type='text' name='roll_no' id='roll_no'/></div>
		</div>
		
		
		
		<div class='control-group'>
		 	<label class='control-label'></label>
		 	<div class='controls'><input type='submit' value='Update' class='btn btn-success'/></div>
		</div>
		
	</form>
	<h4 class='alignC'>OR</h4>
	<p class='alignC'><a href='./scripts/update-students-online.php'><button class='btn btn-warning'>Update All students !</button></a></p>
	</div>
	<div class='pb-window hide span11'><h4 class='p1'>Wait...</h4></div>
	<div class='analyz-option span11 hide'>
		<h5>Congratulation! Evaluation has been finished.</h5>
		
	</div>
	</div>";
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Update students online.",
			"title"=>"Update students online | t-Reader",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-evaluation.ta", $vars);

?>