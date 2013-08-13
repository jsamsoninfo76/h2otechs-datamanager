<?php
/**
 * Liens 
 * http://www.php.net/manual/fr/class.dateinterval.php 
 * http://php.net/manual/fr/function.date.php
 */
 
//Recuperation des variables envoyées
$_SESSION['variables'] = (isset($_POST['variables'])) ? $_POST['variables'] : $_SESSION['variables'];
$_SESSION['datedebut'] = (isset($_POST['datedebut'])) ? $_POST['datedebut'] : $_SESSION['datedebut'];
$_SESSION['frequence'] = (isset($_POST['timeFrequence'])) ? $_POST['timeFrequence'] : $_SESSION['frequence'];

//Traitement action next et back (clik sur flèche datetime)
if (isset($_GET['action']) && isset($_SESSION['datedebut']) && isset($_SESSION['frequence'])){

	try {
		$date = new DateTime($_SESSION['datedebut']);
		$secondes = $_SESSION['frequence'] * 60 * 60;
		if ($_GET['action'] == "next")	$date->add(new DateInterval('PT'.$secondes.'S'));
		else if ($_GET['action'] == "back")  $date->sub(new DateInterval('PT'.$secondes.'S'));
		$_SESSION['datedebut'] = $date->format('Y/m/d H:i:s');
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit(1);
	}
}

$variables = $_SESSION['variables'];
$datedebut = $_SESSION['datedebut'];
$frequence = $_SESSION['frequence'];

//print_r($_SESSION);

//Connexion à la base de données
$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);

//Recuperation des données

if ($datedebut != "" && $frequence != "" && $variables != ""){
	echo getDataCourbe($datedebut, $frequence, $variables, $connexion);	
}

?>

<div id="formCourbesBlock">

	<form id="formCourbes" name="formCourbes" method="post" onsubmit="validerFormCourbes(0)">

		<!-- Titre -->
		<h5 title="Au moins une">*Quelle donn&eacute;es voulez vous r&eacute;cup&eacute;rer ?</h5> 
				
		<!-- Affichage erreur sur sélection -->
		<font  class="message_error" id="variables_checked_error"></font>
		
		<!-- Tableau des variables -->
		<div id="variables_header">
			<table id="tabVariables" cellpadding="5">
				<?php
					$unite = "";
					$compteurPair = 1;
					$numligne = 0;
					
					//Recupération des données de variable
					$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
					$sql_select_variables = "SELECT * FROM variables ORDER BY unite ASC";
					$query_select_variables = $connexion->prepare($sql_select_variables);
					$query_select_variables->execute();
	
					//Tant qu'il y a des données
					while($data=$query_select_variables->fetch(PDO::FETCH_ASSOC)){
						//Pair ou impaire Pour background sur la ligne
						$trColor = ($compteurPair%2) ?  "class'ligne_impair'" : "class='ligne_pair'";
						
						//La donnée est une unité
						if ($data['unite'] != $unite) {
							//Incrémentation du compteur
							$compteurPair++;
							if ($unite != "") echo "</tr>"; //Si l'unite est vide (première data)
							echo "<tr $trColor>";

							$unite = $data['unite'];
							
							//On écrit l'unité puis la première value
							echo '<td><input type="radio" name="tools" onClick="select_' .$unite. '(this)"></td>';
							echo '<td id="tabVariablesHeader"><center>'.verifExposant($unite).'</center></td>';
							$variable = 'data_' .$data['label'];
							$variable = 'data_' .$data['label'];
							echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="' .$variable. '" '.( (in_array($variable, $variables)) ? "checked" : "").'>&nbsp;&nbsp;' .getLabel($data['label']) .'</td>';
							$numligne++;
						}
						else{
							//On écrit la value
							$variable = 'data_' .$data['label'];
							echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="' .$variable. '" '.( (in_array($variable, $variables)) ? "checked" : "").'>&nbsp;&nbsp;' .getLabel($data['label']) .'</td>';
						}
					}
				?>
			</tr>
			</table>
		</div>
	
		<div id="timeFrequenceBloc">
			<div id="timeFrequence_title"><h5>*Echelle : </h5></div>
			<select name="timeFrequence" onchange="validerFormCourbes(1);">
				<option value="1" <?php echo ("1" == $frequence) ? "selected=selected" : ""; ?>>1 heure</option>
				<option value="2" <?php echo ("2" == $frequence) ? "selected=selected" : ""; ?>>2 heures</option>
				<option value="6" <?php echo ("6" == $frequence) ? "selected=selected" : ""; ?>>6 heures</option>
				<option value="12" <?php echo ("12" == $frequence) ? "selected=selected" : ""; ?>>12 heures</option>
				<option value="24" <?php echo ("24" == $frequence) ? "selected=selected" : ""; ?>>24 heures</option>
			</select>
		</div>
		
		<!-- DateDébut Datetimepicker -->
		<div id="datetime_title"><h5>*Date de d&eacute;but : </h5><font class="message_error" id="datetime_courbes_error"></font></div>
		<div id="datetimepickerCourbe" class="input-append date">
		<a href="index.php?id_page=5&action=back"><img src="img/left-arrow.png">&nbsp;&nbsp;</a>
			<input type="text" id="bouttonDate" name="datedebut" value="<?php echo $datedebut; ?>"></input>
	      <span class="add-on">
	        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
	      </span>
	    <a href="index.php?id_page=5&action=next">&nbsp;&nbsp;<img src="img/right-arrow.png"></a>
	    </div>
		 <!-- Ajout du javascript jquery-->
	    <script type="text/javascript">
	    	$('#datetimepickerCourbe').datetimepicker({ 
	    		format: 'yyyy/MM/dd hh:mm:ss'
	    	});
	    </script>
	
	    <input type="submit" value="Voir courbe">
	</form>
	
	<!-- <div id="container" style="min-width: 600px; height: 500px; margin: 0 auto"></div> -->

</div>

