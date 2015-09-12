jQuery(document).ready(function(){
	jQuery(".chosen").chosen();
});


function submitForm(){
	var valor = $(".chosen").chosen().val();
	document.getElementById("user_id_form").value = valor;
    	document.getElementById("formSubmit").submit();
}