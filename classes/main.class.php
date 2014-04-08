<?php
class main{

	public function show_msg(){
			if(isset($_GET['msg'])){
				$msg=$_GET['msg'];
				if(isset($_GET['msg_clr'])){
					$msg_clr=$_GET['msg_clr'];
					$msg_cls="color:".$msg_clr;

				}else{
					$msg_cls="color:red";
				}
			}else{
				$msg="";
				$msg_cls="display:none";
			}
			$this->msg=$msg;
			$this->msg_cls=$msg_cls;
	}
	public function display($file, $vars){
		$file_data=file_get_contents($file);
		$html_var=array();
		foreach($vars as $var_key=>$var_value){
			if(is_array($var_value)){
				foreach($var_value as $key=>$value){
					$var='{$'.$var_key.'.'.$key.'}';
					$html_var[$var]=$value;
				}
			}else{
				$var='{$'.$var_key.'}';
				$html_var[$var]=$var_value;
			}

		}
		unset($vars);
		$file_data=strtr($file_data, $html_var);
		if($file_data!=false){
			echo $file_data;
		}else{
			exit("Error: There is problem with user data.");
		}


		
	}

}

?>