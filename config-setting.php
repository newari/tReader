<?php
		include_once("./classes/main.class.php");
		include_once("./classes/institute.class.php");
		$main=new main();
		$main->show_msg();
		$inst=new institute();
		$main_content="<div class='row-fluid'><div class='span6 offset2 folder-info'>
	<h2 class='alignC well'>Configuration Setting </h2>
	<form class='form-horizontal tile' action='./scripts/config-setting.php' method='post' enctype='multipart/form-data'>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Institute Full Name :</label>
		 	<div class='controls'><input type='text' id='testName' name='brand_name' class='mute' value='".$inst->institute_name."' disabled/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Institute Brand Name :</label>
		 	<div class='controls'><input type='text' id='testName' name='brand_name' value='".$inst->brand_name."'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='omrFolder'>Address :</label>
		 	<div class='controls'><textarea type='text' id='minor_name' name='address' value='".$inst->address."'></textarea></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>City : </label>
		 	<div class='controls'><input type='text' name='city' id='testId' value='".$inst->city."'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Contact No: </label>
		 	<div class='controls'><input type='text' name='c_no' id='omrCode' value='".$inst->contact_no."'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Full Address: </label>
		 	<div class='controls'><textarea type='text' rows='5' name='faddress' id='omrCode'>".$inst->full_address."</textarea></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Name Logo (256*84 Pix=JPEG): </label>
		 	<div class='controls'><input type='file' name='logo' id='omrCode'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label' for='test_id'>Name Logo Large (600*150-JPEG): </label>
		 	<div class='controls'><input type='file' name='logo_big' id='omrCode'/></div>
		</div>
		<div class='control-group'>
		 	<label class='control-label'></label>
		 	<div class='controls'><input type='submit' value='Submit' class='btn btn-success'/></div>
		</div>
		
	</form></div>
	<div class='span12 alignR well marginl0'><a href='./advanced-setting.php'>Advanced setting !</a></div>
	
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