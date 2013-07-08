
			function selectAll(source){
				checkboxes = document.getElementsByName('variables[]');
	  		    for(var i=0, n=checkboxes.length;i<n;i++) {
		  		    checkboxes[i].checked = source.checked;
		  		}
			}
			
			function selectPref(source){
				//CFP
				checkboxes = document.getElementsByName('variables[]');
	  		    for(var i=0, n=checkboxes.length;i<n;i++) {
	  		    	if(checkboxes[i].value == "data_CFP" || checkboxes[i].value == "data_PC")
		  		    	checkboxes[i].checked = source.checked;
		  		}
			}