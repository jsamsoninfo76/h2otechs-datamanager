<?php
//print_r($_SESSION);

//Recuperation des variables envoyées
$datedebut = (isset($_POST['datedebut'])) ? $_POST['datedebut'] : "";
$frequence = (isset($_POST['timeFrequence'])) ? $_POST['timeFrequence'] : "";

//Connexion à la base de données
$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);

//Recuperation des données
$sql_courbe = get1HourData($datedebut, $connexion);
if ($datedebut != "" && $frequence != ""){
	switch($frequence){
		case 1 : $sql_courbe = get1HourData($datedebut, $connexion); break;
		/*case 2 : $sql_courbe = get2HourData($datedebut, $connexion); break;
		case 6 : $sql_courbe = get6HourData($datedebut, $connexion); break;
		case 12 : $sql_courbe = get12HourData($datedebut, $connexion); break;
		case 24 : $sql_courbe = get24HourData($datedebut, $connexion); break;*/

	}
}

?>
<script type="text/javascript">
	$(function () {
        $('#container').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: <?php 
                	//Recupere le label en fonction de l'unité
                	foreach($_SESSION['unite'] as $unite){ $unite = getUniteLabel($unite);}
                	echo "'Courbe de $unite'"; 
                		
                ?>,
                x: -20 //center
            },
            subtitle: {
            	<?php
            		//Recupere la date de début et de fin
            		$subtitles = "text: 'Prelevement de l\'annee ";
            		/*$datePrecedente = "";
            			foreach($_SESSION['categories'] as $subtitle) {
            				$souschaine = substr($subtitle, 6, 4);
            				if ($datePrecedente != $souschaine){
            					$subtitles .= "$souschaine - ";
            					$datePrecedente = $souschaine;
            				}
            			}*/
            		$subtitles .= substr($_SESSION['categories'][0], 0, 4);
            		
            		$subtitles .= " du " .substr($_SESSION['categories'][0], 5, 5). " au " .substr($_SESSION['categories'][count($_SESSION['categories'])-1], 5, 5);
            		$subtitles .= "',";
            		echo $subtitles;
            	?>
                x: -20
            },
            xAxis: {
            	//Axe des abscisse 
                <?php
            		$categories = "categories: [";
            		foreach($_SESSION['categories'] as $categorie) 
            			$categories .= "'" .substr($categorie, 11, 2). "', ";
            		$categories = substr($categories, 0, count($subtitles)-3) . "]";
            		echo $categories;
            	?>
            },
            yAxis: {
            	//Axe des ordonnees
                title: {
                    text: <?php echo "'" .ucfirst($unite). " (" .$_SESSION['unite'][0]. ")'"; ?>
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: <?php echo "'" .$_SESSION['tooltip']. "'"; ?>
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [
            	<?php
            		$datas = "";
            		foreach($_SESSION['subtitles'] as $nom){
            			$datas .= "{";
	            		$datas .= "name: '" .$nom. "',";
	            		$datas .= "data: [";
	            		foreach($_SESSION['series'][$nom] as $data){
	            			$datas .= $data.", ";
	            		}
	            		$datas = substr($datas, 0, count($datas)-2);
	            		$datas .= "]";
	            		$datas .= "},";	
            		}
            		//$datas = substr($datas, 0, count($datas)-1);
            		echo $datas;
            	?>
            ]
        });
    });
</script>
<script src="include/utile/Highcharts/js/highcharts.js"></script>
<script src="include/utile/Highcharts/js/modules/exporting.js"></script>

<div id="formCourbesBlock">

	<form id="formCourbes" name="FormCourbes" method="post" onsubmit="return validerFormCourbes(this)">

		<!-- Titre -->
		<h5 title="Au moins une">*Quelle donn&eacute;es voulez vous r&eacute;cup&eacute;rer ?</h5> 
		
		<!-- Outil pour sélection global et préférenciel -->
		<div id="variables_tools">
			<input type="radio" name="tools" onClick="selectAll(this)"> Tout s&eacute;lectionner
			<input type="radio" name="tools" onClick="resetAll(this)"> Reset
		</div>
		
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
							echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .getLabel($data['label']) .'</td>';
							$numligne++;
						}
						else{
							//On écrit la value
							echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .getLabel($data['label']) .'</td>';	
						}
					}
				?>
			</tr>
			</table>
		</div>
	
		<div id="timeFrequenceBloc">
			<div id="timeFrequence_title"><h5>*Echelle : </h5></div>
			<select name="timeFrequence" onchange="validerFormCourbes(this);">
				<option value="1">1 heure</option>
				<option value="2">2 heures</option>
				<option value="6">6 heures</option>
				<option value="12">12 heures</option>
				<option value="24" selected="selected">24 heures</option>
			</select>
		</div>
		
		<!-- DateDébut Datetimepicker -->
		<div id="datetime_title"><h5>*Date de d&eacute;but : </h5><font class="message_error" id="datetime_courbes_error"></font></div>
		<div id="datetimepickerCourbe" class="input-append date">
		<img src="img/left-arrow.png">
			<input type="text" id="bouttonDate" name="datedebut" value="<?php echo $datedebut; ?>"></input>
		<img src="img/right-arrow.png">
	      <span class="add-on">
	        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
	      </span>
	    </div>
		 <!-- Ajout du javascript jquery-->
	    <script type="text/javascript">
	    	$('#datetimepickerCourbe').datetimepicker({ 
	    		format: 'yyyy/MM/dd hh:mm:ss'
	    	});
	    </script>
	
	    <input type="submit" value="Voir courbe">
	</form>
	
	<div id="container" style="min-width: 600px; height: 500px; margin: 0 auto"></div>

</div>

