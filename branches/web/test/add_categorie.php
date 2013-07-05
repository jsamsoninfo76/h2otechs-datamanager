<?php

include('../include/include.php');

$categorie = $_GET['categorie'];

if (!empty($categorie)){
	$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
	
	$sql_insert_categorie = "INSERT INTO easycompta_categorie(categorie) VALUES('$categorie')";
	$query_insert_categorie = $connexion->prepare($sql_insert_categorie);
	$query_insert_categorie->execute();

	if ($query_insert_categorie)
		echo "Insertion effectué";
	else
		echo "Problème Insertion";
}
else
	echo "Usage : ?categorie=categorie";
?>