<?php
if(isset($_GET['info'])){
	$info=$_GET['info'];
include_once("./classes/main.class.php");
$main=new main();
$main->show_msg();

$main_content="
	<div class='row-fluid'>
		<div class='span6 offset2 alignC'>
			<h4 class='alignR'>".$info."</h4>
			
		</div>
	</div>";

$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Finel rsult of your activity.",
				"title"=>"Message | t-Reader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("pages/omre-blank.ta", $vars);

}else{
	header("Location:./index.php");
	exit();
}



?>