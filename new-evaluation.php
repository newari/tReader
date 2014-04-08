<?php
session_start();

	include_once("classes/main.class.php");
	$main=new main();
	$main->show_msg();
	$main_content="
		<div class='row-fluid'>
			<div class='span12 alignC'>
			<h3>Add Filled OMR Sheets :</h3>
			<p><input type='file' name='omr-sheet'/></p>
			<hr/>
			</div>
			<div class='span12 omr-list'>
			<h3 class='alignC'>Added OMR Sheets :</h3>

				<table class='table table-bordered'>
					<thead class='omr-listH'>
					<tr>
						<th>#</th>
						<th>OMR Sheet Name</th>
						<th>Student Name</th>
						<th>CLass</th>
						<th>OMR Image</th>
						<th>Category</th>
						<th>Student Photo</th>
						<th>Address</th>
						<th>Total Q.</th>
						<th>Right Q.</th>
						<th>Attemted Q.</th>
						<th>Wrong  Q.</th>
						<th>Total Marks</th>
						<th>More Analysis</th>
					</tr>
					</thead>
					<tbody>";
				for($i=0; $i<3; $i++){
						$main_content.="<tr>
							<td>1.</td>
							<td>IIT JEE Test 01 Offline</td>
							<td>Sunil Kumar</td>
							<td>IIT JEE 2014</td>
							<td><img src='images/omrview-demo.jpg'/></td>
							<td>General</td>
							<td><img src='images/sunil pic.jpg' width='100px'></td>
							<td></td>
							<td>90</td>
							<td>78</td>
							<td>88</td>
							<td>10</td>
							<td>224</td>
							<td><p><a href='./graphical-analysis.php'>Graphical Analysis</a></p><p><a href='./rankwise-analysis.php'>Rank wise Analysis</a></p><p><a href='qwise-analysis.php'>Question wise analysis</a></p><p ><a class='red-clr' href='?msg=Content of this link will be according coaching institute. Not available in demo view !&msg_clr=red'>Generate report</a></p></td>
						</tr>";
						}
					$main_content.="</tbody></table></div>
						<div class='span12 alignC'><a href='?msg=Content of this link will be according coaching institute. Not available n demo view!&msg_clr=red'><button class='btn btn-warning btn-large'>Generate overall report</button></a></div></div>
					";
	$vars=array(
		"page"=>array(
			"msg"=>$main->msg,
			"msg_cls"=>$main->msg_cls,
			"metad"=>"Admin login portal.",
			"title"=>"Admin Login | CoachingName",
			"srcext"=>"../../",
			"main_content"=>$main_content,

			)
		);
	$main->display("pages/omre-blank.ta", $vars);

?>