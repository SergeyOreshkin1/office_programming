<?php
	$db_host = 'localhost';
    $db_name = 'lb7';
    $db_username = 'root';
    $db_password = '';

    try {$link = mysqli_connect($db_host,$db_username,$db_password,$db_name);}
    catch (Exception $e){
    die("Не удалось подключиться: ".$e->getMessage());
    }
	
    mysqli_query($link,'SET NAMES UTF8');
    $number = $_GET["numberOtdel"];
	$ksotr =  $_GET["ksotr"];
    $q = "SELECT id,LastName,FirstName,Dolzn from sotr where otdel='$number' order by lastname,firstname";
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<? if ($ksotr>0) { ?>
		<div class="firstContainer" id='table'>
			<table>
				<thead>
					<td>
						<img src="./comp.png" width='70'>
					</td>
					<td colspan='5'>
						<p>
							Отчет о заработной плате сотрудников за 2018 год
						</p>
					</td>
				</thead>
				<tbody>
				<tr>
				<td>
					<img src="./doc.jpg" width='70'>
					</td>
					<td colspan='5'>
						<p>
							Отчетный период: 2018 год
						</p>
					</td>
				</tr>
       				<tr>
						<td>Код сотрудника</td>
						<td>Фамилия</td>
						<td>Имя</td>
						<td>Должность</td>
						<td>Отчет</td>
					</tr>
					<?php
						$r = mysqli_query($link,$q);
						while($row = mysqli_fetch_row($r)) {
							$idsotr=$row[0];
					?>
					<tr>
						<td><?php echo $row[0] ?></td>
						<td><?php echo $row[1] ?></td>
						<td><?php echo $row[2] ?></td>
						<td><?php echo $row[3] ?></td>
						<td>
						<?php
												
						echo "<a href='documentlab12.php?numberOtdel=$idOtdel&ksotr=$k&ids=$idsotr'><img src='./doc.jpg' width='100'></a>";
						?>
						</td>
					</tr>		
					<?php } ?>
					</tbody>
			</table>
		</div>
		<script src='script.js'></script>
	</body>
	<?}
else {echo "В отделе нет сотрудников!";} ?>	
	
</html>