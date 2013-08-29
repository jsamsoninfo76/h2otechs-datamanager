<!-- 
@author Jérémie Samson
@version 1

Site :
http://stackoverflow.com/questions/2309801/how-to-submit-checkbox-values-with-php-post-method (variables)
http://php.net/manual/fr/function.count.php (count)
http://php.net/manual/fr/function.strtolower.php (lowercase)
-->

	<table id="tabListData" border="1" rules="rows">
        <?php
                	
	    //Création de la requête et génération du tableau
        $sql_select = generateMoySQL($variables, $dateDebut, $dateFin, $connexion);
        $query_select = $connexion->prepare($sql_select);
        $query_select->execute();
        $query_select->execute();
        $rowcount = $query_select->rowcount();
        
        if ($rowcount > 0){
        	?>
        	<div id="actions">
				<a href="index.php?id_page=6" target="_blank"><img class="icon" title="Exporter au format Excel" src="img/excel.png"></a>
				<a href="index.php?id_page=7" target="_blank"><img class="icon" title="Exporter au format PDF" src="img/pdf.png"></a>
			</div>
        	<tr id="tabListDataHeader">
            	<th title="Date de la moyenne">Date</th>
        	<?php
        $_SESSION['yAxis_title'] = "Moyennes";  

        foreach($variables as $variable){
                $variable = getHeader($variable);
                $_SESSION['subtitles'][] = $variable;
                $_SESSION['unite'][] = getUnite($variable, $connexion);
                echo "<th title='" .getDescriptionOfLabel($variable, $connexion). " en " .getUnite($variable, $connexion). "'>&nbsp;" .getLabel($variable). "&nbsp;</th>";
        }
        echo "</tr>";
        
        //echo "<br>".$sql_select."<br><br>";
        while($data=$query_select->fetch(PDO::FETCH_OBJ)){
                $datetime = $data->datetime;                                            
                
                echo '<tr class=tabListDataCells>';
                        $_SESSION['categories'][] = $data->Annee;
                        echo "<td>" .$data->Annee. "</td>";
                
                        foreach($variables as $variable){
                                $value = strtolower($variable . "_avg");
                                $header = getHeader($variable);
                                $_SESSION['series'][$header][] = round($data->$value);
                                echo "<td title='" .getHeader($variable). "'>" . traitementDecimal($variable, round($data->$value)). "</td>";
                        }
                echo "</tr>";
                        
        }//Fin while
	}
	else{
		echo "<font class='message_error'>Il n'y a aucune donn&eacute;es pour ces dates.</font>";
	}?>
</table>
