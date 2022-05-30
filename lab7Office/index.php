<html>
<head>
<meta charset=windows-1251>
</head>
<body>
  <form action="phpinfo.php" method=post>;
<style type="text/css">
  form {background-color: rgb(255,255,0); border: dashed; width:800px;}
  font {margin-left: 10px; color: navy; font-size: 16pt}
  table {background-color: rgb(0,255,255);border: solid 5px #00FA9A;}
  .b1 {
	margin-top:20px;
	margin-bottom:20px;
    background: navy; 
    color: yellow; 
    font-size: 12pt; 
	width: 200px;
    height: 40px;
   }

</style>

<br>
<br>

<?php
$db_username="root";
$db_password="";
$db_name="lb7";
$db_host = 'localhost';
echo "<font>Отчет о заработной плате сотрудников</font>"."<br><br>";
echo "<font>Проверка подключения</font>"."<br><br>";
if (!mysql_connect($db_host,$db_username,$db_password))
    die(mysql_error());
echo "<font>Есть подключение к БД…</font>"."<br>";

if (!mysql_select_db($db_name)) { echo "Error-select db..."; die(); };
echo "<font>Есть подключение к таблице БД…</font>"."<br><br>";

echo'<br>';
echo '<font> Номер отдела: </font>';
echo '<input type="text" size="20" name="n_otdel" pattern="[1-4]{1}">';
echo'<br>';
echo '<font>';
echo '<input type="submit" class="b1" value="Создать диаграмму">';
echo '</font>';

?>
<br>
<br>

</form>

</body>
</html>