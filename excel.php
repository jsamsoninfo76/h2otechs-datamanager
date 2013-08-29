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
 * http://anthodevsec.wordpress.com/2011/07/02/phpexcel-une-librairie-excellente/ (style)
 */

//Pour les gros tableaux 
ini_set('memory_limit', '-1');
set_time_limit(65536); 

$verbose = (isset($_GET['verbose'])) ? true : false;

/* STYLE */
$backgroundHeaderColor = "225975";
$textHeaderColor = "FFFFFF";
$textColor = "000000";
$backgroundDateColor = "006361";
$backgroundMoyenneColor = "FFAC42";
$bold = array( 'font' => array( 'bold' => true) ); 



/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

//define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once 'include/include.php';


// Create new PHPExcel object
if ($verbose) echo date('H:i:s') , " Cr&eacute;ation du nouveau fichier" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
if ($verbose) echo date('H:i:s') , " Chargement des propri&eacute;t&eacute;es du fichier" , EOL;
$objPHPExcel->getProperties()->setCreator("H2oTechs")
							 ->setLastModifiedBy("H2oTechs")
							 ->setTitle("Datamanager Reporting")
							 ->setSubject("Reporting")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

$objPHPExcel->setActiveSheetIndex(0);
$sheet=$objPHPExcel->getActiveSheet();
$sheet->setTitle('Releve');

//HEADER
if (isset($_SESSION['decalagepdf']) && $_SESSION['decalagepdf'] != null){
	$objPHPExcel->getDefaultStyle()
    			->getNumberFormat()
    			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    
    //Header : Logo
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo H2otechs');
	$objDrawing->setPath('img/logo2.png');
	$objDrawing->setHeight(50);
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	
	//Header : titre
	$sheet->mergeCells('D1:H1');
	foreach($_SESSION['unite'] as $unite){ $unite = getUniteLabel($unite);}
	$sheet->setCellValue('D1', "Relevé des données \nde $unite");
	
	//Header : date
	$sheet->setCellValue('I1', "Par\nDate\nSite");	
	$sheet->getStyle('I1')->applyFromArray($bold);
	$sheet->getStyle('I1')->getAlignment()->setWrapText(true);	
	$sheet->setCellValue('J1', "H2otechs\nle " . date('d/m/Y') . "\nwww.h2otechs.fr");
	$sheet->getStyle('J1')->getAlignment()->setWrapText(true);	
	$sheet->mergeCells('J1:L1');
	
	$decalagepdf = $_SESSION['decalagepdf'];
	$_SESSION['decalagepdf'] = null;
}else{
	$decalagepdf = 0;
}

$isPDF = ($decalagepdf > 0) ? true : false;
$margePDF = 4;

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

/* GENERATION DES HEADERS */
if ($verbose) echo date('H:i:s') , " G&eacute;n&eacute;ration des nom de colonne" , EOL;
$coordonneeDateHeure = 1 + $decalagepdf;
$localisation = "A" . $coordonneeDateHeure;
$sheet->setCellValue($localisation, 'Date');
makeItColored($sheet, $localisation, $backgroundHeaderColor);
changeFontColor($sheet, $localisation, $textHeaderColor);

$localisation = "B" . $coordonneeDateHeure;
if (!$isMoyenne) {
	$sheet->setCellValue($localisation, 'Heure');
	makeItColored($sheet, $localisation, $backgroundHeaderColor);
	changeFontColor($sheet, $localisation, $textHeaderColor);
}

for($numColonne=0 ; $numColonne<count($_SESSION['subtitles']) ; $numColonne++){
	$coordonneeX    = ($isMoyenne) ? $colonne[$numColonne+$decalage] : $colonne[$numColonne+$decalage]; //+1 pour Date, +1 pour Heure
	$coordonneeY    = 1 + $decalagepdf;
	$localisation  	= $coordonneeX . $coordonneeY; //+1 pour le décalage avec la colonne de date
	$value 			= $_SESSION['subtitles'][$numColonne];

	$sheet->setCellValue($localisation, $value);
	makeItColored($sheet, $localisation, $backgroundHeaderColor);
	changeFontColor($sheet, $localisation, $textHeaderColor);
}

