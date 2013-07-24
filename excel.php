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
 */
 
session_start();
print_r($_SESSION);

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once 'include/include.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("H2oTechs")
							 ->setLastModifiedBy("H2oTechs")
							 ->setTitle("Datamanager Reporting")
							 ->setSubject("Reporting")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");


// Add some data
echo date('H:i:s') , " Add some data" , EOL;

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
$sheet->setCellValue('A1', 'Date');
for($numColonne=0 ; $numColonne<count($_SESSION['subtitles']) ; $numColonne++){
	$localisation  	= $colonne[$numColonne+1]. "1"; //+1 pour le décalage avec la colonne de date
	$value 			= $_SESSION['subtitles'][$numColonne];

	$sheet->setCellValue($localisation, $value);
}

/* GENERATION DE LA PREMIERE COLONNE DE DATE */
for($numColonne=0 ; $numColonne<count($_SESSION['categories']) ; $numColonne++){
	$localisation  	= 'A' . ($numColonne+2); //colonne[0] pour rester sur A & $numColonnes+1 pour commencer à 1
	$value 			= $_SESSION['categories'][$numColonne];

	$sheet->setCellValue($localisation, $value);
}

/* GENERATION DES DATAS */
for($numColonne=0 ; $numColonne<count($_SESSION['subtitles']) ; $numColonne++){
	$nom = $_SESSION['subtitles'][$numColonne];
	for($numLigne=0 ; $numLigne<count($_SESSION['series'][$nom]) ; $numLigne++){
		$localisation  	= $colonne[$numColonne+1].($numLigne+2);		
		$value 			= $_SESSION['series'][$nom][$numLigne];
	
		$sheet->setCellValue($localisation, $value);
	}	
}

/* Augmentation de la taille de la colonne des dates*/
$sheet->getColumnDimension('A')->setWidth(12);

/*
$objPHPExcel->getActiveSheet()->setCellValue('A8',"Hello\nWorld");
$objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(-1);
$objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setWrapText(true);
*/

// Rename worksheet
echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$objWriter->save(str_replace('.php', '.xlsx', "upload/excel.php"));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Save Excel 95 file
/*echo date('H:i:s') , " Write to Excel5 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;


echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;
*/
// Echo done
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , getcwd()."/upload/" , EOL;
echo 'See by yourself : <a href="upload/excel.xlsx">Excel.xlsx</a>';


?>