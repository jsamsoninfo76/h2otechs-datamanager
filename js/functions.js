/*
 *@autor Jérémie Samson
 *@version 1
 * 
 *Sites
 * http://www.siteduzero.com/forum/sujet/verifier-une-date-au-format-jjmmaaaa-93090 (regex)
 */


/**
 * Affiche ou non le 2eme element en fonction du bouton radio coché
 */
function makeChoice(){
	var choix = document.getElementsByName("choix");
     
    for(var elem in choix)
    {
        if(choix[elem].checked)
        {
            var div = document.getElementById("blockFormIntervention");
            if (choix[elem].value == "Tous"){
                div.style.display = "none";
            }
            else
                div.style.display = "block";

        }
    }
}

/**
 * Validation du reporting d'interventions
 */
function validerReportingInterventions(form){
  var res = 0;
  var regexDateTime = /^[2-9][0-9][0-9][0-9]\/[0-1][0-9]\/[0-3][0-9]\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/;
  var dateDebut = form.elements['dateDebutReportingIntervention'];
  var dateFin = form.elements['dateFinReportingIntervention'];
  var choix = form.elements['choix'];
  var faireTest = 1;
  
  for(var elem in choix)
  {
        if(choix[elem].checked && choix[elem].value == "Tous")
            	faireTest = 0;
  }
  
  if (faireTest == 1){
	  //Verification sur la date de début
	  if(dateDebut.value != "") {
		  var isDate = regexDateTime.test(dateDebut.value);
		  if (isDate){
		  	  res++;
			  document.getElementById("datedebut_reporting_intervention_error").innerHTML = "";
			  dateDebut.style.backgroundColor = '#FFFFFF';  	  
		  }
		  else{
			  document.getElementById("datedebut_reporting_intervention_error").innerHTML = "Le format de la date doit être : 'AAAA/MM/JJ HH:MM:SS'.";
			  dateDebut.style.backgroundColor = '#FF6469';
		  }
	  }else{
	  	  document.getElementById("datedebut_reporting_intervention_error").innerHTML = "La date de d&eacute;but doit &ecirc;tre remplit au format : 'AAAA/MM/JJ HH:MM:SS'.";
		  dateDebut.style.backgroundColor = '#FF6469';
	  }
	  
	   //Verification sur la date de début
	  if(dateFin.value != "") {
		  var isDate = regexDateTime.test(dateFin.value);
		  if (isDate){
		  	  res++;
			  document.getElementById("datefin_reporting_intervention_error").innerHTML = "";
			  dateFin.style.backgroundColor = '#FFFFFF';  	  
		  }
		  else{
			  document.getElementById("datefin_reporting_intervention_error").innerHTML = "Le format de la date doit être : 'AAAA/MM/JJ HH:MM:SS'.";
			  dateFin.style.backgroundColor = '#FF6469';
		  }
	  }else{
	  	  document.getElementById("datefin_reporting_intervention_error").innerHTML = "La date de d&eacute;but doit &ecirc;tre remplit au format : 'AAAA/MM/JJ HH:MM:SS'.";
		  dateFin.style.backgroundColor = '#FF6469';
	  }
	
	  if (res == 2)
	  	return true;
	  else
	    return false;
  }
  else
  	return true;
}


/**
 * Submit le formulaire si les deux champs sont remplient
 */
function validerFormCourbes(fromSelect){
  var form = document.getElementById('formCourbes');
  var res = 0;
  var regexDateTime = /^[2-9][0-9][0-9][0-9]\/[0-1][0-9]\/[0-3][0-9]\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/;
  var dateDebut = form.elements['datedebut'];
  
  //Verification sur le nombre d'arguments coché
  var variables = form.elements['variables[]'];
  var nbChecked = 0;
  for (var i=0 ; i< variables.length ; i++)
  {
  	if(variables.item(i).checked)
  		nbChecked++;
  }

  if (nbChecked > 0 ){
  	  res++;
  	  document.getElementById("variables_checked_error").innerHTML = "";
  }
  else{
  	  document.getElementById("variables_checked_error").innerHTML = "Il doit au moins y avoir une variable de coch&eacute;e.";
  }
  
   //Verification sur la date de début
  if(dateDebut.value != "") {
	  var isDate = regexDateTime.test(dateDebut.value);
	  if (isDate){
	  	  res++;
		  document.getElementById("datetime_courbes_error").innerHTML = "";
		  dateDebut.style.backgroundColor = '#FFFFFF';  	  
	  }
	  else{
		  document.getElementById("datetime_courbes_error").innerHTML = "Le format de la date doit être : 'AAAA/MM/JJ HH:MM:SS'.";
		  dateDebut.style.backgroundColor = '#FF6469';
	  }
  }else{
  	  document.getElementById("datetime_courbes_error").innerHTML = "La date de d&eacute;but doit &ecirc;tre remplit au format : 'AAAA/MM/JJ HH:MM:SS'.";
	  dateDebut.style.backgroundColor = '#FF6469';
  }

  if (res == 2 && fromSelect == 0)
  	form.submit();
  else if (fromSelect == 1 && res == 2) 
  	form.submit();
  else{
	  if (fromSelect == 0) return false; 
  } 
}

