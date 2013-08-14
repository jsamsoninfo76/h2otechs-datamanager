<?php
/**
 * Récupère les datas en fonctio nde la frequence
 *
 * Liens
 * http://www.w3resource.com/mysql/mathematical-functions/mysql-mod-function.php (Modulo)
 */
function getDataCourbe($datedebut, $frequence, $variables, $connexion){
	$variables[0] = strtolower($variables[0]);
	
	$sql_select = "SELECT $variables[0].datetime, DATE_FORMAT($variables[0].datetime, '%d/%m/%Y') AS Annee, DATE_FORMAT($variables[0].datetime, '%H')  AS Heure, ";
	for($i=0 ; $i < count($variables) ; $i++){
		$variables[$i] = strtolower($variables[$i]);
		if ($i == count($variables) -1) $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value";
		else $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value ,";
	}
	
	$sql_select .= " FROM " .$variables[0]. " ";		
	for($i=1 ; $i < count($variables) ; $i++){
		$sql_select .= " LEFT JOIN " .$variables[$i]. " ON " .$variables[$i].".datetime = " .$variables[0]. ".datetime ";
		$sql_select .= " AND $variables[$i].state = 1";
	}
	
	$sql_select .= " WHERE $variables[0].datetime BETWEEN '$datedebut' AND DATE_ADD('$datedebut', INTERVAL $frequence HOUR)";
	
	switch ($frequence){
		case 1 : $modulo = 5; break; 	//Données toutes les 2 minutes 	-> 30 Données
		case 2 : $modulo = 5; break;	//Données toutes les 5 minutes	-> 24 Données
		case 6 : $modulo = 15; break;	//Données toutes les 15 minutes -> 24 Données
		case 12 : $modulo = 30; break;	//Données toutes les 30 minutes	-> 24 Données
		default : $modulo = 0; break; 	//Données toutes les heures		-> 24 Données
	}
	
	//SQL Simple
	$query_test = $connexion->prepare($sql_select);
	$query_test->execute();
	$count_simple = $query_test->rowcount();
	echo $sql_select;
	$sql_select_params = $sql_select;
	//VOIR POUR MODIFIER SELECTION SUR 24H
	if ($modulo == 0) $sql_select_params .= " GROUP BY HOUR($variables[0].datetime)";
	else {
		$sql_select_param_mod = $sql_select . " AND MOD(MINUTE($variables[0].datetime), $modulo) = 0";
		$sql_select_param_groupby = $sql_select . " GROUP BY MINUTE($variables[0].datetime)";
		$sql_select_params .= " AND MOD(MINUTE($variables[0].datetime), $modulo) = 0 GROUP BY MINUTE($variables[0].datetime)";
	}
	
	//Group by
	if (isset($sql_select_param_groupby)){
		$query_test = $connexion->prepare($sql_select_param_groupby);
		$query_test->execute();
		$count_groupby = $query_test->rowcount();
	}
	
	//Mod
	if (isset($sql_select_param_mod)){
		$query_test = $connexion->prepare($sql_select_param_mod);
		$query_test->execute();
		$count_mod = $query_test->rowcount();
	}
	
	//Group by et Mod
	$query_test = $connexion->prepare($sql_select_params);
	$query_test->execute();
	$count_params = $query_test->rowcount();

	echo "SIMPLE:$count_simple, PARAMS:$count_params, GROUPBY:$count_groupby, MOD:$count_mod</br>";	
	
	//Triage du tableau et recuperation du parametre le plus grand et <= 30 
	$tri = array($count_simple, $count_params, $count_groupby, $count_mod);
	sort($tri);
	
	$return = 0;
	for($i=0 ; $i < count($tri) ; $i++){
		$value = $tri[$i];
		if ($value <= 30 && $value > $return) {
			$return = $value;
			$index = $i;
		}
	}
	
	if ($return == $count_simple) return $sql_select;
	else if ($return == $count_params) return $sql_select_params;
	else if ($return == $count_groupby) return $sql_select_param_groupby;
	else if ($return == $count_mod) return $sql_select_param_mod;
}

