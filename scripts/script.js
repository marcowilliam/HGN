$(function(){
	$("#tabela input").keyup(function(){

		var index = $(this).parent().index();
		var nth = "#tabela td:nth-child("+(index+1).toString()+")";
		var valor = $(this).val().toUpperCase();
		$("#tabela tbody tr").show();
		$(nth).each(function(){
			if($(this).text().toUpperCase().indexOf(valor) < 0){
				$(this).parent().hide();
			}
		});
	});
	
	$("#tabela2 input").keyup(function(){

		var index = $(this).parent().index();
		var nth = "#tabela2 td:nth-child("+(index+1).toString()+")";
		var valor = $(this).val().toUpperCase();
		$("#tabela2 tbody tr").show();
		$(nth).each(function(){
			if($(this).text().toUpperCase().indexOf(valor) < 0){
				$(this).parent().hide();
			}
		});
	});


	$("#tabelaGeralUsers input").keyup(function(){		

		var index = $(this).parent().index();
		var nth = "#tabelaGeralUsers td:nth-child("+(index+1).toString()+")";
		var valor = $(this).val().toUpperCase();
		$("#tabelaGeralUsers tbody tr").show();
		$(nth).each(function(){
			if($(this).text().toUpperCase().indexOf(valor) < 0){
				$(this).parent().hide();
			}
		});
	});
	
	$("#tabelaGeralUsers2 input").keyup(function(){		

		var index = $(this).parent().index();
		var nth = "#tabelaGeralUsers2 td:nth-child("+(index+1).toString()+")";
		var valor = $(this).val().toUpperCase();
		$("#tabelaGeralUsers2 tbody tr").show();
		$(nth).each(function(){
			if($(this).text().toUpperCase().indexOf(valor) < 0){
				$(this).parent().hide();
			}
		});
	});

	$('.inside_link').click(function(event){
    	//event.stopImmediatePropagation();
    	
    	var href= $(this).attr('href');
    	window.open(href, '_blank');
    	
	});
	
	$(".taskNameSelect").chosen({width: '400px'});
	
	var teams = document.getElementById("connectionPhpJs");
        var myDataTeams = teams.textContent;
        var arrayUserTeams = JSON.parse(myDataTeams);

	  	var currencies = [
	   	 { value: '', data: '' },
	    
	  	];
		
	  	for(var i=0; i< arrayUserTeams.length; i++){
	    	currencies[i] = { value: arrayUserTeams[i], data: 'TM1' }
		
	  	}
	  
	  	// setup autocomplete function pulling from currencies[] array
	  	$('#autocomplete').autocomplete({
	    	lookup: currencies,
	    	onSelect: function (suggestion) {
	    	
	      		var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
	      		$('#outputcontent').html(thehtml);
	    	}
  		});   

	
});

var submitForm = function (input, sub_task_number, initialHours){


		$("#" + input.id).focus(function() {

		}).blur(function() {
			if(initialHours != parseFloat(document.getElementById(input.id).value)){
				document.getElementById('sub_task_form_edit_' + sub_task_number).submit();
			}
		});
	

}

var submitFormDescription = function (sub_task_number){
	
	
	 
    	$("#sub_task_description_div_edit_" + sub_task_number).focus(function() {
		}).blur(function() {
				  
				var valorDaDiv = $("#sub_task_description_div_edit_" + sub_task_number).text(); 
    				$("#sub_task_description_input_edit_" + sub_task_number).val(valorDaDiv);
				document.getElementById('sub_task_description_edit_' + sub_task_number).submit();
		});
		

}

function showAdd() {
	if (document.getElementById("showAddSubTask").className =="fa fa-minus-circle fa-4x"){
		document.getElementById("showAddSubTask").className = "fa fa-plus-circle fa-4x";
		$(".divAddSubTask").hide();
		
		
	} else {
		$(".divAddSubTask").show();
		document.getElementById("showAddSubTask").className = "fa fa-minus-circle fa-4x";
	}
}



function showSubTask(task_id) {

	var v = document.getElementsByName(task_id);

	if (v[0].style.display=="table-row") {
		var i;
		for (i = 0; i < v.length; i++){
			v[i].style.display = "none";
		}	
	} else {
		var i;
		for (i = 0; i < v.length; i++){
			v[i].style.display = "table-row";
		}
	}
}

function controlBarChartDisplay2(){
	document.getElementById('barChart1').style.display="none";
	document.getElementById('barChart2').style.display="block";
	document.getElementById('viewGeneral').style.fontWeight="700";
	document.getElementById('viewAdmin').style.fontWeight="normal";
}

function controlBarChartDisplay1(){
	document.getElementById('barChart2').style.display="none";
	document.getElementById('barChart1').style.display="block";
	document.getElementById('viewAdmin').style.fontWeight="700";
	document.getElementById('viewGeneral').style.fontWeight="normal";
}