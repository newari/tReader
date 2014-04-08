<?php
session_start();
if(isset($_SESSION['std_id'])){
	header("Location:./student-home.php");
	exit();
}else{
	include_once("./classes/main.class.php");
	include_once("./classes/institute.class.php");
	$inst=new institute();
	$main=new main();
	$main->show_msg();
	$main_content="<div class='row-fluid'>

	<div class='span12'>
		<div class='login-box'>
			<div class='row-fluid'>
				<form action='./scripts/student_login.php' method='post'>
					<div class='span12 alignC'><h3>Student Login</h3><h6>".$inst->brand_name."</h6></div>
					<div class='span12'><span>Roll No:</span> <input type='text' name='roll_no' placeholder='Roll No.!'/></div>
					
					<div class='span12 alignC'><input type='submit' class='btn btn-primary' value='Login'/></div>
				</form>
			</div>
		</div>
		</div>
	</div>";
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Student login portal.",
			"title"=>"Student Login | t-Reader",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("./pages/blank.ta", $vars);
}
?>