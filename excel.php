<?php

//– On inclus les fichiers PHPExel
include "include/utile/Excel/PHPExcel.php";
include "include/utile/Excel/Excel2007.php";

//– Go !
$objPHPExcel = new PHPExcel();

//– Quelques propriétées
$objPHPExcel->getProperties()->setCreator("DevZone");
$objPHPExcel->getProperties()->setLastModifiedBy("DevZone");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX");
$objPHPExcel->getProperties()->setDescription("Office 2007 XLSX – By DevZone – With PHPExel");

//– Les Données
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue(‘A1′, ‘La cellule A1′);
$objPHPExcel->getActiveSheet()->SetCellValue(‘B2′, ‘La cellule B2′);
$objPHPExcel->getActiveSheet()->SetCellValue(‘C1′, ‘La cellule C1′);
$objPHPExcel->getActiveSheet()->SetCellValue(‘D2′, ‘La cellule D2′);

//– On nomme notre feuillet
$objPHPExcel->getActiveSheet()->setTitle(‘Exemple’);

//– On sauvegarde notre fichier (Format Excel 2007)
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save(‘Office 2007 XLSX.xlsx’);

?>