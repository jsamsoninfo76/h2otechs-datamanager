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
 
session_unset();  


//Récupération des variables
$variables = $_POST['variables'];
$dateDebut = $_POST['dateDebut'];
$dateFin   = $_POST['dateFin'];
$select    = $_POST['selecteurMoy']; // datas, datasandmoyennes, moyennes

//Test sur les différentes variables récupérées
if (isset($variables) && isset($dateDebut) && isset($dateFin) && isset( $select)){
	//Test sur les variables si c'est un tableau ou non
	if (is_array($variables)){ ?>
		<?php 
		
			//Connexion à la base de données
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
		?>
							 	
		<!-- Création du tableau et de son header-->
		<div id="list">
			<div id="actions">
				<a href="index.php?id_page=5" target="_blank"><img class="icon" title="Voir le tableau sous forme de statistiques" src="img/stat.png"></a>
				<a href="index.php?id_page=6" target="_blank"><img class="icon" title="Exporter au format Excel" src="img/excel.png"></a>
				<a href="index.php?id_page=7" target="_blank"><img class="icon" title="Exporter au format PDF" src="img/pdf.png"></a>
			</div>

			<?php
				//Preparation des donnees de session
				$_SESSION['subtitles'] = null;
				$_SESSION['categories'] = null;
				$_SESSION['tooltip'] = "";
				$_SESSION['series'] = null;
				$_SESSION['dateDebut'] = str_replace("/", "-", substr($dateDebut ,0 ,10 ));
				$_SESSION['dateFin'] = str_replace("/", "-", substr($dateFin ,0 , 10));
				$_SESSION['tailleColonne'] = null;
				
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