/* GENERATION DE LA PREMIERE COLONNE DE DATE */
if ($verbose) echo date('H:i:s') , " Remplissage de la premi&egrave;re colonne (Date)" , EOL;
$localisationDebut = "";
$localisationFin = "";
$valuePrec = "";
for($numColonne=0 ; $numColonne<count($_SESSION['categories']) ; $numColonne++){
	$coordonneeX    = 'A';
	$coordonneeY    = $numColonne + 2 + $decalagepdf;
	$localisation  	= $coordonneeX . $coordonneeY; //colonne[0] pour rester sur A & $numColonnes+2 pour commencer à 2
	$value 			= ($_SESSION['categories'][$numColonne] == "Moyenne du jour") ? $_SESSION['categories'][$numColonne] : substr($_SESSION['categories'][$numColonne], 0, 10);
	
	// On met la localisation de début
	if ($valuePrec != $value){
		if ($valuePrec == ""){
			$localisationDebut = $localisation;
		}else{
			$localisationFin = $coordonneeX. ($coordonneeY-1);
			
			if ($localisationDebut != "" && $localisationFin != "" && $localisationDebut != $localisationFin){
				$localisationMergeCelles = $localisationDebut .":". $localisationFin;
				$sheet->mergeCells($localisationDebut .":". $localisationFin);
			}
			
			$localisationDebut = $coordonneeX . $coordonneeY;
		}
		
		$valuePrec = $value;
	}	
	//echo "localisationDebut: $localisationDebut, localisationFin: $localisationFin<br/>";

	if ($numColonne == count($_SESSION['categories'])-1){
		$localisationFin = $localisation;
		$localisationMergeCelles = $localisationDebut .":". $localisationFin;
		
		if ($localisationDebut != $localisationFin){
			$sheet->mergeCells($localisationDebut .":". $localisationFin);
		}
	}
	
	if ($_SESSION['categories'][$numColonne] != "Moyenne du jour")
		changeFontColor($sheet, $localisation, $textHeaderColor);
	makeItColored($sheet, $localisation, $backgroundDateColor);
	//makeItBordered($sheet, $localisation);
	$sheet->setCellValue($localisation, $value);
}

if (!$isMoyenne){
	if ($verbose) echo date('H:i:s') , " Remplissage de la deuxi&egrave;me colonne (Heure)" , EOL;
	/* GENERATION DE LA DEUXIEME COLONNE D'HEURE */
	for($numLigne=0 ; $numLigne<count($_SESSION['heures']) ; $numLigne++){
		$coordonneeX    = "B";
		$coordonneeY    = ($numLigne + 2 + $decalagepdf);
		$localisation  	= $coordonneeX . $coordonneeY;
		$value 			= $_SESSION['heures'][$numLigne];
		
		// MERGE des deux première colonnes en cas de données et moyennes
		if ($value == "Moyenne du jour"){
			$localisationMergeCelles = "A" . $coordonneeY . ":B" . $coordonneeY;
			$sheet->mergeCells($localisationMergeCelles);
			makeLigneColored($sheet, $colonne, $decalage, $coordonneeY, $backgroundMoyenneColor);
		}
		
		//makeItBordered($sheet, $localisation);
		$sheet->setCellValue($localisation, $value);
		$sheet->getStyle($localisation)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}
}

/* GENERATION DES DATAS */
if ($verbose) echo date('H:i:s') , " Ajout des donn&eacute;es" , EOL;

for($numColonne=0 ; $numColonne<count($_SESSION['subtitles']) ; $numColonne++){
	$nom = $_SESSION['subtitles'][$numColonne];
	
	for($numLigne=0 ; $numLigne<count($_SESSION['series'][$nom]) ; $numLigne++){
		$coordonneeX	= ($isMoyenne) ? $colonne[$numColonne+$decalage] : $colonne[$numColonne+$decalage];
		$coordonneeY	= ($numLigne+2+$decalagepdf); //+1 Pour enlever la ligne de titre et +1 vue que ça commence à 1 et non 0
		$localisation  	= $coordonneeX . $coordonneeY;
		$value 			= $_SESSION['series'][$nom][$numLigne];
		//makeItBordered($sheet, $localisation);
		
		//Enregistrement de la taille max des valeurs de la colonne
		$tailleColonne = strlen($value);
		if ($tailleColonne > $_SESSION['tailleColonne'][$numColonne+$decalage])
			$_SESSION['tailleColonne'][$numColonne+$decalage] = $tailleColonne;
		
		$sheet->setCellValue($localisation, $value);
		$sheet->getStyle($localisation)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}	
}

/* AUGMENTATION DE LA TAILLE DES COLONNES */
if ($verbose) echo date('H:i:s') , " Adaptation de la taille des colonnes" , EOL;
$sheet->getColumnDimension('A')->setWidth(10 + $margePDF);

if (!$isMoyenne) $sheet->getColumnDimension('B')->setWidth(6 + $margePDF);
for($numColonne=2 ; $numColonne<count($_SESSION['tailleColonne']) ; $numColonne++){
	$nombreChar = $_SESSION['tailleColonne'][$numColonne] + 2; // +2 en cas de '-' et 1 de marge
	
	if ($numColonne >= $decalage && strlen($_SESSION['subtitles'][$numColonne-$decalage]) >= $nombreChar)		
		$nombreChar = strlen($_SESSION['subtitles'][$numColonne-$decalage])+1; // Prend la taille du nom de la colonne +1 de marge

	
	$sheet->getColumnDimension($colonne[$numColonne])->setWidth($nombreChar + $margePDF);
}

