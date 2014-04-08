<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	include_once("../classes/db.class.php");
	include_once("../classes/odb.class.php");

	$dbh=new db();
	if(isset($_GET['roll_no'])){
		$roll_no=$_GET['roll_no'];
		$dbh->select("students", "fname, lname, img_src, batch, medium, reg_date, main_stream, mobile, mobile_p, address", "roll_no='$roll_no'", "none", "1");
		if($dbh->sel_count_row>0){	
			$fname=$dbh->select_res['fname'];
			$lname=$dbh->select_res['lname'];
			$img_src=$dbh->select_res['img_src'];
			$batch=$dbh->select_res['batch'];
			$medium=$dbh->select_res['medium'];
			$reg_date=$dbh->select_res['reg_date'];
			$main_stream=$dbh->select_res['main_stream'];
			$mobile=$dbh->select_res['mobile'];
			$mobile_p=$dbh->select_res['mobile_p'];
			$address=$dbh->select_res['address'];

			$odb=new odb();
			$odb->select("students", "id", "roll_no='$roll_no'", "none", "1");
			if($odb->sel_count_row>0){
				$odb->update("students", "roll_no='$roll_no', fname='$fname', lname='$lname', img_src='$img_src', batch='$batch', medium='$medium', reg_date='$reg_date', main_stream='$main_stream', mobile='$mobile', mobile_p='$mobile_p', address='$address'", "roll_no='$roll_no'", "1");
			}else{
				$odb->insert("students", "roll_no='$roll_no', fname='$fname', lname='$lname', img_src='$img_src', batch='$batch', medium='$medium', reg_date='$reg_date', main_stream='$main_stream', mobile='$mobile', mobile_p='$mobile_p', address='$address'");
			}
		}else{
			echo "This roll no doest not exist on local server database. Please first upload data on local server.";
			exit();
		}
	}else{
		$dbh->select("students", "roll_no, fname, lname, img_src, batch, medium, reg_date, main_stream, mobile, mobile_p, address", "none");
		$odb=new odb();
		if($dbh->sel_count_row>1){	
			foreach($dbh->select_res as $std){
				$roll_no=$std['roll_no'];
				$fname=$std['fname'];
				$lname=$std['lname'];
				$img_src=$std['img_src'];
				$batch=$std['batch'];
				$medium=$std['medium'];
				$reg_date=$std['reg_date'];
				$main_stream=$std['main_stream'];
				$mobile=$std['mobile'];
				$mobile_p=$std['mobile_p'];
				$address=$std['address'];
				
				$odb->select("students", "id", "roll_no='$roll_no'", "none", "1");
				if($odb->sel_count_row>0){
					$odb->update("students", "roll_no='$roll_no', fname='$fname', lname='$lname', img_src='$img_src', batch='$batch', medium='$medium', reg_date='$reg_date', main_stream='$main_stream', mobile='$mobile', mobile_p='$mobile_p', address='$address'", "roll_no='$roll_no'", "1");
				}else{
					$odb->insert("students", "roll_no='$roll_no', fname='$fname', lname='$lname', img_src='$img_src', batch='$batch', medium='$medium', reg_date='$reg_date', main_stream='$main_stream', mobile='$mobile', mobile_p='$mobile_p', address='$address'");
				}
			}
		}else{
			echo "There is no data(or Only One) at local server. Please first upload data on local server.";
			exit();
		}
	}
	header("Location:../update-student-online.php?msg=Students data updated successfully online.&msg_cls=green");
	exit();
}else{
	header("Location:../admin-login.php?msg=Session expired. Login again!");
	exit();
}


?>