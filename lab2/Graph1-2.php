<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form method="GET">
		<input type="range" name="param" min="-100" max="100">
		<button type="submit" name="run">run</button>
	</form>
	<img src="Graph1-1.php?param= <?php echo $_GET['param'] ?>" id="pic" width="700" height="480">
</body>
</html>