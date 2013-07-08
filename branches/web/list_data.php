<?php

include("include/include.php");
?>
<html>
	<head>
		<title>H2otechs DataManager</title>
	</head>
	
	

?>

<body>
	<table border="1">
	<tr>
		<td>ID</td>
		<td>Datetime</td>
		<td>Value</td>
		<td>State</td>
		<td>Timestamp</td>
	</tr>
	
	<?php
	
$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
$sql_select_cfc = "SELECT * FROM data_cfc";
$query_select_cfc = $connexion->prepare($sql_select_cfc);
$query_select_cfc->execute();
	
	while($data=$query_select_cfc->fetch(PDO::FETCH_ASSOC)){
		echo "<tr>";
		echo "<td>" .$data['id_cfc']. "</td>";
		echo "<td>" .$data['datetime']. "</td>";
		echo "<td>" .$data['value']. "</td>";
		echo "<td>" .$data['state']. "</td>";
		echo "<td>" .$data['timestamp']. "</td>";
		echo "</tr>";	
	}
	?>

	</table>
	</body>