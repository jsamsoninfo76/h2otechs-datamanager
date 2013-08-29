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
 */

/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

$_SESSION['decalagepdf'] = 4;
include "excel.php";

/** PHPExcel_IOFactory */
require_once 'include/include.php';


//filename & Path
$path = "upload/pdf";
$filename = $_SESSION['dateDebut'] ."_au_". $_SESSION['dateFin'] ."_". $_SESSION['yAxis_title'] ."_". "Enki" .$config['enki']. ".pdf";

//	Change these values to select the Rendering library that you wish to use
//		and its directory location on your server
$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
$rendererLibrary = '';
$rendererLibraryPath = 'include/utile/tcpdf/' . $rendererLibrary;


if ($verbose) echo date('H:i:s') , " Hide grid lines" , EOL;
$objPHPExcel->getActiveSheet()->setShowGridLines(false);

//if ($verbose) echo date('H:i:s') , " Set orientation to landscape" , EOL;
//$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);


if ($verbose) echo date('H:i:s') , " Write to PDF format using {$rendererName}" , EOL;

if (!PHPExcel_Settings::setPdfRenderer(
		$rendererName,
		$rendererLibraryPath
	)) {
	die(
		'NOTICE: Please set the $rendererName and $rendererLibraryPath values' .
		EOL .
		'at the top of this script as appropriate for your directory structure'
	);
}


$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
$objWriter->setSheetIndex(0);
$objWriter->save($path . "/" .$filename);
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
if ($verbose) echo date('H:i:s') , " File written to " , str_replace('.php', '_'.$rendererName.'.pdf', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
if ($verbose) echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// if ($verbose) echo memory usage
if ($verbose) echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// if ($verbose) echo memory peak usage
if ($verbose) echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// if ($verbose) echo done
if ($verbose) echo date('H:i:s') , " Done writing files" , EOL;
if ($verbose) echo 'File has been created in ' , getcwd() , EOL;
echo '<br/><a href="' $path .'/'. $filename. '">Voir le document PDF</a>';
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=downloadfile.php?dir=pdf&filename=$filename'>";
echo '<br/><a href="downloadfile.php?dir=pdf&filename=' .$filename. '">Cliquez ici si le t&eacute;l&eacute;chargement ne commence pas</a>';
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$path/" .$filename . "'>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=downloadfile.php?dir=pdf&filename=$filename'>";
?>