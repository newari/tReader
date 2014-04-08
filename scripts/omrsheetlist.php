<?php
if(isset($_POST['folderName'])){
	$folderName=$_POST['folderName'];
	$folder_files=scandir("../scaned_omrs/".$folderName);
	echo json_encode($folder_files);
}

?>