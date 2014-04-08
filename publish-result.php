<?php

include_once("./classes/main.class.php");
$main=new main();
$main->show_msg();
$main_content="
	<div class='row-fluid'>
		<div class='span6 offset2 alignC'>
			<h3 class='alignR'>Publish test result online (STEP 1):</h3>
			<form class='form-horizontal' action='./scripts/publish-result.php' method='post'>
				
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>Test Id : </label>
				 	<div class='controls'><input type='text' name='test_id' id='test_id'/></div>
				</div>
				<div class='control-group'>
				 	<label class='control-label'></label>
				 	<div class='controls'><input type='submit' value='Submit' class='btn btn-success'/></div>
				</div>
				
			</form>
		</div>
	</div>";

$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Publish Result online of any pen and paper test.",
				"title"=>"Publish result | Samarpan Sikar",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("pages/omre-blank.ta", $vars);


?>