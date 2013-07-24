<div id='intervention'>
	<!-- Retour de l'insertion qui vient du formulaire -->
	<div id='retour_insertion'>
		<?php
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			
			//Recuperation des variables
			$dateintervention 	= $_POST['dateIntervention'];
			$intervenant		= $_POST['intervenant'];
			$observation		= $_POST['observation'];
			
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
		$datetime = (!empty($_POST['datetime'])) ? $_POST['datetime'] : $_GET['datetime'];
	?>
		
	<!-- Creation du formulaire de l'intervention -->
	<form name='formInterventions' method="post" action="index.php?id_page=4">

		<a href='index.php?id_page=4&action=back&datetime=<?php echo getNextOrPrecDatetime($datetime, "back", $connexion);?>'><----&nbsp;&nbsp;</a>
	<select name='datetime' id='selectDatetime' onChange='this.form.submit()'>
	
	
		<?php
			
			$sql_select_interventions = generateInterventionsSQL();
			$query_select_interventions = $connexion->prepare($sql_select_interventions);
			$query_select_interventions->execute();
		
		
			echo "<option selected='selected'></option>";
				
			while($data=$query_select_interventions->fetch(PDO::FETCH_OBJ)){
				$option = "<option ";
				
				if ($data->datetime == $_POST['datetime']){
					$option .= "selected='selected'";
				}
				else if (!empty($_GET['datetime'])){
					if ($data->datetime == $_GET['datetime'])
						$option .= "selected='selected'";
				}
				
				$option .= "value='" .$data->datetime. "'>Le " .$data->Date. " par " .$data->intervenant. "</option>";
				echo $option;
			}
		?>
		</select>
		<a href='index.php?id_page=4&action=next&datetime=<?php echo getNextOrPrecDatetime($datetime, "next", $connexion);?>'>&nbsp;&nbsp;----></a>
	</form>
	
	<?php
	//echo "<br/>".$sql_select_interventions."</br>";
	
	if (!empty($_POST['datetime']))
		$sql_select_interventions = generateInterventionSQL($_POST['datetime']);
	else
		$sql_select_interventions = generateInterventionSQL($_GET['datetime']); 

	$query_select_interventions = $connexion->prepare($sql_select_interventions);
	$query_select_interventions->execute();
	$data = $query_select_interventions->fetch(PDO::FETCH_OBJ);
	$observation = $data->observation;	

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

