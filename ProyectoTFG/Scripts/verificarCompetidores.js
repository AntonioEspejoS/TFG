$(function () {
    $(".botonVerificar").on("click", verificarCompetidor);
});
function verificarCompetidor() {
     var dniCompetidor = $(this).attr("id");
     var estadoReal =$("#CompetidorEstadoReal").val();
     var estadoEnviar;
     if(estadoReal==0){
         estadoEnviar=2;
     }else if(estadoReal==1){
         estadoEnviar=3;
     }else{
         estadoEnviar=estadoReal;
     };
    $("#dialogoVerificar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                    $.ajax({
                    url: "../listados/controladorListaCompetidoresVerificar.php",
                    type: "POST",
                    data: {
                        dni: dniCompetidor,
                        estado: estadoEnviar,
                        accion: 'verificar'
                    }
                })
                .done(function (respuesta) {
                    location.replace("../listados/listaMiClub.php"); // Recargar la página para actualizar la lista
                })
                .fail(function (err) {
                    alert("Error al verificar el competidor: " + err.status);
                });

            },
            [mensajesError.cancelar]: function () {
                $(this).dialog("close");
            }
        }
    });
}
