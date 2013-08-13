<div id='list_planification'>
	<?php
	$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
	
	//Récupération des variables envoyées
	if (isset($_POST['datePlanification']) && (isset($_POST['frequence']) || isset($_POST['uptime'])) && isset($_POST['description'])){
		$date_create  = $_POST['datePlanification'];
		$frequence = (isset($_POST['frequence'])) ? $_POST['frequence'] : "";
		$uptime = (isset($_POST['uptime'])) ? $_POST['uptime'] : "";
		$description		= $_POST['description'];
		
		$resultat = insertPlanification($date_create, $frequence, $uptime, $description, $connexion);	
		
		echo "RESULTAT:".$resultat;
		
		if ($resultat)
			echo "<font class='message_info'>La planification &agrave; bien &eacute;t&eacute; ajout&eacute;.</font>";
		else
			echo "<font class='message_error'>Probleme lors de l'insertion de la planification</font>";
	}
	
	//Tache à effectuer maintenant
	$sql_uptime_today = getUptimePlanification($connexion);
	echo $sql_uptime_today;
	
	/*
	$query_uptime_today = $connexion->prepare($sql_uptime_today);
	$query_uptime_today->execute();
	$count = $query_uptime_today->rowcount();
	
	if ($count > 0){
		echo "<h5> T&acirc;che &agrave; effectuer aujourd'hui : </h5>";
		echo "<div id='planificationsToday'>";
			echo "<ul class='taches'>";
			while($data = $query_planifications_today->fetch(PDO::FETCH_OBJ)){
				echo "<li>";
					echo "<u>" .$data->description. "</u> &agrave; faire " . getFrequence($data->frequence);
				echo "</li>";
			}
			echo "</ul>";		
		echo "</div>";
	}
	
	//Tache à effectuer plus tard
	$sql_planifications_later = getlaterPlanifications($connexion);
	echo $sql_planifications_later;
	$query_planifications_later = $connexion->prepare($sql_planifications_later);
	$query_planifications_later->execute();
	$count = $query_planifications_later->rowcount();
	
	if ($count > 0){
		echo "<h5> T&acirc;che &agrave; venir : </h5>";
		echo "<div id='planificationslater'>";
			echo "<ul class='taches'>";
			while($data = $query_planifications_later->fetch(PDO::FETCH_OBJ)){
				echo "<li>";
					echo "<u>" .$data->description. "</u> &agrave; faire " . getFrequence($data->frequence);
				echo "</li>";
			}
			echo "</ul>";		
		echo "</div>";
	}*/
	
	?>
	
	
	
	
	
</div>