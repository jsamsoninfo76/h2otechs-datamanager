<div id='intervention'>
	<!-- Retour de l'insertion qui vient du formulaire -->
	<div id='retour_insertion'>
		<?php
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			
			//Recuperation des variables
			if (isset($_POST['dateIntervention'])) $dateintervention= $_POST['dateIntervention'];
			if (isset($_POST['intervenant'])) $intervenant			= $_POST['intervenant'];
			if (isset($_POST['observation'])) $observation			= $_POST['observation'];
			
			//Test sur les variables
			if (!empty($dateintervention) && !empty($intervenant) && !empty($observation)){
				
				//Préparation de la requete SQL
				$sql_insert = generateInsertIntervention($dateintervention, $intervenant, $observation);
				$query_insert = $connexion->prepare($sql_insert);
				$query_insert->execute();
			
				//Affichage retour insertion
				if ($query_insert){
					echo "<font class='message_info'>L'intervention &agrave; bien &eacute;t&eacute; ajout&eacute;.</font>";
				}
				else
					echo "<font class='message_error'>probleme insertion</font>";
				echo "<br/><br/>";
			}
		?>
	</div>
	
	<!-- Creation du bouton back et next -->
	<?php
		if (isset($_POST['datetime'])) $datetime = (!empty($_POST['datetime'])) ? $_POST['datetime'] : $_GET['datetime'];
		else $datetime = "";
	?>
	
	<!-- Creation du formulaire de l'intervention -->
	<form name='formInterventions' method="post" action="index.php?id_page=4">
		<div id='intervention_title'><h5>Date et Intervenant :</h5></div>
		<a href='index.php?id_page=4&action=back&datetime=<?php echo getNextOrPrecDatetime($datetime, "back", $connexion);?>'><----&nbsp;&nbsp;</a>
	<select name='datetime' id='selectDatetime' onChange='this.form.submit()'>
		<?php
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
	</form>
	
	<?php
	//echo "<br/>".$sql_select_interventions."</br>";
	
	
	if (isset($_POST['datetime']) && !empty($_POST['datetime'])) $datetime = $_POST['datetime'];
	else if (isset($_GET['datetime']) && !empty($_GET['datetime'])) $datetime = $_GET['datetime'];
	else $datetime = "";
	
	$sql_select_interventions = generateInterventionSQL($datetime); 
	$query_select_interventions = $connexion->prepare($sql_select_interventions);
	$query_select_interventions->execute();
	$data = $query_select_interventions->fetch(PDO::FETCH_ASSOC);
	$observation = $data['observation'];	

	?>

	<div class="observationBlock">
		<h5>Observation :</h5>		
		<textarea id="observation" rows="10" cols="50"><?php echo $observation; ?></textarea>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
		  $('#observation').elastic();
		});
	</script>
</div>

