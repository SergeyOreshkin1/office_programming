<html>
 <head>
 <title>Проверка данных</title>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
 <style type="text/css">
  table {border: solid thin silver}
  td {border: solid thin yellow; color: white;
      text-align: center; font-size: 12pt;
      vertical-align: middle; font-family: arial;
      height: 30}
  th {text-align: center;
      color: navy; font-style: normal; font-size: 12pt;
      font-family: tahoma; 
      background-color: rgb(234,251,140)}
 </style>
 </head>
 <body>
 </body>
</html>

<?php

$user="root";
$pass="";
$db="tovar";
$host = 'localhost';

if (!mysql_connect($host,$user,$pass))
    die(mysql_error());
echo "Есть подключение к БД…"."<br>";

if (!mysql_select_db($db)) { echo "Error-select db..."; die(); };
echo "Есть подключение к таблице БД…"."<br>";
echo "<table width='40%' bgcolor='yellow' border=solid>";
echo "<td style='color:navy'>товары</td>";
echo "</table>";
echo "<table width='40%' bgcolor='green' border=solid>";
echo '<td> <form method="POST">
    <input type="submit" name="btn1" value="Выдать документ Excel" />
</form> </td>';
echo "</table>";
 if( isset( $_POST['btn1'] ) )
{
require_once('PHPExcel/Classes/PHPExcel.php');
require_once('PHPExcel/Classes/PHPExcel/Writer/Excel5.php');
$xls = new PHPExcel();
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
$sheet->getPageSetup()
 ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); 
/* $sheet->getPageSetup()
 ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);*/
$sheet->setTitle('Example1');
$jj=1;
$i=1;
$j=5;
$q = mysql_query("SELECT kod, tname, date_p, price, kol_vo,kol_vo*price as summ,photo from eltovary");

while ($row = mysql_fetch_array($q))
{ 
if($j%2==0)
{
 $xls->getActiveSheet()->getStyle('b' . $j . ':g' . $j)->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'FFCCFFCC')
                ),
            )
        );
}
else{
	 $xls->getActiveSheet()->getStyle('b' . $j . ':g' . $j)->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => '98FB98CC')
                ),
            )
        );
	
}


 $data=$row[photo];
 $file_name= 'f-'.$jj.'.jpg';
 $temp_file=fopen($file_name,'w');
 fwrite($temp_file,$data);
 fclose($temp_file); 
   
 $temp_file=fopen($file_name,'r');
 $sheet->getRowDimension($j)->setRowHeight(34); 
 $logo= new PHPExcel_Worksheet_Drawing();

$sheet->setCellValueByColumnAndRow($i,$j, $row[kod]);
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, $row[tname]);
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, $row[date_p]);
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, number_format($row[price], 2, '.', ' '));
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, $row[kol_vo]);
$i=$i+1;

$sheet->setCellValueByColumnAndRow($i,$j,number_format($row[summ], 2, '.', ' '));
//$i=$i+1;
//$sheet->setCellValueByColumnAndRow($i,$j,$row[photo]);
$i=$i+1;
$j=$j+1;
$i=1;
$j=5;
 $logo->setPath($file_name);
 $logo->SetCoordinates('H',$j);
 $logo->SetOffsetX(3); 
 $logo->SetOffsetY(3);
 $logo->SetWidth(44);
 $logo->SetHeight(34);
 
 $logo->SetWorksheet($sheet);
 fclose($temp_file);


$sheet->setCellValueByColumnAndRow(1,1, "ТОВАРЫ-ЭЛЕКТРОТОВАРЫ");
$sheet->setCellValueByColumnAndRow(1,3, "код");
$sheet->setCellValueByColumnAndRow(2,3, "название");
$sheet->setCellValueByColumnAndRow(3,3, "дата");
$sheet->setCellValueByColumnAndRow(4,3, "цена");
$sheet->setCellValueByColumnAndRow(5,3, "кол-во");
$sheet->setCellValueByColumnAndRow(6,3, "сумма");
$sheet->setCellValueByColumnAndRow(7,3, "товар");

$sheet->getColumnDimension('d')->setWidth(20);
$sheet->getColumnDimension('c')->setWidth(40);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(20);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(20);
$sheet->getStyle("B1")->getFont()->getColor()->setRGB('0000FF');
$sheet->getStyle("B3:H3")->getFont()->getColor()->setRGB('FFFFFF');
$sheet->getStyle("b5:G22")->getFont()->getColor()->setRGB('0000FF');
$bg = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => 'FFCCFFCC')
	)
);

$sheet->getStyle("B19:H19")->applyFromArray($bg);

$bg = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => '0000FF')
	)
);
$sheet->getStyle("B3:H3")->applyFromArray($bg);
  $jj++;
  $j++;
  
}

$q = mysql_query("SELECT sum(kol_vo*price) from eltovary ");

while ($row = mysql_fetch_row($q))
{
$sheet->setCellValueByColumnAndRow(1,$j+1, "итого:");	
$sheet->setCellValueByColumnAndRow(6,$j+1, $row[0]);
$sheet->getStyle($j+1)->getFont()->getColor()->setRGB('FF00FF');
}
$style = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$sheet->getStyle("B1:G17")->applyFromArray($style);
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('output-1.xls');
echo "Ok...";
}
?>





