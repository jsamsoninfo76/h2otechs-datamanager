<?php

$dateintervention 	= $_POST['dateIntervention'];
$intervenant		= $_POST['intervenant'];
$observation		= $_POST['observation'];

if (!empty($dateintervention) && !empty($intervenant) && !empty($observation)){
	$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
	
	$sql_insert = generateInsertIntervention($dateintervention, $intervenant, $observation);
	$query_insert = $connexion->prepare($sql_insert);
	$query_insert->execute();

	if ($query_insert){
		echo "L'intervention &agrave; bien &eacute;t&eacute; ajout&eacute;.";
	}
	else
		echo "probleme insertion";
}
?>