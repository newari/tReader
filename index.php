<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	include_once("classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$main_content="<div class='row-fluid'>
		<div class='span12 alignC'>
			<a href='./all-tests.php'><button class='btn btn-success btn-large'>View results of all Tests</button></a>
			<hr/>
		</div>
		<div class='span12 marginl0'>
			<div class='row-fluid'>
				<div class='span2 round'><a href='./create-omrsheet.php'>Create & Print OMR</a></div>
				<div class='span2 round'><a href='#'>Scan<br/> OMR</a></div>
				<div class='span2 round'><a href='./start-new-test.php'>Create New Test</a></div>
				<div class='span2 round'><a href='./set-answersheet.php'>Set Master Answerkey</a></div>
				<div class='span2 round'><a href='./start-new-ev.php'>Check Omrsheets</a></div>
				<div class='span2 round'><a href='./view-result.php'>View <br/>Result</a></div>

			</div>
			<br/>
			<hr/>
			<br/>
		</div>
		<div class='span12'>
			<div class='row-fluid'>
				<div class='span4'><h4>Publish result</h4>
					<p>According coaching institute.According coaching institute.</p>
					<a href='./publish-result.php'><button class='btn btn-warning'>Go!</button></a>
				</div>
				<div class='offset4 span4'><h4>Send SMS</h4>
					<p>According coaching institute.According coaching institute.</p>
					<a href='./send-sms.php'><button class='btn btn-warning'>Go!</button></a>
				</div>
			</div>
			
			<br/>
			<br/>
		</div>
		<div class='span12'>
			<div class='row-fluid'>
				<div class='span4'><h4>Correction OR Manual Add</h4>
					<p>According coaching institute.According coaching institute.</p>
					<a href='./result-correction.php'><button class='btn btn-warning'>Go!</button></a>
				</div>
				<div class='span4 offset4'><h4>Download or Create OMR Sheet</h4>
					<p>According coaching institute.According coaching institute.</p>
					<a href='./create-omrsheet.php'><button class='btn btn-warning'>Go!</button></a></div>

				
			</div>
<br/>
			<br/>
		</div>
		<div class='span12'>
			<div class='row-fluid'>
				<div class='span4'><h4>Combine two results:</h4>
					<p>According coaching institute.According coaching institute.</p>
					<a href='./combine-two-result.php'><button class='btn btn-warning'>Go!</button></a>
				</div>
				<div class='span4 offset4'><h4>Check Attendance</h4>
					<p>According coaching institute.According coaching institute.</p>
					<a href='./check-attendance.php'><button class='btn btn-warning'>Go!</button></a></div>
				
			</div>

		</div>
	</div>";
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Admin login portal.",
			"title"=>"OMR Evaluation | t-Reader",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-blank.ta", $vars);
}else{
	header("Location:./admin-login.php");
	exit();
}


?>