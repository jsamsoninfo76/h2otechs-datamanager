<!-- 
@author Jérémie Samson
@version 1

Site :
http://stackoverflow.com/questions/2309801/how-to-submit-checkbox-values-with-php-post-method (variables)
http://php.net/manual/fr/function.count.php (count)
http://php.net/manual/fr/function.strtolower.php (lowercase)
-->

<table id="tabListData" border="1" rules="rows">
	<tr id="tabListDataHeader">
			<th title="Date au format AAAA/MM/JJ de la prise de donn&eacute;e">Date</th>
			<th title="Heure de la prise de donn&eacute;e">Heure</th>
		
		<?php	

			$_SESSION['yAxis_title'] = "Donnees";
			foreach($variables as $variable){
				$variable = getHeader($variable);
				$_SESSION['subtitles'][] = $variable;
				echo "<th title='" .getDescriptionOfLabel($variable, $connexion). " en " .getUnite($variable, $connexion). "'>&nbsp;" .getLabel($variable). "&nbsp;</th>";
			}
	echo "</tr>";
		
	//Création de la requête et génération du tableau
	$sql_select = generateDatasSQL($variables, $dateDebut, $dateFin);

	//echo $sql_select;
	$query_select = $connexion->prepare($sql_select);
	$query_select->execute();
	
	$compteurPair = 0;
	$compteurRowSpan = 0;
	$nbRowSpan = 0;
	
	while($data=$query_select->fetch(PDO::FETCH_OBJ)){
		$datetime = $data->datetime;
		$compteurPair++;								
		echo '<tr class=tabListDataCells>';
		$_SESSION['categories'][] = $data->Annee;
		if ($compteurRowSpan == $nbRowSpan){
			$nbRowSpan = getNombreRowSpan($variables[0], $datetime, $dateFin, $connexion);
			echo "<td class='tabListDataCellsAnnee' rowspan=" .(($nbRowSpan>1) ? $nbRowSpan : 1). ">" .$data->Annee. "</td>";	
			$compteurRowSpan = 1;
		}else $compteurRowSpan++;
									
		$heure = ($data->Heure >= 10) ? $data->Heure : "0".$data->Heure;
		$_SESSION['heures'][] = $data->Heure;
		echo "<td>$heure</td>";									
		foreach($variables as $variable){ 
			//Mise en lower du data_label_value
			$value = strtolower($variable . "_value");
			$header = getHeader($variable);
			$_SESSION['series'][$header][] = round($data->$value);
			
			//Si la value est vide
			if ($data->$value == "") {
				//Si la dernière valeur est aussi vide
				if ($lastValue[$variable] == "")
					$lastValue[$variable] = getLastValue($variable, $dateDebut, $connexion);
					
				echo "<td title='" .getHeader($variable). "'>" .$lastValue[$variable]. "</td>";
			}
			else {
				$lastValue[$variable] = $data->$value;
				echo "<td title='" .getHeader($variable). "'>" .$lastValue[$variable]. "</td>";
			}
		}
		echo "</tr>";
	} ?>
</table>