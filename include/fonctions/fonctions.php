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
	return $sql_select;
}

function getLastValue($variable, $dateDebut){
	/*
	SELECT datetime,data_cfp.value AS data_cfp_value
	FROM data_cfp
	WHERE data_cfp.datetime <  '2013/06/30 17:24:24'
	AND data_cfp.value IS NOT NULL
	ORDER BY timestamp DESC
	LIMIT 0 , 1
	*/
	
	
}
?>