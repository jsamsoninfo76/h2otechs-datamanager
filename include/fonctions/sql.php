<?php

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
	$sql_select_interventions =  "SELECT id_intervention, intervenant, observation, datetime, DATE(datetime) AS Date ";
	$sql_select_interventions .= "FROM interventions ";
	$sql_select_interventions .= "ORDER BY YEAR(datetime),DATE(datetime),DAY(datetime) ASC";
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