function insertPlanification($datetime_create, $frequence, $uptime, $description, $connexion){
	$query_insert_planification = "";
	
	if ($uptime != ""){
		$select_planification =  "SELECT COUNT(*) AS count ";
		$select_planification .= "FROM planification_update ";
		$select_planification .= "WHERE datetime_create='$datetime_create' ";
		$select_planification .= "AND uptime='$uptime' ";
		$select_planification .= "AND description='$description'";
		$query_select_planification = $connexion->prepare($select_planification);
		$query_select_planification->execute();
		$data = $query_select_planification->fetch(PDO::FETCH_ASSOC);
		$count = $data['count'];
		
		if ($count == 0){
			$sql_insert_planification = "INSERT INTO planification_uptime";
			$sql_insert_planification .= "(uptime,datetime_create,uptimeTotal,datetime_maj,description)";
			$sql_insert_planification .= "VALUES($uptime,'$datetime_create',0,'','$description')";
		}
	}
	if ($frequence != ""){
		$select_planification =  " SELECT COUNT(*) AS count ";
		$select_planification .= " FROM planification_frequence ";
		$select_planification .= " WHERE datetime_create='$datetime_create' ";
		$select_planification .= " AND frequence='$frequence' ";
		$select_planification .= " AND description='$description'";
		$query_select_planification = $connexion->prepare($select_planification);
		$query_select_planification->execute();
		$data = $query_select_planification->fetch(PDO::FETCH_ASSOC);
		$count = $data['count'];
	
		if ($count == 0){
			$sql_insert_planification = "INSERT INTO planification_frequence";
			$sql_insert_planification .= "(frequence,datetime_create,datetime_maj,description)";
			$sql_insert_planification .= "VALUES('$frequence','$datetime_create','','$description')";			
		}
	}

	//echo $sql_insert_planification;
	$query_insert_planification = $connexion->prepare($sql_insert_planification);
	$query_insert_planification->execute();
	
	return $query_insert_planification;
}

function getUptimePlanification($connexion){
	$select_uptime_planifications  = "SELECT *  ";
	$select_uptime_planifications .= "FROM planification_uptime ";
	$uptime = getHeureProd($connexion);
	$select_uptime_planifications .= "WHERE ( $uptime - uptimeTotal ) < uptime";
	
	return $select_uptime_planifications;
}


function getHeureProd($connexion){
	$sql_last_uptime =  "SELECT value AS uptime ";
	$sql_last_uptime .= "FROM data_compt_hor_prod ";
	$sql_last_uptime .= "WHERE state = 1 ";
	$sql_last_uptime .= "ORDER BY datetime DESC ";
	$sql_last_uptime .= "LIMIT 0,1";
	$query_last_uptime = $connexion->prepare($sql_last_uptime);
	$query_last_uptime->execute();
	$data = $query_last_uptime->fetch(PDO::FETCH_ASSOC);
	return $data['uptime'];
}

function getDateTimeIntervention($connexion){
	$day = substr($datetime, 8, 2);
	$month = substr($datetime, 5, 2);
	$year = substr($datetime, 0, 4);
	$hour  = substr($datetime, 11, 2);
	$date = "$year-$month-$day";
	
	$sql_get_datetime_intervention =  "SELECT datetime ";
	$sql_get_datetime_intervention .= "FROM interventions ";
	$sql_get_datetime_intervention .= "WHERE DATE(datetime) = '$date' ";
	$sql_get_datetime_intervention .= "AND HOUR(datetime) = '$hour'";

	$query_get_datetime_intervention = $connexion->prepare($sql_get_datetime_intervention);
	$query_get_datetime_intervention->execute();
	$data = $query_get_datetime_intervention->fetch(PDO::FETCH_ASSOC);
	return $data['datetime'];
}

function getCountInterventionsByDay($datetime, $connexion){
	$day = substr($datetime, 8, 2);
	$month = substr($datetime, 5, 2);
	$year = substr($datetime, 0, 4);
	$date = "$year-$month-$day";
	
	$sql_count_intervention =  "SELECT COUNT(*) AS nombreInterventionsByDate ";
	$sql_count_intervention .= "FROM interventions ";
	$sql_count_intervention .= "WHERE DATE(datetime) = '$date'";

	$query_count_intervention = $connexion->prepare($sql_count_intervention);
	$query_count_intervention->execute();
	$data = $query_count_intervention->fetch(PDO::FETCH_ASSOC);
	return $data['nombreInterventionsByDate'];
}

function getCountInterventionsByHour($datetime, $connexion){
	$day   = substr($datetime, 8, 2);
	$month = substr($datetime, 5, 2);
	$year  = substr($datetime, 0, 4);
	$hour  = substr($datetime, 11, 2);
	$date  = "$year-$month-$day";
	
	$sql_count_intervention =  "SELECT COUNT(*) AS nombreInterventionsByHour ";
	$sql_count_intervention .= "FROM interventions ";
	$sql_count_intervention .= "WHERE DATE(datetime) = '$date' ";
	$sql_count_intervention .= "AND HOUR(datetime) = '$hour'";

	$query_count_intervention = $connexion->prepare($sql_count_intervention);
	$query_count_intervention->execute();
	$data = $query_count_intervention->fetch(PDO::FETCH_ASSOC);
	return $data['nombreInterventionsByHour'];
}

