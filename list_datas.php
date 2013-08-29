<!-- 
@author Jérémie Samson
@version 1

Site :
http://stackoverflow.com/questions/2309801/how-to-submit-checkbox-values-with-php-post-method (variables)
http://php.net/manual/fr/function.count.php (count)
http://php.net/manual/fr/function.strtolower.php (lowercase)
-->

<table id="tabListData" border="1" rules="rows">
    <?php   
    	//Création de la requête et génération du tableau
        $sql_select = generateDatasSQL($variables, $dateDebut, $dateFin, $connexion);
        $query_select = $connexion->prepare($sql_select);
        $query_select->execute();
        $rowcount = $query_select->rowcount();
        
     if ($rowcount > 0){  
           
     	?>
     	<div id="actions">
			<a href="index.php?id_page=6" target="_blank"><img class="icon" title="Exporter au format Excel" src="img/excel.png"></a>
			<a href="index.php?id_page=7" target="_blank"><img class="icon" title="Exporter au format PDF" src="img/pdf.png"></a>
		</div>
     	<tr id="tabListDataHeader">
	        <th title="Date au format AAAA/MM/JJ de la prise de donn&eacute;e">Date</th>
	        <th title="Heure de la prise de donn&eacute;e">Heure</th>
    
     	<?php
        $_SESSION['yAxis_title'] = "Donnees";
        foreach($variables as $variable){
                $variable = getHeader($variable);
                $_SESSION['subtitles'][] = $variable;
                $lastValue[$variable] = "";
                $_SESSION['unite'][] = getUnite($variable, $connexion);
                echo "<th title='" .getDescriptionOfLabel($variable, $connexion). " en " .getUnite($variable, $connexion). "'>&nbsp;" .getLabel($variable). "&nbsp;</th>";
        }
                        
        echo "</tr>";
                
        
        
        $compteurPair = 0;
        $compteurRowSpan = 0;
        $nbRowSpan = 0;
        
        echo "ROWCOUNT " . $rowcount;

        while($data=$query_select->fetch(PDO::FETCH_OBJ)){
                $datetime = $data->datetime;
                $compteurPair++;  
                                                                              
                echo '<tr class=tabListDataCells>';
                $_SESSION['categories'][] = $data->datetime;
                if ($compteurRowSpan == $nbRowSpan){
                        $nbRowSpan = getNombreRowSpan($variables, $datetime, $dateFin, $connexion);
                        echo "<td class='tabListDataCellsAnnee' rowspan=" .(($nbRowSpan>1) ? $nbRowSpan : 1). ">";      
	                        echo $data->Annee;
                        echo "</td>";   
                        $compteurRowSpan = 1;
                }else $compteurRowSpan++;
                                                     
                //TD Heure et Intervention
                $heure = ($data->Heure >= 10) ? $data->Heure : "0".$data->Heure;
                $_SESSION['heures'][] = $data->Heure;
                echo "<td>";
	                $nombreInterventionsHeure = getCountInterventionsByHour($datetime, $connexion);
	                if ($nombreInterventionsHeure > 0){
	                        $datetimeIntervention = getDateTimeIntervention($datetime, $connexion);
	                        $paramGetDatetime = str_replace(' ', '_', $datetimeIntervention);
	                        echo "<a href ='index.php?id_page=4&datetime=$paramGetDatetime'><img class='icon' src='img/intervention.png' title='intervention'></a>$heure";
	                }       
	                else
	                        echo "&nbsp;&nbsp;&nbsp; $heure";
                echo "</td>";
                                                                                
                foreach($variables as $variable){ 
                        //Mise en lower du data_label_value
                        $value = strtolower($variable . "_value");
                        $header = getHeader($variable);
                        
                        //Si la value est vide
                        if ($data->$value == "") {
                                //Si la dernière valeur est aussi vide
                                if ($lastValue[$variable] == "")
                                        $lastValue[$variable] = getLastValue($variable, $dateDebut, $connexion);
                        }
                        else 
                                $lastValue[$variable] = $data->$value;
                        
                        echo "<td title='" .getHeader($variable). "'>";
                        echo "<span style='color:;:;(";
                        echo getColor($variable, $lastValue[$variable]);
                        echo ");'>";
                        echo traitementDecimal($variable, $lastValue[$variable]);
                        echo "</span>";
                        echo "</td>";
                        
                        $_SESSION['series'][$header][] = $lastValue[$variable];
                }
                echo "</tr>";
        }//Fin while
      }//$rowcount <= 0 
      else{
      	echo "<font class='message_error'>Il n'y a aucune donn&eacute;es pour ces dates.</font>";
      }?>
</table>
