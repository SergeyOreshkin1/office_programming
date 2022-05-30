<?php
     
    $number = $_GET["numberOtdel"];
	$ksotr =  $_GET["ksotr"];
	$date = date("d.m.Y");
		
    $db_host = 'localhost';
    $db_name = 'lb7';
    $db_username = 'root';
    $db_password = '';
       
    try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
    catch (Exception $e){
    die("Не удалось подключиться: ".$e->getMessage());
    }
	
    mysqli_query($link,'SET NAMES UTF8');
	
   $q ="SELECT Sum(Money) FROM zarpl INNER JOIN sotr on zarpl.idSotr = sotr.id WHERE God = 2018 and sotr.Otdel = '$number'";
   $r = mysqli_query($link,$q);
   while ($row = mysqli_fetch_row($r)) 
		{
            $s = $row[0];
        }
		
   $q ="SELECT month as m,IFNULL(sum(money),0) as k from zarpl,otdels,sotr where god=2018 and idotdel='$number' and zarpl.idsotr=sotr.id and sotr.otdel=otdels.idotdel group by month";
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
			
	if ($ksotr>0){
	echo "Отчет успешно сформирован!";
    require_once 'vendor/autoload.php';
    $objWriter = new \PhpOffice\PhpWord\TemplateProcessor('Temp.docx');
    $objWriter->setValue('otdel',$number);
	$objWriter->setValue('dt',$date);
	$objWriter->setValue('main_sum',$s);
	for ($i=1; $i<=12; $i++){
		if ($zarpl[$i] !=''){
		   $objWriter->setValue('S'.$i,$zarpl[$i]);
		}
		else{
		$objWriter->setValue('S'.$i,"0.00");
		}
	}				
    $objWriter->saveAs('MyDocument.docx');
	}
	else{
	echo "В базе данных нет сведений за этот период";
	}
?>