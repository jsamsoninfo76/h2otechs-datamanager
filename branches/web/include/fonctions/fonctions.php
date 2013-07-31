<?php

/**
 * Récupère le nombre d'intervention dans une journée
 */
function getCountInterventions($datetime){
	$day = substr_compare($datetime, 0, 2);
	$month = substr_compare($datetime, 3, 2);
	$year = substr_compare($datetime, 5, 4);
	$date = "$year-$month-$day";
	$sql = generateCountIntervention($date);
}

/**
 * Recuperation des couleurs
 */
function getColor($variable, $value){
	if (strpos($variable, "PH")) return getPHColor($value);
	else return "255,255,255";
}

/**
 * Recuperation des couleurs en fonction du PH
 */
function getPHColor($value){
	if ($value < 1) return "153,0,0";
	else if ($value >= 1 && $value < 2) return "204,0,0";
	else if ($value >= 2 && $value < "2,4") return "255,0,0";
	else if ($value >= "2,4" && $value < "2,6") return "255,51,0";
	else if ($value >= "2,6" && $value < "3,5") return "255,102,0";
	else if ($value >= "3,5" && $value < "4,5") return "255,153,0";
	else if ($value >= "4,5" && $value < 5) return "255,204,0";
	else if ($value >= 5 && $value < "5,5") return "255,255,0";
	else if ($value >= "5,5" && $value < "5,6") return "204,255,0";
	else if ($value >= "5,6" && $value < "6,6") return "102,204,0";
	else if ($value >= "6,6" && $value < "7,4") return "51,204,0";
	else if ($value >= "7,4" && $value < 8) return "0,204,51";
	else if ($value >= 8 && $value < 9) return "0,153,102";
	else if ($value >= 9 && $value < "11,5") return "0,102,153";
	else if ($value >= "11,5" && $value < "12,5") return "0,51,204";
	else if ($value >= "12,5" && $value < 14) return "0,0,204"; 
	else if ($value >= 14) return "0,0,153";
}

/*
 * Modification pour la prise en compte des décimales du PH
 */
function traitementDecimal($variable, $value){
	//Traitement PH, datas entre 0 & 140 
	if (strpos($variable, "PH")){ 
		if (strlen($value) == 3) 		return substr($value, 0, 1) . substr($value, 1, 1) . "," . substr($value, 2, 1);
		else if(strlen($value) == 2) 	return substr($value, 0, 1) . "," . substr($value, 1, 1);		
		else 							return $value;
	}
	else
		return $value;
}
/**
 * http://php.net/manual/fr/datetime.createfromformat.php
 * Mois En -> Fr
 */
function getFrFormatMois($jour){
	if ($jour == "Jan") return "Janvier";
	else if ($jour == "Feb") return "F&eagrave;vrier";
	else if ($jour == "Mar") return "Mars";
	else if ($jour == "Apr") return "Avril";
	else if ($jour == "May") return "Mai";
	else if ($jour == "Jun") return "Juin";
	else if ($jour == "Jul") return "Juillet";
	else if ($jour == "Aug") return "Ao&ucirc;t";
	else if ($jour == "Sep") return "Septembre";
	else if ($jour == "Oct") return "Octobre";
	else if ($jour == "Nov") return "Novembre";
	else return "D&eacute;cembre";
}

/**
 * http://php.net/manual/fr/datetime.createfromformat.php 
 * Jour En -> Fr
 */
function getFrFormatJour($jour){
	if ($jour == "Mon") return "Lundi";
	else if ($jour == "Tue") return "Mardi";
	else if ($jour == "Wed") return "Mercredi";
	else if ($jour == "Thu") return "Jeudi";
	else if ($jour == "Fri") return "Vendredi";
	else if ($jour == "Sat") return "Samedi";
	else return "Dimanche";
}

/* 
 * Recupere le libeler correct pour l'affichage 
 */
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
	else if (strpos($variable,'TOTALISATEUR') !== false) return "TOT " . $variable[strlen($variable)-1];
	else return str_replace('_', ' ', $variable);
}
?>