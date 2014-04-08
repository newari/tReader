<?php
session_start();
if(isset($_SESSION['std_id'])){
	$roll_no=$_SESSION['std_id'];
	include_once("./classes/db.class.php");
	include_once("./classes/main.class.php");
	include_once("./classes/institute.class.php");
	$main=new main();
	$inst=new institute();
	$main->show_msg();
	$dbh=new db("triaasco_omr");
	$dbh->select("students", "fname, lname", "roll_no='$roll_no'", "none", "1");
	$fname=$dbh->select_res['fname'];
	$lname=$dbh->select_res['lname'];

	$dbh->select("tests", "test_name, test_id, test_date, std_type, omr_code, sub_pattern", "none", "none", "none");
$main_content='<div class="row-fluid"><div class="span12 alignC">
	<h3>All created tests</h3>
</div><div class="span12"><table class="table"><thead>
	<tr>
	<th>Sr. No.</th>
	<th>Test Name</th>
	<th>Test Id</th>
	<th>Test Date</th>
	<th>OMR Code</th>
	<th>More</th>

	</tr>
</thead><tbody>';

if($dbh->sel_count_row==1){
	$main_content.='<tr>
	<td>1</td>
	<td>'.$dbh->select_res['test_name'].'</td>
	<td>'.$dbh->select_res['test_id'].'</td>
	<td>'.$dbh->select_res['test_date'].'</td>
	<td>'.$dbh->select_res['omr_code'].'</td>
	<td><a href="view-result.php?test_id='.$dbh->select_res['test_id'].'&report=whole">View result!</a></td>
	</tr>';
}else if($dbh->sel_count_row>1){
	$i=1;
	foreach($dbh->select_res as $val){
		$main_content.='<tr>
		<td>'.$i.'</td>
		<td>'.$val['test_name'].'</td>
		<td>'.$val['test_id'].'</td>
		<td>'.$val['test_date'].'</td>
		<td>'.$val['omr_code'].'</td>
		<td><a href="view-result.php?test_id='.$val['test_id'].'&report=whole">View Result!</a></td>
		</tr>';
		$i++;
	}
}else{
	$main_content.='<p>No records found. Please create a test first.</p>';
}
$main_content.="</tbody></table></div></div>";
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
	header("Location:../student-login.php?msg=Please login again.&msg_clr=red");
	exit();
}


?>