function hasIntervention($datetime, $connexion){
	$sql_select_intervention = "SELECT COUNT(*) AS nombre FROM interventions WHERE datetime='$datetime'";
	$query_select_intervention = $connexion->prepare($sql_select_intervention);
	$query_select_intervention->execute();
	$data = $query_select_intervention->fetch(PDO::FETCH_ASSOC);
	return ($data['nombre'] > 0);
}

function getNextOrPrecDatetime($datetime, $action, $connexion){
	$sql_select_datetime = getNextOrPrecIntervention($datetime, $action);
	$query_select_datetime = $connexion->prepare($sql_select_datetime);
	$query_select_datetime->execute();
	$data = $query_select_datetime->fetch(PDO::FETCH_ASSOC);
	return (($data['datetime'] == "") ? $datetime : $data['datetime']);
}

function generateInterventionSQL($datetime){
	$sql_select_interventions =  "SELECT id_intervention, intervenant, observation, datetime, DATE(datetime) AS Date ";
	$sql_select_interventions .= "FROM interventions ";
	$sql_select_interventions .= "WHERE datetime = '$datetime' ";	
	return $sql_select_interventions;
}

function generateInterventionsSQL(){
	$sql_select_interventions =  "SELECT id_intervention, intervenant, observation, datetime, DATE(datetime) AS Date, DATE_FORMAT(datetime, '%a-%b') AS explode, MONTH(datetime) AS month, YEAR(datetime) AS year, TIME(datetime) AS time ";
	$sql_select_interventions .= "FROM interventions ";
	$sql_select_interventions .= "ORDER BY YEAR(datetime),DATE(datetime),DAY(datetime) ASC";
//	echo $sql_select_interventions;
	return $sql_select_interventions;
}

function getNextOrPrecIntervention($datetime, $action){
	$sql_select_interventions = "SELECT DATE(datetime) AS Date,intervenant,observation, datetime, id_intervention FROM interventions";
	//if (!empty($datetime) && empty($action)) $sql_select_interventions .= " WHERE datetime = '$datetime'";
	if (!empty($datetime) && !empty($action)) $sql_select_interventions .= " WHERE datetime " .(($action == "back") ? "<" : ">"). " '$datetime'";
	$sql_select_interventions .= "ORDER BY datetime ";
	$sql_select_interventions .= ($action == "back") ? "DESC " : "ASC ";
	$sql_select_interventions .= "LIMIT 0,1";
	return $sql_select_interventions;
}

function generateInsertIntervention($datetime, $intervenant, $observation){
	$sql_insert = " INSERT INTO interventions(datetime, intervenant, observation) VALUES('$datetime', '$intervenant', '$observation')";
	return $sql_insert;
}

function generateUpdateIntervention($id_intervention, $observation){
	$sql_update =  "UPDATE interventions ";
	$sql_update .= "SET observation = '$observation' ";
	$sql_update .= "WHERE id_intervention = $id_intervention";
	return $sql_update;
}

function generateMoySQL($variables, $dateDebut, $dateFin){		
		$variables[0] = strtolower($variables[0]);
		
		$sql_select = "SELECT DATE_FORMAT($variables[0].datetime, '%d/%m/%Y') AS Annee, ";
		for($i=0 ; $i < count($variables) ; $i++){
			$variables[$i] = strtolower($variables[$i]);
			if ($i == count($variables) -1) $sql_select .= " AVG($variables[$i].value) AS " .$variables[$i]."_avg";
			else $sql_select .= " AVG($variables[$i].value) AS " .$variables[$i]."_avg,";
		}
		
		$sql_select .= " FROM " .$variables[0]. " ";
		for($i=1 ; $i < count($variables) ; $i++){
			$sql_select .= " LEFT JOIN " .$variables[$i]. " ON " .$variables[$i].".datetime = " .$variables[0]. ".datetime ";
			$sql_select .= " AND $variables[$i].state = 1";
		}
				
		$sql_select .= " WHERE " .$variables[0]. ".datetime BETWEEN '" .$dateDebut. "'";
		$sql_select .= " AND '" .$dateFin. "'";
		$sql_select .= " AND $variables[0].state = 1";
		$sql_select .= " GROUP BY DATE(" .$variables[0]. ".datetime)";
		return $sql_select;
	}


