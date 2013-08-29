<div id="formInterventions">
	<form action="index.php?id_page=4" name="formReportingIntervention" method="POST" onsubmit="return validerFormReportingIntervention(this)">
		<!-- Titre -->
		<div id='intervenant'>
			<h5 title="Nom/Prenom">*Nom et Pr&eacute;nom de l'intervenant :</h5>
			<div><font class='message_error' id='intervenant_error'></font></div> 

			
			<?php
				$sql_intervenants = getIntervenants();
				$query_intervenants = $connexion->prepare($sql_intervenants);
				$query_intervenants->execute();
				$rowcount = $query_intervenants->rowcount();
				
				if ($rowcount > 0){
					echo '<select name="intervenantGlobal">';
						echo "<option value='KO'>Aucune selection</option>";
						while($data=$query_intervenants->fetch(PDO::FETCH_OBJ))
							echo "<option value='$data->intervenant' " .(($data->intervenant == getMaxUsedIntervenant($connexion)) ?  "selected=selected" : ""). ">$data->intervenant</option>";
					echo "</select>";
					echo "<br/>ou<br/>";
				}
				
			?>
			<input type="text" name="intervenant">
		</div>
		
		<!-- DateDébut Datetimepicker -->
		<div id="datetime_title"><h5>*Date de l'intervention : </h5><font class="message_error" id="datetime_intervention_error"></font></div>
		<div id="datetimepickerIntervention" class="input-append date">
		<input type="text" id="bouttonDate" name="dateIntervention"></input>
	      <span class="add-on">
	        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
	      </span>
	    </div>
		 <!-- Ajout du javascript jquery-->
	    <script type="text/javascript">
	    	$('#datetimepickerIntervention').datetimepicker({ 
	    		format: 'yyyy/MM/dd hh:mm:ss',
	    		pickTime: false,
	    		pickSeconds: true
	    	});
	    </script>
		
		<div class='observationBlock'>
			<h5 title="Votre observation">*Observation</h5> 
			<div><font class='message_error' id='observation_error'></font></div>
			<textarea id='observation' name="observation" rows="10" cols="50"></textarea> 
		    
		     <script type="text/javascript">
				$(document).ready(function() {
				  $('#observation').elastic();
				});
			</script>
		</div>
		
	
		<input type="submit" value="Envoyer">
	</form>
</div>

