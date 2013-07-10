<!-- 
@autor Jérémie Samson
@version 1

Site :
http://stackoverflow.com/questions/386281/how-to-implement-select-all-check-box-in-html (checkboxes)
http://www.tizag.com/javascriptT/javascript-string-compare.php (compare strings)
http://tarruda.github.io/bootstrap-datetimepicker/ (datetimepicker)
http://openweb.eu.org/articles/validation_formulaire (validation form)
-->

<?php
	include("include/include.php");
?>

<html>
	<head>
		<title>H2otechs DataManager</title>
		<link rel="stylesheet" href="css/bootstrap-combined.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-datetimepicker.min.css">
		<link rel="stylesheet" href="css/style.css">
  		<script type="text/javascript"  src="js/bootstrap.min.js"></script>
  		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
  		<script type="text/javascript" src="js/functions.js"></script>
	</head>
	
	<body>	
		<?php include("header.html"); ?>
		
		<!-- Récupération des variables à sortir -->
		<div id="corp">
			<form action="list_data.php" name="form" method="POST" onsubmit="return valider(this)">
			<div id="variables">
				<!-- Titre -->
				<h5 title="Au moins une">*Quelle donn&eacute;es voulez vous r&eacute;cup&eacute;rer ?</h5> 
				
				<!-- Outil pour sélection global et préférenciel -->
				<div id="variables_tools">
					<input type="radio" name="tools" onClick="selectAll(this)"> Tout s&eacute;lectionner<br>
					<input type="radio" name="tools" onClick="selectPref(this)"> S&eacute;lectionner CFP<br><br>
				</div>
				
				<!-- Affichage erreur sur sélection -->
				<font id="variables_checked_error"></font>
				
				<!-- Tableau des variables -->
				<div id="variables_header">
					<table id="tabVariables" cellpadding="5">
						<?php
							$unite = "";
							$compteurPair = 1;
							
							//Recupération des données de variable
							$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
							$sql_select_variables = "SELECT * FROM variables";
							$query_select_variables = $connexion->prepare($sql_select_variables);
							$query_select_variables->execute();
			
							//Tant qu'il y a des données
							while($data=$query_select_variables->fetch(PDO::FETCH_ASSOC)){
								//Pair ou impaire Pour background sur la ligne
								$trColor = ($compteurPair%2) ?  "id='ligne_impair'" : "id='ligne_pair'";
								
								//La donnée est une unité
								if ($data['unite'] != $unite) {
									//Incrémentation du compteur
									$compteurPair++;
									if ($unite != "") echo "</tr>"; //Si l'unite est vide (première data)
									echo "<tr $trColor>";
	
									//Verification sur l'exposant pour <sup>
									$unite = verifExposant($data['unite']);
									
									//On écrit l'unité puis la première value
									echo '<td id="tabVariablesHeader"><center>'.$unite.'</center></td>';
									echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .$data['label'] .'</td>';
								}
								else{
									//On écrit la value
									echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .$data['label'] .'</td>';	
								}
							}
						?>
					</tr>
					</table>
				</div>
			</div>
		
			<!-- Récupération de date et d'heure -->
			<div id="datetimes">
				<!-- Titre global -->
				<h5>Date et heure de d&eacute;but et de fin ?</h5>
				
				<!-- Titre Date de début-->
				<div id="datetime_title">*Date de d&eacute;but : <font id="datetime_debut_error"></font></div>
				
				<!-- DateDébut Datetimepicker -->
				<div id="datetimepickerDebut" class="input-append date">
				<input type="text" id="bouttonDate" name="dateDebut"></input>
			      <span class="add-on">
			        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
			      </span>
			    </div>
			    
			    <!-- Titre Date de fin -->
			    <div id="datetime_title">*Date de fin : <font id="datetime_fin_error"></font></div>
			    
			    <!-- DateFin Datetimepicker-->
			    <div id="datetimepickerFin" class="input-append date">
			      <input type="text" id="bouttonDate" name="dateFin"></input>
			      <span class="add-on">
			        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
			      </span>
			    </div>
		    </div>
		    
		    <!-- Ajout du javascript jquery-->
		    <script type="text/javascript">
		    	$('#datetimepickerDebut').datetimepicker({ format: 'yyyy/MM/dd hh:mm:ss' });
		        $('#datetimepickerFin').datetimepicker({ format: 'yyyy/MM/dd hh:mm:ss' });
		    </script>
		    
		    <!-- Envoie du formulaire -->
		    <br><br><input type="submit" value="Envoyer">
			</form>
		</div>
		<?php include("footer.html"); ?>
	</body>
</html>