<div id="blockNomenclature">
	<h4>Nomenclature</h4>
	
	<table id="tabNomenclature">
		<?php
			//Connexion à la base de données
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			$sql_nomenclature = getNomenclature();
			$query_nomenclature = $connexion->prepare($sql_nomenclature);
			$query_nomenclature->execute();
			$rowcount = $query_nomenclature->rowcount();
			
			if ($rowcount > 0){
					echo "<tr>";
						echo "<th>Label</th>";
						echo "<th>Unite</th>";
						echo "<th>Description</th>";
					echo "</tr>";
				while($data=$query_nomenclature->fetch(PDO::FETCH_OBJ)){
					echo "<tr class='tabNomenclatureCells'>";
						echo "<td>$data->label</td>";
						echo "<td>$data->unite</td>";
						echo "<td>$data->description</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
		?>
	</table>
	<?php if ($rowcount == 0) echo "<font class='message_error'>Il n'y &agrave actuellement aucune variables</font>"; ?>
</div>