/** 
 * Ajoute un champ select si la fréquence est sélectionné
 */
function innerMateriel(select){
	var value = select.value;
	var materielblock = document.getElementById("materielBloc");
	materielblock.innerHTML = "";
	
	if (value != ""){
		
		materielblock.innerHTML  = '<div id="materiel_title">';
			materielblock.innerHTML += '<h5>*Mat&eacute;riel : </h5>';
			materielblock.innerHTML += '<font class="message_error" id="materiel_uptime_error"></font>';
		materielblock.innerHTML += '</div>';
		materielblock.innerHTML += '<select name="materiel"><option value="CATL">CATL</option></select>';
	}
}

/** 
 * Ajoute un champ select si la fréquence est sélectionné
 */
function innerUpdate(select){
	var value = select.value;
	var materielblock = document.getElementById("materielBloc");
	
	//Rien pour le moment
	if (value != ""){
		if (materielblock != "")
			materielblock.innerHTML = "";
	}
	else{

	}
}

/**
 * Sélectionne tous les boutons radios
 * @param source bouton radio du selectAll
 */
function selectAll(source){
	checkboxes = document.getElementsByName('variables[]');
	
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}

/**
 * Désélectionne tous les boutons radios
 * @param source bouton radio du resetAll
 */
function resetAll(source){
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = !source.checked;
	}
}

/**
 * Sélectionne les boutons radios passé en préférence
 * @param source bouton radio du selectPref
 */			
function selectPref(source){
	//CFP
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_CFP" || checkboxes[i].value == "data_PC")
			checkboxes[i].checked = source.checked;
	}

}

/**
 * Sélectionne les unites cf : CFC, CFL, CFP, CFPC, CFPL
 * @param source bouton radio
 */
function select_cf(source){
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_CFC" || checkboxes[i].value == "data_CFL" || checkboxes[i].value == "data_CFL1" || checkboxes[i].value == "data_CFP" || checkboxes[i].value == "data_CFPC" || checkboxes[i].value == "data_CFPL" || checkboxes[i].value == "data_CFPL1" || checkboxes[i].value == "data_CFPL2" || checkboxes[i].value == "data_CFPL3")
			checkboxes[i].checked = source.checked;
	}
}

/**
 * Sélectionne les unites h : Compt hor prod
 * @param source bouton radio
 */
function select_h(source){
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_Compt_hor_prod")
			checkboxes[i].checked = source.checked;
	}
}

/**
 * Sélectionne les unites m3 : FCTL, FLE, Totalisateur 1 2 et 3
 * @param source bouton radio
 */
function select_m3(source){
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_FCTL" || checkboxes[i].value == "data_FLE" || checkboxes[i].value == "data_TOTALISATEUR_1" || checkboxes[i].value == "data_TOTALISATEUR_2" || checkboxes[i].value == "data_TOTALISATEUR_3")
			checkboxes[i].checked = source.checked;
	}
}

/**
 * Sélectionne les unites PH : PC, PFIL1, PFIL2, PFIL3
 * @param source bouton radio
 */
function select_bar(source){
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_PC" || checkboxes[i].value == "data_PFIL1" || checkboxes[i].value == "data_PFIL2" || checkboxes[i].value == "data_PFIL3" || checkboxes[i].value == "data_PL" || checkboxes[i].value == "data_PP" || checkboxes[i].value == "data_PPE")
			checkboxes[i].checked = source.checked;
	}
}

/**
 * Sélectionne les boutons radios de la ligne 13: PH_R, PH_L, PH_C
 * @param source bouton radio
 */
function select_ph(source){
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_PH_R" || checkboxes[i].value == "data_PH_L" || checkboxes[i].value == "data_PH_C" || checkboxes[i].value == "data_PH_L1" || checkboxes[i].value == "data_PH_L2")
			checkboxes[i].checked = source.checked;
	}
}

/**
 * Sélectionne les boutons radios de la ligne 5 : RENDT_ETAGE1, RENDT_ETAGE2, RENDT_ETAGE3, RENDT_ETAGES
 * @param source bouton radio
 */
