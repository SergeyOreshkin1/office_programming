<html>
<head>
<meta charset=windows-1251>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form method="post" name="form1">


<br>
<br>

<?php

$db_host       = 'localhost';
$db_name       = 'practica';
$db_username   = 'root';
$db_password   = '';

try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);
}
catch (Exception $e){
die("Не удалось подключиться: ".$e->getMessage());
}
$selectotdel=$_GET["selectotdel"];
echo '<font>';
echo '<pre> Изменить руководителя отдела';
echo '</font>';
echo '<font>';
echo '<pre> <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';
$myquery = 
  "select * from otdel where id_otd='$selectotdel'";
$res = mysqli_query($link,$myquery );
echo '<table border=2>';
echo '<tr>';
echo '<td>Руководитель: ';
echo '</td>';

while ($row = mysqli_fetch_array( $res ))
{
echo '<td><input type="text" readonly size="20" name="n_otdel"  value="'.$row['otd_boss'].'"></td>';
}

 if(isset($_POST['submit3']))
{
echo "<meta http-equiv='refresh' content='0'>";
}
	
$newboss = $_POST['submit3']; //новый руководитель
	
	$res = mysqli_query($link,"select * from sotr where id_sotr = '$newboss';"); 
	$row = mysqli_fetch_array($res);
	$otdel_sotr = $row['n_otdel_sotr']; // отдел выбранного сотрудника		

try{
	$r1 = $link->query("SET AUTOCOMMIT=0");
	$r2 = $link->query("START TRANSACTION");
	if ((!$r1) || (!$r2))
	{
	throw new Exception('Ошибка');
	exit();
	}
			$q0 = "UPDATE otdel 
            set otd_boss = '$newboss' 
            where id_otd='$otdel_sotr'";   
		
          $r0 = mysqli_query($link,$q0);
		  if (!$r0)
	{
	throw new Exception('Ошибка');
	exit();
	}
$R = $link->commit();
	if (!$R) {throw new Exception('Ошибка завершения транзакции');}
}
			catch (Exception $e) {
	echo 'ошибка'.$e->getMessage();
	$res_rollback =$link->rollBack();
	if(!$res_rollback){
	echo 'Ошибка отката';
	}
}
		
echo '<font>';
echo '<pre> Информация по '; 
echo $selectotdel;
echo ' отделу'; 
echo '</font>';
echo '<br>';	
/////////////////////////////////////////////////////////////////
//  Таблица sotr, где номер отдела выбран из выпадающего списка из main
/////////////////////////////////////////////////////////////////
$myquery = 
"select * from sotr where n_otdel_sotr='$selectotdel'";
$res = mysqli_query($link,$myquery );
echo '<br>';

echo '<table border=2>';
echo '<tr>';
echo '<td>Номер сотрудника</td>';
echo '<td>Фамилия И.О.</td>';
echo '<td>Фото</td>';
echo '<td>Зарплата</td>';
echo '<td>Номер отдела</td>';
echo '<td>Назначение руководителя</td>';
echo '</tr>';
while ($row = mysqli_fetch_array($res ))
{
echo '<tr>';
echo '<td>'.$row['id_sotr'].'</td>';
echo '<td>'.$row['fam_im'].'</td>';
echo '<td>' .
      '<img src = "data:image/png;base64,' . base64_encode($row['img']) . '" width = "100px" height = "120px"/>'
      . '</td>';
echo '<td>'.$row['zarp_sotr'].'</td>';
echo '<td>'.$row['n_otdel_sotr'].'</td>';
echo '<td><BUTTON name="submit3" class="b1" value='.$row['id_sotr'].'> Назначить</BUTTON></td>';
echo '</tr>';
echo '</tr>';
}
echo '</table>';

	echo '<br>';
/////////////////////////////////////////////////////////////////////////
// Таблица otdel, где номер отдела выбран из выпадающего списка из main
////////////////////////////////////////////////////////////////////////
$myquery = 
"select * from otdel where id_otd='$selectotdel'";
$res = mysqli_query($link,$myquery );
echo '<br>';

echo '<table border=2>';
echo '<tr>';
echo '<td>Номер отдела</td>';
echo '<td>Номер руководителя</td>';
echo '<td>Сумма</td>';
echo '<td>Размер</td>';
echo '</tr>';
while ($row = mysqli_fetch_array( $res ))
{
echo '<tr>';
echo '<td>'.$row['id_otd'].'</td>';
echo '<td>'.$row['otd_boss'].'</td>';
echo '<td>'.$row['otd_sotr_zarp'].'</td>';
echo '<td>'.$row['otd_razm'].'</td>';
echo '</tr>';
}
echo '</table>';
///////////////////////////////////////////////////////////////////////


?>
<br>
<br>

</form>

</body>
</html>