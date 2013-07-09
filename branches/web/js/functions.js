/*
 *@autor Jérémie Samson
 *@version 1
 * 
 *Sites
 *http://www.siteduzero.com/forum/sujet/verifier-une-date-au-format-jjmmaaaa-93090 (regex)
 */

function selectAll(source){
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	}
}
			
function selectPref(source){
	//CFP
	checkboxes = document.getElementsByName('variables[]');
	for(var i=0, n=checkboxes.length;i<n;i++) checkboxes[i].checked = false;
	
    for(var i=0, n=checkboxes.length;i<n;i++) {
    	if(checkboxes[i].value == "data_CFP" || checkboxes[i].value == "data_PC")
			checkboxes[i].checked = source.checked;
	}
}

function valider(form){
  var res = 0;
  var regexDateTime = /^[2-9][0-9][0-9][0-9]\/[0-1][0-9]\/[0-3][0-9]\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/;
   
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
  var dateDebut = form.elements['dateDebut'];
  if(dateDebut.value != "") {
	  var test = regexDateTime.test(dateDebut.value);
	  if (test){
	  	  res++;
	  	  document.getElementById("datetime_debut_error").innerHTML = "";
	  	  dateDebut.style.backgroundColor = '#FFFFFF';
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
  var dateFin = form.elements['dateFin'];
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

  if (debutSupFin(dateDebut.value, dateFin.value)){
	  document.getElementById("datetime_debut_error").innerHTML = "La date de d&eacute;but doit &ecirc;tre inf&eacute;rieur &agrave; la date de fin.";
	  dateDebut.style.backgroundColor = '#FF6469';
  }
  else{
	res++;
	document.getElementById("datetime_debut_error").innerHTML = "";
	dateDebut.style.backgroundColor = '#FFFFFF';  
  }
  
  if (res == 4) return true;
  else return false;
}

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