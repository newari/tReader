<?php
include_once("./classes/main.class.php");
$main=new main();
$main_content='<div class="row-fluid">
	<div class="span12">This copy of software is fake! Please contact to our technical guy for more information or just visit <a href="http://services.triaas.com">triass software portal</a></div>
</div>';
$vars=new array(
	"main_content"=>$main_content,
	"title"=>"Fake Software | tReader"
	)
$main->display("pages/blank.ta", $vars);

?>