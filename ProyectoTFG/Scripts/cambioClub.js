$(function () {
    //Competidor
    $(".cambiarClub").on("click", dialogoEditarClub);
    $("#editarClub").on("click", editarClub);

});

function dialogoEditarClub() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../listados/controladorListaMiClub.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrarClub'
        },
        dataType: 'json'
    })
            .done(function (competidor) {
                    $("#CompetidorClubEditar").val(competidor.club);
                    $("#clubAntiguo").val(competidor.club);

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#dialogoCambiarClub").dialog({
        resizable: false,
        width: 300,
        modal: true,
        position: { my: "center center", at: "center center-10%", of: window },
        open: function(event, ui) {
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#editarClub").click();
                        return false;
                    }
                });
                var distanciaDesdeArriba = 30;
                $(this).parent().css({
                    "position": "fixed",
                    "top": distanciaDesdeArriba + "%"
                });
        }
        
    }).dialog("open");
}

function editarClub() {
    var club = $("#CompetidorClubEditar").val();
    var clubAntiguo = $("#clubAntiguo").val();
    var dni = $("#dniCompetidorEditarClub").val();
    if(clubAntiguo!=club){
            $.ajax({
                url: "../listados/controladorListaMiClub.php",
                type: "POST",
                data: {
                    club: club,
                    dni: dni,
                    accion:'editarClub'
                }
            })
                    .done(function (datos) {
                        $("#dlgEditarClub").dialog({
                            resizable: false,
                            width: 300,
                            modal: true,
                             open: function(event, ui) {
                                var distanciaDesdeArriba = 30;
                                $(this).parent().css({
                                    "position": "fixed",
                                    "top": distanciaDesdeArriba + "%"
                                });
                            },
                            buttons: {
                                [mensajesError.aceptar]: function () {
                                    $(this).dialog("close");
                                    $("#dialogoCambiarClub").dialog("close");
                                    location.replace("../sesiones/cerrarSesion.php");

                                }
                            }
                        }).dialog("open");
                    })
                    .fail(function (err) {
                        alert(mensajesError.errorConexion + " "  + err.status);
                    });
                }else{
                   alert(mensajesError.mismoClub);

                }            
}
