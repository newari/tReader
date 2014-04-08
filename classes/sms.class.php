<?php

include_once("../classes/db.class.php");
class sms extends db{
	function sms(){
		$this->sender_id='SMRPAN';
		$this->brand_name='SAMARPAN CAREER Institute, Sikar';
	}

	function send_sms($mobile, $msg){

	}

	function send_authcode($mobileNumber, $rec_name, $auth_code){
		//Your authentication key
		$authKey = "126AYsUsmQFPCp52ad86ae";


		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = $this->sender_id;

		//Your message to send, Add URL endcoding here.
		$msg='Dear '.$rec_name.', Your Authentication code for Competition Quiz is '.$auth_code.'. Please enter this on website and enjoy your Tests. All the best. Regards, CQ Team';
		$message = urlencode($msg);

		//Define route 
		$route = "4";
		//Prepare you post parameters
		$postData = array(
		    'authkey' => $authKey,
		    'mobiles' => $mobileNumber,
		    'message' => $message,
		    'sender' => $senderId,
		    'route' => $route
		);

		//API URL
		$url="http://panel.msgclub.net/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData
		    //,CURLOPT_FOLLOWLOCATION => true
		));

		//get response
		$output = curl_exec($ch);

		curl_close($ch);

		return $output;

	}

	function send_result_sms($vars){
		//Your authentication key
		$authKey = "126AYsUsmQFPCp52ad86ae";


		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = $this->sender_id;

		//Your message to send, Add URL endcoding here.
		/////////////Default template1/////////////
		// $msg='Respected Sir, '.$vars['name'].' has got  '.$vars['rank'].' rank ('.$vars['per'].' %) in '.$vars['minor_name'].' held on '.$vars['date'].'. Regards '.$this->brand_name.'.';
		
		//////////////default template 2///////////////////////////////
		$msg='Dear Guardian, Rank of your child '.$vars['name'].' in '.$vars['minor_name'].' is '.$vars['rank'].' & Percentage Marks is '.$vars['per'].'%. Regards Samarpan Career Institute.';
		
		$message = urlencode($msg);

		//Define route 
		$route = "4";
		//Prepare you post parameters
		$postData = array(
		    'authkey' => $authKey,
		    'mobiles' => $vars['mobile'],
		    'message' => $message,
		    'sender' => $senderId,
		    'route' => $route,
		    'response'=>'json'
		);

		//API URL
		$url="http://panel.msgclub.net/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData
		    //,CURLOPT_FOLLOWLOCATION => true
		));

		//get response
		$output = curl_exec($ch);

		curl_close($ch);

		return $output;
	}
	function send_rand_sms($vars, $msg_template){
		//Your authentication key
		if(isset($vars['fname'])){
			$var['$first_name$']=$vars['fname'];
		}

		if(isset($vars['lname'])){
			$var['$last_name$']=$vars['lname'];
		}

		if(isset($vars['name'])){
			$var['$name$']=$vars['name'];
		}
		if(isset($vars['father_name'])){
			$var['$father_name$']=$vars['father_name'];
		}
		if(isset($vars['mobile'])){
			$var['$mobile$']=$vars['mobile'];
		}
		if(isset($vars['batch'])){
			$var['$batch$']=$vars['batch'];
		}
		$msg=strtr($msg_template, $var);
		$this->select("config", "sms_url, sms_un, sms_pas, sms_templates", "id='1'", "none", "none");
		$authKey ='126AYsUsmQFPCp52ad86ae';


		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = $this->sender_id;

		//Your message to send, Add URL endcoding here.
		/////////////Default template1/////////////
		// $msg='Respected Sir, '.$vars['name'].' has got  '.$vars['rank'].' rank ('.$vars['per'].' %) in '.$vars['minor_name'].' held on '.$vars['date'].'. Regards '.$this->brand_name.'.';
		//////////////default template 2///////////////////////////////
		$message = urlencode($msg);

		//Define route 
		$route = "4";
		//Prepare you post parameters
		$postData = array(
		    'authkey' => $authKey,
		    'mobiles' => $vars['mobile'],
		    'message' => $message,
		    'sender' => $senderId,
		    'route' => $route,
		    'response'=>'json'
		);

		//API URL
		$url=$this->select_res['sms_url'];

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData
		    //,CURLOPT_FOLLOWLOCATION => true
		));

		//get response
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}
}


?>