var dni;
var clubAntiguo;
$(function () {
    $(".botonEditarCoach").on("click", dialogoEditar);
    $("#botonEditarCoach").on("click", editarCoach);
    $("#CoachNombreEditar").on("blur", verificarNombre);
    $("#CoachLicenciaEditar").on("blur", verificarLicencia);

    $(".botonEliminarCoach").on("click", eliminar);
});

function verificarNombre() {
var formato = /^([A-Z][a-záéíóúñ]+)(\s(de|del|de\ los|de\ las|de\ la)\s[A-Z][a-záéíóúñ]+)*((\s[A-Z][a-záéíóúñ]+)*)(\s-\s|-|\s)([A-Z][a-záéíóúñ]+)((\s[A-Z][a-záéíóúñ]+)*)(\s[A-Z][a-záéíóúñ]+)*$/;
    if (formato.test($("#CoachNombreEditar").val())) {
        $("#errorNombre").text("");
        $('#botonEditarCoach').attr("disabled", false);
    } else {
        $("#errorNombre").text(mensajesError.errorNombre);
        $('#botonEditarCoach').attr("disabled", true);
    }
}
function verificarLicencia() {
    var formato = /^\d{1,10}$/;
    if (formato.test($("#CoachLicenciaEditar").val())) {
        $("#errorLicencia").text("");
        $('#botonEditarCoach').attr("disabled", false);
    } else {
        $("#errorLicencia").text(mensajesError.errorLicencia);
        $('#botonEditarCoach').attr("disabled", true);
    }
}



function dialogoEditar() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../AdminFed/controladorAdminCoach.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (coach) {
                    $("#CoachDniEditar").val(coach.dni);
                    $("#CoachNombreEditar").val(coach.nombre);
                    $("#CoachClubEditar").val(coach.club);
                    $("#CoachLicenciaEditar").val(coach.licencia);
                    $("#CoachEstadoEditar").val(coach.estado);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " " + err.status);
            });
    $("#editarCoach").dialog({
        resizable: false,
        width: 450,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#botonEditarCoach").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function editarCoach() {
    var dni = $("#CoachDniEditar").val();
    var nombre = $("#CoachNombreEditar").val();
    var club=$("#CoachClubEditar").val();
    var licencia=$("#CoachLicenciaEditar").val();
    var localidad=$("#CoachLocalidadEditar").val();
    var estado =$("#CoachEstadoEditar").val();
    // Verificación de campos vacíos
    if(nombre === "" || estado === "" || licencia === "") {
        alert(mensajesError.errorCamposVacios);
        return;
    }
    $.ajax({
        url: "../AdminFed/controladorAdminCoach.php",
        type: "POST",
        data: {
            dni: dni,
            nombre: nombre,
            club: club,
            licencia:licencia,
            localidad:localidad,
            estado: estado,
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
                            $("#editarCoach").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " " + err.status);           
             });
}
function eliminar() {
    dni = $(this).attr("id");
    $("#DialogoBorrar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                $.ajax({
                    url: "../AdminFed/controladorAdminCoach.php",
                    type: "POST",
                    data: {
                        dni: dni,
                        accion: 'eliminar'
                    }
                })
                        .done(function (datos) {
                            $("#DialogoBorrar").dialog("close");
                            location.reload();
                        })
                        .fail(function (err) {
                            alert(mensajesError.errorConexion + " "  + err.status);
                        });
                return false; //Anular efecto de pagina en blanco, para que permanezca en la misma pagina.
            },
            [mensajesError.cancelar]: function () {
                $(this).dialog("close");
            }
        }
    });
}
