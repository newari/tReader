<?php
include_once("./classes/main.class.php");
include_once("./classes/db.class.php");

$main=new main();
$main->show_msg();
if(isset($_GET['type'])&&$_GET['type']=="crn"){
	$main_content='<div class="row-fluid">
            	<div class="span12">

            		<h3 class="alignC">Design new OMR Sheet</h3>
            		<p class="pushL"><a href="./create-omrsheet.php">OMRSHEET for Common pattern?</a></p>
            		<p class="alignR"><a href="view-omr-list.php">View already created OMR Sheets!</a></p>
            		<hr/>
            		<form action="view-omrsheet.php" method="get">
	            		<div class="row-fluid">
	            			<div class="span12 alignC">
	            				<b>Sheet Name:</b><br>
	            				<input type="text" name="sheet_name">
	            				<br/>
	            				<br/>
	            			</div>
	            			<div class="span12 alignC marginl0">
	            				<b>Roll No:</b><br/>
	            				<select name="roll_digit">
	            					<option value="10">10 Digit</option>
	            					<option value="9">9 Digit</option>
	            					<option value="8">8 Digit</option>
	            					<option value="7">7 Digit</option>
	            					<option value="6">6 Digit</option>
	            					<option value="5">5 Digit</option>
	            					<option value="4">4 Digit</option>
	            					<option value="3">3 Digit</option>
	            				</select>
	            			</div>
	            			<div class="span12 alignC marginl0">
	            				<b>No. Of options in One question:</b><br/>
	            				<select name="q_opts">
	            					<option value="4">4</option>
	            					<option value="5">5</option>
	            				</select>
	            			</div>
	            			<div class="span12 alignC marginl0">
	            				<b>No. of Subjects:</b><br/>
	            				<select name="sub_no">
	            					<option value="1">1</option>
	            					<option value="2">2</option>
	            					<option value="3">3</option>
	            					<option value="4">4</option>
	            					<option value="5">5</option>
	            				</select>
	            			</div>
	            			<div class="span12 ">
	            				<div class="row-fluid">
	            					<div class="span2"><b>Subject Names :</b></div>
	            					<div class="span2">Sub 1st <input type="text" class="span11" name="sub1" /></div>
	            					<div class="span2">Sub 2nd <input type="text" class="span11" name="sub2" /></div>
	            					<div class="span2">Sub 3rd <input type="text" class="span11" name="sub3" /></div>
	            					<div class="span2">Sub 4th <input type="text" class="span11" name="sub4" /></div>
	            					<div class="span2">Sub 5th <input type="text" class="span11" name="sub5" /></div>
	            				</div>
	            			</div>
	            			<div class="span12">
	            				<div class="row-fluid">
	            					<div class="span2"><b>Total no of Qs. :</b></div>
	            					<div class="span2"><input type="text" class="span5" name="sub1Qs" /></div>
	            					<div class="span2"><input type="text" class="span5" name="sub2Qs" /></div>
	            					<div class="span2"><input type="text" class="span5" name="sub3Qs" /></div>
	            					<div class="span2"><input type="text" class="span5" name="sub4Qs" /></div>
	            					<div class="span2"><input type="text" class="span5" name="sub5Qs" /></div>
	            				</div>
	            			</div>
			            	<div class="span12">
			            		<div class="row-fluid">
			            			<div class="span2"><p><b>Marking Scheme:</b></p></div>
			            			<div class="span4"><input type="text" name="mcqsp" placeholder="+" class="span3"/><input type="text" placeholder="-" name="mcqsn" class="span3"/></div>
			            			
			            		</div>
			            	</div>
	            			<div class="span2 offset5">
	            				<input type="hidden" name="sub_pattern" value="crn"/>
	            				<input type="submit" value="Create"  class="btn"/>
	            			</div>
	            		</div>

	            	</form>
            	</div>
            	
            	

            </div>';

}else{
	$main_content='<div class="row-fluid">
            	<div class="span12">

            		<h3 class="alignC">Design new OMR Sheet</h3>
            		<p class="pushL"><a href="?type=crn">OMRSHEET for Random Qs distribution?</a></p>
            		<p class="alignR"><a href="view-omr-list.php">View already created OMR Sheets!</a></p>
            		<hr/>
            		<form action="view-omrsheet.php" method="get">
	            		<div class="row-fluid">
	            			<div class="span12 alignC">
	            			Sheet Name:<br>
	            			<input type="text" name="sheet_name">
	            			</div>
	            			<div class="span12 alignC marginl0">
	            			Roll No:<br/>
	            			<select name="roll_digit">
	            					<option value="7">7 Digit</option>
	            					<option value="6">6 Digit</option>
	            					<option value="5">5 Digit</option>
	            					<option value="4">4 Digit</option>
	            					<option value="3">3 Digit</option>
	            				</select>
	            			<br/>
	            			</div>
	            			<div class="span12 alignC marginl0">
	            			OMR Sheet pattern:<br/>
	            			<select name="sub_pattern">
	            				<option value="sn">Subject wise numbering</option>
	            				<option value="cn">Continuous numbering(MCQ Single Only)</option>
	            			</select>
	            			<br/>
	            			</div>
	            			<div class="span12">
	            				<div class="row-fluid">
	            					<div class="span4 alignC">
	            						<b>Sub 1st: </b><input type="text" name="sub1" />
	            					</div>
	            					<div class="span4 alignC">
	            						<b>Sub 2nd: </b><input type="text" name="sub2" />
	            					</div>
	            					<div class="span4 alignC">
	            						<b>Sub 3rd: </b><input type="text" name="sub3" />
	            					</div>
	            				</div>
	            			</div>
	            			<div class="span12">
	            				<div class="row-fluid">
	            					<div class="span2 marginl0">
			            			 	<p><br/><b>Q-Type:</b></p>
			            				<p><b>No. of Qs.</b>(each sub.)</p>
			            			</div>
			            			<div class="span1">
			            			 	MCQ Single:<br/>
			            				<input type="text" class="span12" name="mcqs"/>
			            			</div>
			            			<div class="span1">
			            			 	MCQ Multiple:<br/>
			            				<input type="text" class="span12" name="mcqm"/>
			            			</div>
			            			<div class="span1">
			            			 	Passage Based:<br/>
			            				<input type="text" class="span12" name="compq"/>
			            			</div>
			            			<div class="span1">
			            			 	Numerical (1-D):<br/>
			            				<input type="text" class="span12" name="digit1q"/>
			            			</div>
			            			<div class="span1">
			            			 	Matrix Match:<br/>
			            				<input type="text" class="span12" name="matrixq"/>
			            			</div>
			            			<div class="span1">
			            			 	Numerical (4-D):<br/>
			            				<input type="text" class="span12" name="digit4q"/>
			            			</div>
			            			
			            			<div class="span1">
			            			 	A/R:<br/><br/>
			            				<input type="text" class="span12" name="arq"/>
			            			</div>
			            			<div class="span1">
			            			 	T/F:<br/><br/>
			            				<input type="text" class="span12" name="tfq"/>
			            			</div>
	            				</div>
	            			</div>
			            	<div class="span12">
			            		<div class="row-fluid">
			            			<div class="span2"><p><b>Marking Scheme:</b></p></div>
			            			<div class="span1"><input type="text" name="mcqsp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="mcqsn" class="span6"/></div>
			            			<div class="span1"><input type="text" name="mcqmp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="mcqmn" class="span6"/></div>
			            			<div class="span1"><input type="text" name="compqp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="compqn" class="span6"/></div>
			            			<div class="span1"><input type="text" name="digit1qp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="digit1qn" class="span6"/></div>
			            			<div class="span1"><input type="text" name="matrixqp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="matrixqn" class="span6"/><br/><p>For Each part(A, B,..)</p></div>
			            			<div class="span1"><input type="text" name="digit4qp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="digit4qn" class="span6"/></div>
			            			<div class="span1"><input type="text" name="arqp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="arqn" class="span6"/></div>
			            			<div class="span1"><input type="text" name="tfqp" placeholder="+" class="span6"/><input type="text" placeholder="-" name="tfqn" class="span6"/></div>
			            			
			            		</div>
			            	</div>
	            			<div class="span2 offset5">
	            				<input type="submit" value="Create"  class="btn"/>
	            			</div>
	            		</div>

	            	</form>
            	</div>
            	<div class="span2 marginl0">
            		<p><b>Format of Qs. </b></p>
            	</div>
            	<div class="span2 ">
            		<div class="qBox mcq circles">
            			<div class="qNo">QN</div>
            			<div class="circle">A</div>
            			<div class="circle">B</div>
            			<div class="circle">C</div>
            			<div class="circle">D</div>
            		</div>
            	</div>
            	<div class="span2">
            		<div class="qBox mcq circles">
            			<div class="qNo">QN</div>
            			<div class="circle">A</div>
            			<div class="circle">B</div>
            			<div class="circle">C</div>
            			<div class="circle">D</div>
            		</div>
            	</div>

            	<div class="span2">
            		<div class="qBox mcq circles">
            			<div class="qNo">QN</div>
            			<div class="circle">A</div>
            			<div class="circle">B</div>
            			<div class="circle">C</div>
            			<div class="circle">D</div>
            		</div>
            	</div>

            	<div class="span2">
            		<div class="qBox matrixq">
            			<div class="circles">
            				<div class="qNo">QN(A)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			<div class="circle">T</div>
	            			
            			</div>
            			<div class="circles">
            				<div class="qNo">(B)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			<div class="circle">T</div>
	            			
            			</div>
            			<div class="circles">
            				<div class="qNo">(C)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			<div class="circle">T</div>
	            			
            			</div>
            			<div class="circles">
            				<div class="qNo">(D)</div>
	            			<div class="circle">P</div>
	            			<div class="circle">Q</div>
	            			<div class="circle">R</div>
	            			<div class="circle">S</div>
	            			<div class="circle">T</div>
	            			
            			</div>
            		</div>
            	</div>

            	<div class="span2">
            		<div class="qBox digitq">
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
		'title'=>"Create OMR Sheet | t-Reader",
		'metad'=>"Create new omr sheet for Pen and Paper sheet.",
		'metat'=>'OMR, OMR SHeet Create OMR Sheet, OMR Evauation Softwre',
		'main_content'=>$main_content
		)
	);

$main->display("./pages/create-omr.ta", $vars);
?>