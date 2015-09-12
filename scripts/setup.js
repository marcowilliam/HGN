
function changeToEdit(el) {
			var x = document.getElementsByClassName("rightArt");
			var i;
			for (i = 0; i < x.length; i++) {
			    x[i].style.display = "none";
			}
			document.getElementById(el).style.display = "block";
}