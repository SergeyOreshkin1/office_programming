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
	
$myquery = 
'select * from otdel;';
$res = mysqli_query($link,$myquery );

	echo '<BUTTON name="otchet" class="b1" > Отчет PDF</BUTTON>';
	echo'<br><br>';

echo '<font>';
echo ' <input type="button" class="b1" onclick="document.location.href=\'main.php\'" value="Назад">';
echo '</font>';
echo '<br>';

if(isset($_POST['otchet']))
{
	$notdel = $_GET["selectotdel"];
       
	ob_start();
 define('FPDF_FONTPATH',"/fpdf/font/");
 require_once("/fpdf/fpdf.php");
 
   $pdf = new FPDF('L', 'pt', 'A4');
   
    $pdf->AddFont('Arial','','arial.php');
    $pdf->SetFont('Arial');
    $pdf->SetFontSize(15);
    $pdf->AddPage();
    $pdf->SetDisplayMode('real', 'default');
	
   	$pdf->SetTextColor(100, 0, 200);
	//$pdf->Image('1.jpg',100,5,50);
	$pdf->Ln(80);
	
    $pdf->SetFillColor(152, 251, 152);
	$pdf->SetDrawColor(4,220,254);
	$pdf->SetLineWidth(1);
	$pdf->Cell(720, 25, iconv('utf-8', 'windows-1251', 'Отчет по '.$notdel.' отделу'), 'LTRB', 1, 'C', true);
	$pdf->Ln(20);
	    
    $result = mysqli_query($link,"SELECT * from sotr where n_otdel_sotr='$notdel'");
         
     
    $pdf->SetFontSize(16);
    $pdf->SetTextColor(0, 100, 0);
    $pdf->SetFillColor(152, 251, 152);
    $pdf->SetLineWidth(2);
	$pdf->Cell(130, 25, iconv('utf-8', 'windows-1251', 'Номер'), 1, 0, 'C', 1);
    $pdf->Cell(130, 25, iconv('utf-8', 'windows-1251', 'Фамилия'), 'LTR', 0, 'C', true);
	$pdf->Cell(460, 25, iconv('utf-8', 'windows-1251', 'Зарплата'), 'LTR', 1, 'C', true);
    
    
     	$i=0;
		$sum=0;
   while ($row2=mysqli_fetch_row($result))
{
            $pdf->SetFontSize(14);
            $pdf->SetTextColor(25, 25, 112);
		    if ($i % 2 == 0) {
        $pdf->setFillColor(183, 255, 255);
    } else {
        
            $pdf->setFillColor(183, 255, 127);
        
    }
            $pdf->Cell(130, 25, "$row2[0]", 1, 0, 'C',true);
            $pdf->Cell(130, 25,  iconv('utf-8', 'windows-1251', "$row2[1]"), 1, 0, 'C', true);
			$pdf->Cell(460, 25,  "$row2[3]", 1, 1, 'R', true);
			$i=$i+1;	
            $sum=$sum+$row2[3];			
}
$pdf->Ln(20);
    $pdf->SetLineWidth(1);
	$pdf->Cell(260, 25, iconv('utf-8', 'windows-1251', 'Всего по '.$notdel.' отделу: '.$sum.' '), 'LTRB', 1, 'C', true);
	$pdf->Cell(260, 25, iconv('utf-8', 'windows-1251', 'Сотрудников в отделе: '.$i.' '), 'LTRB', 1, 'C', true);
	$pdf->Ln(20);
		    
      $file_name = "file.pdf";
      $pdf->Output("$file_name", "F");
   
    ob_end_flush(); 
 
}
  ?>
  <br>
<br>

</form>

</body>
</html>