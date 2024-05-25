var dni;
$(function () {
    $(".botonEditarArbitro").on("click", dialogoEditar);
    $("#botonEditarArbitro").on("click", editarArbitro);
    $("#ArbitroNombreEditar").on("blur", verificarNombre);

    $(".botonEliminarArbitro").on("click", eliminar);
    
});
function verificarNombre() {
    //Nuevo formato con segundo apellido opcional
    var formato = /^([A-Z][a-záéíóúñ]+)(\s(de|del|de\ los|de\ las|de\ la)\s[A-Z][a-záéíóúñ]+)*((\s[A-Z][a-záéíóúñ]+)*)(\s-\s|-|\s)([A-Z][a-záéíóúñ]+)((\s[A-Z][a-záéíóúñ]+)*)(\s[A-Z][a-záéíóúñ]+)*$/;
    if (formato.test($("#ArbitroNombreEditar").val())) {
        $("#errorNombre").text("");
        $('#botonEditarArbitro').attr("disabled", false);
    } else {
        $("#errorNombre").text(mensajesError.errorNombre);
        $('#botonEditarArbitro').attr("disabled", true);
    }
}
function dialogoEditar() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../AdminFed/controladorAdminArbitros.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (arbitro) {
                //console.log(arbitro);
                $("#ArbitroDniEditar").val(arbitro.dni);
                $("#ArbitroNombreEditar").val(arbitro.nombre);
                $("#ArbitroEstadoEditar").val(arbitro.estado.toString());
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " " + err.status);
            });
    $("#editarArbitro").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#botonEditarArbitro").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function editarArbitro() {
    var dni = $("#ArbitroDniEditar").val();
    var nombre = $("#ArbitroNombreEditar").val();
    var estado =$("#ArbitroEstadoEditar").val();
    // Verificación de campos vacíos
    if(nombre === "" || estado === "") {
        alert(mensajesError.errorCamposVacios);
        return;
    }
    $.ajax({
        url: "../AdminFed/controladorAdminArbitros.php",
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
                            $("#editarArbitro").dialog("close");
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
    dni = $(this).attr("id");
    $("#DialogoBorrar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                $.ajax({
                    url: "../AdminFed/controladorAdminArbitros.php",
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