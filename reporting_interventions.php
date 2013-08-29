<div id="formReportingInterventions">
	<h4>Exportation des interventions</h4>

<?php
$choix = $_POST['choix'];

if (isset($_POST['dateDebutReportingIntervention']) && isset($_POST['dateFinReportingIntervention']) && $choix != ""){
	$_SESSION['choix'] = $choix;
	unset($_SESSION['dateDebutReportingIntervention']);
	unset($_SESSION['dateFinReportingIntervention']);
	
	$datedebut = $_POST['dateDebutReportingIntervention'];
	$datefin   = $_POST['dateFinReportingIntervention'];
	$path = "upload/interventions";
	
	if ($datedebut != "" && $datefin != "" && $choix != "Tous"){
		$_SESSION['dateDebutReportingIntervention'] = $datedebut;
		$_SESSION['dateFinReportingIntervention'] = $datefin;
		
		$datedebut_url = substr($datedebut, 0, 10);
		$datedebut_url = str_replace("/","-",$datedebut_url);
		$datefin_url = substr($datefin, 0, 10);
		$datefin_url = str_replace("/", "-", $datefin_url);
		
		$filename = $datedebut_url. "_au_" .$datefin_url. "_Interventions_Enki" .$config['enki']. ".txt";
	}else{
		$filename = "Interventions_Enki" .$config['enki']. ".txt";
	}
	
	$sql_select_interventions = getInterventions($datedebut, $datefin);
	$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
	$query_select_interventions = $connexion->prepare($sql_select_interventions);
	$query_select_interventions->execute();
	$rowcount = $query_select_interventions->rowcount();

	if ($rowcount > 0){
		$pathToFile = $path."/".$filename;
		$monfichier = fopen($pathToFile, 'a+');
		 
		ftruncate($monfichier, 0); // On vide le fichier
		fseek($monfichier, 0); // On remet le curseur au début du fichier				
		
		while($data=$query_select_interventions->fetch(PDO::FETCH_OBJ)){
			fputs($monfichier,  utf8_encode("Intervenant: " . $data->intervenant ."\n"));
			fputs($monfichier,  utf8_encode("Date: " . $data->datetime ."\n"));
			fputs($monfichier,  utf8_encode("Observation:\n"));
			fputs($monfichier,  utf8_encode($data->observation));
			fputs($monfichier,  "\n\n");
		}
		 
		fclose($monfichier);
		
		//echo '<br/><a href="' .$path. '/' .$filename. '">Cliquez ici si le t&eacute;l&eacute;chargement ne commence pas</a>';
		echo '<br/><a href="downloadfile.php?dir=interventions&filename=' .$filename. '">Cliquez ici si le t&eacute;l&eacute;chargement ne commence pas</a>';
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=downloadfile.php?dir=interventions&filename=$filename'>";
	}else{
		echo "<font class='message_error'>Il n'y a aucune interventions pour ces dates.</font>";
	}
}

include("form_reporting_interventions.php");
?>