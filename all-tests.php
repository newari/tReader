<?php
include_once("./classes/db.class.php");
include_once("./classes/main.class.php");
$dbh=new db("triaasco_omr");
$main=new main();
$main->show_msg();
if(isset($_GET['show'])=="all"){
	$dbh->select("tests", "id, test_name, test_id, test_date, std_type, omr_code, sub_pattern, total_stds, sms_sent", "none", "id DESC", "none");
}else{
	$dbh->select("tests", "id, test_name, test_id, test_date, std_type, omr_code, sub_pattern, total_stds, sms_sent", "hidden='0'", "id DESC", "none");
}
$main_content='<div class="row-fluid"><div class="span12 alignC">
	<h3>All created tests</h3><p class="pushR"><a href="?show=all">View all tests!</a></p>
</div><div class="span12"><table class="table"><thead>
	<tr>
	<th>Sr. No.</th>
	<th>Test Name</th>
	<th>Test Id</th>
	<th>Test Date</th>
	<th>OMR Sheet</th>
	<th>Students</th>
	<th>SMS</th>
	<th>More</th>

	</tr>
</thead><tbody>';

if($dbh->sel_count_row==1){
	$id=$dbh->select_res['id'];
	$main_content.='<tr>
	<td>1</td>
	<td>'.$dbh->select_res['test_name'].'</td>
	<td>'.$dbh->select_res['test_id'].'</td>
	<td>'.$dbh->select_res['test_date'].'</td>
	<td>'.$dbh->select_res['omr_code'].'</td>
	<td>'.$dbh->select_res['total_stds'].'</td>
	<td>'.$dbh->select_res['sms_sent'].'</td>
	<td><a href="view-result.php?test_id='.$dbh->select_res['test_id'].'&report=whole">View result!</a><br/>
			<a href="answersheet-pv.php?test_id='.$dbh->select_res['test_id'].'&seted=already">Master Key  </a></td>
	</tr>';
}else if($dbh->sel_count_row>1){
	$i=1;
	foreach($dbh->select_res as $val){
		$id=$val['id'];
		$table_name="'tests'";
		$var1="'id'";
		$val1=$id;
		$main_content.='<tr>
		<td>'.$i.'</td>
		<td>'.$val['test_name'].'</td>
		<td>'.$val['test_id'].'</td>
		<td>'.$val['test_date'].'</td>
		<td>'.$val['omr_code'].'</td>
		<td>'.$val['total_stds'].'</td>
		<td>'.$val['sms_sent'].'</td>
		<td>
			<a href="view-result.php?test_id='.$val['test_id'].'&report=whole">View Result!  </a><br/>
			<a href="answersheet-pv.php?test_id='.$val['test_id'].'&seted=already">Master Key  </a><br/>
			<span onclick="hideTest('.$id.')" class="pointer">Hide </span> | 
			<span onclick="deleteRow('.$table_name.', '.$var1.', '.$val1.')" class="pointer"> Delete</span>
		</td>
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
				"metad"=>"List of all tests created by coaching.",
				"title"=>"All tests list | t-Reader",
				"srcext"=>"../../",
				"main_content"=>$main_content,

				)
			);
$main->display("pages/omre-blank.ta", $vars);


?>