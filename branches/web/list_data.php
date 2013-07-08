<!-- 
@autor Jérémie Samson
@version 1

Site :
http://stackoverflow.com/questions/2309801/how-to-submit-checkbox-values-with-php-post-method (variables)
http://php.net/manual/fr/function.count.php (count)
-->

<?php
	include("include/include.php");
?>

<html>
	<head>
		<title>H2otechs DataManager</title>
	</head>
	
<body>
	<center>
		<h1>H2oTechs DataManager V1.0</h1>
	</center>
	
	<table border="1">
	<tr>
		<td>ID</td>
		<td>Datetime</td>
		<td>Value</td>
		<td>State</td>
		<td>Timestamp</td>
	</tr>
	
	<?php
	$variables = $_POST['variables'];
	$dateDebut = $_POST['dateDebut'];
	$dateFin   = $_POST['dateFin'];
	
	if (isset($variables) && isset($dateDebut) && isset($dateFin)){
		if (is_array($variables)){
			$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
			
			$sql_select = "SELECT * FROM ";

			for($i=0 ; $i < count($variables) ; $i++){
				if ($i != count($variables)) $sql_select .= strtolower($variables[$i] . ',');
				else $sql_select .= strtolower($variables[$i]);
			}
			
			
			$sql_select = substr($sql_select, 0, -1);
			echo $sql_select;
			//$query_select_cfc = $connexion->prepare($sql_select_cfc);
			//$query_select_cfc->execute();
				
		}
	}
	/*

	while($data=$query_select_cfc->fetch(PDO::FETCH_ASSOC)){
		echo "<tr>";
		echo "<td>" .$data['id_cfc']. "</td>";
		echo "<td>" .$data['datetime']. "</td>";
		echo "<td>" .$data['value']. "</td>";
		echo "<td>" .$data['state']. "</td>";
		echo "<td>" .$data['timestamp']. "</td>";
		echo "</tr>";	
	}
	*/
	?>

	</table>
	</body>