<html>
<head>
<meta charset=windows-1251>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form action="" method="post" name="form1" enctype="multipart/form-data">

<br>
<br>

<?php
$db_host       = 'localhost';
$db_name       = 'practica';
$db_username   = 'root';
$db_password   = '';

try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
catch (Exception $e){
die("Не удалось подключиться: ".$e->getMessage());
}
$selectotdel=$_GET["selectotdel"];

echo '<font>';
echo '<pre> Добавление сотрудника';
echo '</font>';
echo '<font>';
echo ' <pre> <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';
echo'<br>';

echo '<table cellpadding="4">';
echo '<tr>';
echo '<td> Фамилия И.О.: </td>';
echo '<td><input type="text" class="s" size="20" placeholder="Иванов И.И." name="fam_im" pattern="^[А-ЯЁ][а-яё]*\s[А-ЯЁ]\.[А-ЯЁ]\.$" title="Введите данные в виде Фамилия И.О."></td>';
echo '</tr>';

echo '<tr>';
echo '<td> Фото (PNG,JPG,JPEG): </td>';
echo '<td><input type="file" name="img_upload" accept=".jpg, .jpeg, .png"></td>';
echo '</tr>'; 
   

echo'<br>';
echo '<tr>';
echo '<td>Зарплата: </td>';
echo '<td><input type="text" size="20" name="zarp" placeholder="10000" pattern="^[0-9]+$" title="Введите число, например: 15000"></td>';
echo '</tr>';
echo'<tr><br>';
echo '<td> Отдел: </td>';
echo '<td><input type="text" readonly size="20" name="n_otdel"  value="',$selectotdel,'"></td>';
echo '</tr></table>';
echo'<br>';
echo '<font>';
echo ' <input type="submit" name="submit" class="b1" value="Добавить">';
echo '</font>';
echo '<br>';
 if(isset($_POST['submit']))
{
echo "<meta http-equiv='refresh' content='0'>";
}
	
$fam_im = $_POST['fam_im'];
$zarp = $_POST['zarp'];
$n_otdel = $_POST['n_otdel'];
$img_size = 3*1024*1024;
if (!empty($_FILES['img_upload']['tmp_name']) && $_FILES['img_upload']['size'] <= $img_size && $_POST["fam_im"]!=NULL && $_POST["zarp"]!=NULL ) 
{$img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
	
$q = 'select * from sotr;';
$res = mysqli_query($link,$q);

	$otd_sotr_zarp = mysqli_query($link,"select otd_sotr_zarp, otd_razm from otdel where id_otd='$n_otdel';");
	$row = mysqli_fetch_array($otd_sotr_zarp);
	$otd_sotr_zarp =  $row['otd_sotr_zarp'] + $zarp;
	$otd_razm =  $row['otd_razm'] + "1";
	$result = mysqli_query($link,"SELECT MAX( id_sotr ) FROM sotr"); // находим максимальный id сотрудника
	$row = mysqli_fetch_row($result);
	if ($row[0] != NULL)
	{
		$id_sotr=$row[0]+1;
	}
else $id_sotr=1;
	
try{
	$r1 = $link->query("SET AUTOCOMMIT=0");// отключить режим автоматического завершения транзакций
	$r2 = $link->query("START TRANSACTION");
	if ((!$r1) || (!$r2))
	{
	throw new Exception('Ошибка');
	exit();
	} 
		
	$q0 = "insert into sotr (id_sotr,fam_im, img, zarp_sotr, n_otdel_sotr) 
       values ('$id_sotr','$fam_im', '$img','$zarp ','$n_otdel')";

    $r0 = mysqli_query($link,$q0); 
	if (!$r0)
	{
	throw new Exception('Ошибка');
	exit();
	} 

      $q0 = "UPDATE otdel 
       set otd_sotr_zarp='$otd_sotr_zarp', otd_razm = '$otd_razm'
      where id_otd='$n_otdel'";

$r0 = mysqli_query($link,$q0);
if (!$r0)
	{
	throw new Exception('Ошибка');
	exit();
	}
	
	$R = $link->commit();// сохранить изменения
	if (!$R) {throw new Exception('Ошибка завершения транзакции');
	
}
}
catch (Exception $e) {
	echo 'ошибка'.$e->getMessage();
	$res_rollback =$link->rollBack();// отменить изменения
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