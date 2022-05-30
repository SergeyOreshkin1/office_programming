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
$db="otdel";
$host = 'localhost';

if (!mysql_connect($host,$user,$pass))
    die(mysql_error());
echo "Есть подключение к БД…"."<br>";

if (!mysql_select_db($db)) { echo "Error-select db..."; die(); };
echo "Есть подключение к таблице БД…"."<br>";
echo "<table width='40%' bgcolor='yellow' border=solid>";
echo "<td style='color:navy'>База данных Отделы-Сотрудники</td>";
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

$i=1;
$j=5;
$q = mysql_query("select nameotdel,lastname,firstname,date_r,dolzn from otdels,sotr where otdels.idotdel=sotr.otdel order by nameotdel,lastname");

while ($row = mysql_fetch_row($q))
{ 

if($j%2==0)
{
 $xls->getActiveSheet()->getStyle('b' . $j . ':f' . $j)->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => 'FFCCFFCC')
                ),
            )
        );
}
else{
	 $xls->getActiveSheet()->getStyle('b' . $j . ':f' . $j)->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('argb' => '98FB98CC')
                ),
            )
        );
	
}

$sheet->setCellValueByColumnAndRow(1,1, "Список сотрудников отдела");
$sheet->setCellValueByColumnAndRow(1,3, "Отдел");
$sheet->setCellValueByColumnAndRow(2,3, "Фамилия");
$sheet->setCellValueByColumnAndRow(3,3, "Имя");
$sheet->setCellValueByColumnAndRow(4,3, "Дата рождения");
$sheet->setCellValueByColumnAndRow(5,3, "Должность");

$sheet->setCellValueByColumnAndRow($i,$j, $row[0]);
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, $row[1]);
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, $row[2]);
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, $row[3]);
$i=$i+1;
$sheet->setCellValueByColumnAndRow($i,$j, $row[4]);
$i=$i+1;
$j=$j+1;
$i=1;
$sheet->getColumnDimension('d')->setWidth(20);
$sheet->getColumnDimension('c')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(20);
$sheet->getStyle("B1")->getFont()->getColor()->setRGB('0000FF');
$sheet->getStyle("B3:F3")->getFont()->getColor()->setRGB('FFFFFF');
$sheet->getStyle("b5:F22")->getFont()->getColor()->setRGB('0000FF');
$bg = array(
	'fill' => array(
		'type' => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array('rgb' => '0000FF')
	)
);
$sheet->getStyle("B3:F3")->applyFromArray($bg);
  
}
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('output-1.xls');
echo "Ok...";

}
?>





