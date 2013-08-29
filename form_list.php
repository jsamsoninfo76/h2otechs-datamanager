<!--
* http://jsbin.com/oheqom/1/edit (elastic)
*
*
-->
<form action="index.php?id_page=2" name="formList" method="POST" onsubmit="return valider(this)">
	<div id="variables">
		<!-- Titre -->
		<h5 title="Au moins une">*Quelle donn&eacute;es voulez vous r&eacute;cup&eacute;rer ?</h5> 
		
		<!-- Outil pour sélection global et préférenciel -->
		<div id="variables_tools">
			<input type="radio" name="tools" onClick="selectAll(this)"> Tout s&eacute;lectionner<br>
			<input type="radio" name="tools" onClick="resetAll(this)"> Reset<br>
			<!--<input type="radio" name="tools" onClick="selectPref(this)"> S&eacute;lectionner CFP et PC<br><br>-->
		</div>
		
		<!-- Affichage erreur sur sélection -->
		<font  class="message_error" id="variables_checked_error"></font>
		
		<!-- Tableau des variables -->
		<div id="variables_header">
			<table id="tabVariables" cellpadding="5">
				<?php
					$unite = "";
					$compteurPair = 1;
					$numligne = 0;
					
					//Recupération des données de variable
					$connexion = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'], $config['user'], $config['pass']);
					$sql_select_variables = "SELECT * FROM variables ORDER BY unite ASC";
					$query_select_variables = $connexion->prepare($sql_select_variables);
					$query_select_variables->execute();
	
					//Tant qu'il y a des données
					while($data=$query_select_variables->fetch(PDO::FETCH_ASSOC)){
						//Pair ou impaire Pour background sur la ligne
						$trColor = ($compteurPair%2) ?  "class'ligne_impair'" : "class='ligne_pair'";
						
						//La donnée est une unité
						if ($data['unite'] != $unite) {
							//Incrémentation du compteur
							$compteurPair++;
							if ($unite != "") echo "</tr>"; //Si l'unite est vide (première data)
							echo "<tr $trColor>";

							$unite = $data['unite'];
							
							//On écrit l'unité puis la première value
							echo '<td><input type="radio" name="tools" onClick="select_' .$unite. '(this)"></td>';
							echo '<td id="tabVariablesHeader"><center>'.verifExposant($unite).'</center></td>';
							echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .getLabel($data['label']) .'</td>';
							$numligne++;
						}
						else{
							//On écrit la value
							echo '<td title="' .$data['description']. '"><input type="checkbox" name="variables[]" value="data_' .$data['label']. '">&nbsp;&nbsp;' .getLabel($data['label']) .'</td>';	
						}
					}
				?>
			</tr>
			</table>
		</div>
	</div>

	<div id='selecteur'>
    	<h5>*Que souhaitez-vous r&eacute;cup&eacute;rer ?</h5>
    	<select name='selecteurMoy'>
    		<option value='datas'>Donn&eacute;es</option>
    		<option value='datasmoyennes' selected="true">Donn&eacute;es et Moyennes</option>
    		<option value='moyennes'>Moyennes</option>
    	</select>
    </div>

	<!-- Récupération de date et d'heure -->
	<div id="datetimes">
		<!-- Titre global -->
		<h5>Date et heure de d&eacute;but et de fin ?</h5>
		
		<!-- Titre Date de début-->
		<div id="datetime_title">*Date de d&eacute;but : <font  class="message_error" id="datetime_debut_error"></font></div>
		
		<!-- DateDébut Datetimepicker -->
		<div id="datetimepickerDebut" class="input-append date">
		<input type="text" id="bouttonDate" name="dateDebut"></input>
	      <span class="add-on">
	        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
	      </span>
	    </div>
	    
	    <!-- Titre Date de fin -->
	    <div id="datetime_title">*Date de fin : <font  class="message_error" id="datetime_fin_error"></font></div>
	    
	    <!-- DateFin Datetimepicker-->
	    <div id="datetimepickerFin" class="input-append date">
	      <input type="text" id="bouttonDate" name="dateFin"></input>
	      <span class="add-on">
	        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
	      </span>
	    </div>
    </div>
    		    
    <!-- Ajout du javascript jquery-->
    <script type="text/javascript">
    	$('#datetimepickerDebut').datetimepicker({ 
    		format: 'yyyy/MM/dd hh:mm:ss',
    		pickSeconds: true 
    	});
        $('#datetimepickerFin').datetimepicker({ 
        	format: 'yyyy/MM/dd hh:mm:ss',
        	pickSeconds: true,
         });
    </script>
    
    <!-- Envoie du formulaire -->
    <br><br><input type="submit" value="Envoyer">
    </div>
</form>
