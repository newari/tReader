<?php
if(file_exists("./classes/db.class.php")){
	include_once("./classes/db.class.php");
}else{
	include_once("../classes/db.class.php");
}
 class institute extends db{
 	public $institute_name;
 	public $brand_name;
 	public $address;
 	public $city;
 	public $contact_no;
 	public $full_address;
 	public $logo;
 	public $logo_large;
 	public function institute(){
 		$this->db();
 		$this->select("config", "institute_name, brand_name, address, city, contact_no, full_address, logo", "id='1'", "none", "1");
	 	if($this->sel_count_row>0){
	 		$this->institute_name=$this->select_res['institute_name'];
	 		$this->brand_name=$this->select_res['brand_name'];
	 		$this->address=$this->select_res['address'];
	 		$this->city=$this->select_res['city'];
	 		$this->contact_no=$this->select_res['contact_no'];
	 		$this->full_address=$this->select_res['full_address'];
	 		$this->logo=$this->select_res['logo'];
	 		$this->logo_large="logo_large.jpg";
	 	}else{
	 		$this->institute_name='';
	 		$this->brand_name='';
	 		$this->address='';
	 		$this->city='';
	 		$this->contact_no='';
	 		$this->full_address='';
	 		$this->logo='logo.jpg';
	 		$this->logo_large="logo_large.jpg";
	 	}
 	}
 }

?>