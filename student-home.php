<?php
session_start();
if(isset($_SESSION['std_id'])){
	$roll_no=$_SESSION['std_id'];
	include_once("./classes/db.class.php");
	include_once("./classes/main.class.php");
	include_once("./classes/institute.class.php");
	$inst=new institute();
	$main=new main();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	$dbh->select("students", "fname, lname", "roll_no='$roll_no'", "none", "1");
	$fname=$dbh->select_res['fname'];
	$lname=$dbh->select_res['lname'];

	$main_content='<div class="row-fluid">
		<div class="span12">

		</div>
		<a href="./std-all-p-test.php"><div class="span4 marginl0 option-btn">My Participated tests</div></a>
		<a href="./std-profile.php"><div class="span4 offset4 option-btn">My profile</div></a>
	</div>';
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Student login portal.",
			"title"=>"Student Login | t-Reader",
			"srcext"=>"../../",
			"main_content"=>$main_content,
			"brand_name"=>$inst->brand_name

			),
		"student"=>array(
			'roll_no'=>$roll_no,
			'fname'=>ucfirst($fname),
			'lname'=>ucfirst($lname)

			)
		);

	$main->display("./pages/std-blank.ta", $vars);
}else{
	header("Location:./student-login.php?msg=Please login again.&msg_clr=red");
	exit();
}


?>