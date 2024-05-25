var dni;
$(function () {
    $(".botonEditarAdminFed").on("click", dialogoEditarAdminFed);
    $("#botonEditarAdminFed").on("click", editarAdminFed);
    $("#AdminFedNombreEditar").on("blur", verificarNombre);
    $(".botonEliminarAdminFed").on("click", eliminarAdminFed);
});


function verificarNombre() {
var formato = /^([A-Z][a-záéíóúñ]+)(\s(de|del|de\ los|de\ las|de\ la)\s[A-Z][a-záéíóúñ]+)*((\s[A-Z][a-záéíóúñ]+)*)(\s-\s|-|\s)([A-Z][a-záéíóúñ]+)((\s[A-Z][a-záéíóúñ]+)*)$/;
    if (formato.test($("#AdminFedNombreEditar").val())) {
        $("#errorNombre").text("");
        $('#botonEditarAdminFed').attr("disabled", false);
    } else {
        $("#errorNombre").text(mensajesError.errorNombre);
        $('#botonEditarAdminFed').attr("disabled", true);
    }
}

function dialogoEditarAdminFed() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../Admin/controladorAdminAdminFed.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (adminFed) {
                $("#AdminFedDniEditar").val(adminFed.dni);
                $("#AdminFedNombreEditar").val(adminFed.nombre);
                $("#federacionAdminFedEditar").val(adminFed.federacion);
                $("#AdminFedEstadoEditar").val(adminFed.estado.toString());
            })
            .fail(function (err) {
                alert("error de conexion al mostrar " + err.status);
            });
    $("#editarAdminFed").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#botonEditarAdminFed").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}

function editarAdminFed() {
    var dni = $("#AdminFedDniEditar").val();
    var nombre = $("#AdminFedNombreEditar").val();
    var estado =$("#AdminFedEstadoEditar").val();
    if(nombre === "" || estado === "") {
        alert(mensajesError.errorCamposVacios);
        return;
    }
    $.ajax({
        url: "../Admin/controladorAdminAdminFed.php",
        type: "POST",
        data: {
            dni: dni,
            nombre: nombre,
            estado: estado,
            accion: 'editar'
        }
    })
            .done(function (datos) {
                $("#dlgEditar").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#editarAdminFed").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert("error de conexion al insertar " + err.status);
            });
}

function eliminarAdminFed() {
    dni = $(this).attr("id");
    $("#DialogoBorrar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                $.ajax({
                    url: "../Admin/controladorAdminAdminFed.php",
                    type: "POST",
                    data: {
                        dni: dni,
                        accion: 'eliminar'
                    }
                })
                        .done(function (datos) {
                            console.log(datos);
                            $("#DialogoBorrar").dialog("close");
                            location.reload();
                        })
                        .fail(function (err) {
                            alert("error de conexion al insertar " + err.status);
                        });
                return false;
            },
            [mensajesError.cancelar]: function () {
                $(this).dialog("close");
            }
        }
    });
}