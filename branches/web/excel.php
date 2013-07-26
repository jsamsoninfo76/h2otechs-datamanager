<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2013 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.9, 2013-06-02
 *
 * http://www.developpez.net/forums/d400523/php/langage/fonctions/tableaux-incrementer-alphabet-sans-tableau/ (alphabet ASCII)
 * http://stackoverflow.com/questions/12041844/phpexcel-set-column-width (changer la taille des colonne)
 * http://www.labo-web.com/blog/actualite/tutoriel-de-generation-de-document-excel-en-php-via-phpexcel/ 
 * http://g-ernaelsten.developpez.com/tutoriels/excel2007/?page=styles (style)
 */
 
//print_r($_SESSION);

//Pour les gros tableaux 
ini_set('memory_limit', '-1');
set_time_limit(65536); 

/* STYLE */
//array de configuration des bordures
$bordersarray=array(
'borders'=>array(
'top'=>array(
'style'=>PHPExcel_Style_Border::BORDER_THIN),
'left'=>array(
'style'=>PHPExcel_Style_Border::BORDER_THIN),
'right'=>array(
'style'=>PHPExcel_Style_Border::BORDER_THIN),
'bottom'=>array(
'style'=>PHPExcel_Style_Border::BORDER_THIN)));
//array de configuration des polices
//pour mettre en gras
$gras=array('font' => array(
'bold' => true
));
//on centre verticalement et horizontalement
$center=array('alignment'=>array(
'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER));
//pour aligner à gauche
$left=array('alignment'=>array(
'horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_LEFT));
//pour souligner
$souligner=array('font' => array(
'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE
));


/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once 'include/include.php';


// Create new PHPExcel object
echo date('H:i:s') , " Cr&eacute;ation du nouveau fichier" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Changement des propri&eacute;t&eacute;es du fichier" , EOL;
$objPHPExcel->getProperties()->setCreator("H2oTechs")
							 ->setLastModifiedBy("H2oTechs")
							 ->setTitle("Datamanager Reporting")
							 ->setSubject("Reporting")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");


//Test sur le document en cours
$isMoyenne = ($_SESSION['yAxis_title'] == "Moyennes") ? 1 : 0;
$decalage   = ($isMoyenne) ? 1 : 2; // 1 pour la colonne de Date, 1 pour la colonne des heures
for($numColonne=0 ; $numColonne<count($_SESSION['subtitles'])+$decalage ; $numColonne++)
	$_SESSION['tailleColonne'][$numColonne] = 0;

//Création d'un tableau avec les lettres des colonnes
$cpt = 65;
while($cpt<91){
  $colonne[$cpt-65] = chr($cpt);
  $cpt++;
}

$objPHPExcel->setActiveSheetIndex(0);
$sheet=$objPHPExcel->getActiveSheet();
$sheet->setTitle('Releve');

/* GENERATION DES HEADERS */
echo date('H:i:s') , " G&eacute;n&eacute;ration des nom de colonne" , EOL;
$sheet->setCellValue('A1', 'Date');
if (!$isMoyenne) $sheet->setCellValue('B1', 'Heure');

for($numColonne=0 ; $numColonne<count($_SESSION['subtitles']) ; $numColonne++){
	$coordonneeX    = ($isMoyenne) ? $colonne[$numColonne+$decalage] : $colonne[$numColonne+$decalage]; //+1 pour Date, +1 pour Heure
	$coordonneeY    = "1";
	$localisation  	= $coordonneeX . $coordonneeY; //+1 pour le décalage avec la colonne de date
	$value 			= $_SESSION['subtitles'][$numColonne];

	$sheet->setCellValue($localisation, $value);
}

/* GENERATION DE LA PREMIERE COLONNE DE DATE */
echo date('H:i:s') , " Remplissage de la premi&egrave;re colonne (Date)" , EOL;

for($numColonne=0 ; $numColonne<count($_SESSION['categories']) ; $numColonne++){
	$localisation  	= 'A' . ($numColonne+2); //colonne[0] pour rester sur A & $numColonnes+2 pour commencer à 2
	$value 			= $_SESSION['categories'][$numColonne];
	
	makeItBordered($sheet, $localisation);
	$sheet->setCellValue($localisation, $value);
}

if (!$isMoyenne){
	echo date('H:i:s') , " Remplissage de la deuxi&egrave;me colonne (Heure)" , EOL;
	/* GENERATION DE LA DEUXIEME COLONNE D'HEURE */
	for($numLigne=0 ; $numLigne<count($_SESSION['heures']) ; $numLigne++){
		$coordonneeX    = "B";
		$coordonneeY    = ($numLigne+2);
		$localisation  	= $coordonneeX . $coordonneeY;
		$value 			= $_SESSION['heures'][$numLigne];
		
		// MERGE des deux première colonnes en cas de données et moyennes
		if ($value == "Moyenne du jour"){
			$localisationMergeCelles = "A" . $coordonneeY . ":B" . $coordonneeY;
			$sheet->mergeCells($localisationMergeCelles);
		}

		makeItBordered($sheet, $localisation);
		$sheet->setCellValue($localisation, $value);
	}
}

/* GENERATION DES DATAS */
echo date('H:i:s') , " Ajout des donn&eacute;es" , EOL;

for($numColonne=0 ; $numColonne<count($_SESSION['subtitles']) ; $numColonne++){
	$nom = $_SESSION['subtitles'][$numColonne];
	
	for($numLigne=0 ; $numLigne<count($_SESSION['series'][$nom]) ; $numLigne++){
		$coordonneeX	= ($isMoyenne) ? $colonne[$numColonne+$decalage] : $colonne[$numColonne+$decalage];
		$coordonneeY	= ($numLigne+2); //+1 Pour enlever la ligne de titre et +1 vue que ça commence à 1 et non 0
		$localisation  	= $coordonneeX . $coordonneeY;
		$value 			= $_SESSION['series'][$nom][$numLigne];
		makeItBordered($sheet, $localisation);
		
		//Enregistrement de la taille max des valeurs de la colonne
		$tailleColonne = strlen($value);
		if ($tailleColonne > $_SESSION['tailleColonne'][$numColonne+$decalage])
			$_SESSION['tailleColonne'][$numColonne+$decalage] = $tailleColonne;
		
		$sheet->setCellValue($localisation, $value);
	}	
}

/* AUGMENTATION DE LA TAILLE DES COLONNES */
echo date('H:i:s') , " Adaptation de la taille des colonnes" , EOL;
$sheet->getColumnDimension('A')->setWidth(10);
if (!$isMoyenne) $sheet->getColumnDimension('B')->setWidth(6);
for($numColonne=2 ; $numColonne<count($_SESSION['tailleColonne']) ; $numColonne++){
	$nombreChar = $_SESSION['tailleColonne'][$numColonne] + 2; // +2 en cas de '-' et 1 de marge
	
	if ($numColonne >= $decalage && strlen($_SESSION['subtitles'][$numColonne-$decalage]) >= $nombreChar)		
		$nombreChar = strlen($_SESSION['subtitles'][$numColonne-$decalage])+1; // Prend la taille du nom de la colonne +1 de marge

	
	$sheet->getColumnDimension($colonne[$numColonne])->setWidth($nombreChar);
}

/* Style */
echo date('H:i:s') , " Stylisation du fichier" , EOL;

//Mise en gras des Headers
for($numColonne=0 ; $numColonne<count($_SESSION['subtitles'])+$decalage ; $numColonne++){
	$coordonneeX    = $colonne[$numColonne];
	$coordonneeY    = 1;
	$localisation  	= $coordonneeX . $coordonneeY;
	makeItBordered($sheet, $localisation); 
	$styleCase = $sheet->getStyle($localisation);
	$styleFont = $styleCase->getFont();
	$styleFont->setBold(true);
}

//Ajout des bordures au tableau
echo date('H:i:s') , " Ajout des bordures" , EOL;
$nbColonne = ($isMoyenne) ? count($_SESSION['subtitles'])+$decalage : count($_SESSION['subtitles'])+$decalage;
$nom = $_SESSION['subtitles'][0];
$nbLigne = count($_SESSION['series'][$nom])+1; //+1 Pour header

//FileName & Path
$path = "upload";
$fileName = $_SESSION['dateDebut'] ."_au_". $_SESSION['dateFin'] ."_". $_SESSION['yAxis_title'] ."_". "Enky" .$config['enky']. ".xlsx";

// Rename worksheet
echo date('H:i:s') , " Changement du titre de la feuille en: " . $fileName, EOL;
$objPHPExcel->getActiveSheet()->setTitle($_SESSION['yAxis_title']);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo date('H:i:s') , " Ecriture en format Excel 2007" , EOL;
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//Save
$objWriter->save($path."/".$fileName);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

// Echo done
echo '<br/><a href="upload/' .$fileName. '">Cliquez ici pour t&eacute;l&eacute;charger le fichier</a>';




/*
* Rajoute une bordure autour de la case 
* BORDER_NONE	 'none'
* BORDER_DASHDOT	 'dashDot'
* BORDER_DASHDOTDOT	 'dashDotDot'
* BORDER_DASHED	 'dashed'
* BORDER_DOTTED	 'dotted'
* BORDER_DOUBLE	 'double'
* BORDER_HAIR	 'hair'
* BORDER_MEDIUM	 'medium'
* BORDER_MEDIUMDASHDOT	 'mediumDashDot'
* BORDER_MEDIUMDASHDOTDOT	 'mediumDashDotDot'
* BORDER_MEDIUMDASHED	 'mediumDashed'
* BORDER_SLANTDASHDOT	 'slantDashDot'
* BORDER_THICK	 'thick'
* BORDER_THIN	 'thin'
*/
function makeItBordered($sheet, $localisation){
	$sheet->getStyle($localisation)->getBorders()->applyFromArray(
		array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array(
					'rgb' => '808080'
				)
			)
		)
	);
}

function makeItColored($sheet, $localisation){
	$sheet->getStyle($localisation)->applyFromArray(
	    array(
	        'fill' => array(
	            'color' => array('rgb' => 'FF0000')
	        )
	    )
	);
}
?>