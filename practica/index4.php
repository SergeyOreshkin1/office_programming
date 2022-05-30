<html>
<head>
<meta charset=windows-1251>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form method="post" name="form1" enctype="multipart/form-data" action="">


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
echo '<pre> Изменение фотографии';
echo '</font>';
echo '<font>';
echo '<pre> <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';

echo '<table cellpadding="4">';
echo '</td>';
echo '<tr>';
echo '<td>Новое фото (PNG,JPG,JPEG):</td>';
echo '<td><input type="file" name="img_upload" accept=".jpg, .jpeg, .png"></td>';
echo '</table>';
echo '</tr>';

 if(isset($_POST['upload']))
{
	
echo "<meta http-equiv='refresh' content='0'>";


}
$img_size = 3*1024*1024;
if (!empty($_FILES['img_upload']['tmp_name']) && $_FILES['img_upload']['size'] <= $img_size){	
 
$sotrid = $_POST['upload']; // выбранный сотрудник
$img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));

try{
	$r1 = $link->query("SET AUTOCOMMIT=0");
	$r2 = $link->query("START TRANSACTION");
	if ((!$r1) || (!$r2))
	{
	throw new Exception('Ошибка');
	exit();
	} 

  $q0 = "UPDATE sotr 
         set img ='$img'
         where id_sotr='$sotrid'";


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
echo '<td><BUTTON name="upload" class="b1" id="hider "value='.$row['id_sotr'].'> Изменить </BUTTON></td>';
echo '</tr>';
}
echo '</table>';

echo '<br>';

?>
<br>
<br>

</form>

</body>
</html>