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
$q = mysql_query("SELECT tname, date_p, price, kol_vo,kol_vo*price as summ,photo from eltovary");

$bgcolor='#C5C388';
echo "<table width='40%' bgcolor='yellow' border=solid>";
echo "<td style='color:navy'>товары</td>";
echo "</table>";
echo "<table width='40%' bgcolor='green' border=solid>";
echo '<td> <form method="POST">
    
</form> </td>';
echo "</table>";
echo "<table width='40%' bgcolor='yellow' border=solid>";
echo "<td style='color:navy'>Сведения о товарах</td>";
echo "</table>";
echo "<table width='40%' bgcolor='red' border=solid>";

echo "<td>наименование<td>";
 
  echo "<td>дата поступления<td>";
  
   echo "<td>цена<td>";
   
    echo "<td>количество<td>";

	 echo "<td>сумма";
	echo '<br>';
	
	echo "<tr>";
	echo "</tr>";
while ($row = mysql_fetch_array($q))
{ 
 echo "<td>$row[tname]<td>";
 
  echo "<td>$row[date_p]<td>";
  
   echo "<td>$row[price]<td>";
   
    echo "<td>$row[kol_vo]<td>";

	 echo "<td>$row[summ]<td>";
	 echo '<td>' .
      '<img src = "data:image/png;base64,' . base64_encode($row['photo']) . '" width = "50px" height = "50px"/>'
      . '</td>';
	 
	  
 echo "</tr>";

}
 echo "</table>";
 

?>





