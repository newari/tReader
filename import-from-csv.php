<?php

if(isset($_FILES['filename']['tmp_name'])){
	include_once("./classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$tot=0;
	$handle = fopen($_FILES['filename']['tmp_name'], "r");
		while (($data = fgetcsv($handle, ",")) !== FALSE) {
			for ($c=0; $c < 1; $c++) {

		            //only run if the first column if not equal to firstname
		            if($data[0] !='id'&&$data[0] !=''){
						// mysql_query("INSERT INTO contacts(
						// firstname,
						// lastname,
						// email,
						// telephone
						// )VALUES(
						// 	'".mysql_real_escape_string($data[0])."',
						// 	'".mysql_real_escape_string($data[1])."',
						// 	'".mysql_real_escape_string($data[2])."',
						// 	'".mysql_real_escape_string($data[3])."'
						// )")or die(mysql_error());
		            	$rol_no=$data[0];
		            	$img_src=$data[0].".jpg";
		            	$dbh->select("students", "id", "roll_no='$rol_no'", "none", "1");
		            	if($dbh->sel_count_row>0){
		            		$std_id=$dbh->select_res['id'];
							$dbh->update("students", "roll_no='$rol_no', fname='$data[1]', img_src='$img_src', batch='$data[2]', medium='$data[3]', mobile='$data[4]', mobile_p='$data[5]', address='$data[6]'", "id='$std_id'", "1");
		            	}else{
							$dbh->insert("students", "roll_no='$rol_no', fname='$data[1]', img_src='$img_src', batch='$data[2]', medium='$data[3]', mobile='$data[4]', mobile_p='$data[5]', address='$data[6]'");
		            	}
		            }

				$tot++;
				echo $data[0];
			}
		}
		$content="";
		fclose($handle);
	}else{
		$content='<form action="import-from-csv.php" enctype="multipart/form-data" method="post">
			<input type="file" name="filename" />
			<input type="submit" value="submit">
		</form>
		<p><b>First create comma delimeter CSV file from excel file(can be created by Micosoft excel using "save as").</b></p>
		<p>In CSV file column should be accordin below order:</p>
		<p>Roll NO | Student Name | Batch | medium | Mobile | Mobile Parents | address</p>
		';
		echo $content;
	}






?>