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
$q = mysql_query("select id,otdel,lastname,firstname,(select IFNULL(sum(money),0) from zarpl where zarpl.idSotr=sotr.id and god=2018) from sotr group by otdel,lastname");

$bgcolor='#C5C388';
echo "<table width='40%' bgcolor='yellow' border=solid>";
echo "<td style='color:navy'>База данных Отделы-Сотрудники</td>";
echo "</table>";
echo "<table width='40%' bgcolor='green' border=solid>";
echo '<td> <form method="POST">
    <input type="submit" name="btn1" value="Выдать документ Excel" />
</form> </td>';
echo "</table>";
echo "<table width='40%' bgcolor='yellow' border=solid>";
echo "<td style='color:navy'>Сведения о сотрудниках отдела</td>";
echo "</table>";
echo "<table width='40%' bgcolor='red' border=solid>";

echo "<td>idСотр<td>";
 
  echo "<td>Отдел<td>";
  
   echo "<td>Фамилия<td>";
   
    echo "<td>Имя<td>";

	 echo "<td>Зарплата";
	echo '<br>';echo "<tr>";
	echo "</tr>";
while ($row = mysql_fetch_row($q))
{ 
 echo "<td>$row[0]<td>";
 
  echo "<td>$row[1]<td>";
  
   echo "<td>$row[2]<td>";
   
    echo "<td>$row[3]<td>";

	 echo "<td>$row[4]";
	  echo '<br>';
 echo "</tr>";

}
 echo "</table>";
  
 if( isset( $_POST['btn1'] ) )
{
	        $i = 3;
            $sum = array();
            $row = array();
            $countOtdels = 0;
            $k = 0;
            $sum = array();
            $NameOtdel = array();
            require_once('PHPExcel/Classes/PHPExcel.php');
            require_once('PHPExcel/Classes/PHPExcel/Writer/Excel5.php');
            $xls = new \PHPExcel();
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
            $sheet->setTitle('Example1');
			$sheet->setCellValueByColumnAndRow(1,2, "Отдел");
            $sheet->setCellValueByColumnAndRow(2,2, "Фамилия");
            $sheet->setCellValueByColumnAndRow(3,2, "Имя");
            $sheet->setCellValueByColumnAndRow(4,2, "Зарплата");
            $sheet->setCellValueByColumnAndRow(5,2, "Итого по отделу");
			$sheet->setCellValueByColumnAndRow(1,1, "Отчет по з/п за 2018 год");
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('c')->setWidth(20);
            $sheet->getColumnDimension('d')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);
            $sheet->getColumnDimension('f')->setWidth(20);
			$induction = mysqli_connect($host, $user, $pass, $db);
            mysqli_query($induction, 'SET NAMES utf8');
            $NameOtdel = array();
            $ot = mysqli_query($induction, 'SELECT * FROM `otdels`');
            while($ott = mysqli_fetch_assoc($ot)){
                $countOtdels++;
                $NameOtdel[$countOtdels] = $ott['NameOtdel'];
            }
            for($l = 1; $l <= $countOtdels; $l++){
                $sum[$l] = 0;
                $row[$l] = 0;
            }

            $result = mysqli_query($induction, "select otdel as otd,lastname as ln,firstname as fn,(select IFNULL(sum(money),0) from zarpl where zarpl.idSotr=sotr.id and god=2018) as summ from sotr group by otd,ln");                              
            while($row1 = mysqli_fetch_assoc($result)){
                $otd = $row1['otd'];
                $sheet->setCellValueByColumnAndRow(1, $i, $NameOtdel[$otd]);
                $sum[$otd] += $row1['summ'];
                $row[$otd] = $i;
                $sheet->setCellValueByColumnAndRow(2, $i, $row1['ln']);
                $sheet->setCellValueByColumnAndRow(3, $i, $row1['fn']);
                $sheet->setCellValueByColumnAndRow(4, $i, number_format($row1['summ'], 2, '.', ' '));
                $i++;
            }

            $sumOtdels = 0;
            for($l = 1; $l <= $countOtdels; $l++){
                $sheet->setCellValueByColumnAndRow(5, $row[$l], number_format($sum[$l], 2, '.', ' '));
                $sheet->getStyle("F$row[$l]")->getFont()->getColor()->setRGB('ff0000');
                $sumOtdels += $sum[$l];
            }
            
            $sheet->setCellValueByColumnAndRow(1, $row[$countOtdels] + 2 , "Всего по учереждению");
            $sheet->setCellValueByColumnAndRow(5, $row[$countOtdels] + 2, number_format($sumOtdels, 2, '.', ' '));
            $st = $row[$countOtdels] + 2;
            $sheet->getStyle("F$st")->getFont()->getColor()->setRGB('ff00ed');
            $sheet->getStyle("B$st")->getFont()->getColor()->setRGB('0000FF');
            $sheet->getStyle("B1")->getFont()->getColor()->setRGB('0000FF');
            $sheet->getStyle("B2:F2")->getFont()->getColor()->setRGB('387C44');
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('output-1.xls');
echo "Ok...";
}
?>