/* Style */
if ($verbose) echo date('H:i:s') , " Stylisation du fichier" , EOL;

//Mise en gras des Headers
for($numColonne=0 ; $numColonne<count($_SESSION['subtitles'])+$decalage ; $numColonne++){
	$coordonneeX    = $colonne[$numColonne];
	$coordonneeY    = 1+$decalagepdf;
	$localisation  	= $coordonneeX . $coordonneeY;
	//makeItBordered($sheet, $localisation); 
	$styleCase = $sheet->getStyle($localisation);
	$styleFont = $styleCase->getFont();
	$styleFont->setBold(true);
}

//Ajout des bordures au tableau
if ($verbose) echo date('H:i:s') , " Ajout des bordures" , EOL;
$nbColonne = ($isMoyenne) ? count($_SESSION['subtitles'])+$decalage : count($_SESSION['subtitles'])+$decalage;
$nom = $_SESSION['subtitles'][0];
$nbLigne = count($_SESSION['series'][$nom])+1; //+1 Pour header

//filename & Path
$path = "upload/excel";
$filename = $_SESSION['dateDebut'] ."_au_". $_SESSION['dateFin'] ."_". $_SESSION['yAxis_title'] ."_". "Enki" .$config['enki']. ".xlsx";

// Rename worksheet
if ($verbose) echo date('H:i:s') , " Changement du titre de la feuille en: " . $filename, EOL;
$objPHPExcel->getActiveSheet()->setTitle($_SESSION['yAxis_title']);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
if ($verbose) echo date('H:i:s') , " Ecriture en format Excel 2007" , EOL;
$callStartTime = microtime(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//Save
$objWriter->save($path."/".$filename);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

// Echo done
if ($decalagepdf == 0){
	//echo '<br/><a href="' .$path. '/' .$filename. '">Cliquez ici si le t&eacute;l&eacute;chargement ne commence pas</a>';
	echo '<br/><a href="downloadfile.php?dir=excel&filename=' .$filename. '">Cliquez ici si le t&eacute;l&eacute;chargement ne commence pas</a>';
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=downloadfile.php?dir=excel&filename=$filename'>";
}

/*
* Rajoute une bordure autour de la case 
* BORDER_NONE	 		'none'
* BORDER_DASHDOT 		'dashDot'
* BORDER_DASHDOTDOT		'dashDotDot'
* BORDER_DASHED	 		'dashed'
* BORDER_DOTTED	 		'dotted'
* BORDER_DOUBLE	 		'double'
* BORDER_HAIR	 		'hair'
* BORDER_MEDIUM	 		'medium'
* BORDER_MEDIUMDASHDOT	'mediumDashDot'
* BORDER_MEDIUMDASHDOTDOT'mediumDashDotDot'
* BORDER_MEDIUMDASHED	'mediumDashed'
* BORDER_SLANTDASHDOT	'slantDashDot'
* BORDER_THICK	 		'thick'
* BORDER_THIN	 		'thin'
*/
function makeItBordered($sheet, $localisation){
	$sheet->getStyle($localisation)->getBorders()->applyFromArray(
		array(
			'allborders' => array(
				'style' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array(
					'rgb' => '808080'
				)
			)
		)
	);
}

/*
 * COLOR_BLACK	 	'FF000000'
 * COLOR_WHITE	 	'FFFFFFFF'
 * COLOR_RED	 	'FFFF0000'
 * COLOR_DARKRED 	'FF800000'
 * COLOR_BLUE	 	'FF0000FF'
 * COLOR_DARKBLUE	'FF000080'
 * COLOR_GREEN	 	'FF00FF00'
 * COLOR_DARKGREEN	'FF008000'
 * COLOR_YELLOW	 	'FFFFFF00'
 * COLOR_DARKYELLOW	'FF808000'
 * Orange moyenne 	'ffac42'
 * bleu : #225975
 * turquoise : #009997
 * orange : #FFB200
 * gris : #CEDAE0
 */
function makeLigneColored($sheet, $colonne, $decalage, $coordonneeY, $color){
	for($numColonne=0 ; $numColonne<count($_SESSION['subtitles'])+$decalage ; $numColonne++){
		$coordonneeX = $colonne[$numColonne];
		$localisation = $coordonneeX . $coordonneeY;
		$sheet->getStyle($localisation)
		  ->getFill()
		  ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		  ->getStartColor()->setRGB($color);
			
	}	
}

function makeItColored($sheet, $localisation, $color){
	$sheet->getStyle($localisation)
	  ->getFill()
	  ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	  ->getStartColor()->setRGB($color);
}

function changeFontColor($sheet, $localisation, $color){
	$sheet->getStyle($localisation)->getFont()->getColor()->setRGB($color);
}
?>