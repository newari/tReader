<?php
include_once("./classes/db.class.php");
include_once("./classes/main.class.php");
$main=new main();
$main->show_msg();
$dbh=new db("triaasco_omr");
if(isset($_GET['batch'])){
	$batch=$_GET['batch'];
	if($batch=="all"){
		if(isset($_GET['start_from'])){
			$start_from=$_GET['start_from'];
			if($start_from=="all"){
				$limit="none";
			}else{
				$limit="50";
			}
		}else{
			$limit='50';
			$start_from=0;
		}
		$dbh->select("students", "id, roll_no, fname, lname, img_src, batch, mobile, mobile_p", "id > '$start_from'", "id ASC", "$limit");
		if($dbh->sel_count_row==1){
				$id=$dbh->select_res['id'];
				$test_participated=0;
				if(file_exists('./images/students/'.$dbh->select_res['img_src'])){
					$img_src='images/students/'.$dbh->select_res['img_src'];
				}else{
					$img_src="images/default-pic.jpg";
				}
			$student_list='<div class="row-fluid">
					<div class="span6 alignL"><a href="./students.php">Back</a></div>
			<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
					<div class="span12">
						<table class="table table-stripted">
							<thead>
								<tr>
									<th>#</th>
									<th>Student Name</th>
									<th>Roll NO.</th>
									<th>Image</th>
									<th>Batch</th>
									<th>Mobile</th>
									<th>Mobile-P</th>
									<th>Tests</th>
									<th>More?</th>
								</tr>
							</thead>
							<tbody><tr>
									<td>1.</td>
									<td>'.ucfirst($dbh->select_res['fname']).' '.ucfirst($dbh->select_res['lname']).'</td>
									<td>'.$dbh->select_res['roll_no'].'</td>
									<td><img src="'.$img_src.'" width="32"></td>
									<td>'.$dbh->select_res['batch'].'</td>
									<td>'.$dbh->select_res['mobile'].'</td>
									<td>'.$dbh->select_res['mobile_p'].'</td>
									<td>'.$test_participated.'</td>
									<td><a href="./student-profile.php?roll_no='.$dbh->select_res['roll_no'].'">View</a></td>
								</tr></tbody>
						</table>
					</div>
				</div>';
		}else if($dbh->sel_count_row>1){
			$student_list='<div class="row-fluid">
					<div class="span6 alignL"><a href="./students.php">Back</a></div>
					<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
					<div class="span12">
						<table class="table table-stripped">
							<thead>
								<tr>
									<th>#</th>
									<th>Student Name</th>
									<th>Roll NO.</th>
									<th>Image</th>
									<th>Batch</th>
									<th>Mobile</th>
									<th>Mobile-P</th>
									<th>Tests</th>
									<th>More</th>
								</tr>
							</thead>
							<tbody>';
			$i=0;
			foreach($dbh->select_res as $student){
				$i+=1;
				$id=$student['id'];
				$dbh->select("scaned_omrs", "id", "std_roll_no='$student[roll_no]'", "none", "none");
				$test_participated=$dbh->sel_count_row;
				if(file_exists('images/students/'.$student['img_src'])){
					$img_src='images/students/'.$student['img_src'];
				}else{
					$img_src="images/default-pic.jpg";
				}
				$student_list.='<tr>
									<td>'.($i+$start_from).'</td>
									<td>'.ucfirst($student['fname']).' '.ucfirst($student['lname']).'</td>
									<td>'.$student['roll_no'].'</td>
									<td><img src="'.$img_src.'" width="32"></td>
									<td>'.$student['batch'].'</td>
									<td>'.$student['mobile'].'</td>
									<td>'.$student['mobile_p'].'</td>
									<td>'.$test_participated.'</td>
									<td><a href="./student-profile.php?roll_no='.$student['roll_no'].'">View Profile</a><br/><a href="./edit-student-profile.php?roll_no='.$student['roll_no'].'">Edit</a></td>
								</tr>';
			}
			$newNextId=$id;
			$newPrevId=$start_from-50;
			$student_list.='</tbody>
						</table>
					</div>
					<div class="span4 alignL">
						<p><a href="?batch=all&start_from='.$newPrevId.'"><< PREV.</a></p>
					</div>
					<div class="span4 alignC">
						<p><a href="?batch=all&start_from=all">View All in a page</a></p>
					</div>
					<div class="span3 alignR">
						<p><a href="?batch=all&start_from='.$newNextId.'">NEXT >></a></p>
					</div>
				</div>';
		}


	}else{
		$batch=$_GET['batch'];
		$dbh->select("students", "roll_no, fname, lname, img_src, batch, mobile, mobile_p", "batch='$batch'", "none", "none");
		if($dbh->sel_count_row==1){
				$test_participated=0;
				if(file_exists('./images/students/'.$dbh->select_res['img_src'])){
					$img_src='images/students/'.$dbh->select_res['img_src'];
				}else{
					$img_src="images/default-pic.jpg";
				}
			$student_list='<div class="row-fluid">
					<div class="span6 alignL"><a href="./students.php">Back</a></div>
			<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
					<div class="span12">
						<table class="table table-stripted">
							<thead>
								<tr>
									<th>#</th>
									<th>Student Name</th>
									<th>Roll NO.</th>
									<th>Image</th>
									<th>Batch</th>
									<th>Mobile</th>
									<th>Mobile-P</th>
									<th>Tests</th>
									<th>More?</th>
								</tr>
							</thead>
							<tbody><tr>
									<td>1.</td>
									<td>'.ucfirst($dbh->select_res['fname']).' '.ucfirst($dbh->select_res['lname']).'</td>
									<td>'.$dbh->select_res['roll_no'].'</td>
									<td><img src="'.$img_src.'" width="32"></td>
									<td>'.$dbh->select_res['batch'].'</td>
									<td>'.$dbh->select_res['mobile'].'</td>
									<td>'.$dbh->select_res['mobile_p'].'</td>
									<td>'.$test_participated.'</td>
									<td><a href="./student-profile.php?roll_no='.$dbh->select_res['roll_no'].'">View</a></td>
								</tr></tbody>
						</table>
					</div>
				</div>';
		}else if($dbh->sel_count_row>1){
			$student_list='<div class="row-fluid">
					<div class="span6 alignL"><a href="./students.php">Back</a></div>
					<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
					<div class="span12">
						<table class="table table-stripped">
							<thead>
								<tr>
									<th>#</th>
									<th>Student Name</th>
									<th>Roll NO.</th>
									<th>Image</th>
									<th>Batch</th>
									<th>Mobile</th>
									<th>Mobile-P</th>
									<th>Tests</th>
									<th>More</th>
								</tr>
							</thead>
							<tbody>';
			$i=0;
			foreach($dbh->select_res as $student){
				$i+=1;
				$dbh->select("scaned_omrs", "id", "std_roll_no='$student[roll_no]'", "none", "none");
				$test_participated=$dbh->sel_count_row;
				if(file_exists('images/students/'.$student['img_src'])){
					$img_src='images/students/'.$student['img_src'];
				}else{
					$img_src="images/default-pic.jpg";
				}
				$student_list.='<tr>
									<td>'.$i.'</td>
									<td>'.ucfirst($student['fname']).' '.ucfirst($student['lname']).'</td>
									<td>'.$student['roll_no'].'</td>
									<td><img src="'.$img_src.'" width="32"></td>
									<td>'.$student['batch'].'</td>
									<td>'.$student['mobile'].'</td>
									<td>'.$student['mobile_p'].'</td>
									<td>'.$test_participated.'</td>
									<td><a href="./student-profile.php?roll_no='.$student['roll_no'].'">View Profile</a><br/><a href="./edit-student-profile.php?roll_no='.$student['roll_no'].'">Edit</a></td>
								</tr>';
			}
			$student_list.='</tbody>
						</table>
					</div>
				</div>';
		}else{
			$student_list="<b>No results found with this batch name. Try with another batch name!</b>";
		}
		

	}
	$main_content=$student_list;
}else if(isset($_GET['roll_no'])){
	$roll_no=$_GET['roll_no'];
	$dbh->select("students", "roll_no, fname, lname, img_src, batch, mobile, mobile_p", "roll_no LIKE '%$roll_no%'", "none", "none");
	if($dbh->sel_count_row==1){
			$test_participated=0;
			if(file_exists('./images/students/'.$dbh->select_res['img_src'])){
				$img_src='images/students/'.$dbh->select_res['img_src'];
			}else{
				$img_src="images/default-pic.jpg";
			}
		$student_list='<div class="row-fluid">
				<div class="span6 alignL"><a href="./students.php">Back</a></div>
		<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
				<div class="span12">
					<table class="table table-stripted">
						<thead>
							<tr>
								<th>#</th>
								<th>Student Name</th>
								<th>Roll NO.</th>
								<th>Image</th>
								<th>Batch</th>
								<th>Mobile</th>
								<th>Mobile-P</th>
								<th>Tests</th>
								<th>More?</th>
							</tr>
						</thead>
						<tbody><tr>
								<td>1.</td>
								<td>'.ucfirst($dbh->select_res['fname']).' '.ucfirst($dbh->select_res['lname']).'</td>
								<td>'.$dbh->select_res['roll_no'].'</td>
								<td><img src="'.$img_src.'" width="32"></td>
								<td>'.$dbh->select_res['batch'].'</td>
								<td>'.$dbh->select_res['mobile'].'</td>
								<td>'.$dbh->select_res['mobile_p'].'</td>
								<td>'.$test_participated.'</td>
								<td><a href="./student-profile.php?roll_no='.$dbh->select_res['roll_no'].'">View</a></td>
							</tr></tbody>
					</table>
				</div>
			</div>';
	}else if($dbh->sel_count_row>1){
		$student_list='<div class="row-fluid">
				<div class="span6 alignL"><a href="./students.php">Back</a></div>
				<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
				<div class="span12">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Student Name</th>
								<th>Roll NO.</th>
								<th>Image</th>
								<th>Batch</th>
								<th>Mobile</th>
								<th>Mobile-P</th>
								<th>Tests</th>
								<th>More</th>
							</tr>
						</thead>
						<tbody>';
		$i=0;
		foreach($dbh->select_res as $student){
			$i+=1;
			$dbh->select("scaned_omrs", "id", "std_roll_no='$student[roll_no]'", "none", "none");
			$test_participated=$dbh->sel_count_row;
			if(file_exists('images/students/'.$student['img_src'])){
				$img_src='images/students/'.$student['img_src'];
			}else{
				$img_src="images/default-pic.jpg";
			}
			$student_list.='<tr>
								<td>'.$i.'</td>
								<td>'.ucfirst($student['fname']).' '.ucfirst($student['lname']).'</td>
								<td>'.$student['roll_no'].'</td>
								<td><img src="'.$img_src.'" width="32"></td>
								<td>'.$student['batch'].'</td>
								<td>'.$student['mobile'].'</td>
								<td>'.$student['mobile_p'].'</td>
								<td>'.$test_participated.'</td>
								<td><a href="./student-profile.php?roll_no='.$student['roll_no'].'">View Profile</a><br/><a href="./edit-student-profile.php?roll_no='.$student['roll_no'].'">Edit</a></td>
							</tr>';
		}
		$student_list.='</tbody>
					</table>
				</div>
			</div>';
	}else{
		$student_list="<b>No results found for this roll no.. Try with another roll no.!</b>";
	}
	$main_content=$student_list;
}else if(isset($_GET['name'])){
	$name=$_GET['name'];
	$dbh->select("students", "roll_no, fname, lname, img_src, batch, mobile, mobile_p", "fname LIKE '%$name%'", "none", "none");
	if($dbh->sel_count_row==1){
			$test_participated=0;
			if(file_exists('./images/students/'.$dbh->select_res['img_src'])){
				$img_src='images/students/'.$dbh->select_res['img_src'];
			}else{
				$img_src="images/default-pic.jpg";
			}
		$student_list='<div class="row-fluid">
				<div class="span6 alignL"><a href="./students.php">Back</a></div>
		<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
				<div class="span12">
					<table class="table table-stripted">
						<thead>
							<tr>
								<th>#</th>
								<th>Student Name</th>
								<th>Roll NO.</th>
								<th>Image</th>
								<th>Batch</th>
								<th>Mobile</th>
								<th>Mobile-P</th>
								<th>Tests</th>
								<th>More?</th>
							</tr>
						</thead>
						<tbody><tr>
								<td>1.</td>
								<td>'.ucfirst($dbh->select_res['fname']).' '.ucfirst($dbh->select_res['lname']).'</td>
								<td>'.$dbh->select_res['roll_no'].'</td>
								<td><img src="'.$img_src.'" width="32"></td>
								<td>'.$dbh->select_res['batch'].'</td>
								<td>'.$dbh->select_res['mobile'].'</td>
								<td>'.$dbh->select_res['mobile_p'].'</td>
								<td>'.$test_participated.'</td>
								<td><a href="./student-profile.php?roll_no='.$dbh->select_res['roll_no'].'">View</a></td>
							</tr></tbody>
					</table>
				</div>
			</div>';
	}else if($dbh->sel_count_row>1){
		$student_list='<div class="row-fluid">
				<div class="span6 alignL"><a href="./students.php">Back</a></div>
				<div class="span6 alignR"><a href="./add-student.php">Add new student</a></div>
				<div class="span12">
					<table class="table table-stripped">
						<thead>
							<tr>
								<th>#</th>
								<th>Student Name</th>
								<th>Roll NO.</th>
								<th>Image</th>
								<th>Batch</th>
								<th>Mobile</th>
								<th>Mobile-P</th>
								<th>Tests</th>
								<th>More</th>
							</tr>
						</thead>
						<tbody>';
		$i=0;
		foreach($dbh->select_res as $student){
			$i+=1;
			$dbh->select("scaned_omrs", "id", "std_roll_no='$student[roll_no]'", "none", "none");
			$test_participated=$dbh->sel_count_row;
			if(file_exists('images/students/'.$student['img_src'])){
				$img_src='images/students/'.$student['img_src'];
			}else{
				$img_src="images/default-pic.jpg";
			}
			$student_list.='<tr>
								<td>'.$i.'</td>
								<td>'.ucfirst($student['fname']).' '.ucfirst($student['lname']).'</td>
								<td>'.$student['roll_no'].'</td>
								<td><img src="'.$img_src.'" width="32"></td>
								<td>'.$student['batch'].'</td>
								<td>'.$student['mobile'].'</td>
								<td>'.$student['mobile_p'].'</td>
								<td>'.$test_participated.'</td>
								<td><a href="./student-profile.php?roll_no='.$student['roll_no'].'">View Profile</a><br/><a href="./edit-student-profile.php?roll_no='.$student['roll_no'].'">Edit</a></td>
							</tr>';
		}
		$student_list.='</tbody>
					</table>
				</div>
			</div>';
	}else{
		$student_list="<b>No results found with this name. Try with another name!</b>";
	}
	$main_content=$student_list;
}else{
	$dbh->select("students", "id", "none", "none", "none");
	$total_students=$dbh->sel_count_row;include_once("./classes/db.class.php");
	$dbh=new db("triaasco_omr");
	$dbh->select("students", "id", "main_stream='eng'", "none", "none");
	$eng_students=$dbh->sel_count_row;
	$dbh->select("students", "id", "main_stream='med'", "none", "none");
	$med_students=$dbh->sel_count_row;
	$total_students=$eng_students+$med_students;
	
	$main_content='<div class="row-fluid">

		<div class="span6 offset3 alignC">
			<h3>Get student details</h3>
			<div id="roll-form">
				<form action="./students.php" method="get">
					<b>Search By Student Roll No.</b><br/><br/>
					<input type="text" placeholder="Enter student Roll NO." name="roll_no"/><br/>
					<input type="submit" class="btn btn-warning" value="Find"/>
				</form>
			</div>
			<div id="name-form" class="hide">
				<form action="./students.php" method="get">
					<b>Search By Student Name</b><br/><br/>
					<input type="text" placeholder="Enter student Name." name="name"/><br/>
					<input type="submit" class="btn btn-warning" value="Find"/>
				</form>
			</div>
			<div id="batch-form" class="hide">
				<form action="./students.php" method="get">
					<b>Search By Student Batch</b><br/><br/>
					<input type="text" placeholder="Enter student Batch" name="batch"/><br/>
					<input type="submit" class="btn btn-warning" value="Find"/>
				</form>
			</div>
		</div>
		<div class="span3 alignR pointer"> 
			<p id="searchName">Search by Studnt name?</p>
			<p id="searchBatch">Search by Batch?</p>
			<p id="searchRoll" class="hide">Search by Roll No.?</p>
		</div>
		<div class="span12">
			<div class="row-fluid">
				<div class="span6 alignC"><a href="?batch=all"><button class="btn btn-success">View all students</button></a></div>
				<div class="span6 alignC"><a href="add-student.php"><button class="btn btn-success">Add new student</button></a></div>
			</div>
		</div>
		<div class="span12">
			<div class="row-fluid">
				<div class="span12 alignC"><hr/><h4>Student dashboard</h4></div>
				<div class="span12 alignC"><b>Total Students:'.$total_students.' </b></div>
				<div class="span5 alignC">Total Engineering Students:'.$eng_students.'</div>
				<div class="span6 alignC">Total Medical Students: '.$med_students.'</div>
			</div>
		</div>
	</div>';
}
$vars=array(
	"page"=>array(
		"msg"=>$main->msg,
		"msg_cls"=>$main->msg_cls,
		"metad"=>"TStudent list of all students of coaching. Powered by triaas",
		"title"=>"Students | t-Reader",
		"srcext"=>"../../",
		"main_content"=>$main_content,

		)
	);
$main->display("pages/omre-blank.ta", $vars);



?>