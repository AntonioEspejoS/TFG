var dni;
$(function () {
    $(".botonEditarClub").on("click", dialogoEditar);
    $("#botonEditarClub").on("click", editarClub);
    $(".botonEliminarClub").on("click", eliminar);
});
function dialogoEditar() {
    var idClub = $(this).attr("id");
    $.ajax({
        url: "../AdminFed/controladorAdminClubes.php",
        type: "POST",
        data: {
            idClub: idClub,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (club) {
                //console.log(club);
                $("#ClubId").val(club.idclub);
                $("#ClubNombreEditar").val(club.nombre);
                $("#ClubLocalidadEditar").val(club.localidad);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#editarClub").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#botonEditarClub").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function editarClub() {
    var idClub = $("#ClubId").val();
    var nombre = $("#ClubNombreEditar").val();
    var localidad = $("#ClubLocalidadEditar").val();
        // Verificación de campos vacíos
    if(nombre === "" || localidad === "") {
        alert(mensajesError.errorCamposVacios);
        return;
    }
    $.ajax({
        url: "../AdminFed/controladorAdminClubes.php",
        type: "POST",
        data: {
            idClub: idClub,
            nombre: nombre,
            localidad: localidad,
            accion: 'editar'
        }
    })
            .done(function (datos) {
                console.log(datos);
                $("#dlgEditar").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#editarClub").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
}
function eliminar() {
    var idClub = $(this).attr("id");
    $("#DialogoBorrar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                $.ajax({
                    url: "../AdminFed/controladorAdminClubes.php",
                    type: "POST",
                    data: {
                        idClub: idClub,
                        accion: 'eliminar'
                    }
                })
                        .done(function (datos) {
                            console.log(datos);
                            $("#DialogoBorrar").dialog("close");
                            location.reload();
                        })
                        .fail(function (err) {
                            alert(mensajesError.errorConexion + " " + err.status);
                        });
                return false; //Anular efecto de pagina en blanco, para que permanezca en la misma pagina.
            },
            [mensajesError.cancelar]: function () {
                $(this).dialog("close");
            }
        }
    });
}