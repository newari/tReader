<?php
if(isset($_GET['test_id'])&&isset($_GET['report'])){
	$test_id=$_GET['test_id'];
	$report=$_GET['report'];
	include_once("../classes/db.class.php");
	$dbh=new db();
	$dbh->select("tests", "max_score", "test_id='$test_id'", "none", "1");
	if($dbh->sel_count_row>0){
		$max_score=$dbh->select_res['max_score'];
		$dbh->select("scaned_omrs", "rank", "test_id='$test_id'", "id DESC", '1');
		if($dbh->sel_count_row>0){
			$last_score=0;
			$dbh->select("scaned_omrs", "id, std_roll_no, total_score", "test_id='$test_id'", "total_score DESC", 'none');
			$rank=1;
			$total_score=0;
			$sr=0;
			$total_stds=$dbh->sel_count_row;
			if($dbh->sel_count_row>1){
				foreach($dbh->select_res as $val){
					$id=$val['id'];
					$total_score=$val['total_score'];
					$percentile=(($total_stds-$sr)/$total_stds)*100;
					$percentile=substr($percentile, 0, 5);
					if($last_score==$total_score){
						$rank=$rank-1;
						$percentile=$last_percentile;
					}
					if($sr==0){
						$topper_roll_no=$val['std_roll_no'];
						$topper_score=$val['total_score'];
					}
					$percentage=$total_score/$max_score*100;
					$percentage=substr($percentage, 0, 5);
					
					$dbh->update("scaned_omrs", "rank='$rank', percentage='$percentage', percentile='$percentile'", "id='$id'", "1");
					$last_score=$total_score;
					$last_percentile=$percentile;
					$rank++;
					$sr++;
				}
			}else if($dbh->sel_count_row==1){
				$id=$dbh->select_res['id'];
				$total_score=$dbh->select_res['total_score'];
				if($last_score==$total_score){
					$rank=$rank-1;
				}
				$dbh->update("scaned_omrs", "rank='$rank'", "id='$id'", "1");
				$last_score=$total_score;
				$rank++;
			}
			$topper_data=$topper_roll_no."|".$topper_score;
			$dbh->update("tests", "total_stds='$total_stds', topper='$topper_data'", "test_id='$test_id'", "none", "1");
			header("Location:../view-result.php?test_id=".$test_id."&report=".$report."&msg=Updated successfully.&msg_clr=green");
			exit();
		}else{
			header("Location:../view-result.php?test_id=".$test_id."&report=".$report."&msg=ERROR! Try again.");
			exit();
		}
	}else{
		header("Location:../all-tests.php?msg=ERROR! Try again.");
		exit();
	}
		
}else{
	header("Location:../all-tests.php?msg=ERROR! Try again.");
	exit();
}

?>