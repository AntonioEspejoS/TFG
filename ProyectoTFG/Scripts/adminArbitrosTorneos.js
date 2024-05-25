var id;
$(function () {
    $(".addArbitro").on("click", dialogoAdd);
    $(".eliminar").on("click", eliminar);
    $("#add").on("click", insertarArbitro);
});
function dialogoAdd() {
    var idTorneo = $(this).attr("id");
    $.ajax({
        url: "../AdminFed/controladorAdminArbitrosTorneos.php",
        type: "POST",
        data: {
            idTorneo: idTorneo,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (arbitros) {
                var select = $('#listaArbitros');
                select.empty(); // Limpiar el select antes de agregar nuevas opciones
                // Agregar la primera opción deshabilitada
                select.append($('<option>', {
                    value: "",
                    text: mensajeSeleccionaArbitro,
                    disabled: true,
                    selected: true
                }));

                // Rellenar el select con los árbitros disponibles
                $.each(arbitros, function (ind, arbitro) {
                    select.append($('<option>', {
                        value: arbitro.dni,
                        text: arbitro.nombre
                    }));
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#addArbitro").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#add").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function insertarArbitro() {
    var dniArbitro = $("#listaArbitros").val();
    var idTorneo = $("#idTorneo").val();
    // Asegurarte de que se ha seleccionado un árbitro
        // Verificar que se ha seleccionado un árbitro
    if (!dniArbitro || dniArbitro === "") {
        alert(mensajesError.introduceUnArbitro);
        return;
    }
    $.ajax({
        url: "../AdminFed/controladorAdminArbitrosTorneos.php",
        type: "POST",
        data: {
            dniArbitro: dniArbitro,
            idTorneo: idTorneo,
            accion: 'insertar'
        }
    })
            .done(function (datos) {
                $("#dlgInsertar").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#addArbitro").dialog("close");
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
    var dni = $(this).attr("id");
    var idTorneo = $("#idTorneoGeneral").val();

    $("#DialogoBorrar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                $.ajax({
                    url: "../AdminFed/controladorAdminArbitrosTorneos.php",
                    type: "POST",
                    data: {
                        dni: dni,
                        idTorneo: idTorneo,
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

