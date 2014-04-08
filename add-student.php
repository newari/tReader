<?php
include_once("./classes/db.class.php");
include_once("./classes/main.class.php");
$main=new main();
$main->show_msg();
$dbh=new db("triaasco_omr");

$main_content='<div class="row-fluid">
<div class="span6 alignL"><a href="./students.php">Back</a></div>
<div class="span6 alignR">
	<p><a href="./students.php?batch=all">View All student</a>  &nbsp; &nbsp; &nbsp;|  &nbsp; &nbsp; &nbsp;<a href="./import-from-csv.php">Import From CSV</a> &nbsp; &nbsp; &nbsp;| &nbsp; &nbsp; &nbsp; <a href="./update-students-online.php">Update Online</a></p>
</div>
	<h4 class="alignC">Add new student</h4>
<div class="span12"></div>
	<div class="span8 offset2">
		<form action="./scripts/add-student.php" class="form form-horizontal" method="post" enctype="multipart/form-data">
			<div class="control-group">
			<div class="control-label">
			<div class="">First Name:</div>
			</div>
			<div class="controls">
			<input type="text" name="fname"/>
			</div>
			</div>
			<div class="control-group">
			<div class="control-label">
			<div class="">Last Name:</div>
			</div>
			<div class="controls">
			<input type="text" name="lname"/>
			</div>
			</div>
			<div class="control-group">
			<div class="control-label">
			<div class="">Roll No:</div>
			</div>
			<div class="controls">
			<input type="text" name="roll_no"/>
			</div>
			</div>
			<div class="control-group">
			<div class="control-label">
			<div class="">Batch:</div>
			</div>
			<div class="controls">
			<input type="text" name="batch"/>
			</div>
			</div>
			<div class="control-group">
			<div class="control-label">
			<div class="">Stream:</div>
			</div>
			<div class="controls">
			<input type="text" name="stream"/>
			</div>
			</div>
			<div class="control-group">
			<div class="control-label">
			<div class="">Mobile:</div>
			</div>
			<div class="controls">
			<input type="text" name="mobile"/>
			</div>
			</div>
			<div class="control-group">
			<div class="control-label">
			<div class="">Mobile Parent:</div>
			</div>
			<div class="controls">
			<input type="text" name="mobile_p"/>
			</div>
			</div>
			<div class="control-group">
			<div class="control-label">
			<div class="">Address:</div>
			</div>
			<div class="controls">
			<textarea  name="address" rows="6"></textarea>
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
			<input type="submit" class="btn" value="Add"/>
			</div>
			</div>
		</form>
	</div>
</div>';
$vars=array(
	"page"=>array(
		"msg"=>$main->msg,
		"msg_cls"=>$main->msg_cls,
		"metad"=>"Coaching students.",
		"title"=>"Add new Students | t-Reader",
		"srcext"=>"../../",
		"main_content"=>$main_content,

		)
	);
$main->display("pages/omre-blank.ta", $vars);
?>