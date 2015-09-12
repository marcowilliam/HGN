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
	
});

var submitForm = function (input, sub_task_number, initialHours){

	//alert(initialHours);
	//alert(parseFloat(document.getElementById(input.id).value));
		$("#" + input.id).focus(function() {

		}).blur(function() {
			if(initialHours != parseFloat(document.getElementById(input.id).value)){
				document.getElementById('sub_task_form_edit_' + sub_task_number).submit();
			}
		});
	

}

function showAdd() {
	if (document.getElementById("showAddSubTask").className =="fa fa-minus-circle fa-4x"){
		document.getElementById("showAddSubTask").className = "fa fa-plus-circle fa-4x";
		document.getElementById("divAddSubTask").style.display = "none";
	} else {
		document.getElementById("divAddSubTask").style.display = "block";
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
