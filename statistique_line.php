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
	    //echo $e->getMessage();
	    exit(1);
	}
}

$variables = $_SESSION['variables'];
$datedebut = $_SESSION['datedebut'];
$frequence = $_SESSION['frequence'];

//Connexion à la base de données
$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);

//Recuperation des données
$_SESSION['subtitles'] = null;
$_SESSION['categories'] = null;
$_SESSION['series'] = null;
$_SESSION['unite'] = null;

if ($datedebut != "" && $frequence != "" && $variables != ""){
	$sql_select_data = getDataCourbe($datedebut, $frequence, $variables, $connexion);	
	//echo $sql_select_data."<br/><br/>";
	$query_select_data = $connexion->prepare($sql_select_data);
	$query_select_data->execute();
	$rowCount = $query_select_data->rowcount();
	
	if ($rowCount > 0){
		foreach($variables as $variable){
			$variable = getHeader($variable);
			$_SESSION['subtitles'][] = $variable;
			$lastValue[$variable] = "";
			$_SESSION['unite'][] = getUnite($variable, $connexion);
		}
		
		while($data=$query_select_data->fetch(PDO::FETCH_OBJ)){
			$datetime = $data->datetime;
			$_SESSION['categories'][] = $datetime;							
			
			foreach($variables as $variable){ 
				//Mise en lower du data_label_value
				$value = strtolower($variable . "_value");
				$header = getHeader($variable);
				
				//Si la value est vide
				if ($data->$value == ""){
					//Si la dernière valeur est aussi vide
					if ($lastValue[$variable] == "")
						$lastValue[$variable] = getLastValue($variable, $datedebut, $connexion);
				}
				else 
					$lastValue[$variable] = $data->$value;
				
				$_SESSION['series'][$header][] = traitementDecimal($variable, $lastValue[$variable]);
			}
		} 
	}
	else{
		?>
		<font class="message_error" id="countRow">Il n\'y a aucune donn&eacute;es pour cette &eacute;chelle et date de d&eacute;but.</font>
		
		<?php
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
            		$annee	    = substr($_SESSION['categories'][0], 0, 4); 	//Recuperation année
            		$subtitles  = "text: 'Prelevement de l\'annee $annee";
            		$moisDebut  = substr($_SESSION['categories'][0], 5, 5);		//Recuperation mois de debut
            		$subtitles .= " du $moisDebut";
            		$heureDebut = substr($_SESSION['categories'][0], 11, 2); 	//Recuperation heure de debut
            		$subtitles .= " a " .$heureDebut. "h";
            		$moisFin	= substr($_SESSION['categories'][count($_SESSION['categories'])-1], 5, 5); //Recuperation mois de fin
            		$subtitles .= " au $moisFin";
            		$heureFin = substr($_SESSION['categories'][count($_SESSION['categories'])-1], 11, 2); //Recuperation heure de debut
            		$subtitles .= " a " .$heureFin. "h";
            		$subtitles .= "',";
            		echo $subtitles;
            	?>
                x: -20
            },
            xAxis: {
            	//Axe des abscisse 
                <?php
            		$categories = "categories: [";
            		foreach($_SESSION['categories'] as $datetime) {
            			$heure = substr($datetime, 11, 5);
            			$categories .= "'" .$heure. "', ";
            		}
            		if (strlen($categories) != 13)
	            		$categories = substr($categories, 0, count($subtitles)-3);
	            	$categories .= "]";
	            		
            		echo $categories ;
            	?>
            },
            yAxis: {
            	//Axe des ordonnees
                title: {
                    text: <?php echo "'" .ucfirst($unite). " (" . (($_SESSION['unite'][0] == "pourcent") ? "%" : $_SESSION['unite'][0]). ")'"; ?>
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: <?php echo "' " .$_SESSION['unite'][0]. "'"; ?>
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
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
            		//			echo traitementDecimal($variable, $lastValue[$variable]);
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

	<form id="formCourbes" name="formCourbes" method="post" onsubmit="return validerFormCourbes(0)">	
		<div id="timeFrequenceBloc">
			<table>
				<tr>
					<td class="tdstatistique"><div id="timeFrequence_title"><h5>*&Eacute;chelle : </h5></div></td>
					<td class="tdstatistique"><div id="datetime_title"><h5>*Date de d&eacute;but : </h5><font class="message_error" id="datetime_courbes_error"></font></div></td>
				</tr>
				<tr>
					<td class="tdstatistique">
						<select name="timeFrequence" onchange="validerFormCourbes(1);">
							<option value="1" <?php echo ("1" == $frequence) ? "selected=selected" : ""; ?>>1 heure</option>
							<option value="2" <?php echo ("2" == $frequence) ? "selected=selected" : ""; ?>>2 heures</option>
							<option value="6" <?php echo ("6" == $frequence) ? "selected=selected" : ""; ?>>6 heures</option>
							<option value="12" <?php echo ("12" == $frequence) ? "selected=selected" : ""; ?>>12 heures</option>
							<option value="24" <?php echo ("24" == $frequence) ? "selected=selected" : ""; ?>>24 heures</option>
						</select>
					</td>
					<td class="tdstatistique">
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
					</td>
				</tr>
			</table>
		</div>
	    
	    <?php 
		    //On affiche seuelemnt si il y a des données
		   echo '<div id="container" style="display: none; min-width: 600px; height: 500px; margin: 0 auto"></div>';
	    ?>
	    
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
			<input type="submit" value="Voir courbe">
		</div>
	</form>
	
	
</div> 