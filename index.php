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

  		<script type="text/javascript" src="js/jquery.min.js"></script> 
  		<script type="text/javascript"  src="js/bootstrap.min.js"></script>
  		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
  		<script type="text/javascript" src="js/functions.js"></script>

	</head>
	
	<body>	
		<?php
			include("header.html");
			
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			$sql_select_variables = "SELECT * FROM variables";
			$query_select_variables = $connexion->prepare($sql_select_variables);
			$query_select_variables->execute();
		?>
		
		<!-- Récupération des variables à sortir -->
		<div id="corp">
			<form action="list_data.php" name="form" method="POST" onsubmit="return valider(this)">
			<div id="variables">
				<h5 title="Au moins une">*Quelle donn&eacute;es voulez vous r&eacute;cup&eacute;rer ?</h5> 
				<div id="variables_tools">
					<input type="radio" name="tools" onClick="selectAll(this)"> Tout s&eacute;lectionner<br>
					<input type="radio" name="tools" onClick="selectPref(this)"> S&eacute;lectionner CFP<br><br>
				</div>
				<font id="variables_checked_error"></font>
				<div id="variables_header">
					<table id="tabVariables" cellpadding="5">
						<?php
							//Creation du tableau de variables
							$unite = "";
							$pair = 1;
							while($data=$query_select_variables->fetch(PDO::FETCH_ASSOC)){
								$trColor = ($pair%2) ?  "id='ligne_impair'" : "id='ligne_pair'";
								if ($data['unite'] != $unite) {
									$pair++;
									if ($unite == "") echo "<tr $trColor>";
									else echo "</tr><tr $trColor>";
	
									$unite = verifExposant($data['unite']);
									echo '<td id="tabVariablesHeader"><center>'.$unite.'</center></td>';
									echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .$data['label'] .'</td>';
								}
								else
									echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .$data['label'] .'</td>';	
							}
						?>
					</tr>
					</table>
				</div>
			</div>
		
			<!-- Récupération de date et d'heure -->
			<div id="datetimes">
				<h5>Date et heure de d&eacute;but et de fin ?</h5>
				<div id="datetime_title">*Date de d&eacute;but : <font id="datetime_debut_error"></font></div>
				<div id="datetimepickerDebut" class="input-append date">
				<input type="text" id="bouttonDate" name="dateDebut"></input>
			      <span class="add-on">
			        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
			      </span>
			    </div>
			    <div id="datetime_title">*Date de fin : <font id="datetime_fin_error"></font></div>
			    <div id="datetimepickerFin" class="input-append date">
			      <input type="text" id="bouttonDate" name="dateFin"></input>
			      <span class="add-on">
			        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
			      </span>
			    </div>
		    </div>
		    <script type="text/javascript">
		    	$('#datetimepickerDebut').datetimepicker({ format: 'yyyy/MM/dd hh:mm:ss' });
		        $('#datetimepickerFin').datetimepicker({ format: 'yyyy/MM/dd hh:mm:ss' });
		    </script>
		    
		    <br><br><input type="submit" value="Envoyer">
			</form>
		</div>
		<?php include("footer.html"); ?>
	</body>
</html>