function select_pourcent(source){
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_RENDT_ETAGE1" || checkboxes[i].value == "data_RENDT_ETAGE2" || checkboxes[i].value == "data_RENDT_ETAGE3" || checkboxes[i].value == "data_RENDT_ETAGES")
			checkboxes[i].checked = source.checked;
	}
}

/**
 * Vérification du formulaire
 * @param source le formulaire
 */	
function valider(form){
  var res = 0;
  var regexDateTime = /^[2-9][0-9][0-9][0-9]\/[0-1][0-9]\/[0-3][0-9]\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/;
  var dateFin = form.elements['dateFin'];
  var dateDebut = form.elements['dateDebut'];
  
  //Verification sur le nombre d'arguments coché
  var variables = document.getElementsByName("variables[]");
  var nbChecked = 0;
  for (var i=0 ; i< variables.length ; i++)
  {
  	if(variables.item(i).checked)
  		nbChecked++;
  }
  if (nbChecked > 0 ){
  	  res++;
  	  document.getElementById("variables_checked_error").innerHTML = "";
  }
  else{
  	  document.getElementById("variables_checked_error").innerHTML = "Il doit au moins y avoir une variable de coch&eacute;e.";
  }
   
  //Verification sur la date de début
  if(dateDebut.value != "") {
	  var isDate = regexDateTime.test(dateDebut.value);
	  if (isDate){
	  	  res++;
		  document.getElementById("datetime_debut_error").innerHTML = "";
		  dateDebut.style.backgroundColor = '#FFFFFF';  
		  
		  //Verification si la date de fin est completé
	  	  if (dateFin.value != ""){
	  	  
	  	  	  //Comparaison date de début et date de fin
		  	  if (debutSupFin(dateDebut.value, dateFin.value)){
				  document.getElementById("datetime_debut_error").innerHTML = "La date de d&eacute;but doit &ecirc;tre inf&eacute;rieur &agrave; la date de fin.";
				  dateDebut.style.backgroundColor = '#FF6469';
			  }
			  else{
				res++;
				document.getElementById("datetime_debut_error").innerHTML = "";
				dateDebut.style.backgroundColor = '#FFFFFF';  
			  }
			  
		  }
	  }
	  else{
		  document.getElementById("datetime_debut_error").innerHTML = "Le format de la date doit être : 'AAAA/MM/JJ HH:MM:SS'.";
		  dateDebut.style.backgroundColor = '#FF6469';
	  }
  }else{
  	  document.getElementById("datetime_debut_error").innerHTML = "La date de d&eacute;but doit &ecirc;tre remplit au format : 'AAAA/MM/JJ HH:MM:SS'.";
	  dateDebut.style.backgroundColor = '#FF6469';
  }
  
  //Même vérification sur la date de fin
  if(dateFin.value != "") {
	  var test = regexDateTime.test(dateFin.value);
	  if (test){
	   	  res++;
	   	  document.getElementById("datetime_fin_error").innerHTML = "";
	   	  dateFin.style.backgroundColor = '#FFFFFF';
	  }
	  else {
		  document.getElementById("datetime_fin_error").innerHTML = "Le format de la date doit être : 'AAAA/MM/JJ HH:MM:SS'.";
		  dateFin.style.backgroundColor = '#FF6469';
	  }
  }else{
  	  document.getElementById("datetime_fin_error").innerHTML = "La date de fin doit &ecirc;tre remplit au format : 'AAAA/MM/JJ HH:MM:SS'.";
	  dateFin.style.backgroundColor = '#FF6469';
  }
  
  if (res == 4) return true;
  else return false;
}


/**
 * Comparaison entre les deux dates après convertion en objet Date
 */
function debutSupFin(dateDebut, dateFin)
{
	var date1 = new Date();
	date1.setYear(dateDebut.substring(0, 4));
	date1.setMonth(dateDebut.substr(5,2));
	date1.setDate(dateDebut.substr(8,2));
	date1.setHours(dateDebut.substr(11,2));
	date1.setMinutes(dateDebut.substr(14,2));
	date1.setSeconds(dateDebut.substr(17,2));
	date1.setMilliseconds(0);
	var debut=date1.getTime();

	 
	var date2 = new Date();
	date2.setYear(dateFin.substring(0, 4));
	date2.setMonth(dateFin.substr(5,2));
	date2.setDate(dateFin.substr(8,2));
	date2.setHours(dateFin.substr(11,2));
	date2.setMinutes(dateFin.substr(14,2));
	date2.setSeconds(dateFin.substr(17,2));
	date2.setMilliseconds(0);
	var fin=date2.getTime();

	if (debut > fin) return true;
	else return false;
}

/**
 * Vérification du formulaire
 * @param source le formulaire
 */	
