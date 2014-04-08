<?php
// require 'pdfcrowd.php';
//$receipt_no=$_GET['receipt_no'];
if(isset($_GET['mcqs'])&&isset($_GET['mcqm'])&&isset($_GET['compq'])&&isset($_GET['matrixq'])&&isset($_GET['digitq'])&&isset($_GET['marking_pattern'])&&isset($_GET['sub_q_pattern'])){
    $mcqs=$_GET['mcqs'];
    $mcqm=$_GET['mcqm'];
    $compq=$_GET['compq'];
    $matrixq=$_GET['matrixq'];
    $digitq=$_GET['digitq'];
    $sub_pattern=$_GET['sub_pattern'];
    $sub_q_pattern=$_GET['sub_q_pattern'];
    $sheet_name=$_GET['sheet_name'];
    $js_file="omr-ev-default.js";
    $q_opts=$_GET['q_opts'];
    include_once("../classes/db.class.php");
    $dbh=new db("triaasco_omr");
    switch($sub_pattern){
        case "pcm":
            $col1_name="Physics";
            $col2_name="Chemistry";
            $col3_name="Mathematics";
            break;
        case "pcb":
            $col1_name="Physics";
            $col2_name="Chemistry";
            $col3_name="Biology";
        case "dn":
            $col1_name="";
            $col2_name="";
            $col3_name="";
            break;
        case "drn":
            $col1_name="";
            $col2_name="";
            $col3_name="";
            break;
    }
    $omr_code=$sub_pattern."-".$mcqs."-".$mcqm."-".$compq."-".$matrixq."-".$digitq;
    $marking_pattern=$_GET['marking_pattern'];
    $dbh->select("omrsheets", "id", "sheet_code='$omr_code' AND marking_pattern='$marking_pattern'", "none", "none");
    if($dbh->sel_count_row>1){
        $id=$dbh->select_res[0]['id'];
        $dbh->update("omrsheets", "sheet_name='$sheet_name', drn_case='$sub_q_pattern', q_opts='$q_opts'", "id='$id'", "1");
        echo "success";
        exit();
    }else if($dbh->sel_count_row==1){
         $id=$dbh->select_res['id'];
        $dbh->update("omrsheets", "sheet_name='$sheet_name', drn_case='$sub_q_pattern', q_opts='$q_opts'", "id='$id'", "1");
        echo "success";
        exit();
    }else{
        $dbh->insert("omrsheets", "sheet_name='$sheet_name', sheet_code='$omr_code', drn_case='$sub_q_pattern', marking_pattern='$marking_pattern', js_file='$js_file', q_opts='$q_opts'");
        if(mysql_insert_id()>0){
            echo "success";
            exit();
        }else{
            echo "Error-303: Please try again from starting.";
            exit();
        }
    }
           
}else{
    echo "Try again! There is something missing in question types";
    exit();
}
// try
// {   
//     // create an API client instance
//     $client = new Pdfcrowd("sunilnewari", "42177faf7cda7332d093ac985c788c46");

//     // convert a web page and store the generated PDF into a $pdf variable
//     $pdf = $client->convertURI('http://omr.triaas.com/view-omrsheet.php?sub_pattern='.$sub_pattern.'&mcqs='.$mcqs.'&mcqm='.$mcqm.'&matrixq='.$matrixq.'&digitq='.$digitq);

//     // set HTTP response headers
//     header("Content-Type: application/pdf");
//     header("Cache-Control: no-cache");
//     header("Accept-Ranges: none");
//     header("Content-Disposition: attachment; filename=\"omr Sheet.pdf\"");
//     $dbh->select("omrsheets", "sheet_name", "sheet_code='$omr_code'", "none", "none");
//     if($dbh->sel_count_row>0){
//         $sheet_name=$dbh->select_res['sheet_name'];
//         header("Location:./create-omrsheet.php?msg=This type of OMR sheet already has been created with name '".$sheet_name."'.&msg_clr=red");
//         exit();
//     }else{
//         $dbh->insert("omrsheets", "sheet_name='$sheet_name', sheet_code='$sheet_code', js_file='omr_ev.js'");
//     }
//     // send the generated PDF 
//     echo $pdf;

// }
// catch(PdfcrowdException $why)
// {
//     echo "Pdfcrowd Error: " . $why;
// }


?>