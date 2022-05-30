<?php

    $db_host = 'localhost';
    $db_name = 'lb14';
    $db_username = 'root';
    $db_password = '';
      
    try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
    catch (Exception $e){
    die("Не удалось подключиться: ".$e->getMessage());
    }
    mysqli_query($link,"set character set cp1251");
echo "<table width='40%' bgcolor='green' border=solid>";
echo '<td> <form method="POST">
    <input type="submit" name="btn1" value="Выдать документ PDF" />
</form> </td>';
echo "</table>";
 if( isset( $_POST['btn1'] ) )
{
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
	$pdf->Image('1.jpg',100,5,50);
	$pdf->Ln(80);
	
    $pdf->SetFillColor(152, 251, 152);
	$pdf->SetDrawColor(4,220,254);
	$pdf->SetLineWidth(1);
	$pdf->Cell(720, 25, iconv('utf-8', 'windows-1251', 'Отчет за 2018 год'), 'LTRB', 1, 'C', true);
	$pdf->Ln(20);
	    
    $result = mysqli_query($link,"select id,otdel,lastname,firstname,(select IFNULL(sum(money),0) from zarpl where zarpl.idSotr=sotr.id and god=2018) from sotr group by otdel,lastname");
         
     
    $pdf->SetFontSize(16);
    $pdf->SetTextColor(0, 100, 0);
    $pdf->SetFillColor(152, 251, 152);
    $pdf->SetLineWidth(2);
	$pdf->Cell(130, 25, iconv('utf-8', 'windows-1251', 'Номер'), 1, 0, 'C', 1);
    $pdf->Cell(130, 25, iconv('utf-8', 'windows-1251', 'Отдел'), 'LTR', 0, 'C', true);
	$pdf->Cell(130, 25, iconv('utf-8', 'windows-1251', 'Фамилия'), 'LTR', 0, 'C', true);
	$pdf->Cell(130, 25, iconv('utf-8', 'windows-1251', 'Имя'), 'LTR', 0, 'C', true);
    $pdf->Cell(200, 25, iconv('utf-8', 'windows-1251', 'Зарплата'), 'LTR', 1, 'C', true);
    
   $i=0;
   while ($row2=mysqli_fetch_row($result))
   {
            $pdf->SetFontSize(14);
            $pdf->SetTextColor(25, 25, 112);
	if ($i % 2 == 0)
	{
        $pdf->setFillColor(183, 255, 255);
		
    } 
	else 
	{
        $pdf->setFillColor(183, 255, 127);
        
    }
            $pdf->Cell(130, 25, "$row2[0]", 1, 0, 'C',true);
            $pdf->Cell(130, 25,  "$row2[1]", 1, 0, 'C', true);
			$pdf->Cell(130, 25,  "$row2[2]", 1, 0, 'L', true);
			$pdf->Cell(130, 25,  "$row2[3]", 1, 0, 'L', true);
            $pdf->Cell(200, 25,  "$row2[4]", 1,1, 'R', true);
		 		$i=$i+1;	 
   }
		    
      $file_name = "file.pdf";
      $pdf->Output("$file_name", "F");
   
    ob_end_flush(); 
 
}
?>