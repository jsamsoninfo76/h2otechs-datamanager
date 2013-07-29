<?php


/**
 * Recuperation des couleurs en fonction du PH
 */
function getPHColor($ph){
	if ($ph < 1) return "153,0,0";
	else if ($ph >= 1 && $ph < 2) return "204,0,0";
	else if ($ph >= 2 && $ph < "2,4") return "255,0,0";
	else if ($ph >= "2,4" && $ph < "2,6") return "255,51,0";
	else if ($ph >= "2,6" && $ph < "3,5") return "255,102,0";
	else if ($ph >= "3,5" && $ph < "4,5") return "255,153,0";
	else if ($ph >= "4,5" && $ph < 5) return "255,204,0";
	else if ($ph >= 5 && $ph < "5,5") return "255,255,0";
	else if ($ph >= "5,5" && $ph < "5,6") return "204,255,0";
	else if ($ph >= "5,6" && $ph < "6,6") return "102,204,0";
	else if ($ph >= "6,6" && $ph < "7,4") return "51,204,0";
	else if ($ph >= "7,4" && $ph < 8) return "0,204,51";
	else if ($ph >= 8 && $ph < 9) return "0,153,102";
	else if ($ph >= 9 && $ph < "11,5") return "0,102,153";
	else if ($ph >= "11,5" && $ph < "12,5") return "0,51,204";
	else if ($ph >= "12,5" && $ph < 14) return "0,0,204"; 
	else if ($ph >= 14) return "0,0,153";
}

function rgbToHexa($r, $g, $b){
	
	$hex_value = dechex($r); 
	
		if(strlen($hex_value)<2){
			$hex_value="0".$hex_value;
		}
	$hex_RGB.=$hex_value;
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