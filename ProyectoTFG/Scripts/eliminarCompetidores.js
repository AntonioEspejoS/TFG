$(function () {
    $(".botonEliminarCompetidor").on("click", eliminarCompetidor);
});
function eliminarCompetidor() {
     var dniCompetidor = $(this).attr("id");
    $("#dialogoEliminar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            "Sí": function () {
                    $.ajax({
                    url: "../listados/controladorListaMiClub.php",
                    type: "POST",
                    data: {
                        dni: dniCompetidor,
                        accion: 'eliminar'
                    }
                })
                .done(function (respuesta) {
                    //alert("Competidor eliminado con éxito");
                    location.reload(); // Recargar la página para actualizar la lista
                })
                .fail(function (err) {
                    alert("Error al eliminar el competidor: " + err.status);
                });

            },
            "Cancelar": function () {
                $(this).dialog("close");
            }
        }
    });
}
