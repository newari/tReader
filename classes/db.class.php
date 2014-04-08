<?php
class db{
	private $host="localhost";
	private $un="triaas";
	private $password="tReader";
	public function db($db="treader_db"){
		$db="treader_db";
		if(!isset($connection)||$connection==false){
			$this->db=$db;
			if(file_exists("../../redaert.txt")){
				$enc=fopen("../../redaert.txt", "r");
				$enc_string="";
				while(!feof($enc)){
					$enc_string.=fgetc($enc);
				}
				fclose($enc);
			}else if(file_exists("../../../redaert.txt")){
				$enc=fopen("../../../redaert.txt", "r");
				$enc_string="";
				while(!feof($enc)){
					$enc_string.=fgetc($enc);
				}
				fclose($enc);
			}else{
				header("Location:http://localhost/treader/fake_soft.php");
				exit();
			}
			$enc_data=explode("-", $enc_string);
			$tl=$enc_data[0];
			$ii=$enc_data[1];
			$ct=time();
			if($tl<$ct&&$tl!="lt"){
				header("Location:http://localhost/treader/expire.php");
				exit();
			}
			$this->connect=mysql_connect($this->host, $this->un, $this->password);
			mysql_set_charset('utf8', $this->connect);

			if(!$this->connect){
				$connection=false;
				header("Location:./install_rem.php");
				die('Could not connected to server::'.mysql_error());

			}
			if($this->db!="create"){
				$sel_db=mysql_select_db($this->db, $this->connect);
				if(!$sel_db){
					$connection=false;
					die("Could not connect to server : ".mysql_error());
				}else{
					$connection=true;
				}
			}else{
				$connection=true;
			}
		}
		
	}

	public function create_db($db_name){
		$sql="CREATE DATABASE ".$db_name;
		$res=mysql_query($sql);
		if($res){
			$sel_db=mysql_select_db($this->db, $this->connect);
			if(!$sel_db){
				$connection=false;
				die("Could not connect to server : ".mysql_error());
			}else{
				$connection=true;
			}
		}
	}

	public function table_exist($table){
		$sel_sql="SHOW TABLES LIKE '$table'";
		$res=mysql_query($sel_sql);
		$count=mysql_num_rows($res);
		if($count>0){
			return true;
		}else{
			return false;
		}
	}
	public function select($tablename, $column, $where, $order, $limit){
		if(isset($this->select_res)){
			unset($this->select_res);
		}
		$sel_sql="SELECT ".$column." FROM ".$tablename;
		if($where!="none"){
			$sel_sql="SELECT ".$column." FROM ".$tablename." WHERE ".$where;
		}
		if($order!='none'){
			$sel_sql=$sel_sql." ORDER BY ".$order;
		}
		if($limit!='none'){
			$sel_sql=$sel_sql." LIMIT ".$limit;
		}	
		$sel_res=mysql_query($sel_sql);
		
		$this->sel_count_row=mysql_num_rows($sel_res);
		for($i=0; $i<$this->sel_count_row; $i++){
			$sel_row=mysql_fetch_array($sel_res);
			foreach($sel_row as $sel_key=>$sel_val){
				if(!is_int($sel_key)){
					if($this->sel_count_row>1){
						$this->select_res[$i][$sel_key]=$sel_val;
					}else{
						$this->select_res[$sel_key]=$sel_val;
					}
				}
				
			}
		}
	}
	// public function join_select($table1, $table2, $table1_cols, $table2_cols, $where, $order){
	// 	if(isset($this->select_res)){
	// 		unset($this->select_res);
	// 	}
	// 	$sel_sql="SELECT ".$table1_cols.", ".$table2_cols." FROM ".$table1."INNER JOIN ".$table2;
	// 	if($where!="none"){
	// 		$sel_sql="SELECT ".$column." FROM ".$tablename." ON ".$where;
	// 	}
	// 	if($order!='none'){
	// 		$sel_sql=$sel_sql." ORDER BY ".$order;
	// 	}
			
	// 	$sel_res=mysql_query($sel_sql);
		
	// 	$this->sel_count_row=mysql_num_rows($sel_res);
	// 	for($i=0; $i<$this->sel_count_row; $i++){
	// 		$sel_row=mysql_fetch_array($sel_res);
	// 		foreach($sel_row as $sel_key=>$sel_val){
	// 			if(!is_int($sel_key)){
	// 				if($this->sel_count_row>1){
	// 					$this->select_res[$i][$sel_key]=$sel_val;
	// 				}else{
	// 					$this->select_res[$sel_key]=$sel_val;
	// 				}
	// 			}
				
	// 		}
	// 	}
	// }
	public function insert($table, $column){
		$ins_sql="INSERT into ".$table." SET ".$column;
		$ins_res=mysql_query($ins_sql);
	}

	public function update($table, $column, $where, $limit){
		$upd_sql="UPDATE ".$table." SET ".$column." WHERE ".$where;
		if($limit!='none'){
			$upd_sql="UPDATE ".$table." SET ".$column." WHERE ".$where." LIMIT ".$limit;
		}
		$upd_res=mysql_query($upd_sql);
	}

	public function delete($table, $where){
		$del_sql="DELETE FROM ".$table." WHERE ".$where;
		$del_res=mysql_query($del_sql);
	}

	public function disconnect(){
		if($this->connect){
			$diconnect=mysql_close($this->connect);
		}
	}
}

?>