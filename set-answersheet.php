<?php
include_once("./classes/main.class.php");
$main=new main();
$main->show_msg();
// if($_POST['test_id']&&$_FILES['omrsheet']['tmp_name']){
// 	if($_FILES['omrsheet']['size']>0){
// 		$file_name=$_FILES['omrsheet']['tmp_name'];
// 		if(file_exists("answersheets/".$file_name)){

// 		}
// 	}
// }else{
// 	$main_content='<div class="row-fluid">
//             	<div class="span12">
//             		<h3>Select your answer sheet scaned photo:</h3>
//             		<form action="set-answersheet.php" method="post" enctype="multipart/form-data">
// 	            		<div class="row-fluid">
// 	            			<div class="span3 offset4">
// 	            			Test ID:<br/>
// 	            				<input type="text" name="test_id" class="span12"/>
// 	            				<input type="file" name="omrsheet" id="answersheet"/>
// 	            			</div>
	            			
// 	            		</div>

// 	            	</form>
//             	</div>

//             </div>';
// }
$vars=array(
	'page'=>array(
		'msg'=>$main->msg,
		'msg_cls'=>$main->msg_cls,
		'title'=>"Set AnswerSheet | t-Reader",
		'metad'=>"Create new omr sheet for Pen and Paper sheet.",
		'metat'=>'OMR, OMR SHeet Create OMR Sheet, OMR Evauation Softwre'
		)
	);

$main->display("./pages/set-answersheet.ta", $vars);
?>