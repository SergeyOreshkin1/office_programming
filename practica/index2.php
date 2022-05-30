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

$db_host = 'localhost';
$db_name = 'practica';
$db_username = 'root';
$db_password = '';

try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
    catch (Exception $e){
    die("Не удалось подключиться: ".$e->getMessage());
    }
	
	
	$selectotdel=$_GET["selectotdel"];
	
	echo '<font>';
    echo ' Получить отчет по '.$selectotdel.' отделу';
    echo '</font><br><br>';
	
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

	echo '<BUTTON name="otchet" class="b1" > Отчет в Word</BUTTON>';
	echo'<br><br>';

echo '<font>';
echo ' <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';
echo '<br>';

if(isset($_POST['otchet']))
{
	$notdel = $_GET["selectotdel"];
     
    $q="SELECT * from sotr where n_otdel_sotr='$notdel' ";
	require_once 'vendor/autoload.php';
	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	
 
        $tableStyle = array('borderSize' => 4, 'borderColor' => '000000', 'cellMargin' => 60);
        $sectionStyle = array('orientation' => 'landscape', 'marginLeft' => '800', 'marginRight' => '800', 'marginTop' => '800');
        $textCenter = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $textLeft = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);

        $date = date("d.m.Y");
        
        $section = $phpWord->createSection($sectionStyle);
        $section->addText('Отчет по '.$selectotdel.' отделу', Textstyle(18, 'blue'), $textCenter);
		$section->addText('Дата формирования отчета: ' . $date , Textstyle(18, 'blue'), $textCenter);
		
        $styleName = 'myTable';
        $table = $section->addTable($styleName);
        $phpWord->addTableStyle($styleName, $tableStyle, cellStyle('66BBFF'));

        $imageStyle = array('width' => 100, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $result = mysqli_query($link,$q);

        $sum = 0;
	   $table->addRow();
            addTextInCell($table, 2000, "Номер сотрудника", $textLeft, Textstyle(14, 'red'));
            addTextInCell($table, 3000, "Сотрудник", $textCenter, Textstyle(14, 'red'));
            addTextInCell($table, 3000, "Зарплата", $textCenter, Textstyle(14, 'red'));
			addTextInCell($table, 4000, "Фото", $textCenter, Textstyle(14, 'red'));
        while ($row = mysqli_fetch_array($result)) {
            $sum = $sum + $row['zarp_sotr'];
            
            $table->addRow();
            addTextInCell($table, 2000, $row['id_sotr'], $textLeft, Textstyle(14, 'green'));
            addTextInCell($table, 3000, $row['fam_im'], $textCenter, Textstyle(14, 'green'));
            addTextInCell($table, 3000, $row['zarp_sotr'], $textCenter, Textstyle(14, 'green'));
            $table->addCell(4000, cellStyle('#FFFACD'))->addImage('' . $row['img'] . '', $imageStyle);
        }

        $table->addRow();
        addTextInCell($table, 2000, 'Итого по отделу', $textLeft, Textstyle(14, 'red'));
        addTextInCell($table, 3000, '', $textCenter, Textstyle(14, ''));
        addTextInCell($table, 3000, number_format($sum, 2), $textCenter, Textstyle(14, 'red')); 

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('MyDocument.docx');
}
  ?>
  <br>
<br>

</form>

</body>
</html>