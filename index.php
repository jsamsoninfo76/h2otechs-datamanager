<!-- 
@autor Jérémie Samson
@version 1

Site :
http://stackoverflow.com/questions/386281/how-to-implement-select-all-check-box-in-html (checkboxes)
http://www.tizag.com/javascriptT/javascript-string-compare.php (compare strings)
http://tarruda.github.io/bootstrap-datetimepicker/ (datetimepicker)
http://openweb.eu.org/articles/validation_formulaire (validation form)
-->

<?php
	include("include/include.php");
	include("header.html");

	switch($_GET['id_page']){
		case 1 : include("form_list.php"); 			break; // index?id_page=1
		case 2 : include("list.php"); 				break; // index?id_page=2
		case 3 : include("form_interventions.php"); break; // index?id_page=3
		case 4 : include("list_interventions.php"); break; // index?id_page=4
		case 5 : include("statistique_line.php"); 	break; // index?id_page=5
		case 6 : include("excel.php"); 				break; // index?id_page=6
		case 7 : include("pdf.php"); 				break; // index?id_page=7
		default : 
			?>
				<div id="index">
					<p id="presentation">
						Bienvenue dans votre espace de gestion de donn&eacute;es, bonne navigation.
					</p>
				</div>
			<?php
		break;
	}

	include("footer.html"); 
?>
