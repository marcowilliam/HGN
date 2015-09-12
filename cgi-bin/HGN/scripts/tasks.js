var descriptiontext = '1';

function changeDescription(number){
		
		descriptiontext = number;
		description();
		
}

function description(){
	
	
		if (descriptiontext == '1'){
			document.getElementById("taskDescriptionText").innerHTML = "Description 1";
		}
		if(descriptiontext == '2'){
			document.getElementById("taskDescriptionText").innerHTML = "Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2Description 2";
		}
	
	
	}