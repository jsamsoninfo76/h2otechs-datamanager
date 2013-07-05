<?php

include('../include/include.php');

$cout = $_GET['cout'];
$description = $_GET['description'];
$id_categorie= $_GET['id_categorie'];

$cout=99;
$description="test2";
$id_categorie=1;
if (!empty($cout) || !empty($description) || !empty($id_categorie)){
	$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
	
	$sql_insert_depense = "INSERT INTO easycompta_depense(cout,id_categorie, description) VALUES('$cout',$id_categorie, '$description')";
	$query_insert_depense = $connexion->prepare($sql_insert_depense);
	$query_insert_depense->execute();

	if ($query_insert_depense)
		echo "Insertion effectué";
	else
		echo "Problème Insertion";
}
else
	echo "Usage : ?cout=cout&description=description&id_categorie=id_categorie";
?>