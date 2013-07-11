<?php
function generateSQL($variables, $dateDebut, $dateFin){
	$variables[0] = strtolower($variables[0]);
	$sql_select = "SELECT " .$variables[0]. ".datetime,";
	
	for($i=0 ; $i < count($variables) ; $i++){
		$variables[$i] = strtolower($variables[$i]);
		if ($i == count($variables) -1) $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value";
		else $sql_select .= $variables[$i]. ".value AS " .$variables[$i]."_value ,";
	}
	$sql_select .= " FROM " .$variables[0]. " ";
		
	for($i=1 ; $i < count($variables) ; $i++){
		$sql_select .= "LEFT JOIN " .$variables[$i]. " ON " .$variables[$i].".datetime = " .$variables[0]. ".datetime ";
	}
			
	$sql_select .= " WHERE " .$variables[0]. ".datetime >= '" .$dateDebut. "'";
	$sql_select .= " AND " .$variables[0]. ".datetime <= '" .$dateFin. "'";
	//$sql_select .= " LIMIT 0,1";
	return $sql_select;
}

function getHeader($string){
	$strings = explode("_", $string);
	$res = "";
	
	for($i=1 ; $i<count($strings) ; $i++){
		if ($i == count($strings)-1)
			$res .= $strings[$i];
		else
			$res .= $strings[$i] . "_";
	}
	
	return $res;
}

function getDescriptionOfLabel($label, $connexion){
	$sql_select_description = "SELECT description FROM variables WHERE label='$label'";
	$query_select_description = $connexion->prepare($sql_select_description);
	$query_select_description->execute();
	$data = $query_select_description->fetch(PDO::FETCH_ASSOC);
	return $data['description'];
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

function verifExposant($unite){
	if (is_numeric(substr($unite, strlen($unite)-1, strlen($unite))))
		$unite = substr($unite, 0, strlen($unite)-1) . "<sup>" .substr($unite, strlen($unite)-1, strlen($unite)). "</sup>";
	return $unite;
}

function isOneHourDiff($heure, $datetime){
	$hourFromDateTime = getHourFromDatetime($datetime);
	return ($hourFromDateTime > $heure);	
}

function getHourFromDatetime($datetime){
	$tmp = explode(" ", $datetime);
	$time = explode(":", $tmp[1]);
	return $time[0];
}

function getMinFromDatetime($datetime){
	$tmp = explode(" ", $datetime);
	$time = explode(":", $tmp[1]);
	return $time[1];
}

function getLabel($variable){
	if (strpos($variable,'RENDT_ETAGES') !== false) return "ETAGES";
	else if (strpos($variable,'RENDT_ETAGE') !== false) return "ETAGE " . $variable[strlen($variable)-1];
	else return str_replace('_', ' ', $variable);
}
?>