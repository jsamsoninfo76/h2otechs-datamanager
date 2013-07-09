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

  		<script type="text/javascript" src="js/jquery.min.js"></script> 
  		<script type="text/javascript"  src="js/bootstrap.min.js"></script>

  		<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
  		<script type="text/javascript" src="js/functions.js"></script>

	</head>
	
	<body>
		<center>
		<h1>H2oTechs DataManager V1.0</h1>
		Bienvenue dans votre espace d'administration de base de donn&eacute;e.<br><br>
		</center>
		<?php
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			$sql_select_variables = "SELECT * FROM variables";
			$query_select_variables = $connexion->prepare($sql_select_variables);
			$query_select_variables->execute();
		?>
		
		<!-- Récupération des variables à sortir -->
		<form action="list_data.php" name="form" method="POST" onsubmit="return valider(this)">
		<div id="datas">
			<h5 title="Au moins une">*Quelle donn&eacute;es voulez vous r&eacute;cup&eacute;rer ?</h5> 
			<div id="datas_tools">
				<input type="checkbox" onClick="selectAll(this)">Tout selectionner<br>
				<input type="checkbox" onClick="selectPref(this)">Selectionner CFP<br><br>
			</div>
			<font id="data_checked_error" color="#FF6469"></font>
			<div id="datas_variables">
				<?php
					while($data=$query_select_variables->fetch(PDO::FETCH_ASSOC)){
						echo '<input type="checkbox" name="variables[]" value="data_' .$data['label']. '">' .$data['label'];
					}
				?>
			</div>
		</div>
			
		<!-- Récupération de date et d'heure -->
		<div id="datetimes">
			<h5>Date et heure de d&eacute;but et de fin ?</h5>
			<div id="datetime_title">*Date de d&eacute;but : <font id="datetime_debut_error" color="#FF6469"></font></div>
			<div id="datetimepickerDebut" class="input-append date">
			<input type="text" name="dateDebut"></input>
		      <span class="add-on">
		        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
		      </span>
		    </div>
		    <div id="datetime_title">*Date de fin : <font id="datetime_fin_error" color="#FF6469"></font></div>
		    <div id="datetimepickerFin" class="input-append date">
		      <input type="text" name="dateFin"></input>
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
		
	</body>
</html>