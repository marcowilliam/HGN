window.onload = function () {
		
		//quando adicionamos um usuario com uma task no dia 27/06

		var names = document.getElementById("connectionPhpJs0");
		var myDataNames = names.textContent;
		var arrayUserNames = JSON.parse(myDataNames);
		var usersNumber = arrayUserNames.length;

		var finalHours = document.getElementById("connectionPhpJs1");
		var myDataHours = finalHours.textContent;
		var arrayFinalHours = JSON.parse(myDataHours);

		var finalDates = document.getElementById("connectionPhpJs2");
		var myDataDates = finalDates.textContent;
		var arrayFinalDates = JSON.parse(myDataDates);

		var usersDatesNumber = document.getElementById("connectionPhpJs4");
		var myDataUserDatesNumber = usersDatesNumber.textContent;
		var arrayUsersDatesNumber = JSON.parse(myDataUserDatesNumber);

		var currentMonthPhp = document.getElementById("connectionPhpJs3");
		var myDataMonth = currentMonthPhp.textContent;
		var currentMonth = JSON.parse(myDataMonth);
		var currentMonth1 = Number(currentMonth) - 1;
		alert("alo");

		
		var finalDatesSplit = new Array();

		for(var i = 0; i < arrayFinalDates.length; i++){

			for(var j=0; j < arrayFinalDates[i].length; j++){
				finalDatesSplit[i] = new Array(j);
			}
		}
		
		for(var i = 0; i < arrayFinalDates.length; i++){
		
			for(var j=0; j < arrayFinalDates[i].length; j++){

				finalDatesSplit[i][j] = arrayFinalDates[i][j].split("-");
				
				
			}
		}

		var chartStructure = {

			title:{
				text: "Team members Hours",
				fontSize: 30
			},
                        animationEnabled: true,
			axisX:{

				gridColor: "Silver",
				tickColor: "silver",
				valueFormatString: "DD/MMM"

			},                        
                        toolTip:{
                          shared:true
                        },
			theme: "theme2",
			axisY: {
				gridColor: "Silver",
				tickColor: "silver"
			},
			legend:{
				verticalAlign: "center",
				horizontalAlign: "right"
			},

          legend:{
            cursor:"pointer",
            itemclick:function(e){
              if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              	e.dataSeries.visible = false;
              }
              else{
                e.dataSeries.visible = true;
              }
              chart.render();
            }
          }
      };

      chartStructure.data = new Array();

      for(var i = 0; i<usersNumber; i++){
		      
		      chartStructure.data[i] =
					{        
						type: "line",
						showInLegend: true,
						lineThickness: 2,
						name: arrayUserNames[i],
						markerType: "square",
						color: getRandomColor(),
						
					};


			chartStructure.data[i].dataPoints = new Array();
			 
			for(var j = 0; j<arrayFinalHours[i].length; j++){
				
				if(Number(finalDatesSplit[i][j][1]) == Number(currentMonth)){
					chartStructure.data[i].dataPoints[j] = { x: new Date(2010,currentMonth1,Number(finalDatesSplit[i][j][2])), y: Number(arrayFinalHours[i][j])};
				}
			}


	}
	
		

		var chart = new CanvasJS.Chart("chartContainer", chartStructure);

chart.render();

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 3; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
}