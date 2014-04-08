<?php
session_start();

	include_once("classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$main_content='<p><a href="./new-evaluation.php">Back</a></p><div class="row-fluid">
		<div class="span12"><h3 class="alignC">Question wise analysis of student performance!</h3></div>
		<div class="span12"><h4 class="alignC">Student Name: Sunil Kumar</h4><hr/></div>
		<div class="span11">
			<table class="table"><thead><tr>
			<th>Q. No.</th>
			<th>Status</th>
			<th>Student Ans</th>
			<th>Right Ans</th>
			</tr>
			</thead><tbody>';
		for($i=1; $i<91; $i++){
			if($i%2==0||$i%3==0){
				$cls="success";
				$status="Right";
				$sa="B";
				$ra="B";
			}else if($i%7==0){
				$cls="warning";
				$status="Unanswered";
				$sa="None";
				$ra="D";
			}else{
				
				$cls="error";
				$status="Wrong";
				$sa="C";
				$ra="A";
			}
			$main_content.='<tr class="'.$cls.'">
				<td>'.$i.'</td>
				<td>'.$status.'</td>
				<td>'.$sa.'</td>
				<td>'.$ra.'</td>
			</tr>';
		}

			$main_content.='</tbody></table>
		</div>
	</div>';
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Admin login portal.",
			"title"=>"Admin Login | CoachingName",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-blank.ta", $vars);

?>