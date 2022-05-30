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
   
    $q = "SELECT idOtdel, NameOtdel,(SELECT distinct COUNT(id) FROM sotr WHERE idOtdel = Otdel ) as 'kol_vo' FROM otdels";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="firstContainer" id='table'>
			<table>
				<thead>
					<td>
						<img src="./comp.png" width='70'>
					</td>
					<td colspan='8'>
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
					<td colspan='8'>
						<p>
							Отчетный период: 2018 год
						</p>
					</td>
				</tr>
       				<tr>
						<td>Код отдела</td>
						<td>Название отдела</td>
						<td>Перестроить диаграмму</td>
						<td>Показать диаграмму</td>
						<td>Количество сотрудников</td>
						<td>Обновить форму</td>
						<td>Диаграмма</td>
						<td>Отчет</td>
						<td>Выбор отдела</td>
					</tr>
					<?php
						$r = mysqli_query($link,$q);
						while($row = mysqli_fetch_row($r)) {
					?>
					<tr>
						<td><?php echo $row[0] ?></td>
						<td><?php echo $row[1] ?></td>
						<td>
							<button onclick="rebuild(<?= $row[0]?>)">
								Перестроить диаграмму
							</button>
						</td>
						<td>
							<button onclick="show(<?= $row[0]?>)">
								Показать диаграмму
							</button>
						</td>
						<td>
							<?php echo $row[2] ?>
						</td>
						<td class="td-individual">
							<form action="index.php" method="post">
								<button type="submit">
									Обновить форму
								</button>
							</form>
						</td>
						<td>
							<?php
							   $idOtdel = $row[0];
							   $k = $row[2];
							   if ($row[2]>0) {
								$id = 'image' + $row[0];
							   echo "<img id='$id' src='diagram.php?numberOtdel=$idOtdel' width='190' height='120'>";
							   }
							   else {
							  echo '<img src="./vopros.jpg" width="130" >';
							   }
							?>
						</td>
						<td>
						<?php
												
						echo "<a href='document2.php?numberOtdel=$idOtdel&ksotr=$k'><img src='./doc.jpg' width='100'></a>";
						?>
						</td>
						<td>
						<?php
												
						echo "<a href='lab12.php?numberOtdel=$idOtdel&ksotr=$k'><img src='./sotrs.png' width='100'></a>";
						?>
						</td>
						
					</tr>		
					<?php } ?>
					</tbody>
			</table>
		</div>

		<div class="secondContainer" id='diagram' style="display: none">
			<table>
				<thead>
					<td>
						<img src="./comp.png" width='70'>
					</td>
					<td colspan='6'>
						<p>
							Отчет о заработной плате сотрудников за 2018 год
						</p>
					</td>
					
				</thead>
				<tbody>
					<td colspan='7'>
						<img id='openImage'>
					</td>
				</tbody>
				<tfoot>
					<td colspan='7' style="text-align: left;">
						<button onclick="Hide()">
							Скрыть диаграмму
						</button>
					</td>
				</tfoot>
			</table>
		</div>
		<script src='script.js'></script>
	</body>
</html>