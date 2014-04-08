<?php
include_once("./classes/main.class.php");
include_once("./classes/institute.class.php");
$inst=new institute();
$address=$inst->address;
$main=new main();
$main->show_msg();
$sheet_title="OMR Sheet perview | tReader";
$roll_digit=7;
$q_opts=4;
$digit1q=0;
if(isset($_GET['sub_pattern'])){
	$sub_pattern=$_GET['sub_pattern'];
	if($sub_pattern=="sn"){
		$sub1=$_GET['sub1'];
		$sub2=$_GET['sub2'];
		$sub3=$_GET['sub3'];
		$sub4="";
		$sub5="";
		$col1_name=$sub1;
		$col2_name=$sub2;
		$col3_name=$sub3;
		$mcqs=$_GET['mcqs'];
		$mcqm=$_GET['mcqm'];
		$compq=$_GET['compq'];
		$matrixq=$_GET['matrixq'];
		$digit4q=$_GET['digit4q'];
		$digit1q=$_GET['digit1q'];
		$arq=$_GET['arq'];
		$tfq=$_GET['tfq'];
		$roll_digit=$_GET['roll_digit'];
		$sub_no=3;
		$sub_pattern_string="'".$_GET['sub_pattern']."'";
		$sub_name_string="'".$sub1.",".$sub2.",".$sub3.",".$sub4.",".$sub5."'";
		$qs_dist_string="'".$mcqs.",0,0,0,0'";
		$sheet_name=$_GET['sheet_name'];
	    $col_qs_pattern="'".$mcqs.",".$mcqm.",".$compq.",".$digit1q.",".$matrixq.",".$digit4q.",".$arq.",".$tfq."'";
		$sheet_title=$sheet_name;
		$sheet_name="'".$_GET['sheet_name']."'";
		$marking_pattern="'".$_GET['mcqsp'].",".$_GET['mcqsn']."|".$_GET['mcqmp'].",".$_GET['mcqmn']."|".$_GET['compqp'].",".$_GET['compqn']."|".$_GET['digit1qp'].",".$_GET['digit1qn']."|".$_GET['matrixqp'].",".$_GET['matrixqn']."|".$_GET['digit4qp'].",".$_GET['digit4qn']."|".$_GET['arqp'].",".$_GET['arqn']."|".$_GET['tfqp'].",".$_GET['tfqn']."'";
		$action='<button class="saveOption btn" onclick="saveOmrSheet('.$sheet_name.', '.$sub_pattern_string.', '.$sub_no.', '.$sub_name_string.', '.$qs_dist_string.', '.$col_qs_pattern.', '.$marking_pattern.', '.$roll_digit.', '.$q_opts.')">Download</button>';
	}else if($sub_pattern=="cn"){
		
		$sub1=$_GET['sub1'];
		$sub2=$_GET['sub2'];
		$sub3=$_GET['sub3'];
		$col1_name=$sub1;
		$col2_name=$sub2;
		$col3_name=$sub3;
		$sub4="";
		$sub5="";
		$mcqs=$_GET['mcqs'];
		$mcqm=$_GET['mcqm'];
		$compq=$_GET['compq'];
		$matrixq=$_GET['matrixq'];
		$digit4q=$_GET['digit4q'];
		$digit1q=$_GET['digit1q'];
		$arq=$_GET['arq'];
		$tfq=$_GET['tfq'];
		$roll_digit=$_GET['roll_digit'];
		$exQs=0;
		$sub_no=3;
		$sub_pattern_string="'".$_GET['sub_pattern']."'";
		$sub_name_string="'".$sub1.",".$sub2.",".$sub3.",".$sub4.",".$sub5."'";
		$qs_dist_string="'".$mcqs.",0,0,0,0'";
		$sheet_name=$_GET['sheet_name'];
	    $col_qs_pattern="'".$mcqs.",".$mcqm.",".$compq.",".$digit1q.",".$matrixq.",".$digit4q.",".$arq.",".$tfq."'";
		$sheet_title=$sheet_name;
		$sheet_name="'".$_GET['sheet_name']."'";
		$marking_pattern="'".$_GET['mcqsp'].",".$_GET['mcqsn']."|0,0|0,0|0,0|0,0|0,0|0,0|0,0'";
		$action='<button class="saveOption btn" onclick="saveOmrSheet('.$sheet_name.', '.$sub_pattern_string.', '.$sub_no.', '.$sub_name_string.', '.$qs_dist_string.', '.$col_qs_pattern.', '.$marking_pattern.', '.$roll_digit.', '.$q_opts.')">Download</button>';
	}else if($sub_pattern=="crn"){
		$sub_no=$_GET['sub_no'];
		$col1_name="";
		$col2_name="";
		$col3_name="";
		$sub1=$_GET['sub1'];
		$sub2=$_GET['sub2'];
		$sub3=$_GET['sub3'];
		$sub4=$_GET['sub4'];
		$sub5=$_GET['sub5'];
		$q_opts=$_GET['q_opts'];
		$totalQs=$_GET['sub1Qs']+$_GET['sub2Qs']+$_GET['sub3Qs']+$_GET['sub4Qs']+$_GET['sub5Qs'];
		$exQs=($totalQs%3);
		$mcqs=intval($totalQs/3)+$exQs;
		$exQs=$exQs*2;
		$roll_digit=$_GET['roll_digit'];
		
		
		$mcqm=0;
		$compq=0;
		$arq=0;
		$tfq=0;
		$digi1q=0;
		$matrixq=0;
		$digit4q=0;;
		$sub_pattern_string="'".$_GET['sub_pattern']."'";
		$sub_name_string="'".$sub1.",".$sub2.",".$sub3.",".$sub4.",".$sub5."'";
		$qs_dist_string="'".$_GET['sub1Qs'].",".$_GET['sub2Qs'].",".$_GET['sub3Qs'].",".$_GET['sub4Qs'].",".$_GET['sub5Qs']."'";
		$sheet_name=$_GET['sheet_name'];
	    $col_qs_pattern="'".$mcqs.",".$mcqm.",".$compq.",".$digit1q.",".$matrixq.",".$digit4q.",".$arq.",".$tfq."'";
		$sheet_title=$sheet_name;
		$sheet_name="'".$_GET['sheet_name']."'";
		$marking_pattern="'".$_GET['mcqsp'].",".$_GET['mcqsn']."|0,0|0,0|0,0|0,0|0,0|0,0|0,0'";
		$action='<button class="saveOption btn" onclick="saveOmrSheet('.$sheet_name.', '.$sub_pattern_string.', '.$sub_no.', '.$sub_name_string.', '.$qs_dist_string.', '.$col_qs_pattern.', '.$marking_pattern.', '.$roll_digit.', '.$q_opts.')">Download</button>';
	}else{
		header("Location:create-omrsheet.php?msg=Some Error! Try again.");
		exit();
	}
}else{
	header("Location:create-omrsheet.php?msg=Some Error! Try again.");
	exit();
}
if(isset($mcqs)&&isset($mcqm)&&isset($compq)&&isset($matrixq)&&isset($digit4q)){

	$mcqs1=$mcqs/2;
	if($mcqs%2==0){
		
		$mcqs2=$mcqs1;
	}else{
		$mcqs2=$mcqs1;
		$mcqs1=$mcqs1+1;

	}

	$arq1=$arq/2;
	if($arq%2==0){
		
		$arq2=$arq1;
	}else{
		$arq2=$arq1;
		$arq1=$arq1+1;

	}

	$tfq1=$tfq/2;
	if($tfq%2==0){
		
		$tfq2=$tfq1;
	}else{
		$tfq2=$tfq1;
		$tfq1=$tfq1+1;

	}

	$mcqm1=$mcqm/2;
	if($mcqm%2==0){
		
		$mcqm2=$mcqm1;
	}else{
		$mcqm2=$mcqm1;
		$mcqm1=$mcqm1+1;

	}
	$compq1=intval($compq/2);
	if($compq%2==0){
		
		$compq2=$compq1;
	}else{
		$compq2=$compq1;
		$compq1=$compq1+1;

	}

	$matrixq1=intval($matrixq/2);
	if($matrixq%2==0){
		
		$matrixq2=$matrixq1;
	}else{
		$matrixq2=$matrixq1;
		$matrixq1=$matrixq1+1;

	}
	if($digit4q>2){
		$digit4qD=intval($digit4q/3);
		$digit4qRem=$digit4q%3;
		if($digit4qRem>1){
			$digit4q1=$digit4qD+1;
			$digit4q2=$digit4qD+1;
			$digit4q3=$digit4qD;
		}else if($digit4qRem==1){
			$digit4q1=$digit4qD+1;
			$digit4q2=$digit4qD;
			$digit4q3=$digit4qD;
		}else{
			$digit4q1=$digit4qD;
			$digit4q2=$digit4qD;
			$digit4q3=$digit4qD;
		}
	}else if($digit4q==2){
		$digit4q1=1;
		$digit4q2=1;
		$digit4q3=0;
	}else{
		$digit4q1=1;
		$digit4q2=0;
		$digit4q3=0;
	}
		
	if($mcqs>0){
		$secA=1;
	}else{
		$secA=0;
	}
	if($mcqm>0){
		$secB=1+$secA;
	}else{
		$secB=$secA;
	}
	if($compq>0){
		$secC=1+$secB;
	}else{
		$secC=$secB;
	}
	if($digit1q>0){
		$secD=1+$secC;
	}else{
		$secD=$secC;
	}
	if($matrixq>0){
		$secE=1+$secD;
	}else{
		$secE=$secD;
	}
	if($digit4q>0){
		$secF=1+$secE;
	}else{
		$secF=$secE;
	}
	
	if($arq>0){
		$secG=1+$secF;
	}else{
		$secG=$secF;
	}
	if($tfq>0){
		$secH=1+$secG;
	}else{
		$secH=$secG;
	}
	function getSecName($secVal){
		switch($secVal){
			case '1':
				$sec_name="A";
				break;
			case '2':
				$sec_name="B";
				break;
			case '3':
				$sec_name="C";
				break;
			case '4':
				$sec_name="D";
				break;
			case '5':
				$sec_name="E";
				break;
			case '6':
				$sec_name="F";
				break;
			case '7':
				$sec_name="G";
				break;
			case '8':
				$sec_name="H";
				break;
			default:
				$sec_name="";
		}
		return $sec_name;
	}
	$mcqs1_content="";
	$mcqs2_content="";
	$arq1_content="";
	$arq2_content="";
	$tfq1_content="";
	$tfq2_content="";
	$mcqs_squares="";
	$mcqm_square="";
	$matrixq_squares="";
	$digit4q_squares="";
	$digit1q_squares="";
	$mcqsqRefs="";
	$mcqmqRefs="";
	$compqRefs="";
	$matrixRefs="";
	$digit4qRefs="";
	$digit1qRefs="";
	$arqRefs="";
	$tfqRefs="";
	$roll_squares="";
	$roll_0s="";
	$roll_1s="";
	$roll_2s="";
	$roll_3s="";
	$roll_4s="";
	$roll_5s="";
	$roll_6s="";
	$roll_7s="";
	$roll_8s="";
	$roll_9s="";
	for($rn=0; $rn<$roll_digit; $rn++){
		$roll_squares.='<div class="square"></div>';
		$roll_0s.='<div class="circle">0</div>';
		$roll_1s.='<div class="circle">1</div>';
		$roll_2s.='<div class="circle">2</div>';
		$roll_3s.='<div class="circle">3</div>';
		$roll_4s.='<div class="circle">4</div>';
		$roll_5s.='<div class="circle">5</div>';
		$roll_6s.='<div class="circle">6</div>';
		$roll_7s.='<div class="circle">7</div>';
		$roll_8s.='<div class="circle">8</div>';
		$roll_9s.='<div class="circle">9</div>';
		
	}
	$q_no=1;
	$q_nom=1;
	$q_nor=1;
	if($sub_pattern=='cn'||$sub_pattern=='crn'){
		$clm_qs=$mcqs+$mcqm+$compq+$digit1q+$digit4q+$arq+$tfq;
		$q_nom=$clm_qs+1;
		$q_nor=$clm_qs*2+1;
	}
	if($q_opts==5){
		$fifth_opt='<div class="circle">5</div>';
	}else{
		$fifth_opt='';
	}
	if($mcqs>0){
		for($i=1; $i<=$mcqs1; $i++){
			if($i==29){
				$margin_cls="omr-margin-q-29";
			}else{
				$margin_cls="";
			}

			$mcqs1_content.='<div class="qBox mcq circles '.$margin_cls.'">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			'.$fifth_opt.'
	            		</div>';
	            $mcqsqRefs.='<div class="ref-square"></div>';
	            		$q_no++;
		}
		for($i=1; $i<=$mcqs2; $i++){
			if($i==29){
				$margin_cls="omr-margin-q-29";
			}else{
				$margin_cls="";
			}
			$mcqs2_content.='<div class="qBox mcq circles '.$margin_cls.'">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			'.$fifth_opt.'
	            		</div>';
	            		$q_no++;
		}

		$mcqs_content_l='<div class="span1 marginl0">
							<p class="section-name"><b>'.getSecName($secA).'</b></p>
							<div class="ref-squares">'.$mcqsqRefs.'</div>

							
						</div>
						<div class="span11 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$mcqs1_content.'</div>
								<div class="span6">'.$mcqs2_content.'</div>
							</div>
							
						</div>';
		if($sub_pattern=="cn"||$sub_pattern=="crn"){
			$mcqs1_content="";
			$mcqs2_content="";
			for($i=1; $i<=$mcqs1; $i++){
				$mcqs1_content.='<div class="qBox mcq circles">
		            			<div class="qNo">'.$q_no.'</div>
		            			<div class="circle">A</div>
		            			<div class="circle">B</div>
		            			<div class="circle">C</div>
		            			<div class="circle">D</div>
	            			'.$fifth_opt.'
		            		</div>';
		            		$q_no++;
			}
			for($i=1; $i<=$mcqs2; $i++){
			$mcqs2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			'.$fifth_opt.'
	            		</div>';
	            		$q_no++;
			}
		}
		$mcqs_content_m='<div class="span12 marginl0 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$mcqs1_content.'</div>
								<div class="span6">'.$mcqs2_content.'</div>
							</div>
							
						</div>';
		if($sub_pattern=="cn"||$sub_pattern=="crn"){
			$mcqs2_content="";
			$mcqs1_content="";
			for($i=1; $i<=$mcqs1; $i++){
				$mcqs1_content.='<div class="qBox mcq circles">
		            			<div class="qNo">'.$q_no.'</div>
		            			<div class="circle">A</div>
		            			<div class="circle">B</div>
		            			<div class="circle">C</div>
		            			<div class="circle">D</div>
	            			'.$fifth_opt.'
		            		</div>';
		            		$q_no++;
			}
			$mcqs2=($mcqs2-$exQs);
			for($i=1; $i<=$mcqs2; $i++){
			$mcqs2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			'.$fifth_opt.'
	            		</div>';
	            		$q_no++;
			}
		}
		$mcqs_content_r='
						
						<div class="span11 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$mcqs1_content.'</div>
								<div class="span6">'.$mcqs2_content.'</div>
							</div>
						</div>
						<div class="span1 rightBars ref-squares">'.$mcqsqRefs.'</div>
						';
	}else{
		$mcqs_content_l='';
		$mcqs_content_m='';
		$mcqs_content_r='';
	}


	$mcqm1_content="";
	$mcqm2_content="";
	$mcqm_squares='';
	if($mcqm>0){
		for($i=1; $i<=$mcqm1; $i++){
			$mcqm1_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            		</div>';
        	$mcqmqRefs.='<div class="ref-square"></div>';

	            		$q_no++;
		}

		for($i=1; $i<=$mcqm2; $i++){
			$mcqm2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            		</div>';
	            		$q_no++;
		}
		$mcqm_content_l='<div class="span1 marginl0">
							<p class="section-name"><b>'.getSecName($secB).'</b></p>
							<div class="ref-squares">'.$mcqmqRefs.'</div>

						</div>
						<div class="span11 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$mcqm1_content.'</div>
								<div class="span6">'.$mcqm2_content.'</div>
							</div>
						</div>';
		$mcqm_content_m='
						<div class="span12 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$mcqm1_content.'</div>
								<div class="span6">'.$mcqm2_content.'</div>
							</div>
						</div>';
		$mcqm_content_r='
						<div class="span11 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$mcqm1_content.'</div>
								<div class="span6">'.$mcqm2_content.'</div>
							</div>
						</div>
						<div class="span1 rightBars ref-squares">'.$mcqmqRefs.'</div>
						';
	}else{
		$mcqm_content_l='';
		$mcqm_content_m='';
		$mcqm_content_r='';
	}

	$compq1_content="";
	$compq2_content="";
	$compq_squares='';
	if($compq>0){
		for($i=1; $i<=$compq1; $i++){
			$compq1_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            		</div>';
	            	$compqRefs.='<div class="ref-square"></div>';

	            		$q_no++;
		}

		for($i=1; $i<=$compq2; $i++){
			$compq2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            		</div>';
	            		$q_no++;
		}
		$compq_content_l='<div class="span1 marginl0">
							<p class="section-name"><b>'.getSecName($secC).'</b></p>
							<div class="ref-squares">'.$compqRefs.'</div>

						</div>
						<div class="span11 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$compq1_content.'</div>
								<div class="span6">'.$compq2_content.'</div>
							</div>
						</div>';
		$compq_content_m='
						<div class="span12 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$compq1_content.'</div>
								<div class="span6">'.$compq2_content.'</div>
							</div>
						</div>';
		$compq_content_r='
						<div class="span11 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$compq1_content.'</div>
								<div class="span6">'.$compq2_content.'</div>
							</div>
						</div>
						<div class="span1 ref-squares rightBars">'.$compqRefs.'</div>
						';
	}else{
		$compq_content_l='';
		$compq_content_m='';
		$compq_content_r='';
	}

	$digit1q_content="";
	if($digit1q>0){
		for($i=0; $i<$digit1q; $i++){
			$digit1q_content.='<div class=" digitq1">
	            			<div class="circles row1">
	            				<div class="qNo">'.$q_no.'</div>

	            			</div>
	            			<div class="circles">
		            			<div class="circle">0</div>
		            			
	            			</div>
	            			<div class="circles">
		            			<div class="circle">1</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">2</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">3</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">4</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">5</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">6</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">7</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">8</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">9</div>
	            			</div>
	            		</div>';
	            if($i==0){
	            	$digit1qRefs.='<div class="ref-square"></div>';

	            }
	            $q_no++;

		}
		
		$digit1q_content_l='
						<div class="span1 marginl0">
							<p class="section-name"><b>'.getSecName($secD).'</b></p>
							<div class="digit-refs ref-squares">'.$digit1qRefs.'</div>
						</div>
						<div class="span11 digitq1_box borderlrbb1">
							<div class="row-fluid">
								'.$digit1q_content.'
							</div>
						</div>';
		$digit1q_content_m='
						<div class="span12 digitq1_box borderlrbb1 marginl0">
							<div class="row-fluid">
								'.$digit1q_content.'
							</div>
						</div>';
		$digit1q_content_r='
						<div class="span11 digitq1_box borderlrbb1 marginl0">
							<div class="row-fluid">
								'.$digit1q_content.'
							</div>
						</div>
						<div class="span1 digit-refs ref-squares rightBars">'.$digit1qRefs.'</div>
						';
	}else{
		$digit1q_content_l='';
		$digit1q_content_m='';
		$digit1q_content_r='';
	}

	$matrixq1_content="";
	$matrixq2_content="";
	if($matrixq>0){
		for($i=1; $i<=$matrixq1; $i++){
			$matrixq1_content.='<div class="qBox matrixq">
	            			<div class="qNo">'.$q_no.'</div>

	            			<div class="circles">
	            				<div class="">(A)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            			<div class="circles">
	            				<div class="">(B)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            			<div class="circles">
	            				<div class="">(C)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            			<div class="circles">
	            				<div class="">(D)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            		</div>';
	            	$matrixRefs.='<div class="ref-square"></div>';
	            		$q_no++;
		}

		for($i=1; $i<=$matrixq2; $i++){
			$matrixq2_content.='<div class="qBox matrixq">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circles">
	            				<div class="">(A)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            			<div class="circles">
	            				<div class="">(B)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            			<div class="circles">
	            				<div class="">(C)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            			<div class="circles">
	            				<div class="">(D)</div>
		            			<div class="circle">P</div>
		            			<div class="circle">Q</div>
		            			<div class="circle">R</div>
		            			<div class="circle">S</div>
		            			<div class="circle">T</div>
		            			
	            			</div>
	            		</div>';
	            		$q_no++;
		}
		$matrixq_content_l='<div class="span1 marginl0 pos-abs">
							<p class="section-name"><b>'.getSecName($secE).'</b></p>
							<div class="matrix-refs ref-squares">'.$matrixRefs.'</div>

						</div>
						<div class="span11 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$matrixq1_content.'</div>
								<div class="span6">'.$matrixq2_content.'</div>
							</div>
						</div>';
		$matrixq_content_m='
						<div class="span12 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$matrixq1_content.'</div>
								<div class="span6">'.$matrixq2_content.'</div>
							</div>
						</div>';
		$matrixq_content_r='
						<div class="span11 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$matrixq1_content.'</div>
								<div class="span6">'.$matrixq2_content.'</div>
							</div>
						</div>
						<div class="span1 matrix-refs ref-squares rightBars">'.$matrixRefs.'</div>
						';
	}else{
		$matrixq_content_l='';
		$matrixq_content_m='';
		$matrixq_content_r='';
	}
	$digit4q1_content="";
	$digit4q2_content="";
	$digit4q3_content="";
	$digit4qNo=$q_no;
	if($digit4q>0){
		for($i=0; $i<$digit4q1; $i++){
			$digit4q1_content.='<div class="qBox digitq">
	            			<div class="circles row1">
	            				<div class="qNo">'.($digit4qNo+($i*3)).'</div>

		            			<div class="circle marginl54">+</div>
		            			<div class="circle">-</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
	            			</div>
	            			<div class="circles rowdecimal">
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
	            			</div>
	            		</div>';
	            	$digit4qRefs.='<div class="ref-square"></div>';

	            		$q_no++;
		}
		for($i=0; $i<$digit4q2; $i++){
			$digit4q2_content.='<div class="qBox digitq">
	            			<div class="circles row1">
	            				<div class="qNo">'.($digit4qNo+1+($i*3)).'</div>

		            			<div class="circle marginl54">+</div>
		            			<div class="circle">-</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
	            			</div>
	            			<div class="circles rowdecimal">
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
	            			</div>
	            		</div>';
	            		$q_no++;
		}
		for($i=0; $i<$digit4q3; $i++){
			$digit4q3_content.='<div class="qBox digitq">
	            			<div class="circles row1">
	            				<div class="qNo">'.($digit4qNo+2+($i*3)).'</div>

		            			<div class="circle marginl54">+</div>
		            			<div class="circle">-</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
		            			<div class="circle">0</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
		            			<div class="circle">1</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
		            			<div class="circle">2</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
		            			<div class="circle">3</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
		            			<div class="circle">4</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
		            			<div class="circle">5</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
		            			<div class="circle">6</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
		            			<div class="circle">7</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
		            			<div class="circle">8</div>
	            			</div>
	            			<div class="circles">
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
		            			<div class="circle">9</div>
	            			</div>
	            			<div class="circles rowdecimal">
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
		            			<div class="circle">.</div>
	            			</div>
	            		</div>';
	            		$q_no++;
		}
		$digit4q_content_l='
						<div class="span1 marginl0">
							<p class="section-name"><b>'.getSecName($secF).'</b></p>
							<div class="digit-refs ref-squares">'.$digit4qRefs.'</div>
						</div>
						<div class="span11 borderlrbb1">
							<div class="row-fluid">
								<div class="span4">'.$digit4q1_content.'</div>
								<div class="span4">'.$digit4q2_content.'</div>
								<div class="span4">'.$digit4q3_content.'</div>
							</div>
						</div>';
		$digit4q_content_m='
						<div class="span12 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span4">'.$digit4q1_content.'</div>
								<div class="span4">'.$digit4q2_content.'</div>
								<div class="span4">'.$digit4q3_content.'</div>
							</div>
						</div>';
		$digit4q_content_r='
						<div class="span11 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span4">'.$digit4q1_content.'</div>
								<div class="span4">'.$digit4q2_content.'</div>
								<div class="span4">'.$digit4q3_content.'</div>
							</div>
						</div>
						<div class="span1 digit-refs ref-squares rightBars">'.$digit4qRefs.'</div>
						';
	}else{
		$digit4q_content_l='';
		$digit4q_content_m='';
		$digit4q_content_r='';
	}
	if($arq>0){
		for($i=1; $i<=$arq1; $i++){
			if($i==29){
				$margin_cls="omr-margin-q-29";
			}else{
				$margin_cls="";
			}

			$arq1_content.='<div class="qBox mcq circles '.$margin_cls.'">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			<div class="circle">E</div>
	            			'.$fifth_opt.'
	            		</div>';
	            $arqRefs.='<div class="ref-square"></div>';
	            		$q_no++;
		}
		for($i=1; $i<=$arq2; $i++){
			if($i==29){
				$margin_cls="omr-margin-q-29";
			}else{
				$margin_cls="";
			}
			$arq2_content.='<div class="qBox mcq circles '.$margin_cls.'">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			<div class="circle">E</div>
	            			
	            		</div>';
	            		$q_no++;
		}

		$arq_content_l='<div class="span1 marginl0">
							<p class="section-name"><b>'.getSecName($secG).'</b></p>
							<div class="ref-squares">'.$arqRefs.'</div>

							
						</div>
						<div class="span11 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$arq1_content.'</div>
								<div class="span6">'.$arq2_content.'</div>
							</div>
							
						</div>';
		if($sub_pattern=="cn"||$sub_pattern=="crn"){
			$arq1_content="";
			$arq2_content="";
			for($i=1; $i<=$arq1; $i++){
				$arq1_content.='<div class="qBox mcq circles">
		            			<div class="qNo">'.$q_no.'</div>
		            			<div class="circle">1</div>
		            			<div class="circle">2</div>
		            			<div class="circle">3</div>
		            			<div class="circle">4</div>
	            				<div class="circle">E</div>
	            			
		            		</div>';
		            		$q_no++;
			}
			for($i=1; $i<=$arq2; $i++){
			$arq2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			<div class="circle">E</div>
	            			
	            		</div>';
	            		$q_no++;
			}
		}
		$arq_content_m='<div class="span12 marginl0 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$arq1_content.'</div>
								<div class="span6">'.$arq2_content.'</div>
							</div>
							
						</div>';
		if($sub_pattern=="cn"||$sub_pattern=="crn"){
			$arq2_content="";
			$arq1_content="";
			for($i=1; $i<=$arq1; $i++){
				$arq1_content.='<div class="qBox mcq circles">
		            			<div class="qNo">'.$q_no.'</div>
		            			<div class="circle">1</div>
		            			<div class="circle">2</div>
		            			<div class="circle">3</div>
		            			<div class="circle">4</div>
	            				<div class="circle">E</div>
	            				
		            		</div>';
		            		$q_no++;
			}
			$arq2=($arq2-$exQs);
			for($i=1; $i<=$arq2; $i++){
			$arq2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			<div class="circle">E</div>
	            			
	            		</div>';
	            		$q_no++;
			}
		}
		$arq_content_r='
						
						<div class="span11 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$arq1_content.'</div>
								<div class="span6">'.$arq2_content.'</div>
							</div>
						</div>
						<div class="span1 rightBars ref-squares">'.$arqRefs.'</div>
						';
	}else{
		$arq_content_l='';
		$arq_content_m='';
		$arq_content_r='';
	}
	if($tfq>0){
		for($i=1; $i<=$tfq1; $i++){
			if($i==29){
				$margin_cls="omr-margin-q-29";
			}else{
				$margin_cls="";
			}

			$tfq1_content.='<div class="qBox mcq circles '.$margin_cls.'">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			'.$fifth_opt.'
	            		</div>';
	            $tfqRefs.='<div class="ref-square"></div>';
	            		$q_no++;
		}
		for($i=1; $i<=$tfq2; $i++){
			if($i==29){
				$margin_cls="omr-margin-q-29";
			}else{
				$margin_cls="";
			}
			$tfq2_content.='<div class="qBox mcq circles '.$margin_cls.'">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			'.$fifth_opt.'
	            		</div>';
	            		$q_no++;
		}

		$tfq_content_l='<div class="span1 marginl0">
							<p class="section-name"><b>'.getSecName($secH).'</b></p>
							<div class="ref-squares">'.$tfqRefs.'</div>

							
						</div>
						<div class="span11 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$tfq1_content.'</div>
								<div class="span6">'.$tfq2_content.'</div>
							</div>
							
						</div>';
		if($sub_pattern=="cn"||$sub_pattern=="crn"){
			$tfq1_content="";
			$tfq2_content="";
			for($i=1; $i<=$tfq1; $i++){
				$tfq1_content.='<div class="qBox mcq circles">
		            			<div class="qNo">'.$q_no.'</div>
		            			<div class="circle">1</div>
		            			<div class="circle">2</div>
		            			<div class="circle">3</div>
		            			<div class="circle">4</div>
	            			'.$fifth_opt.'
		            		</div>';
		            		$q_no++;
			}
			for($i=1; $i<=$tfq2; $i++){
			$tfq2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">A</div>
	            			<div class="circle">B</div>
	            			<div class="circle">C</div>
	            			<div class="circle">D</div>
	            			'.$fifth_opt.'
	            		</div>';
	            		$q_no++;
			}
		}
		$tfq_content_m='<div class="span12 marginl0 borderlrbb1">
							<div class="row-fluid">
								<div class="span6">'.$tfq1_content.'</div>
								<div class="span6">'.$tfq2_content.'</div>
							</div>
							
						</div>';
		if($sub_pattern=="cn"||$sub_pattern=="crn"){
			$tfq2_content="";
			$tfq1_content="";
			for($i=1; $i<=$tfq1; $i++){
				$tfq1_content.='<div class="qBox mcq circles">
		            			<div class="qNo">'.$q_no.'</div>
		            			<div class="circle">1</div>
		            			<div class="circle">2</div>
		            			<div class="circle">3</div>
		            			<div class="circle">4</div>
	            			'.$fifth_opt.'
		            		</div>';
		            		$q_no++;
			}
			$tfq2=($tfq2-$exQs);
			for($i=1; $i<=$tfq2; $i++){
			$tfq2_content.='<div class="qBox mcq circles">
	            			<div class="qNo">'.$q_no.'</div>
	            			<div class="circle">1</div>
	            			<div class="circle">2</div>
	            			<div class="circle">3</div>
	            			<div class="circle">4</div>
	            			'.$fifth_opt.'
	            		</div>';
	            		$q_no++;
			}
		}
		$tfq_content_r='
						
						<div class="span11 borderlrbb1 marginl0">
							<div class="row-fluid">
								<div class="span6">'.$tfq1_content.'</div>
								<div class="span6">'.$tfq2_content.'</div>
							</div>
						</div>
						<div class="span1 rightBars ref-squares">'.$tfqRefs.'</div>
						';
	}else{
		$tfq_content_l='';
		$tfq_content_m='';
		$tfq_content_r='';
	}
	

	$main_content='<div class="row-fluid omrsheet">
		<div class="span12 omrwidth">
			<div class="row-fluid">
				<div class="span1">
					<div class="squares">
            			<div class="squaree filledB"></div>
        			</div>
				</div>
				<div class="span10 ">
					<div clas="row-fluid">
					<div class="span1">
						<b class="">Test ID</b>
						<div class="qBox">
		            			<div class="squares">
			            			<div class="square"></div>
			            			<div class="square"></div>
			            			<div class="square"></div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">0</div>
			            			<div class="circle">0</div>
			            			<div class="circle">0</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">1</div>
			            			<div class="circle">1</div>
			            			<div class="circle">1</div>
			            		</div>
		            			<div class="circles">
			            			<div class="circle">2</div>
			            			<div class="circle">2</div>
			            			<div class="circle">2</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">3</div>
			            			<div class="circle">3</div>
			            			<div class="circle">3</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">4</div>
			            			<div class="circle">4</div>
			            			<div class="circle">4</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">5</div>
			            			<div class="circle">5</div>
			            			<div class="circle">5</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">6</div>
			            			<div class="circle">6</div>
			            			<div class="circle">6</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">7</div>
			            			<div class="circle">7</div>
			            			<div class="circle">7</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">8</div>
			            			<div class="circle">8</div>
			            			<div class="circle">8</div>
		            			</div>
		            			<div class="circles">
			            			<div class="circle">9</div>
			            			<div class="circle">9</div>
			            			<div class="circle">9</div>
		            			</div>
		            			
		            		</div>
					</div>
					<div class="span4 ">
						<b class="roll-heading">Student Roll No</b>
						<div class="rollNo-Box ">
		            			<div class="squares">
			            			'.$roll_squares.'
		            			</div>
		            			<div class="rollNo circles">
			            			'.$roll_0s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_1s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_2s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_3s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_4s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_5s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_6s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_7s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_8s.'
			        			</div>
			        			<div class="rollNo circles">
			            			'.$roll_9s.'
			        			</div>
		            			
		            		</div>
					</div>
					<div class="span7 marginl0">
						<div class="row-fluid">
								<div class="span12"><b>Student Name</b></div>
								<div class="span7 marginl0 h70 borderb1"></div>
								<div class="span5 h70 alignC brand-box">
								<img src="images/'.$inst->logo.'" width="">
								</div>
		            			
		            	</div>
		            		<br/>
		            	<div class="row-fluid">
			            	<div class="span4">
			            		<b>Date</b>
				            	<div class="row-fluid">
					            	<div class="span12 marginl0">
						            	<div class="row-fluid">
							            	<div class="span4">
								            	<div class="squares">
								            	<div class="square"></div>
								            	<div class="square"></div>
								            	</div>
							            	</div>
							            	<div class="span4">
								            	<div class="squares">
								            	<div class="square"></div>
								            	<div class="square"></div>
								            	</div>
							            	</div>
							            	<div class="span4">
								            	<div class="squares">
								            	<div class="square"></div>
								            	<div class="square"></div>
								            	</div>
							            	</div>
						            	</div>
					            	</div>
					            	<br/>
					            	<b>Student'."'".'s Sign</b>
				            		<div class="span12 marginl0 borderb1 mh80"></div>
				            	</div>
			            	</div>
			            	<div class="span4">
			            		<div class=" mh127">
			            			<b>Medium</b> 
			            			<div class="squares">
						            	<div class="square">E</div>
						            	<div class="square">H</div>
					            	</div>
								    <b> Batch</b> 
								    <div class="squares">
						            	<div class="square width40"></div>
						            </div>
			            		</div>

			            	</div>
			            	<div class="instBox marginl0 borderb1 mh149">
				            	<h6 class="alignC">Instructions:</h6>
				            	<p>1. Use only blue or black ball point pen.</p>
				            	<p>2. Do not use Ink/Gel Pen or Pencil.</p>
				            	<p>3.Avoid partial filling or spill out.</p> 
			 					<p>4.Completely darken the respective circle for your response.</p>
			            	</div>
		            	</div>
					</div>
					</div>
				</div>
				<div class="span1">
					<div class="squares pushR">
            			<div class="squaree filledB"></div>
        			</div>
				</div>
			</div>
			
		</div>
		
		<div class="span12  marginl0 omrwidth">
			<div class="row-fluid">
				<div class="span4 sub1">
					<div class="row-fluid">
						<div class="span11   borderb1 alignC offset1"><b>'.$col1_name.'</b></div>
						'.$mcqs_content_l.'
						'.$mcqm_content_l.'
						'.$compq_content_l.'
						'.$digit1q_content_l.'
						'.$matrixq_content_l.'
						'.$digit4q_content_l.'
						'.$arq_content_l.'
						'.$tfq_content_l.'
					</div>
				</div>
				<div class="span4 sub2">
					<div class="row-fluid">
						<div class="span12   borderb1 alignC "><b>'.$col2_name.'</b></div>
						'.$mcqs_content_m.'
						'.$mcqm_content_m.'
						'.$compq_content_m.'
						'.$digit1q_content_m.'
						'.$matrixq_content_m.'
						'.$digit4q_content_m.'
						'.$arq_content_m.'
						'.$tfq_content_m.'
					</div>
				</div>
				<div class="span4 sub3">
					<div class="row-fluid">
						<div class="span11   borderb1 alignC "><b>'.$col3_name.'</b></div>
						'.$mcqs_content_r.'
						'.$mcqm_content_r.'
						'.$compq_content_r.'
						'.$digit1q_content_r.'
						'.$matrixq_content_r.'
						'.$digit4q_content_r.'
						'.$arq_content_r.'
						'.$tfq_content_r.'
					</div>
				</div>

				
			</div>
		</div>
		<div class="span12 marginl0 omrwidth ">
			<div class="row-fluid">
				<div class="span4">
					<div class="hBars">
						<div class="barL "></div>
						<div class="bar1"></div>
						<div class="bar2"></div>
						<div class="bar3"></div>
						<div class="bar4"></div>
						<div class="bar5"></div>
						<div class="bar6"></div>
						<div class="bar7"></div>
					</div>
				</div>
				<div class="span4 mSub">
					<div class="hBars ">
						<div class="bar1"></div>
						<div class="bar2"></div>
						<div class="bar3"></div>
						<div class="bar4"></div>
						<div class="bar5"></div>
						<div class="bar6"></div>
						<div class="bar7"></div>
					</div>
				</div>
				<div class="span4 rSub">
					<div class="hBars">
						<div class="bar1"></div>
						<div class="bar2"></div>
						<div class="bar3"></div>
						<div class="bar4"></div>
						<div class="bar5"></div>
						<div class="bar6"></div>
						<div class="bar7"></div>
						<div class="barR "></div>

					</div>
				</div>
			</div>
		</div>
		<div class="span12  alignC " style="padding:5px 5px; font-size:16px">
			
			<b>'.$address.'</b>
			
		</div>
		<div class="span12 omrwidth alignC ">
			'.$action.'
			
		</div>
	</div>';
}else{
	$main_content='<div class="row-fluid">
            	<div class="span12">
            		<h3>Design new OMR Sheet</h3>
            		<form action="create-omrsheet.php" method="get">
	            		<div class="row-fluid">
	            			<div class="span3">
	            			 	MCQ Single answer:<br/>
	            				<input type="text" name="mcqs"/>
	            			</div>
	            			<div class="span3">
	            			 	MCQ Multiple answer:<br/>
	            				<input type="text" name="mcqm"/>
	            			</div>
	            			<div class="span3">
	            			 	Matrix Match:<br/>
	            				<input type="text" name="matrixq"/>
	            			</div>
	            			<div class="span3">
	            			 	4 Digit answer:<br/>
	            				<input type="text" name="digit4q"/>
	            			</div>
	            			<div class="span3 offset5">
	            				<input type="submit" value="Create"  class="btn"/>
	            			</div>
	            		</div>

	            	</form>
            	</div>
            	<div class="span3 marginl0">
            		<div class="qBox mcq circles">
            			<div class="qNo">QN</div>
            			<div class="circle">A</div>
            			<div class="circle">B</div>
            			<div class="circle">C</div>
            			<div class="circle">D</div>
            		</div>
            	</div>

            	<div class="span3">
            		<div class="qBox mcq circles">
            			<div class="qNo">QN</div>
            			<div class="circle">A</div>
            			<div class="circle">B</div>
            			<div class="circle">C</div>
            			<div class="circle">D</div>
            		</div>
            	</div>

            	<div class="span3">
            		<div class="qBox matrixq">
            			<div class="circles">
            				<div class="qNo">23(A)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			
            			</div>
            			<div class="circles">
            				<div class="qNo">(B)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			
            			</div>
            			<div class="circles">
            				<div class="qNo">(C)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			
            			</div>
            			<div class="circles">
            				<div class="qNo">(D)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			
            			</div>
            		</div>
            	</div>

            	<div class="span3">
            		<div class="qBox digit4q">
            			<div class="circles row1">
            				<div class="qNo">QN</div>

	            			<div class="circle marginl54">+</div>
	            			<div class="circle">-</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">0</div>
	            			<div class="circle">0</div>
	            			<div class="circle">0</div>
	            			<div class="circle">0</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">1</div>
	            			<div class="circle">1</div>
	            			<div class="circle">1</div>
	            			<div class="circle">1</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">2</div>
	            			<div class="circle">2</div>
	            			<div class="circle">2</div>
	            			<div class="circle">2</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">3</div>
	            			<div class="circle">3</div>
	            			<div class="circle">3</div>
	            			<div class="circle">3</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">4</div>
	            			<div class="circle">4</div>
	            			<div class="circle">4</div>
	            			<div class="circle">4</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">5</div>
	            			<div class="circle">5</div>
	            			<div class="circle">5</div>
	            			<div class="circle">5</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">6</div>
	            			<div class="circle">6</div>
	            			<div class="circle">6</div>
	            			<div class="circle">6</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">7</div>
	            			<div class="circle">7</div>
	            			<div class="circle">7</div>
	            			<div class="circle">7</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">8</div>
	            			<div class="circle">8</div>
	            			<div class="circle">8</div>
	            			<div class="circle">8</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">9</div>
	            			<div class="circle">9</div>
	            			<div class="circle">9</div>
	            			<div class="circle">9</div>
            			</div>
            			<div class="circles">
	            			<div class="circle">.</div>
	            			<div class="circle">.</div>
	            			<div class="circle">.</div>
	            			<div class="circle">.</div>
            			</div>
            		</div>
            	</div>

            </div>';
}
$vars=array(
	'page'=>array(
		'msg'=>$main->msg,
		'msg_cls'=>$main->msg_cls,
		'title'=>$sheet_title,
		'metad'=>"Create new omr sheet for Pen and Paper sheet.",
		'metat'=>'OMR, OMR SHeet Create OMR Sheet, OMR Evauation Softwre',
		'main_content'=>$main_content
		)
	);

$main->display("./pages/view-omrsheet.ta", $vars);
?>