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
?>

<html>
	<head>
		<title>H2otechs DataManager</title>
	</head>
	
<body>
	<?php
	$variables = $_POST['variables'];
	$dateDebut = $_POST['dateDebut'];
	$dateFin   = $_POST['dateFin'];
	?>
	
	<center>
		<h1>H2oTechs DataManager V1.0</h1>
	</center>
	
	<table border="1">
	<tr>
		<th>Datetime</th>
		
		<?php
		foreach($variables as $variable)
			echo "<th>" .getHeader($variable). "</th>";
		?>
	</tr>
	
	<?php
	if (isset($variables) && isset($dateDebut) && isset($dateFin)){
		if (is_array($variables)){
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			$sql_select = generateSQL($variables, $dateDebut, $dateFin);
			$query_select = $connexion->prepare($sql_select);
			$query_select->execute();
			echo "<br>".$sql_select."<br><br>";
			while($data=$query_select->fetch(PDO::FETCH_OBJ)){
				echo "<tr>";
					echo "<td>" .$data->datetime. "</td>";
					foreach($variables as $variable){ 
						$value = strtolower($variable . "_value");
						echo "<td>" .$data->$value. "</td>";
					}
				echo "</tr>";
			}
		}
	}
	?>
	
	</table>
	</body>