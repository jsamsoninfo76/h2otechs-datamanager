<?php

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