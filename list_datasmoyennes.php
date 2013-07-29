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
							$_SESSION['yAxis_title'] = "DonneesEtMoyennes";
							
							foreach($variables as $variable){
								$variable = getHeader($variable);
								$_SESSION['subtitles'][] = $variable;
								echo "<th title='" .getDescriptionOfLabel($variable, $connexion). " en " .getUnite($variable, $connexion). "'>&nbsp;" .getLabel($variable). "&nbsp;</th>";
							}
					echo "</tr>";
							 
					//Création de la requête et génération du tableau
					$sql_select = generateDatasAndMoySQL($variables, $dateDebut, $dateFin);
					$query_select = $connexion->prepare($sql_select);
					$query_select->execute();
					
					$compteurRowSpan = 0;
					$nbRowSpan = 0;
			
					//echo "<br>".$sql_select."<br><br>";
					while($data=$query_select->fetch(PDO::FETCH_OBJ)){
						$datetime = $data->datetime;
												
						echo '<tr class=tabListDataCells>';
						$_SESSION['categories'][] = $data->Annee;
						if ($compteurRowSpan == $nbRowSpan){
							$nbRowSpan = getNombreRowSpan($variables[0], $datetime, $dateFin, $connexion);
							echo "<td class='tabListDataCellsAnnee' rowspan=" .(($nbRowSpan>1) ? $nbRowSpan : 1). ">";
								if (hasIntervention($data->Annee, $connexion)){
									echo $data->Annee . '<a href="index.php?id_page=4&datetime=' .$data->Annee. '"><img class="icon" title="Voir l\'intervention" src="img/intervention.png"></a>';			
								}else {
									echo $data->Annee;
								}
							echo "</td>";	

							$compteurRowSpan = 1;
						}else $compteurRowSpan++;
													
						$heure = ($data->Heure >= 10) ? $data->Heure : "0".$data->Heure;
						$_SESSION['heures'][] = $data->Heure;
						echo "<td>$heure</td>";									
						foreach($variables as $variable){ 
							//Mise en lower du data_label_value
							$value = strtolower($variable . "_value");
							$header = getHeader($variable);
							
							//Si la value est vide
							if ($data->$value == "") {
								//Si la dernière valeur est aussi vide
								if ($lastValue[$variable] == "")
									$lastValue[$variable] = getLastValue($variable, $dateDebut, $connexion);
									
								echo "<td title='" .getHeader($variable). "'>" .traitementDecimal($variable, $lastValue[$variable]). "</td>";
							}
							else {
								$lastValue[$variable] = $data->$value;
								echo "<td title='" .getHeader($variable). "'>" .traitementDecimal($variable, $lastValue[$variable]). "</td>";
							}
							
							$_SESSION['series'][$header][] = $lastValue[$variable];
							
							//Moyenne
							if ($select != "datas") $moyenne[$variable] = $moyenne[$variable] + $lastValue[$variable];
						}
						echo "</tr>";
						
						// Moyennes
						if ($compteurRowSpan == $nbRowSpan && $select != "datas"){
							$_SESSION['categories'][] = "Moyenne du jour";
							$_SESSION['heures'][] = "Moyenne du jour";
	
//							$_SESSION['nombreLignesMoyennes']++;
							echo "<tr class='tabListDataMoy'><td colspan=2>Moyenne du $data->Annee</td>";
							foreach($variables as $variable){
								$value = strtolower($variable . "_value");
								$header = getHeader($variable);
								$moy = round($moyenne[$variable] / $nbRowSpan);
								$_SESSION['series'][$header][] = $moy;
								echo "<td>" . traitementDecimal($variable, $moy). "</td>";
							}	
							
							//On vide la variable pour reinitialiser les moyennes
							unset($moyenne);
							
							echo "</tr>";
						} 
						
							
					} ?>
				</table>