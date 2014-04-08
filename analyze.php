<?php
session_start();
include_once("classes/main.class.php");

$main=new main();
$main->show_msg();
if(isset($_GET['report'])&&isset($_GET['test_id'])){
	$report_type=$_GET['report'];
	$test_id=$_GET['test_id'];
	if($report_type=="whole"){
		include_once("classes/db.class.php");
		
		$dbh=new db("triaasco_omr");
		$dbh->select("scaned_omrs", "std_roll_no, wrong_ans, right_ans, total_score, incorrect_filled", "test_id='$test_id'", "total_score DESC", '10');
		
		$main_content='<p><a href="./new-evaluation.php">Back</a></p>
			<div class="row-fluid">
				<div class="span12"><h3 class="alignC">Rankwise analysis of student performance!</h3><hr/></div>
				<div class="span11"><h4 class="alignC">Sunil Kumar | Rank : 209</h4></div>
				<div class="span12">
					<table class="table">
						<thead>
						<tr>
							<th>Rank</th>
							<th>Student Name</th>
							<th>Attemted q.</th>
							<th>Rght Q.</th>
							<th>Wrong Q.</th>
							<th>Marks</th>
							<th>Percentile</th>
							<th>More</th>
						</tr>
						</thead>';
		foreach($dbh->select_res as $key=>$val){
					$wrong_ans=$val['wrong_ans'];
					$right_ans=$val['right_ans'];
					$total_score=$val['total_score'];
					$incorrect_filled=$val['incorrect_filled'];
					$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
						$main_content.='<tbody>
						<tr>
						<td>'.$key.'</td>
						<td>Sunil Kumar</td>
						<td>'.$val['wrong_ans'].'</td>
						<td>'.$val['right_ans'].'</td>
						<td>'.$val['wrong_ans'].'</td>
						<td>'.$val['total_score'].'</td>
						<td>'.$val['total_score'].'</td>
						<td><a href="?msg=Content of this link is not available in demo version!&msg_clr=red">View Profile</a></td>
						</tr>';
		}
		$main_content.='</tbody>
					</table>
				</div>
			</div>';
		
	}
}else{
	$main_content="
	<div class='row-fluid'>
		<div class='span5 offset3 alignC'>
			<h3 class='alignR'>Analysis of test result :</h3>
			<form class='form-horizontal' action='#' method='get'>
				<input type='hidden' name='report' value='whole'/>
				
				<div class='control-group'>
				 	<label class='control-label' for='test_id'>Test Id : </label>
				 	<div class='controls'><input type='text' name='test_id' id='test_id'/></div>
				</div>
				<div class='control-group'>
				 	<label class='control-label'></label>
				 	<div class='controls'><input type='submit' value='Submit' class='btn btn-success'/></div>
				</div>
				
			</form>
		</div>
	</div>";
}
	$vars=array(
			"page"=>array(
				"msg"=>$main->msg,
				"msg_cls"=>$main->msg_cls,
				"metad"=>"Whole analysis of student performance.",
				"title"=>"Get Analysis of test | t-Reader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
		$main->display("pages/omre-blank.ta", $vars);

?>