function generateDatasSQL($variables, $dateDebut, $dateFin){
	$variables[0] = strtolower($variables[0]);
	
	$sql_select = "SELECT $variables[0].datetime, DATE_FORMAT($variables[0].datetime, '%d/%m/%Y') AS Annee, HOUR($variables[0].datetime) AS Heure, ";
	for($i=0 ; $i < count($variables) ; $i++){
		$variables[$i] = strtolower($variables[$i]);
		if ($i == count($variables) -1) $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value";
		else $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value ,";
	}
	
	$sql_select .= " FROM " .$variables[0]. " ";		
	for($i=1 ; $i < count($variables) ; $i++){
		$sql_select .= " LEFT JOIN " .$variables[$i]. " ON " .$variables[$i].".datetime = " .$variables[0]. ".datetime ";
		$sql_select .= " AND $variables[$i].state = 1";
	}
			
	$sql_select .= " WHERE " .$variables[0]. ".datetime BETWEEN '" .$dateDebut. "'";
	$sql_select .= " AND '" .$dateFin. "'";
	$sql_select .= " AND $variables[0].state = 1";
	$sql_select .= " GROUP BY YEAR($variables[0].datetime),MONTH($variables[0].datetime),DATE($variables[0].datetime), HOUR(" .$variables[0]. ".datetime)";
	$sql_select .= " ORDER BY YEAR($variables[0].datetime),MONTH($variables[0].datetime),DATE($variables[0].datetime), HOUR($variables[0].datetime)";
	return $sql_select;
}

function generateDatasAndMoySQL($variables, $dateDebut, $dateFin){
	$variables[0] = strtolower($variables[0]);
	
	$sql_select = "SELECT $variables[0].datetime, DATE_FORMAT($variables[0].datetime, '%d/%m/%Y') AS Annee, HOUR($variables[0].datetime) AS Heure, ";
	for($i=0 ; $i < count($variables) ; $i++){
		$variables[$i] = strtolower($variables[$i]);
		if ($i == count($variables) -1) $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value";
		else $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value ,";
	}
	
	$sql_select .= " FROM " .$variables[0]. " ";		
	for($i=1 ; $i < count($variables) ; $i++){
		$sql_select .= " LEFT JOIN " .$variables[$i]. " ON " .$variables[$i].".datetime = " .$variables[0]. ".datetime ";
		$sql_select .= " AND $variables[$i].state = 1";
	}
			
	$sql_select .= " WHERE " .$variables[0]. ".datetime BETWEEN '" .$dateDebut. "'";
	$sql_select .= " AND '" .$dateFin. "'";
	$sql_select .= " AND $variables[0].state = 1";
	$sql_select .= " GROUP BY DATE($variables[0].datetime), HOUR($variables[0].datetime)";
	$sql_select .= " ORDER BY DATE($variables[0].datetime), HOUR($variables[0].datetime)";
	return $sql_select;
}


function getDescriptionOfLabel($label, $connexion){
	$sql_select_description = "SELECT description FROM variables WHERE label='$label'";
	$query_select_description = $connexion->prepare($sql_select_description);
	$query_select_description->execute();
	$data = $query_select_description->fetch(PDO::FETCH_ASSOC);
	return $data['description'];
}

function getUnite($label, $connexion){
	$sql_select_unite = "SELECT unite FROM variables WHERE label='$label'";
	$query_select_unite = $connexion->prepare($sql_select_unite);
	$query_select_unite->execute();
	$data = $query_select_unite->fetch(PDO::FETCH_ASSOC);
	return $data['unite'];
}

function getLastValue($variable, $dateDebut, $connexion){
	$sql_select_last =  " SELECT value" 						.
						" FROM " .$variable				   	.
					 	" WHERE datetime < '" .$dateDebut. "'" 	.
					 	" AND value IS NOT NULL"				.
					 	" ORDER BY timestamp DESC"				.
					 	" LIMIT 0,1";
	$query_select_last = $connexion->prepare($sql_select_last);
	$query_select_last->execute();
	$data = $query_select_last->fetch(PDO::FETCH_ASSOC);
	return $data['value'];
}

function getNombreRowSpan($table, $datetime, $dateFin, $connexion){
	$table = strtolower($table);
	$sql_select  = "SELECT COUNT(DISTINCT(HOUR($table.datetime))) AS Nombre 
					FROM $table 
					WHERE $table.datetime >= '" .$datetime. "' AND $table.datetime < DATE('" .$datetime. "' + INTERVAL 1 DAY) 
					AND $table.datetime < '$dateFin'";
	//echo "</br>".$sql_select."</br>";
	$query_select = $connexion->prepare($sql_select);
	$query_select->execute();
	$data = $query_select->fetch(PDO::FETCH_ASSOC);
	return $data['Nombre'];					
}

?>