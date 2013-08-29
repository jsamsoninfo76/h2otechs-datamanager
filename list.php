<?php
/*
 * @author Jérémie Samson
 * @version 1
 *
 * Site :
 * http://stackoverflow.com/questions/2309801/how-to-submit-checkbox-values-with-php-post-method (variables)
 * http://php.net/manual/fr/function.count.php (count)
 * http://php.net/manual/fr/function.strtolower.php (lowercase)
 */

//Récupération des variables
$variables = $_POST['variables'];
$dateDebut = $_POST['dateDebut'];
$dateFin   = $_POST['dateFin'];
$select    = $_POST['selecteurMoy']; // datas, datasandmoyennes, moyennes

echo "<a name='download'></a>";

//Test sur les différentes variables récupérées
if (isset($variables) && isset($dateDebut) && isset($dateFin) && isset( $select)){
	//Test sur les variables si c'est un tableau ou non
	if (is_array($variables)){ ?>							 	
		<!-- Création du tableau et de son header-->
		<div id="list">
			<?php
				$_SESSION = array();
                $_SESSION['dateDebut'] = str_replace("/", "-", substr($dateDebut ,0 ,10 ));
                $_SESSION['dateFin'] = str_replace("/", "-", substr($dateFin ,0 , 10));
                
				if ($select == "datas") include("list_datas.php");
				if ($select == "moyennes") include("list_moyennes.php");
				if ($select == "datasmoyennes") include("list_datasmoyennes.php");
			?>
		</div>
	<?php
	}
}
else
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php">';
?>