<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	if(isset($_POST['type'])){
		$type=$_POST['type'];
		include_once("../classes/db.class.php");
		$dbh=new db("triaasco_omr");
		switch($type){
			case 'delete':
				$val=$_POST['val'];
				$where=$_POST['where'];
				$table_name=$_POST['table_name'];
				$dbh->delete("$table_name", "$where='$val'");
				echo "success";
				break;
			case 'update':
				// $dbh->update("$_POST['table_name']", "$_POST['update']", "$_POST['where']", "$_POST['limit']");
				echo "success";
				break;
			default :
				echo "There is error with this action. Please try again later!";
				break;
		}
	}
}else{
	echo "Session expired! Please login again!";
}



?>