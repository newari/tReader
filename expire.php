<?php
include_once("./classes/main.class.php");
$main=new main();
$main->show_msg();
$main_content='<div class="row-fluid">
	<div class="span12 well"><strong>This copy of software has expired! Please contact to our technical guy for more information or just visit <a href="http://services.triaas.com">triass software portal</a></strong></div>
</div>';
$vars=array(
	"page"=>array(
		"main_content"=>$main_content,
		'msg'=>$main->msg,
		'msg_cls'=>$main->msg_cls,
		"title"=>"Fake Software | tReader"
		)
	);
$main->display("pages/blank.ta", $vars);

?>