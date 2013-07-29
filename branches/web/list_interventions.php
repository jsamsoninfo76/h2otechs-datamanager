<?php
/**
 * list_interventions.php
 *
 * Liste toutes les interventions avec un select en onclick:submit et un champ textarea pour afficher l'observation
 * Possibilité de modifier l'observation 
 * Inclut l'ajout d'intervention
 *
 */
?>

<div id='intervention'>
	<!-- Retour de l'insertion qui vient du formulaire -->
	<div id='retour_insertion'>
		<?php
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			
			print_r($_GET);
			
			//Recuperation des variables
			if (isset($_POST['dateIntervention'])) $dateintervention= $_POST['dateIntervention'];
			if (isset($_POST['intervenant'])) $intervenant			= $_POST['intervenant'];
			if (isset($_POST['observation'])) $observation			= $_POST['observation'];
			if (isset($_POST['id_intervention'])) $id_intervention  = $_POST['id_intervention'];
			
			//Test sur les variables
			if (!empty($id_intervention) && !empty($observation)){
				$sql_update = generateUpdateIntervention($id_intervention, $observation);
				$query_update = $connexion->prepare($sql_update);
				$query_update->execute();
			}
			else if (!empty($dateintervention) && !empty($intervenant) && !empty($observation)){
				//Préparation de la requete SQL
				$sql_insert = generateInsertIntervention($dateintervention, $intervenant, $observation);
				$query_insert = $connexion->prepare($sql_insert);
				$query_insert->execute();
			
				//Affichage retour insertion
				if ($query_insert){
					echo "<font class='message_info'>L'intervention &agrave; bien &eacute;t&eacute; ajout&eacute;.</font>";
				}
				else
					echo "<font class='message_error'>Probleme lors de l'insertion de l'intervention</font>";
				echo "<br/><br/>";
			}
		?>
	</div>
	
	<?php
		//Déclaration de $datetime pour éviter les php_notices
		if (isset($_POST['datetime']) || isset($_GET['datetime'])) 
			$datetime = (!empty($_POST['datetime'])) ? $_POST['datetime'] : $_GET['datetime'];
		else
			$datetime = "";
		
	?>
	
	<!-- Creation du formulaire de l'intervention -->
	<form name='formInterventions' method="post" action="index.php?id_page=4">
		<div id='intervention_title'><h5>Date et Intervenant :</h5></div>
		<a href='index.php?id_page=4&action=back&datetime=<?php echo getNextOrPrecDatetime($datetime, "back", $connexion);?>'><----&nbsp;&nbsp;</a>
		
	<select name='datetime' id='selectDatetime' onChange='this.form.submit()'>
		<?php
			//Création du select dynamique
			$sql_select_interventions = generateInterventionsSQL();
			$query_select_interventions = $connexion->prepare($sql_select_interventions);
			$query_select_interventions->execute();
			$moisPrecedent = "";
		
			echo "<option selected='selected'>Aucune selection</option>";
				
			while($data=$query_select_interventions->fetch(PDO::FETCH_OBJ)){
				$annee = substr($data->datetime, 0, 4);
				$mois  = substr($data->datetime, 5, 2);
				$date   = DateTime::createFromFormat('Y-m-d', $data->datetime);
				$jourFR = $date->format('D');
				$jourFR = getFrFormatJour($jourFR);
				$moisFR = $date->format('M');
				$moisFR = getFrFormatMois($moisFR);
				$jour   = substr($data->datetime, 8, 2);
				
				if ($moisPrecedent != $mois){
					if ($moisPrecedent != "") 
						echo "</optgroup>";
					
					echo "<optgroup label='$moisFR $annee'>";
					$moisPrecedent = $mois;
				}

				$option = "<option ";				
				if (isset($_POST['datetime'])){
					if ($data->datetime == $_POST['datetime'])
						$option .= "selected='selected'";
				}
				else if (isset($_GET['datetime'])){
					if (!empty($_GET['datetime'])){
						if ($data->datetime == $_GET['datetime'])
							$option .= "selected='selected'";
					}
				}

				//$option .= "value='" .$data->datetime. "'>Le " .$data->Date. " par " .$data->intervenant. "</option>";
				$option .= "value='" .$data->datetime. "'>Le " .$jourFR." " .$jour. " " .$moisFR. " par " . $data->intervenant . "</option>";
				echo $option;
			}
		?>
		</select>
		<a href='index.php?id_page=4&action=next&datetime=<?php echo getNextOrPrecDatetime($datetime, "next", $connexion);?>'>&nbsp;&nbsp;----></a>
	
		<?php
			//Déclaration du datetime pour éviter le php_notices
			if (isset($_POST['datetime']) && !empty($_POST['datetime'])) $datetime = $_POST['datetime'];
			else if (isset($_GET['datetime']) && !empty($_GET['datetime'])) $datetime = $_GET['datetime'];
			else $datetime = "";
			
			//Récupération de l'intervention selectionné ou passer en paramètre
			$sql_select_intervention = generateInterventionSQL($datetime); 
			$query_select_intervention = $connexion->prepare($sql_select_intervention);
			$query_select_intervention->execute();
			$data = $query_select_intervention->fetch(PDO::FETCH_ASSOC);
			$observation = $data['observation'];	
			
			echo "<input type='hidden' name='id_intervention' value='" .$data['id_intervention']. "'>";
		?>
	
		<div class="observationBlock">
			<h5>Observation :</h5>		
			<textarea id="observation" name="observation" rows="10" cols="50"><?php echo $observation; ?></textarea>
		</div>
		
		<input type="submit" value="Modifier">
	
		<script type="text/javascript">
			$(document).ready(function() {
			  $('#observation').elastic();
			});
		</script>
	</form>
</div>

