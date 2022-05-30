<?php

$db_host       = 'localhost';
$username = 'root';
$password = '';
$dbname = 'practica';
$charset = 'utf8';

$link = new mysqli($db_host, $username, $password, $dbname);

if($link->connect_error){
	die("Ошибка соединения".$link->connect_error);
}

if(!$link->set_charset($charset)){
	echo "Ошибка установки кодировки UTF8";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Загрузка картинки в БД</title>
</head>

<body>
<form action="index3.php" method="post" enctype="multipart/form-data">
<p>Загрузить картику</p>
<input type="file" name="img_upload"><input type="submit" name="upload" value="Загрузить">
<?php
	
if(isset($_POST['upload'])){
	$img_type = substr($_FILES['img_upload']['type'], 0, 5);
	$img_size = 2*1024*1024;
	if(!empty($_FILES['img_upload']['tmp_name']) and $img_type === 'image' and $_FILES['img_upload']['size'] <= $img_size){ 
	$img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
	$link->query("INSERT INTO sotr (img) VALUES ('$img')");
	}
}
?>
</form>
<?php/*
	
	$query = $link->query("SELECT * FROM sotr");
	while($row = $query->fetch_assoc()){
		$show_img = base64_encode($row['img']);?>
		<img src="data:image/jpeg;base64, <?=$show_img ?>" alt="">
	<?php } */?> 
</body>
</html>