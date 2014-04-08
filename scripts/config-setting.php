<?php
if(isset($_POST['brand_name'])&&isset($_POST['address'])&&isset($_POST['city'])&&isset($_POST['c_no'])&&isset($_POST['faddress'])&&isset($_FILES['logo']['tmp_name'])){
	$brand_name=$_POST['brand_name'];
	$address=$_POST['address'];
	$city=$_POST['city'];
	$c_no=$_POST['c_no'];
	$logo=$_FILES['logo']['tmp_name'];
	$logo_big=$_FILES['logo_big']['tmp_name'];
	if($_FILES['logo']['size']>0){
		move_uploaded_file($logo, "../images/logo.jpg");
	}
	if($_FILES['logo_big']['size']>0){
		move_uploaded_file($logo_big, "../images/logo_large.jpg");
	}
	include_once("../classes/db.class.php");
	$dbh=new db();
	$dbh->select("config", "id", "id='1'", "none", "1");
	if($dbh->sel_count_row>0){
		$dbh->update("config", "brand_name='$brand_name', address='$address', city='$city',  contact_no='$c_no', logo='logo.jpg'", "id='1'", "1");

	}else{
		$dbh->insert("config", "brand_name='$brand_name', address='$address', city='$city',  contact_no='$c_no', logo='logo.jpg'", "id='1'", "1");

	}
	
		header("Location:../index.php?msg=Installed successfully. Now Evaluate OMR Sheets&msg_clr=green");
		exit();
	
}else{
	header("Location:../config-setting.php?msg=Please fill all the fields&msg_clr=red");
}


?>