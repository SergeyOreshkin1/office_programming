<? 
$idOtd=$_POST['n_otdel'];
include 'pChart/class/pData.class.php'; 
include 'pChart/class/pDraw.class.php'; 
include 'pChart/class/pImage.class.php'; 

 $db = mysql_connect("localhost", "root", '');
    mysql_select_db("lb7",$db);
			
	$result=mysql_query("select idotdel,sum(money) from otdels left outer join sotr on idotdel=otdel left outer join zarpl on id=idsotr and god=2018 where money is null");
		   $row=mysql_fetch_row($result);
	
	if ($idOtd==$row[0])
	  {
		  echo 'no information in the database';
		  exit;
		  	  }
		   
	  else{
	

//создаем объект данных 

$myData = new pData(); 
	//SELECT MONTH FROM zarpl, otdels, sotr WHERE god =2018 AND zarpl.idsotr = sotr.id AND sotr.otdel = otdels.idotdel GROUP BY MONTH , idotdel

    $query = "SELECT month as m,IFNULL(sum(money),0) as k from zarpl,otdels,sotr where god=2018 and idotdel='$idOtd' and zarpl.idsotr=sotr.id and sotr.otdel=otdels.idotdel group by month";
    $result = mysql_query($query,$db);
	   
    while($row = mysql_fetch_array($result))
        {   
            $myData->addPoints($row["m"],"Month");
            $myData->addPoints($row["k"],"Доходы по месяцам");
			
        }
		
        $myData->setAbscissa("Month");
	    $myData->setAxisName(0,"Доходы");
		$myData->setAbscissaName("Месяцы (с января по декабрь)");
		
  
    $myPicture = new pImage(1100,400,$myData);
       
	$myPicture->SetFontProperties(array("FontName"=>"pChart/fonts/verdana.ttf","FontSize"=>9));
 
    $myPicture->setGraphArea(80,60,1000,340);
	$myPicture->drawText(350,30,"Отчет о доходах сотрудников $idOtd отдела за 2018 год",array("FontSize"=>12,"Align"=>TEXT_ALIGN_BOTTOMLEFT));

    $myPicture->drawScale();
    
   // $myPicture->drawSplineChart();
   
	$myPicture->drawBarChart();
	$myPicture->drawPlotChart(array("DisplayValues"=>TRUE, "PlotBorder"=>TRUE));
    $myPicture->drawLegend(900,65,array("Mode"=>LEGEND_VERTICAL));  
    $myPicture->autoOutput("grafico.png"); 
	
	  }
		   
?>

