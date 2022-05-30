<?php
     
    $number = $_GET["numberOtdel"];
	$ksotr =  $_GET["ksotr"];
	$date = date("d.m.Y");
	$idsotr = $_GET["ids"];
				
    $db_host = 'localhost';
    $db_name = 'lb7';
    $db_username = 'root';
    $db_password = '';
       
    try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
    catch (Exception $e){
    die("Не удалось подключиться: ".$e->getMessage());
    }
	
    mysqli_query($link,'SET NAMES UTF8');
	
   $q ="select id,otdel,nameotdel,lastname,firstname,(select IFNULL(sum(money),0) from zarpl where zarpl.idSotr=sotr.id and god=2018) from sotr,otdels where otdels.idotdel=sotr.otdel and id='$idsotr' group by otdel,lastname";
   $r = mysqli_query($link,$q);
   while ($row = mysqli_fetch_row($r)) 
		{
            $id = $row[0];
			$nameotdel = $row[2];
			$ln = $row[3];
			$fn = $row[4];
			$zp = $row[5];
	    }
		
   $q ="SELECT Month as m, Sum(Money) as k FROM zarpl INNER JOIN sotr on zarpl.idSotr = sotr.id WHERE God = 2018 and idsotr='$idsotr' GROUP BY Month";
   $r = mysqli_query($link,$q);
    $rr=$r->fetch_assoc();
    for ($i=1; $i<=12; $i++){
	if($i == $rr["m"]){
	$zarpl[$i] = $rr["k"];
    $sum += $zarpl[$i];
    $rr = $r->fetch_assoc();
	}
	else{
	$zarpl[$i] = 0;
	}
}		
  		
	echo "Отчет успешно сформирован!";
    require_once 'vendor/autoload.php';
    $objWriter = new \PhpOffice\PhpWord\TemplateProcessor('Temp2.docx');
    $objWriter->setValue('otdel',$nameotdel);
	$objWriter->setValue('dt',$date);
	$objWriter->setValue('main_sum',$zp);
	$objWriter->setValue('sotr',$ln." ".$fn);
	for ($i=1; $i<=12; $i++){
		if ($zarpl[$i] !=''){
		   $objWriter->setValue('S'.$i,$zarpl[$i]);
		}
		else{
		$objWriter->setValue('S'.$i,"0.00");
		}
	}	
    $objWriter->saveAs('MyDocumentLab12.docx');
		
?>