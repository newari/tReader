<?php 
// include_once("./classes/db.class.php");
// $dbh=new db();
// $user = 'testing';
// $host = 'localhost';
// $pass = '1234';
// $createQ = "CREATE USER '{$user}'@'{$host}' IDENTIFIED BY '{$pass}'";
// $grantQ = "GRANT  ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, CREATE TEMPORARY TABLES, CREATE USER, CREATE VIEW, DELETE, DROP, EVENT, EXECUTE, FILE, INDEX, INSERT, LOCK TABLES, PROCESS, REFERENCES, RELOAD, REPLICATION CLIENT, REPLICATION SLAVE, SELECT, SHOW DATABASES, SHOW VIEW, SHUTDOWN, SUPER, TRIGGER, UPDATE ON  *.* TO '{$user}'@'{$host}' WITH GRANT OPTION";
// if(mysql_query($createQ)){
//     echo 'user created<br/>';
//     if(mysql_query($grantQ)){
//         echo 'permissions granted<br/>';
//     }else{
//         echo 'permissions query failed:'.mysql_error().'<br/>';
//     }
    
// }else{
//     echo 'user create query failed:'.mysql_error().'<br/>';
// }
// include_once("./classes/sms.class.php");
// $sms=new sms();
// $vars=array('mobile'=>'810471', 'name'=>'Sunil Kumar', 'rank'=>'2', 'per'=>'20.34', 'minor_name'=>'Minor race test-03', 'date'=>'12 Oct. 2014');
// $out= $sms->send_result_sms($vars);
// print_r($out);
// $out=json_decode($out);
// echo $out->type;

// $rr=fwrite($x, "password");

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=document_name.xls");

echo "<html>";
echo "<meta http-equiv='Content-Type' content='text/html'; charset='Windows-1252'>";
echo "<body>";
echo "<b>testdata1</b> &nbsp; <u>testdata2</u> \t \n <br/>";
echo '<b>testdata1</b> '."\t".'<u>testdata2</u> \t \n ';
echo "</body>";
echo "</html>";
?>