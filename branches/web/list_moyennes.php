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
			<th title="Date de la moyenne">Date</th>
		<?php
			session_start();
			session_unset();  
			$_SESSION['subtitles'] = null;
			$_SESSION['categories'] = null;
			$_SESSION['yAxis_title'] = "Moyennes";
			$_SESSION['tooltip'] = "";
			$_SESSION['series'] = null;
			
			foreach($variables as $variable){
				$variable = getHeader($variable);
				$_SESSION['subtitles'][] = $variable;
				echo "<th title='" .getDescriptionOfLabel($variable, $connexion). " en " .getUnite($variable, $connexion). "'>&nbsp;" .getLabel($variable). "&nbsp;</th>";
			}
	echo "</tr>";
			 
	//Création de la requête et génération du tableau
	$sql_select = generateMoySQL($variables, $dateDebut, $dateFin);
	$query_select = $connexion->prepare($sql_select);
	$query_select->execute();
	
	//echo "<br>".$sql_select."<br><br>";
	while($data=$query_select->fetch(PDO::FETCH_OBJ)){
		$datetime = $data->datetime;						
		
		echo '<tr class=tabListDataCells>';
			$_SESSION['categories'][] = $data->date;
			echo "<td>" .$data->date. "</td>";
		
			foreach($variables as $variable){
				$value = strtolower($variable . "_avg");
				$header = getHeader($variable);
				$_SESSION['series'][$header][] = round($data->$value);
				echo "<td title='" .getHeader($variable). "'>" . round($data->$value). "</td>";
			}
		echo "</tr>";
			
	} ?>
</table>