function validerFormIntervention(form){
  var res = 0;
  var regexDateTime = /^[2-9][0-9][0-9][0-9]\/[0-1][0-9]\/[0-3][0-9]\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/;
  var dateDebut = form.elements['dateIntervention'];
  
   //Verification sur la date de début
  if(dateDebut.value != "") {
	  var isDate = regexDateTime.test(dateDebut.value);
	  if (isDate){
	  	  res++;
		  document.getElementById("datetime_intervention_error").innerHTML = "";
		  dateDebut.style.backgroundColor = '#FFFFFF';  	  
	  }
	  else{
		  document.getElementById("datetime_intervention_error").innerHTML = "Le format de la date doit être : 'AAAA/MM/JJ HH:MM:SS'.";
		  dateDebut.style.backgroundColor = '#FF6469';
	  }
  }else{
  	  document.getElementById("datetime_intervention_error").innerHTML = "La date de l'intervention doit &ecirc;tre remplit au format : 'AAAA/MM/JJ HH:MM:SS'.";
	  dateDebut.style.backgroundColor = '#FF6469';
  }
  
  //Verification de l'intervenant
  var intervenant = form.elements['intervenant'];
  if (intervenant.value != ""){
  	  res++;
	  document.getElementById('intervenant_error').innerHTML = "";
	  intervenant.style.backgroundColor = '#FFFFFF';  	  
  }else {
	  document.getElementById("intervenant_error").innerHTML = "L'intervenant est vide";
	  intervenant.style.backgroundColor = '#FF6469';
  }
  
  //Verification de l'observation
  var observation = form.elements['observation'];
  if (observation.value != ""){
  	  res++;
	  document.getElementById('observation_error').innerHTML = "";
	  observation.style.backgroundColor = '#FFFFFF';  	  
  }else {
	  document.getElementById("observation_error").innerHTML = "L'observation est vide";
	  observation.style.backgroundColor = '#FF6469';
  }
    
  if (res == 3) return true;
  else return false;
}

/**
 * Vérification du formulaire
 * @param source le formulaire
 */	
function validerFormPlanification(form){
  var res = 0;
  var regexDateTime = /^[2-9][0-9][0-9][0-9]\/[0-1][0-9]\/[0-3][0-9]\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/;
  var dateDebut = form.elements['datePlanification'];
  
   //Verification sur la date de début
  if(dateDebut.value != "") {
	  var isDate = regexDateTime.test(dateDebut.value);
	  if (isDate){
	  	  res++;
		  document.getElementById("datetime_planification_error").innerHTML = "";
		  dateDebut.style.backgroundColor = '#FFFFFF';  	  
	  }
	  else{
		  document.getElementById("datetime_planification_error").innerHTML = "Le format de la date doit être : 'AAAA/MM/JJ HH:MM:SS'.";
		  dateDebut.style.backgroundColor = '#FF6469';
	  }
  }else{
  	  document.getElementById("datetime_planification_error").innerHTML = "La date de la planification doit &ecirc;tre remplit au format : 'AAAA/MM/JJ HH:MM:SS'.";
	  dateDebut.style.backgroundColor = '#FF6469';
  }
  
  //Verification de la frequence et de l'uptime
  var frequence = form.elements['frequence'];
  var uptime 	= form.elements['uptime'];
  if ((frequence.value != "" && uptime.value == "") || (frequence.value == "" && uptime.value != "")){
  	  res++;
	  document.getElementById('frequence_uptime_error').innerHTML = "";
	  frequence.style.backgroundColor = '#FFFFFF';  	  
	  uptime.style.backgroundColor = '#FFFFFF';
  }else if(frequence.value != "" && uptime.value != "") {
	  document.getElementById("frequence_uptime_error").innerHTML = "Vous devez s&eacute;lectionner l'un ou l'autre mais pas les deux.";
	  frequence.style.backgroundColor = '#FF6469';
	  uptime.style.backgroundColor = '#FF6469';
  }else if(frequence.value == "" && uptime.value == ""){
	  document.getElementById("frequence_uptime_error").innerHTML = "Vous devez au moins s&eacute;lectionner l'un ou l'autre.";
	  frequence.style.backgroundColor = '#FF6469'; 
	  uptime.style.backgroundColor = '#FF6469';
  }
  
  //Verification de la description
  var description = form.elements['description'];
  if (description.value != ""){
  	  res++;
	  document.getElementById('description_error').innerHTML = "";
	  description.style.backgroundColor = '#FFFFFF';  	  
  }else {
	  document.getElementById("description_error").innerHTML = "La description est vide";
	  description.style.backgroundColor = '#FF6469';
  }
    
  if (res == 3) return true;
  else return false;
}