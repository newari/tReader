<?php
		include_once("./classes/main.class.php");
		include_once("./classes/institute.class.php");
		$main=new main();
		$main->show_msg();
		$inst=new institute();
		$main_content="<div class='row-fluid'><div class='span6 offset2 folder-info'>
	<h2 class='alignC well'>WebHost Setting </h2>
	<form class='form-horizontal tile' action='./scripts/advanced-setting.php' method='post' enctype='multipart/form-data'>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Host Name :</label>
		 	<div class='controls'><input type='text' id='testName' name='webh' class='mute'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Database Name :</label>
		 	<div class='controls'><input type='text' id='testName' name='odb'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Username :</label>
		 	<div class='controls'><input type='text' id='testName' name='webu'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Password :</label>
		 	<div class='controls'><textarea type='text' id='minor_name' name='webp'></textarea></div>
		</div>
		
		<div class='control-group'>
		 	<label class='control-label'></label>
		 	<div class='controls'><input type='submit' value='Submit' class='btn btn-success'/></div>
		</div>
		
	</form></div>
	<div class='span12 well marginl0'><a href='./config-setting.php'>Back !</a></div>
	
	</div>";
		$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"OMR Admin login portal.",
				"title"=>"Installation process | t-Reader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("./pages/blank.ta", $vars);
	



?>