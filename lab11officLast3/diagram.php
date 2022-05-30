<?php
function SumZarpl($otdel)
{
    return "SELECT Month, Sum(Money) FROM zarpl INNER JOIN sotr on zarpl.idSotr = sotr.id WHERE God = 2018 and sotr.Otdel = '$otdel' GROUP BY Month";
}
    $number = $_GET["numberOtdel"];

    $db_host = 'localhost';
    $db_name = 'lb7';
    $db_username = 'root';
    $db_password = '';

    header("Content-type: image/jpeg");
    
    $width = 800;
    $height = 560;
    $im = ImageCreate($width, $height);
   
    $blueColor = ImageColorAllocate($im, 0, 0, 255);
    $yellowColor = ImageColorAllocate($im,255,255,153);
	$yellowColor2 = ImageColorAllocate($im,255,255,0);
    $blackColor = ImageColorAllocate($im, 0, 0, 0);
    $font = "C:\\Windows\\Fonts\\Arial.ttf";

    try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
    catch (Exception $e){
    die("Не удалось подключиться: ".$e->getMessage());
    }
	
    mysqli_query($link,'SET NAMES UTF8');

    $months = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
    $res = mysqli_query($link,SumZarpl($number));
        
    $queryNameOtdel = "SELECT NameOtdel FROM otdels WHERE idOtdel = '$number'";
    $result = mysqli_query($link,$queryNameOtdel);
    $otdelName = '';
    while ($row = mysqli_fetch_row($result)) {
        $otdelName = $row[0];
    }
	
	//ежемесячный доход
    $monthlyIncome = array();
        while ($row = mysqli_fetch_row($res)) 
		{
            $monthlyIncome[$row[0]] = $row[1];
        }
	
    $maxHeight = 0;
    foreach ($monthlyIncome as $key => $value) {
        $maxHeight = max($maxHeight, $value);
    }

    if ($maxHeight != 0) {
        ImageFilledRectangle($im, 0, 0, 700, 500, $blueColor);
        Imagettftext($im, 16, 0, 150, 20, $yellowColor2 , $font, 'Отчет о доходах сотрудников отдела за 2018 год');
        ImageFilledRectangle($im, 10, 540, 790, 50, $yellowColor);
        Imagettftext($im, 10, 0, 20, 70, $blackColor, $font, "Отдел №$number - $otdelName");
        
        $Max = max($monthlyIncome) + 20000;
        for ($m = 1; $m <= 12; $m++) {
			
			if (array_key_exists("$m", $monthlyIncome))
			{
			    $Salary = $monthlyIncome["$m"];
			}
			else 
			{
			    $Salary = 0;
			}
           
            $colors = ImageColorAllocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
            $heightImageRectangle = round(($Salary * $height) / $Max);
            //столбцы
            ImageFilledRectangle($im, $m * 60 - 25, $height - $heightImageRectangle-20, $m * 60 + 25, $height - 26, $colors);
			//граница стобцов
            ImageRectangle($im, $m * 60 - 25, $height - $heightImageRectangle-20, $m * 60 + 25, $height - 25, $blackColor);
			//доходы по месяцам
            ImageString($im, 2, $m * 60 - 30, $height - 15, number_format($Salary, 2), $yellowColor);
			//месяца на стобцах
            Imagettftext($im, 15, 90, $m * 60 + 10, $height - 30, $blackColor, $font, $months[$m - 1]);
        }
    } 
	else 
	{
        ImageFilledRectangle($im, 0, 0, 799, 500, $blueColor);
        Imagettftext($im, 30, 0, 320, 70, $yellowColor2, $font, 'Ошибка');
        ImageFilledRectangle($im, 25, 100, 775, 500, $yellowColor);
        Imagettftext($im, 20, 0, 130, 250, $blackColor, $font, 'В базе данных нет сведений за этот период!');
     }

    ImageJpeg($im);
    imagedestroy($im);
?>