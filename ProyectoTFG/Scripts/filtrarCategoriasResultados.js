$(function () {
    $("#filtrarResultados").click(function(){
        var modalidadFiltro = $("#filtroModalidad").val().toLowerCase();
        var edadFiltro = $("#filtroEdad").val().toLowerCase();
        var sexoFiltro = $("#filtroSexo").val().toLowerCase();
        var pesoFiltro = $("#filtroPeso").val().toLowerCase();
        $("#tablaResultados tbody tr").filter(function(){
            $(this).toggle($(this).find("td").eq(0).text().toLowerCase().indexOf(modalidadFiltro) > -1 &&
                           $(this).find("td").eq(1).text().toLowerCase().indexOf(edadFiltro) > -1 &&
                           $(this).find("td").eq(2).text().toLowerCase().indexOf(sexoFiltro) > -1 &&
                           $(this).find("td").eq(3).text().toLowerCase().indexOf(pesoFiltro) > -1);
        });
    });
});
