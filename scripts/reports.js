jQuery(document).ready(function(){
	jQuery(".chosen").chosen();
});


function submitForm(){
	var valor = $(".chosen").chosen().val();
	var label = $("#selecionado").find("option:selected").parent().attr("label");
	
	if (label == "Users") {
		document.getElementById("user_id_form").value = valor;
		document.getElementById("team_id_form").value = false;
	} else {
		document.getElementById("user_id_form").value = false;
		document.getElementById("team_id_form").value = valor;
		document.getElementById("formSubmit").action = "reportsTeam.php";
	}
    	document.getElementById("formSubmit").submit();
}