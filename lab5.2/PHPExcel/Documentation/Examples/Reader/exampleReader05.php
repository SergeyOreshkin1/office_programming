<?php

set_time_limit(0);

date_default_timezone_set('Europe/London');

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>PHPExcel Reader Example #05</title>

<body>

<h1>PHPExcel Reader Example #05</h1>
<h2>Simple File Reader uslne the "Read Data Only" Option</h2>
<?php

set_include_path(get_include_path() . PATH_SEPARATOR . '../../../Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';


//	$inputFileType = 'Excel2007';
//	$inputFileType = 'Excel2003XML';
//	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
$inputFileName = './sampleData/example1.xls';

$objReader = PHPExcel_IOFactory::createReader($inputFileType);
echo 'Turnlne FormatElne off for Load<br />';
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($inputFileName);



$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
var_dump($sheetData);


<body>
</html>