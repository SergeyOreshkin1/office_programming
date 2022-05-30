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
echo '<pre> Таблица "Отделы"<br>';
echo '</font>';

echo'<br>';

echo '<font>';
echo ' <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';
echo '<br>';

function cellStyle($bgColor)
    {
        return array('borderBottomColor' => '', 'bgColor' => $bgColor, 'valign' => 'center');
    }

    function Textstyle($fontSize, $fontColor)
    {
        return array('name' => 'Times New Roman', 'color' => $fontColor, 'size' => $fontSize, 'bold' => true, 'lang' => \PhpOffice\PhpWord\Style\Language::RU_RU);
    }
    
    function addTextInCell($table, $widthCell, $text, $textAling, $styleText)
    {
        $table->addCell($widthCell, cellStyle('#FFFACD'))->addText($text, $styleText, $textAling);
    }   

$myquery = 
'select * from otdel;';
$res = mysqli_query($link,$myquery );
echo '<br>';

echo '<table border=2>';
echo '<tr>';
echo '<td>Номер отдела</td>';
echo '<td>Номер руководителя</td>';
echo '<td>Сумма</td>';
echo '<td>Размер</td>';
echo '</tr>';
while ($row = mysqli_fetch_array($res ))
{
echo '<tr>';
echo '<td>'.$row['id_otd'].'</td>';
echo '<td>'.$row['otd_boss'].'</td>';
echo '<td>'.$row['otd_sotr_zarp'].'</td>';
echo '<td>'.$row['otd_razm'].'</td>';
echo '</tr>';
}
echo '</table>';

?>
<br>
<br>

</form>

</body>
</html>