<?php
if(isset($_POST['webh'])&&isset($_POST['webu'])&&isset($_POST['webp'])){
	$webh=$_POST['webh'];
	$webu=$_POST['webu'];
	$webp=$_POST['webp'];
	$odb=$_POST['odb'];
	
	
	include_once("../classes/db.class.php");
	$dbh=new db();
	$dbh->select("config", "id", "id='1'", "none", "1");
	if($dbh->sel_count_row>0){
		if($odb!=""){
			$dbh->update("config", "webh='$webh', odb='$odb', odbu='$webu', odbp='$webp'", "id='1'", "1");
		}else{
			$dbh->update("config", "webh='$webh'", "id='1'", "1");
		}
	}else{
		header("Location:../index.php?msg=Please first set basic setting related to this Institute!");
		exit();
	}
	
		header("Location:../index.php?msg=Installed successfully. Now Evaluate OMR Sheets&msg_clr=green");
		exit();
	
}else{
	header("Location:../config-setting.php?msg=Please fill all the fields&msg_clr=red");
}


?>