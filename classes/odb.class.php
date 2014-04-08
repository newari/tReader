<?php
if(file_exists("../classes/db.class.php")){
	include_once("../classes/db.class.php");
}else{
	include_once("./classes/db.class.php");
}
class odb extends db{
	

	public $connection=false;
	
	public function odb(){
	$dbh=new db();
	$dbh->select("config", "webh, odb, odbu, odbp", "id='1'", "none", "1");
	$this->host=$dbh->select_res['webh'];
	$connection=false;$host=$dbh->select_res['webh'];
		$db=$dbh->select_res['odb'];
		$un=$dbh->select_res['odbu'];
		$pas=$dbh->select_res['odbp'];
		if(!isset($this->connection)||$this->connection==false){
			$this->db=$db;
			$this->connect=mysql_connect($this->host, $un, $pas);
			mysql_set_charset('utf8', $this->connect);
			if(!$this->connect){
				$this->connection=false;
				echo "<h2>Internet connection problem !</h2>";
				die('Could not connected to server::'.mysql_error());

			}
			$sel_db=mysql_select_db($this->db, $this->connect);
			if(!$sel_db){
				$this->connection=false;
				die("Could not connect to server : ".mysql_error());
			}else{
				$this->connection=true;
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