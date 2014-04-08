<?php
	if(isset($_POST['test_data'])){
		include_once("../classes/db.class.php");
		$dbh=new db("triaasco_omr");
		$std_data=$_POST['test_data'];
		$std_data_arr=json_decode($std_data, true);
		$test_id=$std_data_arr['testId'];
		
		$dbh->select("tests", "omr_code, answer_data", "test_id='$test_id'", "none", "1");
		$std_roll_no=$std_data_arr['rollNo'];
		$omr_src=$std_data_arr['omr_src'];
		$omr_id=$dbh->select_res['omr_code'];
		
		$answer_data_arr=json_decode($dbh->select_res['answer_data'], true);
		$dbh->select("omrsheets", "sub_pattern, no_of_subs, sub_qs_dist, col_qs_pattern, marking_pattern", "id='$omr_id'", "none", "1");
		$sub_pattern=$dbh->select_res['sub_pattern'];
		$no_of_subs=$dbh->select_res['no_of_subs'];
		$sub_qs_dist=$dbh->select_res['sub_qs_dist'];
		$marking_pattern=$dbh->select_res['marking_pattern'];
		$markin_arr=explode("|", $marking_pattern);
		$mcqs_m=explode(",", $markin_arr[0]);
		$mcqm_m=explode(",", $markin_arr[1]);
		$compq_m=explode(",", $markin_arr[2]);
		$digit1q_m=explode(",", $markin_arr[3]);
		$matrixq_m=explode(",", $markin_arr[4]);
		$digitq_m=explode(",", $markin_arr[5]);
		$arq_m=explode(",", $markin_arr[6]);
		$tfq_m=explode(",", $markin_arr[7]);
		$sheet_pattern_arr=explode("-", $dbh->select_res['col_qs_pattern']);
		$sheet_type=$dbh->select_res['sub_pattern'];
		$col1_mcqsq=$sheet_pattern_arr[0];
		if($sub_pattern=="crn"){
			$crn_q_arr=explode(",", $sub_qs_dist);
			$sub1_qs=$crn_q_arr[0];
			$sub2_qs=$crn_q_arr[1]+$sub1_qs;
			$sub3_qs=$crn_q_arr[2]+$sub2_qs;
			$sub4_qs=$crn_q_arr[3]+$sub3_qs;
			$sub5_qs=$crn_q_arr[4]+$sub4_qs;
		}
		$std_right_ans=0;
		$std_wrong_ans=0;
		$std_unattemted=0;
		$std_wrong_filled=0;
		$correct_match=0;
		$incorrect_match=0;
		$unmatch=0;
		$wrongfilled_match=0;
		$x="";
		$i=0;
		$sub_score=array();
		$c=0;
		$sub_score["sub_1"]=0;
		$sub_score["sub_2"]=0;
		$sub_score["sub_3"]=0;
		$sub_score["sub_4"]=0;
		$sub_score["sub_5"]=0;
		$negative_marks=0;
		$q=0;
		foreach($answer_data_arr as $col=>$val){

			$c++;
			if(is_object($answer_data_arr)){
				$answer_data_arr =  (array) $answer_data_arr;
				$std_data_arr= (array) $std_data_arr;
			}
			foreach($answer_data_arr[$col] as $sec=>$value){
				if(is_object($answer_data_arr[$col])){
					$answer_data_arr[$col]=(array) $answer_data_arr[$col];
					$std_data_arr[$col]= (array) $std_data_arr[$col];
				}
				foreach($answer_data_arr[$col][$sec] as $qNo=>$ans){

					if($sec=="mcqsq"){
						if($sheet_type=="crn"){
							$q++;
							if($std_data_arr[$col][$sec][$qNo]=="blank"){
								$std_unattemted+=1;
							}else if($answer_data_arr[$col][$sec][$qNo]=="blank"){
								continue;
							}else if($std_data_arr[$col][$sec][$qNo]=="more"||$std_data_arr[$col][$sec][$qNo]=="wrong"){
								$std_wrong_filled+=1;
							}else if($answer_data_arr[$col][$sec][$qNo]==$std_data_arr[$col][$sec][$qNo]){
								$std_right_ans+=1;
								if($q<=$sub1_qs){
									$sub_score['sub_1']+=$mcqs_m[0];
								}else if($q>$sub1_qs&&$q<=$sub2_qs){
									$sub_score['sub_2']+=$mcqs_m[0];
								}else if($q>$sub2_qs&&$q<=$sub3_qs){
									$sub_score['sub_3']+=$mcqs_m[0];
								}else if($q>$sub3_qs&&$q<=$sub4_qs){
									$sub_score['sub_4']+=$mcqs_m[0];
								}else if($q>$sub4_qs&&$q<=$sub5_qs){
									$sub_score['sub_5']+=$mcqs_m[0];
								}else{
									$sub_score[$col]+=$mcqs_m[0];
								}
								
							}else{
								$std_wrong_ans+=1;
								if($q<=$sub1_qs){
									$sub_score['sub_1']-=$mcqs_m[1];
								}else if($q>$sub1_qs&&$q<=$sub2_qs){
									$sub_score['sub_2']-=$mcqs_m[1];
								}else if($q>$sub2_qs&&$q<=$sub3_qs){
									$sub_score['sub_3']-=$mcqs_m[1];
								}else if($q>$sub3_qs&&$q<=$sub4_qs){
									$sub_score['sub_4']-=$mcqs_m[1];
								}else if($q>$sub4_qs&&$q<=$sub5_qs){
									$sub_score['sub_5']-=$mcqs_m[1];
								}else{
									$sub_score[$col]-=$mcqs_m[1];
								}
							}	
						}else{
							if($std_data_arr[$col][$sec][$qNo]=="blank"){
								$std_unattemted+=1;
							}else if($answer_data_arr[$col][$sec][$qNo]=="blank"){
								continue;
							}else if($std_data_arr[$col][$sec][$qNo]=="more"||$std_data_arr[$col][$sec][$qNo]=="wrong"){
								$std_wrong_filled+=1;
							}else if($answer_data_arr[$col][$sec][$qNo]==$std_data_arr[$col][$sec][$qNo]){
								$std_right_ans+=1;
								$sub_score[$col]+=$mcqs_m[0];
								
							}else{
								$std_wrong_ans+=1;
								$sub_score[$col]=$sub_score[$col]-$mcqs_m[1];
							}
						}

					}else if($sec=="mcqmq"){
						$no_of_right_opt=sizeof($answer_data_arr[$col][$sec][$qNo]);
						
						if($answer_data_arr[$col][$sec][$qNo][0]=="blank"||$answer_data_arr[$col][$sec][$qNo]==array("none")){
						
							
							continue;
						}else if($std_data_arr[$col][$sec][$qNo]=="blank"||$std_data_arr[$col][$sec][$qNo][0]=="blank"||$std_data_arr[$col][$sec][$qNo]==array("none")){
							$std_unattemted+=1;
							continue;
						}else if(sizeof($std_data_arr[$col][$sec][$qNo])!=$no_of_right_opt){
							$std_wrong_ans+=1;
							$sub_score[$col]=$sub_score[$col]-$mcqm_m[1];
						}else if(in_array("wrong", $std_data_arr[$col][$sec][$qNo])){
							$std_wrong_filled+=1;
						}else{
							$crct_filled_opt=0;
							foreach($answer_data_arr[$col][$sec][$qNo] as $sub_qNo=>$sub_ans){
								if($answer_data_arr[$col][$sec][$qNo][$sub_qNo]==$std_data_arr[$col][$sec][$qNo][$sub_qNo]){
									$crct_filled_opt+=1;
								}
							}
							if($crct_filled_opt==$no_of_right_opt){
								$std_right_ans+=1;
								$sub_score[$col]+=$mcqm_m[0];
							}else{
								$std_wrong_ans+=1;
								$sub_score[$col]=$sub_score[$col]-$mcqm_m[1];
							}
						}
						
					}else if($sec=="compq"){

						if($answer_data_arr[$col][$sec][$qNo]=="blank"){
							continue;
						}else if($std_data_arr[$col][$sec][$qNo]=="blank"){
							$std_unattemted=+1;
						}else if($std_data_arr[$col][$sec][$qNo]=="more"||$std_data_arr[$col][$sec][$qNo]=="wrong"){
							$std_wrong_filled+=1;
						}else if($answer_data_arr[$col][$sec][$qNo]==$std_data_arr[$col][$sec][$qNo]){
							$std_right_ans+=1;
							$sub_score[$col]+=$compq_m[0];
						}else{
							$std_wrong_ans+=1;
							$negative_marks+=1;
							$sub_score[$col]=$sub_score[$col]-$compq_m[1];
						}

					}else if($sec=="digit1q"){
						if($answer_data_arr[$col][$sec][$qNo]=="blank"){
							continue;
						}else if($std_data_arr[$col][$sec][$qNo]=="blank"){
							$std_unattemted=+1;
						}else if($std_data_arr[$col][$sec][$qNo]=="more"||$std_data_arr[$col][$sec][$qNo]=="wrong"){
							$std_wrong_filled+=1;
						}else if($answer_data_arr[$col][$sec][$qNo]==$std_data_arr[$col][$sec][$qNo]){
							$std_right_ans+=1;
							$sub_score[$col]+=$digit1q_m[0];
						}else{
							$std_wrong_ans+=1;
							$negative_marks+=1;
							$sub_score[$col]=$sub_score[$col]-$digit1q_m[1];
						}
						
					}else if($sec=="matrixq"){
						foreach($answer_data_arr[$col][$sec][$qNo] as $sub_qNo=>$sub_ans){
							$correct_sub_match=0;
							foreach($answer_data_arr[$col][$sec][$qNo][$sub_qNo] as $subin_qNo=>$subin_ans){
								if(isset($std_data_arr[$col][$sec][$qNo][$sub_qNo][$subin_qNo])){
									if($answer_data_arr[$col][$sec][$qNo][$subin_qNo]=="blank"){
										continue;
									}else if($std_data_arr[$col][$sec][$qNo][$sub_qNo][$subin_qNo]=="blank"){
										$unmatch+=1;
									}else if($answer_data_arr[$col][$sec][$qNo][$sub_qNo][$subin_qNo]==$std_data_arr[$col][$sec][$qNo][$sub_qNo][$subin_qNo]){
										$correct_sub_match+=1;
									}else if($std_data_arr[$col][$sec][$qNo][$sub_qNo][$subin_qNo]=="wrong"||$std_data_arr[$col][$sec][$qNo][$sub_qNo][$subin_qNo]=="more"){
										$wrongfilled_match+=1;
									}
								}
							}
							if($correct_sub_match==sizeof($answer_data_arr[$col][$sec][$qNo][$sub_qNo])&&sizeof($answer_data_arr[$col][$sec][$qNo][$sub_qNo])==sizeof($std_data_arr[$col][$sec][$qNo][$sub_qNo])){
								$correct_match+=1;
								$sub_score[$col]+=$matrixq_m[0];
								$x.="(".$qNo."---".$sub_qNo.")";
							}else{
								$incorrect_match+=1;
								$sub_score[$col]=$sub_score[$col]-$matrixq_m[1];
							}
								
						}
						// $x.=sizeof($answer_data_arr[$col][$sec][$qNo][$sub_qNo])."---";
					
					}else if($sec=="digitq"){
						

						$right_match=0;
						$none_count=0;
						foreach($answer_data_arr[$col][$sec][$qNo] as $sub_qNo=>$sub_ans){
							if($sub_qNo==0){
								if($answer_data_arr[$col][$sec][$qNo][$sub_qNo]==$std_data_arr[$col][$sec][$qNo][$sub_qNo]||$answer_data_arr[$col][$sec][$qNo][$sub_qNo]=="blank"){
									$right_match+=1;
									$none_count+=1;
								}else if($answer_data_arr[$col][$sec][$qNo][$sub_qNo]!=$std_data_arr[$col][$sec][$qNo][$sub_qNo]&&$answer_data_arr[$col][$sec][$qNo][$sub_qNo]=="-"){
									continue;
								}else if($std_data_arr[$col][$sec][$qNo][$sub_qNo]=="blank"){
									$right_match+=1;
									$none_count+=1;
								}

							}else{
								if($answer_data_arr[$col][$sec][$qNo][$sub_qNo]=="blank"&&$answer_data_arr[$col][$sec][$qNo][$sub_qNo]!='0'){
									continue;
								}else if($answer_data_arr[$col][$sec][$qNo][$sub_qNo]==$std_data_arr[$col][$sec][$qNo][$sub_qNo]){
									$right_match+=1;
									if($std_data_arr[$col][$sec][$qNo][$sub_qNo]=="blank"&&$std_data_arr[$col][$sec][$qNo][$sub_qNo]!='0'){
										$none_count+=1;
									}
								}else if($std_data_arr[$col][$sec][$qNo][$sub_qNo]=="more"&&$std_data_arr[$col][$sec][$qNo][$sub_qNo]=="wrong"){
									$std_wrong_filled+=1;
									break;
								}else if($std_data_arr[$col][$sec][$qNo][$sub_qNo]=="blank"&&$std_data_arr[$col][$sec][$qNo][$sub_qNo]!='0'){
									$none_count+=1;
									
								}
							}
						}
						if($none_count==5){
							$std_unattemted+=1;
						}else if($right_match==5){
							$std_right_ans+=1;
							$sub_score[$col]+=$digitq_m[0];
						}else{
							$std_wrong_ans+=1;
							$sub_score[$col]=$sub_score[$col]-$digitq_m[1];
						}
						
					}else if($sec=="arq"){
						if($answer_data_arr[$col][$sec][$qNo]=="blank"){
							continue;
						}else if($std_data_arr[$col][$sec][$qNo]=="blank"){
							$std_unattemted=+1;
						}else if($std_data_arr[$col][$sec][$qNo]=="more"||$std_data_arr[$col][$sec][$qNo]=="wrong"){
							$std_wrong_filled+=1;
						}else if($answer_data_arr[$col][$sec][$qNo]==$std_data_arr[$col][$sec][$qNo]){
							$std_right_ans+=1;
							$sub_score[$col]+=$arq_m[0];
						}else{
							$std_wrong_ans+=1;
							$negative_marks+=1;
							$sub_score[$col]=$sub_score[$col]-$arq_m[1];
						}
						
					}else if($sec=="tfq"){
						if($answer_data_arr[$col][$sec][$qNo]=="blank"){
							continue;
						}else if($std_data_arr[$col][$sec][$qNo]=="blank"){
							$std_unattemted=+1;
						}else if($std_data_arr[$col][$sec][$qNo]=="more"||$std_data_arr[$col][$sec][$qNo]=="wrong"){
							$std_wrong_filled+=1;
						}else if($answer_data_arr[$col][$sec][$qNo]==$std_data_arr[$col][$sec][$qNo]){
							$std_right_ans+=1;
							$sub_score[$col]+=$tfq_m[0];
						}else{
							$std_wrong_ans+=1;
							$negative_marks+=1;
							$sub_score[$col]=$sub_score[$col]-$tfq_m[1];
						}
						
					}
				}
			}
		}
			
		$std_score=$sub_score["sub_1"]+$sub_score["sub_2"]+$sub_score["sub_3"]+$sub_score["sub_4"]+$sub_score["sub_5"];
		
		$crnt_time=time();
		$col1_score=$sub_score["sub_1"];
		$col2_score=$sub_score["sub_2"];
		$col3_score=$sub_score["sub_3"];
		$col4_score=$sub_score["sub_4"];
		$col5_score=$sub_score["sub_5"];
		if($std_score!=0||$std_wrong_ans!=0){
			$tag=substr($crnt_time, 6, 10);
			$file_src_arr=explode("/", $omr_src);
			$insert_omr_src=$file_src_arr[0]."/".$file_src_arr[1]."-Checked/".$tag.".jpg";
			$dbh->insert("scaned_omrs", "test_id='$test_id', std_roll_no='$std_roll_no', test_data='$std_data', scaned_time='$crnt_time', wrong_ans='$std_wrong_ans', right_ans='$std_right_ans', total_score='$std_score', incorrect_filled='$std_wrong_filled', correct_match='$correct_match', incorrect_match='$incorrect_match', col1_score='$col1_score', col2_score='$col2_score', col3_score='$col3_score', col4_score='$col4_score', col5_score='$col5_score', omr_src='$insert_omr_src'");
			if(mysql_insert_id()>0){
				if(!is_dir("../".$file_src_arr[0]."/".$file_src_arr[1]."-Checked")){
				   mkdir("../".$file_src_arr[0]."/".$file_src_arr[1]."-Checked");
				}
				if(file_exists("../".$omr_src)){
					rename("../".$omr_src, "../".$file_src_arr[0]."/".$file_src_arr[1]."-Checked/".$tag.".jpg");
				}
			}

		}
	}
	

?>