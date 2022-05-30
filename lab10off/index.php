<?php
$db_host = 'localhost';
$db_name = 'tovar';
$db_username = 'root';
$db_password = '';

try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
    catch (Exception $e){
    die("Не удалось подключиться: ".$e->getMessage());
    }
	
mysqli_query($link,'SET NAMES UTF8');
require_once 'vendor/autoload.php';
?>
    <html>
    <head>
    <meta charset="utf-8">
    </head>
    <body>
    <div>
    <form action="index.php" method="post">
    <button type="submit" name='b1'>Сгенерировать Документ MicrosoftWord</button>
    </form>
    </div>
    </body>
    </html>
<?php

    $q="SELECT tname, date_p, price, kol_vo, price*kol_vo Сумма, photo FROM eltovary";

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

   if (isset($_POST['b1'])) 
	{
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $tableStyle = array('borderSize' => 4, 'borderColor' => '000000', 'cellMargin' => 60);
        $sectionStyle = array('orientation' => 'landscape', 'marginLeft' => '800', 'marginRight' => '800', 'marginTop' => '800');
        $textCenter = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $textLeft = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
        $textRight = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT);
        $date = date("d.m.Y");
        
        $section = $phpWord->createSection($sectionStyle);
        $section->addText('Отчет о приходе электротоваров на склад', Textstyle(18, 'blue'), $textCenter);
        $section->addText('Дата формирования отчета: ' . $date , Textstyle(18, 'blue'), $textCenter);

        $styleName = 'myTable';
        $table = $section->addTable($styleName);
        $phpWord->addTableStyle($styleName, $tableStyle, cellStyle('66BBFF'));

        $imageStyle = array('width' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $result = mysqli_query($link,$q);

        $sum = 0;
        while ($row = mysqli_fetch_array($result)) {
            $sum = $sum + $row['Сумма'];

            $table->addRow();
            addTextInCell($table, 4200, $row['tname'], $textLeft, Textstyle(14, 'red'));
            addTextInCell($table, 2000, $row['date_p'], $textCenter, Textstyle(14, 'green'));
            addTextInCell($table, 1800, $row['price'], $textRight, Textstyle(14, 'green'));
            addTextInCell($table, 1300, $row['kol_vo'], $textCenter, Textstyle(14, 'green'));
            addTextInCell($table, 2200, number_format($row['Сумма'],2), $textRight, Textstyle(14, 'red'));
			$table->addCell(3400, cellStyle('#FFFACD'))->addImage('' . $row['photo'] . '', $imageStyle);
        }

        $table->addRow();
        addTextInCell($table, 4200, 'Итого по складу', $textLeft, Textstyle(14, 'red'));
        addTextInCell($table, 2000, '', $textCenter, Textstyle(14, ''));
        addTextInCell($table, 1800, '', $textCenter, Textstyle(14, ''));
        addTextInCell($table, 1300, '', $textCenter, Textstyle(14, ''));
        addTextInCell($table, 2200, number_format($sum, 2), $textCenter, Textstyle(14, 'red'));

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('MyDocument.docx');
    }
  ?>