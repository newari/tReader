<?php
	include_once("./classes/main.class.php");
	$main=new main();
	$main->show_msg();

	$main_content='<h2>Please first Complete the Installation process!</h2><a href="http://services.triaas.com/new_installation.php">Click Here for next Step !</a>';

	$vars=array(
		'page'=>array(
			'msg'=>$main->msg,
			'msg_cls'=>$main->msg_cls,
			'main_content'=>$main_content,
			'title'=>"Installation | tReader"
		)
	);
	$main->display("pages/blank.ta", $vars);

?>