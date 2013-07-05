<?php

include('../include/include.php');

$user = $_GET['user'];
$password = $_GET['password'];
$password = md5($password);

if (!empty($user) || !empty($password)){
	$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
	
	$sql_insert_user = "INSERT INTO easycompta_user(user,password) VALUES('$user','$password')";
	$query_insert_user = $connexion->prepare($sql_insert_user);
	$query_insert_user->execute();

	if ($query_insert_user)
		echo "Insertion effectué";
	else
		echo "Problème Insertion";
}
else
	echo "Usage : ?user=user&password=password";
?>