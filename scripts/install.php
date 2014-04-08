<?php
if(isset($_POST['un'])&&isset($_POST['paswword'])){
	$un=$_POST['un'];
	$password=$_POST['password'];
	include_once("../classes/db.class.php");
	$odb=new odb($un, $password);
	if($odb->connection==true){
		header("Location:http://omr.triaas.com/new-installation.php");
	}else{
		header("Location:../install.php?msg=Invalid credentials!");
		exit();
	}
}else{
	header("Location:../install.php?msg=Please Fill all the fields!");
	exit();
}


?>