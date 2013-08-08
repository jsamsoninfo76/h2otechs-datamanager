<div id="formPlanificateur">
	<form method="post" action="index.php" name="formPlanificateur" onsubmit="return validerFormPlanification(this)">
	
		<!-- DateDébut Datetimepicker -->
		<div id="datetime_title"><h5>*Date de la planification : </h5><font class="message_error" id="datetime_planification_error"></font></div>
		<div id="datetimepickerPlanification" class="input-append date">
		<input type="text" id="bouttonDate" name="datePlanification"></input>
	      <span class="add-on">
	        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
	      </span>
	    </div>
	    
	    <!-- Frequence -->
		<div id="frequence_title">
			<h5>*Fr&eacute;quence / Uptime : </h5>
			<font class="message_error" id="frequence_uptime_error"></font>
		</div>
		<div id="frequenceBloc">
			<select name="frequence">
				<option value="" selected="selected"></option>
				<option value="1/d" >Une fois par jour</option>
				<option value="1/m" >Une fois par mois</option>
				<option value="1/y" >Une fois par an</option>
			</select>
			ou
			<select name="uptime">
				<option value="" selected="selected"></option>
				<option value="250">250 heures</option>
				<option value="500">500 heures</option>
				<option value="750">750 heures</option>
				<option value="1000">1000 heures</option>
			</select>
	    </div>

	    <div id="uptimeBloc">
			
	    </div>
	    
		 <!-- Ajout du javascript jquery-->
	    <script type="text/javascript">
	    	$('#datetimepickerPlanification').datetimepicker({ 
	    		format: 'yyyy/MM/dd hh:mm:ss',
	    		pickTime: false
	    	});
	    </script>
	    
	    <div class='descriptionBloc'>
			<h5 title="Votre description">*Description</h5> 
			<div><font class='message_error' id='description_error'></font></div>
			<textarea id='description' name="description" rows="10" cols="50"></textarea> 
		    
		     <script type="text/javascript">
				$(document).ready(function() {
				  $('#description').elastic();
				});
			</script>
		</div>
		
		<input type="submit" value="Envoyer">
	</form>

</div>