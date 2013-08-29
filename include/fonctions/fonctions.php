<?php


/**
 * Recupere le browser
 */
function detect_os(){
	$a=$_SERVER['HTTP_USER_AGENT'];
	if (preg_match("#windows\snt\s5\.1#i",$a))return("Microsoft Windows XP");
	if (preg_match("#mac\sos\sx#i",$a))return("Mac OS X");
	if (preg_match("#windows\snt\s6\.1#i",$a))return("Microsoft Windows 7");
	if (preg_match("#haiku#i",$a))return("Haiku");
	if (preg_match("#windows\snt\s6\.0;\swow64#i",$a))return("Microsoft Windows Vista (64bits)");if (preg_match("#windows\snt\s6\.0;\swin64#i",$a))return("Microsoft Windows Vista (64bits)");if (preg_match("#windows\snt\s6\.0#i",$a))return("Microsoft Windows Vista");if (preg_match("#sunos#i",$a))return("Open Solaris");if (preg_match("#android#i",$a))return("Android");if (preg_match("#windows\s95#i",$a))return("Microsoft Windows 95");if (preg_match("#windows\snt\s5\.0#i",$a))return("Microsoft Windows 2000");if (preg_match("#windows\snt\s5\.3#i",$a))return("Microsoft Windows Server 2003");if (preg_match("#windows\snt#i",$a))return("Microsoft Windows NT");if (preg_match("#windows\s98#i",$a))return("Microsoft Windows 98");if (preg_match("#windows\sce#i",$a))return("Microsoft Windows Mobile");if (preg_match("#windows\sphone\sos[\s\/]([0-9v]{1,7}(?:\.[0-9a-z]{1,7}){0,7})#i",$a,$c))return("Microsoft Windows Phone version ".$c[1]);if (preg_match("#mac_powerpc#i",$a))return("Mac OS X");if (preg_match("#macintosh#i",$a))return("Macintosh");if (preg_match("#cygwin_nt#i",$a))return("Microsoft Windows 2000");if (preg_match("#os\/2#i",$a))return("Microsoft OS/2");if (preg_match("#symbianos[\s\/]([0-9v]{1,7}(?:\.[0-9a-z]{1,7}){0,7})#i",$a,$c))return("Symbian OS version ".$c[1]);if (preg_match("#symbian-crystal[\s\/]([0-9v]{1,7}(?:\.[0-9a-z]{1,7}){0,7})#i",$a,$c))return("Symbian OS version ".$c[1]);if (preg_match("#offbyone;\swindows\s2000#i",$a))return("Microsoft Windows XP");if (preg_match("#windows\s2000#i",$a))return("Microsoft Windows 2000");if (preg_match("#nintendo\swii#i",$a))return("Nintendo Wii");if (preg_match("#playstation\sportable#i",$a))return("PlayStation Portable");if (preg_match("#iphone\sos\s[\s\/]([0-9v]{1,7}(?:[\._][0-9a-z]{1,7}){0,7})#i",$a,$c))return("iPhone OS version ".$c[1]);return "OS non identifié";
}

/**
 * Retourne n'utilé en fonction du label
 */
function getUniteLabel($unite){
	if ($unite == "bar") return "pression";
	if ($unite == "ph") return "ph";
	if ($unite == "%") return "rendement";
	if ($unite == "m3") return "debit";
	if ($unite == "cf") return "conductivite";
	if ($unite == "h") return "horaire";
	if ($unite == "pourcent") return "pourcentage";
}

/**
 * 
 */
function hasOneUnite($variables, $connexion){
	$repere = "";

	foreach($variables as $variable){
		$variable = getHeader($variable);
		$unite = getUnite($variable, $connexion);
		//echo "Repere=".$repere."|Unite=".$unite."<br/>";
		if ($repere == "") $repere = $unite;
		else if ($repere != $unite) return false;
	}

	return true;
}
 

/**
 * Traduction de la fréquence
 */
function getFrequence($frequence){
	if ($frequence == "1/m") 		return "une fois par mois";
	else if ($frequence == "1/d")	return "une fois par jour";
	else if ($frequence == "1/y")   return "une fois par an";
}

/**
 * Recuperation des couleurs
 */
function getColor($variable, $value){
	if (strpos($variable, "PH")) return getPHColor($value);
	else return "0,0,0"; // Noir
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
	if (strpos($variable, "PH") || strpos($variable, "PP") || strpos($variable, "PL") || strpos($variable, "PFIL1") || strpos($variable, "PFIL2")|| strpos($variable, "PFIL3")|| strpos($variable, "PL")|| strpos($variable, "PPE")){ 
		if ($value[0] != '-'){
			if (strlen($value) == 3) 		return substr($value, 0, 1) . substr($value, 1, 1) . "." . substr($value, 2, 1);
			else if(strlen($value) == 2) 	return substr($value, 0, 1) . "." . substr($value, 1, 1);		
			else 							return $value;
		}   
		else
			return $value;
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
	return getLabelHeader($unite);
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

function getLabelHeader($header){
	if ($header == "pourcent") return "%";
	else return $header;
}

function getLabel($variable){
	if (strpos($variable,'RENDT_ETAGES') !== false) return "ETAGES";
	else if (strpos($variable,'RENDT_ETAGE') !== false) return "ETAGE " . $variable[strlen($variable)-1];
	else if (strpos($variable,'TOTALISATEUR') !== false) return "TOT " . $variable[strlen($variable)-1];
	else return str_replace('_', ' ', $variable);
}


?>