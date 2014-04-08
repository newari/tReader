<?php
    
    $sub_pattern=$_GET['sub_pattern'];
    $sheet_name=$_GET['sheet_name'];
    $sub_no=$_GET['sub_no'];
    $sub_names=$_GET['sub_names'];
    $sub_qs_dist=$_GET['sub_qs_dist'];
    $col_qs_pattern=$_GET['col_qs_pattern'];
    $marking_pattern=$_GET['marking_pattern'];
    $roll_digit=$_GET['roll_digit'];
    $js_file="omr-ev-default.js";
    include_once("../classes/db.class.php");
    $dbh=new db();
   
    
    $dbh->insert("omrsheets", "sheet_name='$sheet_name', sub_pattern='$sub_pattern', no_of_subs='$sub_no', sub_names='$sub_names', sub_qs_dist='$sub_qs_dist', col_qs_pattern='$col_qs_pattern', marking_pattern='$marking_pattern', roll_digit='$roll_digit'");
    if(mysql_insert_id()>0){
        echo "success";
        exit();
    }else{
        echo "Error-303: Please try again from starting.";
        exit();
    }
    
           

?>