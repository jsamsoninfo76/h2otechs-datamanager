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
			foreach($variables as $variable){
				$variable = getHeader($variable);
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
			echo "<td>" .$data->Annee. "</td>";
		
			foreach($variables as $variable){
				$value = strtolower($variable . "_avg");
				$header = getHeader($variable);
				echo "<td title='" .getHeader($variable). "'>" . traitementDecimal($variable, round($data->$value)). "</td>";
			}
		echo "</tr>";
			
	} ?>
</table>

