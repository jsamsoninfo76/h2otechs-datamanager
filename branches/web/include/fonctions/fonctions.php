<?php

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