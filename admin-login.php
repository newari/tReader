<?php
	session_start();
	if(isset($_SESSION['omr-admin-id'])){
		header("Location:./index.php");
		exit();
	}else{
		include_once("./classes/main.class.php");
		include_once("./classes/institute.class.php");
		$inst=new institute();
		$main=new main();
		$main->show_msg();
		$main_content="<div class='row-fluid'>

		<div class='span12'>
			<div class='login-box login-box-omr'>
				<div class='row-fluid'>
					<form action='./scripts/omr_admin_login.php' method='post'>
						<div class='span12 alignC'><h3>OMR Admin Login</h3><h6>".$inst->brand_name."</h6></div>
						<div class='span12'><span>Username:</span> <input type='text' name='omr-un' placeholder='Username'/></div>
						<div class='span12'><span>Password:&nbsp;</span> <input type='password' name='omr-pas' placeholder='Password'/></div>
						
						<div class='span12 alignC'><input type='submit' class='btn btn-warning' value='Login'/></div>
					</form>
				</div>
			</div>
			</div>
		</div>";
		$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"OMR Admin login portal.",
				"title"=>"Admin login | t-Reader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("./pages/blank.ta", $vars);
	}




?>