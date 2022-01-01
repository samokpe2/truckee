<?php
include_once("xlsxwriter.class.php");

$filename = "example.xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$header = array(
    'Name'=>'string',
    'age'=>'string',
    'developer'=>'string',  
);
$data1 = array(
    array('Aneh Thakur','22','PHP, Android'),
    array('Amit Rana','22','PHP, iPhone'),
	
);
$header2 = array(
    'Status'=>'string',
);

$data2 = array(
    array('Love think code!!!'),
);

$writer = new XLSXWriter();
$writer->setAuthor('Aneh Thakur');
$writer->writeSheet($data1,'sheet1',$header);
$writer->writeSheet($data2,'sheet2',$header2);
$writer->writeToStdOut();

?>