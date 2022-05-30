<?

if ((int)$_GET["param"] == 0) { $param0 = 0; }
else { $param0 = (int)$_GET["param"]; }

//$param0 = -40;
$filename = 'Saransk2018.jpg';
 
$info   = getimagesize($filename);
$width  = $info[0];
$height = $info[1];
$type   = $info[2];
 
switch ($type) { 
	case 1: 
		$img = imageCreateFromGif($filename);
		imageSaveAlpha($img, true);
		break;					
	case 2: 
		$img = imageCreateFromJpeg($filename);
		break;
	case 3: 
		$img = imageCreateFromPng($filename); 
		imageSaveAlpha($img, true);
		break;
}

$font_file = 'C:/Windows/Fonts/arial.ttf';
$MyColorAxes = imageColorAllocate($img,0,0,64);
ImageRectangle($img,10,10,150,80,$MyColorAxes);
imagettftext($img,28,0,40,55,$color_text1,$font_file,$param0);

$color_text1 = imageColorAllocate($img,20,10,10);

header('Content-type: image/jpeg');
imagefilter($img, IMG_FILTER_CONTRAST, $param0);
imagejpeg($img,null,100);
imagedestroy($img);
?>