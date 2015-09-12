var filtro = document.getElementById('team_name1');
var tabela = document.getElementById('tabela');

filtro.onkeyup = function() {
	
    var nomeFiltro = filtro.value;
    alert(nomeFiltro);
    for (var i = 1; i < tabela.rows.length; i++) {
    	alert("t");
        var conteudoCelula = tabela.rows[i].cells[0].innerText;
        var corresponde = conteudoCelula.toLowerCase().indexOf(nomeFiltro) >= 0;
        tabela.rows[i].style.display = corresponde ? '' : 'none';

    }
};