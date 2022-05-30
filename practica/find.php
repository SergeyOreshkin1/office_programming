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
echo '<pre> Поиск сотрудников';
echo '</font>';
echo '<font>';
echo '<pre> <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';

echo '<table cellpadding="4">';
echo '<tr>';
echo '<td>Запрплата >= </td>';
echo '<td><input type="text" size="20" name="newzarp" placeholder="10000" pattern="^[0-9]+$" title="Введите число, например: 15000""></td>';
echo '<td><BUTTON name="submit3" class="b1"> Найти </BUTTON></td>';
echo '</tr>';
echo '<tr>';
echo '<td>Первая буква фамилии</td>';
echo '<td><input type="text" size="20" name="fam" pattern="[А-ЯЁё]{1}" placeholder="Заглавная буква""></td>';
echo '<td><BUTTON name="submit4" class="b1"> Найти </BUTTON></td>';
echo '</tr>';
echo '</table>';



if( $_POST['newzarp']!=null){
$zp = $_POST['newzarp'];	

echo '<font>';
echo '<pre> Информация по '; 
echo $selectotdel;
echo ' отделу'; 
echo '</font>';
echo '<br>';
/////////////////////////////////////////////////////////////////
//  Таблица sotr, где номер отдела выбран из выпадающего списка из main
/////////////////////////////////////////////////////////////////
$myquery = "select id_sotr,fam_im,img,zarp_sotr,n_otdel_sotr from sotr where (n_otdel_sotr='$selectotdel') and zarp_sotr >= '$zp'";
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
}



if( $_POST['fam']!=null){
$fam = $_POST['fam'];	

echo '<font>';
echo '<pre> Информация по '; 
echo $selectotdel;
echo ' отделу'; 
echo '</font>';
echo '<br>';
/////////////////////////////////////////////////////////////////
//  Таблица sotr, где номер отдела выбран из выпадающего списка из main
/////////////////////////////////////////////////////////////////
$myquery = "select id_sotr,fam_im,img,zarp_sotr,n_otdel_sotr from sotr where (n_otdel_sotr='$selectotdel') and fam_im like '".$fam."%'";
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
}

?>
<br>
<br>

</form>

</body>
</html>