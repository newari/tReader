<?php
require 'pdfcrowd.php';
//$receipt_no=$_GET['receipt_no'];
if(isset($_GET['test_id'])){
	$test_id=$_GET['test_id'];
}else{
	echo "Try again! There is something missing in question types";
	exit();
}
try
{   
    // create an API client instance
    $client = new Pdfcrowd("sunilnewari", "42177faf7cda7332d093ac985c788c46");

    // convert a web page and store the generated PDF into a $pdf variable
    $pdf = $client->convertURI('http://omr.triaas.com/result-print-view.php?test_id='.$test_id);

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: no-cache");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"omr Sheet.pdf\"");

    // send the generated PDF 
    echo $pdf;

}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}


?>