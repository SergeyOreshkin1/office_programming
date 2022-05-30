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
echo '<pre> Изменение зарплаты сотрудника';
echo '</font>';
echo '<font>';
echo '<pre> <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';

echo '<table cellpadding="4">';
echo '</td>';
echo '<tr>';
echo '<td>Новая запрплата: </td>';
echo '<td><input type="text" size="20" name="newzarp" placeholder="10000" pattern="^[0-9]+$" title="Введите число, например: 15000""></td>';
echo '</table>';
echo '</tr>';

 if(isset($_POST['submit']))
{
echo "<meta http-equiv='refresh' content='0'>";
}

if( $_POST['newzarp']!=null){
$sotrid = $_POST['submit3']; // выбранный сотрудник
$newzarp = $_POST['newzarp']; // новая зарплата
$res = mysqli_query($link,"select n_otdel_sotr, zarp_sotr from sotr where id_sotr = '$sotrid';"); 
$row = mysqli_fetch_array($res);
$zarp_sotr = $row['zarp_sotr']; // старая зарплата
$n_otdel_sotr = $row['n_otdel_sotr']; // отдел сотрудника


    $otd_sotr_zarp = mysqli_query($link,"select otd_sotr_zarp from otdel where id_otd='$n_otdel_sotr';");
	$row = mysqli_fetch_array($otd_sotr_zarp);
	$otd_sotr_zarp =  $row['otd_sotr_zarp'] + $newzarp - $zarp_sotr; // прибавляем к суммарной зарплате отдела разницу между новой и старой зарплатой сотрудника

try{
	$r1 = $link->query("SET AUTOCOMMIT=0");
	$r2 = $link->query("START TRANSACTION");
	if ((!$r1) || (!$r2))
	{
	throw new Exception('Ошибка');
	exit();
	} 

  $q0 = "UPDATE sotr 
         set zarp_sotr ='$newzarp'
         where id_sotr='$sotrid'";


$r0 = mysqli_query($link,$q0);

if (!$r0)
	{
	throw new Exception('Ошибка');
	exit();
	} 
      $q0 = "UPDATE otdel 
             set otd_sotr_zarp='$otd_sotr_zarp'
             where id_otd='$n_otdel_sotr'";

$r0 = mysqli_query($link,$q0);
if (!$r0)
	{
	throw new Exception('Ошибка');
	exit();
	} 

	$R = $link->commit();
	if (!$R) {throw new Exception('Ошибка завершения транзакции');
	
}
	}
	catch (Exception $e) {
	echo 'ошибка'.$e->getMessage();
	$res_rollback =$link->rollBack();
	if(!$res_rollback){
	echo 'Ошибка отката';
	}
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
echo '<td>Изменение</td>';
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
echo '<td><BUTTON name="submit3" class="b1" value='.$row['id_sotr'].'> Изменить </BUTTON></td>';
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
echo '<font>';
echo '<pre> Контроль зарплаты';
echo '<br> по таблице Отделы:';
$myquery = 
"select otd_sotr_zarp from otdel where id_otd='$selectotdel'";
$res = mysqli_query($link,$myquery );
while ($summa_otdel = mysqli_fetch_array($res ))
{
echo $summa_otdel[0];
}
// суммы заработных плат по таблице sotr не будет в реальной программе
echo '<br> по таблице Сотрудники:';
$myquery = 
"select sum(zarp_sotr) from sotr where n_otdel_sotr='$selectotdel'";
$res = mysqli_query($link,$myquery );
while ($summa_sotr = mysqli_fetch_array($res ))
{
echo $summa_sotr[0];
}
echo '</font>';

?>
<br>
<br>

</form>

</body>
</html>