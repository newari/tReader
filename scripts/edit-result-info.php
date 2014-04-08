<?php
session_start();
if(isset($_SESSION['omr-admin-id'])){
	if(isset($_POST['result_id'])&&$_POST['result_id']>0){
		$result_id=$_POST['result_id'];
		$std_roll_no=$_POST['roll_no'];
		$wrong_ans=$_POST['wrong_ans'];
		$right_ans=$_POST['right_ans'];
		$total_score=$_POST['total_score'];
		$incorrect_filled=$_POST['incorrect_filled'];
		$attemted_qs=$wrong_ans+$right_ans+$incorrect_filled;
		$sub1_score=$_POST['sub1_score'];
		$sub2_score=$_POST['sub2_score'];
		$sub3_score=$_POST['sub3_score'];
		$sub4_score=$_POST['sub4_score'];
		$sub5_score=$_POST['sub5_score'];
		if($total_score==($sub1_score+$sub2_score+$sub3_score+$sub5_score+$sub4_score)){
			include_once("../classes/db.class.php");
			$dbh=new db("triaasco_omr");
			$dbh->update("scaned_omrs", "std_roll_no='$std_roll_no', wrong_ans='$wrong_ans', right_ans='$right_ans', total_score='$total_score', incorrect_filled='$incorrect_filled', col1_score='$sub1_score', col2_score='$sub2_score', col3_score='$sub3_score', col4_score='$sub4_score', col5_score='$sub5_score'", "id='$result_id'", "1");
			
			header("Location:../edit-result-info.php?result_id=".$result_id."&msg=Information updated successfully!&msg_clr=green");
			exit();
			
		}else{
			header("Location:../edit-result-info.php?result_id=".$result_id."&msg=Toatal score is not equal to sum of all subjects!&msg_clr=red");
			exit();
		}
	}else{
		echo "There is some problem with this result. Please contact to Mr. C. P. Meena (08439695457)";
		exit();
	}	
		
}else{
	header("Location:../admin-login.php?msg=Session expired! Please login again&msg_clr=red");
	exit();
}
?>