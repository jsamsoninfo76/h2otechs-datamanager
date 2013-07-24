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
		case 1 : include("form_list.php"); 			break;
		case 2 : include("list.php"); 				break;
		case 3 : include("form_interventions.php"); break;
		case 4 : include("list_interventions.php"); break;
		case 5 : include("statistique_line.php"); 	break;
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
