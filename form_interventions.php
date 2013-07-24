<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript" src="http://jquery-elastic.googlecode.com/svn/trunk/jquery.elastic.source.js"></script>

<div id="formInterventions">
	<form action="index.php?id_page=4" name="formIntervention" method="POST" onsubmit="return validerFormIntervention(this)">
		<!-- Titre -->
		<h5 title="Nom/Prenom">*Nom et Pr&eacute;nom de l'intervenant :</h5>
		<div><font class='message_error' id='intervenant_error'></font></div> 
		<input type="text" name="intervenant">
		
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
		
		<h5 title="Votre observation">*Observation</h5> 
		<div><font class='message_error' id='observation_error'></font></div>
		<textarea id='observation' name="observation" rows="10" cols="500"></textarea> 
	    
	     <script type="text/javascript">
			$(document).ready(function() {
			  $('#observation').elastic();
			});
		</script>

		<br/>
		<input type="submit" value="Envoyer">
	</form>
</div>

