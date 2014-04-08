<?php

include_once("./classes/main.class.php");
$main=new main();
$main->show_msg();
$get_str=json_encode($_GET);
$main_content="
	<div class='row-fluid'>
		<div class='span6 offset2 alignC'>
			<h3 class='alignR'>Send SMS to all students:</h3>
			<form class='form-horizontal' action='./scripts/send-rand-sms.php' method='post'>
				
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>SMS Template : </label>
				 	<div class='controls'><textarea name='msg_template' id='msg_template'></textarea></div>
				</div>
				<div class='control-group'>
				 	<label class='control-label'></label>
				 	<div class='controls'>
				 	<input type='hidden' value='".$get_str."' name='get_str'/>
				 	<input type='submit' value='Send SMS' class='btn btn-success'/></div>
				</div>
				
			</form>
			<h5>Hint:</h5>
			<p>Use below variables in your template<br/> Student Name=".'$name$'."<br/> Father's Name=".'$father_name$'."<br/> Roll No=".'$roll_no$'." <br/> Batch=".'$batch$'."<br/></p>
		</div>
	</div>";

$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Send SMS to all students or their gaurdians for Pen and Paper Test result.",
				"title"=>"Send SMS to gaurdians | t-Reader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("pages/omre-blank.ta", $vars);


?>