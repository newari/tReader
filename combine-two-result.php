<?php
session_start();
include_once("classes/main.class.php");
if(isset($_GET['type'])){
	$type=$_GET['type'];
}else{
	$type="rank";
}

switch($type){
	case 'rank':
		$link="<a href='?type=score'>Combine two results scores!</a>";
		$heading="Combine two results by RANK";
		break;
	case 'score':
		$link="<a href='?type=rank'>Combine two results rank!</a>";
		$heading="Combine two results by SCORE";
		break;
}
$main=new main();
$main->show_msg();
$main_content="<div class='row-fluid'>
			<p class='alignR'>".$link."</p>
		<div class='span6 offset3 alignC'>
			<h3 class='alignR'>".$heading.":</h3>
			<form class='form-horizontal' action='./scripts/combine-results.php' method='post'>
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>New test name(Heading) : </label>
				 	<div class='controls'><input type='text' name='new_name_h' id='test_id'/></div>
				</div>
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>New test name (For SMS) : </label>
				 	<div class='controls'><input type='text' name='new_name' id='test_id'/></div>
				</div>
				
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>Test-1 Id : </label>
				 	<div class='controls'><input type='text' name='test1_id' id='test_id'/><input type='hidden' name='type' value='".$type."'/></div>
				</div>
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>Test-2 Id : </label>
				 	<div class='controls'><input type='text' name='test2_id' id='test_id'/></div>
				</div>
				<div class='control-group'>
				 	<label class='control-label'></label>
				 	<div class='controls'><input type='submit' value='Submit' class='btn btn-success'/></div>
				</div>
				
			</form>
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
		$main->display("pages/omre-blank.ta", $vars);

?>
