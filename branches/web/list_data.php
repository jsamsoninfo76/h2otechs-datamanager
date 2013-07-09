<!-- 
@autor Jérémie Samson
@version 1

Site :
http://stackoverflow.com/questions/2309801/how-to-submit-checkbox-values-with-php-post-method (variables)
http://php.net/manual/fr/function.count.php (count)
http://php.net/manual/fr/function.strtolower.php (lowercase)
-->

<?php
	include("include/include.php");
	$variables = $_POST['variables'];
	$dateDebut = $_POST['dateDebut'];
	$dateFin   = $_POST['dateFin'];
	
	//Test sur les différentes variables récupérées
	if (isset($variables) && isset($dateDebut) && isset($dateFin)){
		if (is_array($variables)){ ?>
			<html>
				<head>
					<title>H2otechs DataManager</title>
					<link rel="stylesheet" href="css/style.css">
				</head>
				
				<body>
					<?php include("header.html");
					
					echo "<div id='corp'>";
			
						//Connexion à la base de données
						$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
						?>
								 	
						<!-- Création du tableau et de son header-->
						<table border="1">
							<tr>
								<th title="Temps au format AAAA/MM/JJ HH:MM:SS de la prise de donn&eacute;e">Datetime</th>
											
								<?php
									foreach($variables as $variable){
										$variable = getHeader($variable);
										echo "<th title='" .getDescriptionOfLabel($variable, $connexion). "'>" .$variable. "</th>";
									}
							echo "</tr>";
									 
							//Création de la requête et génération du tableau
							$sql_select = generateSQL($variables, $dateDebut, $dateFin);
							$query_select = $connexion->prepare($sql_select);
							$query_select->execute();
										
							echo "<br>".$sql_select."<br><br>";
							while($data=$query_select->fetch(PDO::FETCH_OBJ)){
								echo "<tr>";
									echo "<td>" .$data->datetime. "</td>";
									foreach($variables as $variable){ 
										//Mise en lower du data_label_value
										$value = strtolower($variable . "_value");
										
										//Si la value est vide
										if ($data->$value == "") {
										
											//Si la dernière valeur est aussi vide
											if ($lastValue[$variable] == "")
												$lastValue[$variable] = getLastValue($variable, $dateDebut, $connexion);
												
											echo "<td>" .$lastValue[$variable]. "</td>";
										}
										else {
											$lastValue[$variable] = $data->$value;
											echo "<td>" .$lastValue[$variable]. "</td>";
										}
									}
								echo "</tr>";
							}
						echo "</table>";
					echo "</div>";
					include("footer.html");
			}
	}
	else
		echo '<META HTTP-EQUIV="Refresh" CONTENT="0;URL=index.php">';
	?>
	
	</body>
</html>