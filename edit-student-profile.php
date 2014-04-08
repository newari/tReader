<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){	
	include_once("./classes/db.class.php");
	include_once("./classes/main.class.php");
	$roll_no=$_GET['roll_no'];
	$main=new main();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	$dbh->select("students", "fname, lname, batch, mobile, mobile_p, address", "roll_no='$roll_no'", "none", "1");
	if($dbh->sel_count_row>0){
		$name=ucfirst($dbh->select_res['fname']);
		$batch=$dbh->select_res['batch'];
		$mobile=$dbh->select_res['mobile'];
		$mobile_p=$dbh->select_res['mobile_p'];
		$address=$dbh->select_res['address'];
	}else{
		$name="";
		$batch="";
		$mobile="";
		$mobile_p="";
		$address="";
	}
	$main_content='<div class="row-fluid">
	<div class="span6 alignL"><a href="./students.php">Back</a></div>
	<div class="span6 alignR"><a href="./students.php?batch=all">View All students</a></div>
		<h4 class="alignC">Update student info</h4>
	<div class="span12"></div>
		<div class="span8 offset2">
			<form action="./scripts/edit-student.php" class="form form-horizontal" method="post" enctype="multipart/form-data">
				<div class="control-group">
				<div class="control-label">
					<div class="">Name:</div>
				</div>
				<div class="controls">
					<input type="text" name="fname" value="'.$name.'"/>
					<input type="hidden" name="add_type" value="update"/>
				</div>
				</div>
				
				<div class="control-group">
				<div class="control-label">
				<div class="">Batch:</div>
				</div>
				<div class="controls">
				<input type="text" name="batch" value="'.$batch.'"/>
				</div>
				</div>
				<div class="control-group">
				<div class="control-label">
				<div class="">Mobile:</div>
				</div>
				<div class="controls">
				<input type="text" name="mobile" value="'.$mobile.'"/>
				</div>
				</div>
				<div class="control-group">
				<div class="control-label">
				<div class="">Mobile Parent:</div>
				</div>
				<div class="controls">
				<input type="text" name="mobile_p" value="'.$mobile_p.'"/>
				</div>
				</div>
				<div class="control-group">
				<div class="control-label">
				<div class="">Address:</div>
				</div>
				<div class="controls">
				<textarea rows="8" name="address">'.$address.'</textarea>
				</div>
				</div>
				<div class="control-group">
				<div class="control-label">
				<div class="">Select Photo:</div>
				</div>
				<div class="controls">
				<input type="file" name="photo"/>
				</div>
				</div>
				<div class="control-group">
				<div class="control-label">
				<div class=""></div>
				</div>
				<div class="controls">
				<input type="hidden" name="roll_no" value="'.$roll_no.'"/>
				<input type="submit" class="btn" value="Update"/>
				</div>
				</div>
			</form>
		</div>
	</div>';
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Here you can edit student profile and information.",
			"title"=>"Edit student info | t-Reader",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-blank.ta", $vars);
}else{
	header("Location:./admin-login.php?msg=Session expired! Please login again&msg_clr=red");
	exit();
}
?>