<?php
	session_start();
	
	/*
	 *@author Jérémie Samson
	 *@version 1
	 *
	 *Site :
	 *http://stackoverflow.com/questions/386281/how-to-implement-select-all-check-box-in-html (checkboxes)
	 *http://www.tizag.com/javascriptT/javascript-string-compare.php (compare strings)
	 *http://tarruda.github.io/bootstrap-datetimepicker/ (datetimepicker)
	 *http://openweb.eu.org/articles/validation_formulaire (validation form)
	 */

	include("include/include.php");
	include("header.html");

	$id_page = $_GET['id_page'];
	
	switch($id_page){
		case 1 : include("form_list.php"); 			break; // index.php?id_page=1
		case 2 : include("list.php"); 				break; // index.php?id_page=2
		case 3 : include("form_interventions.php"); break; // index.php?id_page=3
		case 4 : include("list_interventions.php"); break; // index.php?id_page=4
		case 5 : include("statistique_line.php"); 	break; // index.php?id_page=5
		case 6 : include("excel.php"); 				break; // index.php?id_page=6
		case 7 : include("pdf.php"); 				break; // index.php?id_page=7
		case 8 : include("form_planification.php");	break; // index.php?id_page=8
		default: include("list_planification.php"); break; // index.php
	}

	include("footer.html"); 
?>
