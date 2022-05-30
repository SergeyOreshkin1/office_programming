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
$db_username="root";
$db_password="";
$db_name="practica";
$db_host = 'localhost';
echo "<font><pre> База данных «ОТДЕЛЫ-СОТРУДНИКИ»</font> ";
echo "<p><pre>   <img src='./sotrs.png' width='200'>"."<br><br>";
echo "<font> Проверка подключения к БД</font>"."<br><br>";

try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);
echo "<font> Есть подключение</font><br><br>";}
catch (Exception $e) {
die("<font> Нет подключения</font>".$e->getMessage());
}
echo "</p>";

if(isset($_POST['b'])){
		
$selectotdel = $_POST['selectotdel'];
echo '<font>';
echo '<pre> Просмотр таблицы "Отделы"';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <a href='view.php?selectotdel=$selectotdel' >Посмотреть</a>";
echo'<br>';
echo '</font>';

echo'<br>';
echo '<font>';
echo ' Добавление сотрудника';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <a href='add.php?selectotdel=$selectotdel' >Добавить</a>";
echo'<br>';
echo '</font>';

echo'<br>';
echo '<font>';
echo ' Удаление сотрудника';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <a href='delete.php?selectotdel=$selectotdel' >Удалить</a>";
echo'<br>';
echo '</font>';


echo'<br>';
echo '<font>';
echo ' Изменение зарплаты';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <a href='change_salary.php?selectotdel=$selectotdel' >Изменить зарплату</a>";
echo'<br>';
echo '</font>';

echo'<br>';
echo '<font>';
echo ' Изменение фотографии';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <a href='index4.php?selectotdel=$selectotdel' >Изменить фото</a>";
echo'<br>';
echo '</font>';


echo'<br>';
echo '<font>';
echo ' Измененить руководителя отдела';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <a href='change_boss.php?selectotdel=$selectotdel' >Изменить руководителя</a>";
echo'<br>';
echo '</font>';
echo '<font>';
echo'<br>';


echo '<font>';
echo ' Поиск';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <pre> <a href='find.php?selectotdel=$selectotdel'><img src='./poisk.jpg' width='100'></a></pre>";
echo'<br>';
echo '</font>'; 


echo '<font>';
echo ' Отчет по отделу';
echo '</font>';
echo'<br>';
echo '<font>';
echo " <pre> <a href='index2.php?selectotdel=$selectotdel'><img src='./doc.jpg' width='100'></a>  <a href='pdf.php?selectotdel=$selectotdel'><img src='./pd.png' width='100'></a></pre>";
echo'<br>';
echo '</font>'; 


echo'<br>';
echo '<font>';
echo ' Выбранный отдел:';
echo '</font>';

	
echo $selectotdel;
	}

echo '<form method="POST">';
$myquery = 
  'select * from otdel';
$res = mysqli_query($link,$myquery );
echo '<table border=2>';
echo '<tr>';
echo '<td><font><input  type="submit" class="b1" name="b" value="Выбрать отдел">';
echo '</font></td>';

echo '<td><select name="selectotdel" class="select-css" size=1 >';

while ($row = mysqli_fetch_array( $res ))
{
echo '<option value="'.$row['id_otd'].'">'.$row['id_otd'].'</option>';

}
echo '</select></td></tr></form>';
	
?>

</form>

</body>
</html>