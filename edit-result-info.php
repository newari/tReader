<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){	
	include_once("./classes/db.class.php");
	include_once("./classes/main.class.php");
	if(isset($_GET['result_id'])){
		$result_id=$_GET['result_id'];
	}else{
		echo "There is some problem with this result. Try again later after refreshing result page.";
		exit();
	}
	$main=new main();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	$dbh->select("scaned_omrs", "test_id, std_roll_no, wrong_ans, right_ans, total_score, rank, incorrect_filled, col1_score, col2_score, col3_score, col4_score, col5_score", "id='$result_id'", "none", "1");
	if($dbh->sel_count_row>0){
		$test_id=$dbh->select_res['test_id'];
		$std_roll_no=$dbh->select_res['std_roll_no'];
		$wrong_ans=$dbh->select_res['wrong_ans'];
		$right_ans=$dbh->select_res['right_ans'];
		$total_score=$dbh->select_res['total_score'];
		$incorrect_filled=$dbh->select_res['incorrect_filled'];
		$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
		$col1_score=$dbh->select_res['col1_score'];
		$col2_score=$dbh->select_res['col2_score'];
		$col3_score=$dbh->select_res['col3_score'];
		$col4_score=$dbh->select_res['col4_score'];
		$col5_score=$dbh->select_res['col5_score'];
		$main_content='<div class="row-fluid">
			
		<div class="span11"><h4 class="alignC">Update student Result info</h4></div>
		<dic class="span1"><p><a href="view-result.php?test_id='.$test_id.'&report=whole">View Result !</a></p></div>
			<div class="span8 offset2">
				<form action="./scripts/edit-result-info.php" class="form form-horizontal" method="post" enctype="multipart/form-data">
					<div class="control-group">
					<div class="control-label">
						<div class="">Roll No.:</div>
					</div>
					<div class="controls">
						<input type="text" name="roll_no" value="'.$std_roll_no.'" plcaeholder="Student Roll No."/>
						<input type="hidden" name="result_id" value="'.$result_id.'"/>
					</div>
					</div>
					<div class="control-group">
					 	<div class="control-label">
					<div class="">Wrong Answers</div>
					</div>
					<div class="controls">
					<input type="text" name="wrong_ans" value="'.$wrong_ans.'"/>
					</div>
					</div>
					<div class="control-group">
					<div class="control-label">
					<div class="">Right Answers:</div>
					</div>
					<div class="controls">
					<input type="text" name="right_ans" value="'.$right_ans.'"/>
					</div>
					</div>
					<div class="control-group">
					<div class="control-label">
					<div class="">Total Score:</div>
					</div>
					<div class="controls">
					<input type="text" name="total_score" value="'.$total_score.'"/>
					</div>
					</div>

					<div class="control-group">
					<div class="control-label">
					<div class="">Incorrect filled:</div>
					</div>
					<div class="controls">
					<input type="text" name="incorrect_filled" value="'.$incorrect_filled.'"/>
					</div>
					</div>
					<div class="control-group">
					<div class="control-label">
					<div class="">Attemted Qs.:</div>
					</div>
					<div class="controls">
					<input type="text" name="attemted_qs" value="'.$attemted_qs.'"">
					</div>
					</div>
					
					<div class="control-group">
					<div class="control-label">
					<div class="">Subject 1st Score:</div>
					</div>
					<div class="controls">
					<input type="text" name="sub1_score" value="'.$col1_score.'"/>
					</div>
					</div>
					<div class="control-group">
					<div class="control-label">
					<div class="">Subject 2nd Score:</div>
					</div>
					<div class="controls">
					<input type="text" name="sub2_score" value="'.$col2_score.'"/>
					</div>
					</div>
					<div class="control-group">
					<div class="control-label">
					<div class="">Subject 3rd Score:</div>
					</div>
					<div class="controls">
					<input type="text" name="sub3_score" value="'.$col3_score.'"/>
					</div>
					</div>
					<div class="control-group">
					<div class="control-label">
					<div class="">Subject 4th Score:</div>
					</div>
					<div class="controls">
					<input type="text" name="sub4_score" value="'.$col4_score.'"/>
					</div>
					</div>
					<div class="control-group">
					<div class="control-label">
					<div class="">Subject 5th Score:</div>
					</div>
					<div class="controls">
					<input type="text" name="sub5_score" value="'.$col5_score.'"/>
					</div>
					</div>
					<div class="controls">
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
		echo "There is some problem with this result. Try again later after refreshing result page.";
		exit();
	}
		
}else{
	header("Location:./admin-login.php?msg=Session expired! Please login again&msg_clr=red");
	exit();
}
?>