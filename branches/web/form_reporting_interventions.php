	<form action="index.php?id_page=8" name="formIntervention" method="POST" onsubmit="return validerReportingInterventions(this)">
		<h5>*Que voulez-vous r&eacute;cup&eacute;rer ?</h5>
		<table id="tableChoix">
			<tr id="trChoix"><td id="tdRadio"><input type="radio" name="choix"  value="Tous" onchange="makeChoice()" <?php echo ($_SESSION['choix'] == 'Tous') ? 'checked="checked"' : ''; ?>></td><td id="tdTitre">Toutes les interventions</td></tr>
			<tr id="trChoix"><td id="tdRadio"><input type="radio" name="choix" value="Dates" onchange="makeChoice()" <?php echo ($_SESSION['choix'] != 'Tous') ? 'checked="checked"' : ''; ?>></td><td id="tdTitre">Entre deux dates</td></tr>
		</table>
		
		<div id="blockFormIntervention">
			<!-- DateDébut Datetimepicker -->
			<div id="datedebut_reporting_title"><h5>*Date de d&eacute;but : </h5><font class="message_error" id="datedebut_reporting_intervention_error"></font></div>
			<div id="dateDebutReportingIntervention" class="input-append date">
			<input type="text" id="bouttonDate" name="dateDebutReportingIntervention" value="<?php echo (isset($_SESSION['dateDebutReportingIntervention'])) ? $_SESSION['dateDebutReportingIntervention'] : ""; ?>"></input>
		      <span class="add-on">
		        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
		      </span>
		    </div>
			 <!-- Ajout du javascript jquery-->
		    <script type="text/javascript">
		    	makeChoice();
		    	$('#dateDebutReportingIntervention').datetimepicker({ 
		    		format: 'yyyy/MM/dd hh:mm:ss'
		    	});
		    </script>
		    
			<!-- DateFin Datetimepicker -->
			<div id="datefin_reporting_title"><h5>*Date de fin : </h5><font class="message_error" id="datefin_reporting_intervention_error"></font></div>
			<div id="dateFinReportingIntervention" class="input-append date">
			<input type="text" id="bouttonDate" name="dateFinReportingIntervention" value="<?php echo (isset($_SESSION['dateFinReportingIntervention'])) ? $_SESSION['dateFinReportingIntervention'] : ""; ?>"></input>
		      <span class="add-on">
		        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
		      </span>
		    </div>
			 <!-- Ajout du javascript jquery-->
		    <script type="text/javascript">
		    	$('#dateFinReportingIntervention').datetimepicker({ 
		    		format: 'yyyy/MM/dd hh:mm:ss'
		    	});
		    </script>	
	    </div>
		<input type="submit" value="Recup&eacute;rer">
	</form>
</div>
