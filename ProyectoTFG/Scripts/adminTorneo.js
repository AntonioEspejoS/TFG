var id;
$(function () {
    $("#nuevoTorneo").on("click", dialogoCrear);
    $(".editar").on("click", dialogoEditar);
    $(".eliminar").on("click", eliminar);
    $("#crear").on("click", insertarTorneo);
    $("#editar").on("click", editarTorneo);
    $(".botonTerminarTorneo").on("click", terminar);
});
function dialogoCrear() {
    $("#TorneoDescripcion").val("");
    $("#TorneoFechaInscripcion").val("");
    $("#TorneoFecha").val("");
    $("#generoTorneo").val("ambos");
    $("#modalidadTorneo").val("todas");
    $("#categoriaEdadTorneo").val("todas");
    $("#numeroPlazasTorneo").val("8");
    $("#crearTorneo").dialog({
        resizable: false,
        width: 730,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
              $(this).find("input[type=button], button").button();
              $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#crear").click();
                        return false;
                    }
            });


            }
    }).dialog("open");
}
function insertarTorneo() {
    var descripcion = $("#TorneoDescripcion").val();
    var fechaInscripcion = $("#TorneoFechaInscripcion").val();    
    var fecha = $("#TorneoFecha").val();
    var estado = $("#estadoTorneo").val();
    var genero = $("#generoTorneo").val(); 
    var modalidad = $("#modalidadTorneo").val(); 
    var categoriaEdad = $("#categoriaEdadTorneo").val();
    var plazas = $("#numeroPlazasTorneo").val();
    
        // Verificación de campos vacíos
    if(descripcion === "" || estado === "" || fechaInscripcion==="" || fecha==="") {
        alert(mensajesError.errorCamposVacios);
        return;
    }
    if(plazas>8 || plazas < 2){
        alert(mensajesError.errorPlazas);
        return;
    }
    // Convertir las fechas a objetos Date para comparación
    var fechaInscripcionDate = new Date(fechaInscripcion);
    var fechaTorneoDate = new Date(fecha);
    var fechaActual = new Date();
    fechaActual.setHours(0,0,0,0); // Resetear horas, minutos, segundos y milisegundos
        if (fechaInscripcionDate >= fechaActual && fechaTorneoDate > fechaInscripcionDate) {
        // Deshabilitar el botón aquí para evitar múltiples envíos
        $("#crear").prop('disabled', true);
    $.ajax({
        url: "../AdminFed/controladorAdminTorneos.php",
        type: "POST",
        data: {
            descripcion: descripcion,
            fechaInscripcion: fechaInscripcion,
            fecha: fecha,
            estado: estado,
            generoTorneo: genero, 
            modalidadTorneo: modalidad,
            categoriaEdadTorneo: categoriaEdad,
            plazas: plazas,
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
                            $("#crearTorneo").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " " + err.status);
            });
        }else{
          alert(mensajesError.errorFechasTorneos);
        }    
}

function dialogoEditar() {
    var idTorneo = $(this).attr("id");
    $.ajax({
        url: "../AdminFed/controladorAdminTorneos.php",
        type: "POST",
        data: {
            idTorneo: idTorneo,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (torneo) {
                    $("#TorneoIdEditar").val(torneo.idtorneo);
                    $("#TorneoDescripcionEditar").val(torneo.descripcion);
                    $("#TorneoFechaInscripcionEditar").val(torneo.fechainscripcion);
                    $("#TorneoFechaEditar").val(torneo.fechatorneo);
                    $("#estadoTorneoEditar").val(torneo.estado);
                    $("#finalizadoTorneoEditar").val(torneo.finalizado);
                    $("#numeroPlazasTorneoEditar").val(torneo.plazas);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " " + err.status);
            });
    $("#editarTorneo").dialog({
        resizable: false,
        width: 730,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
            $(this).find("input[type=button], button").button();
            $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#editar").click();
                        return false;
                    }
            });
        }
        
    }).dialog("open");
}
function editarTorneo() {
    var idTorneo = $("#TorneoIdEditar").val();
    var descripcion = $("#TorneoDescripcionEditar").val();
    var fechaInscripcion = $("#TorneoFechaInscripcionEditar").val();
    var fecha = $("#TorneoFechaEditar").val();
    var estado = $("#estadoTorneoEditar").val();
    var finalizado = $("#finalizadoTorneoEditar").val();
    var plazas = $("#numeroPlazasTorneoEditar").val();
    if(descripcion === "" || estado === "" || fechaInscripcion==="" || fecha==="") {
        alert(mensajesError.errorCamposVacios);
        return;
    }
    if(plazas>8 || plazas < 2){
        alert(mensajesError.errorPlazas);
        return;
    }
    // Convertir las fechas a objetos Date para comparación
    var fechaInscripcionDate = new Date(fechaInscripcion);
    var fechaTorneoDate = new Date(fecha);
    var fechaActual = new Date();
    fechaActual.setHours(0,0,0,0); // Resetear horas, minutos, segundos y milisegundos
   // if (fechaInscripcionDate >= fechaActual && fechaTorneoDate > fechaInscripcionDate) {
        


    $.ajax({
        url: "../AdminFed/controladorAdminTorneos.php",
        type: "POST",
        data: {
            idTorneo:idTorneo,
            descripcion: descripcion,
            fechaInscripcion: fechaInscripcion,
            fecha: fecha,
            estado: estado,
            finalizado: finalizado,
            plazas: plazas,
            accion: 'editar'
        }
    })
            .done(function (datos) {
                //console.log(datos);
                $("#dlgEditar").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#editarTorneo").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " " + err.status);
            });
       // }else{
         // alert(mensajesError.errorFechasTorneos);
        //}    
}
function eliminar() {
    id = $(this).attr("id");
    $("#DialogoBorrar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                $.ajax({
                    url: "../AdminFed/controladorAdminTorneos.php",
                    type: "POST",
                    data: {
                        id: id,
                        accion: 'eliminar'
                    }
                })
                        .done(function (datos) {
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



function terminar() {
    var idTorneo = $(this).attr("id");
    $("#DialogoTerminar").dialog({
        resizable: false,
        width: 300,
        modal: true,
        buttons: {
            [mensajesError.si]: function () {
                $.ajax({
                    url: "../Torneo/controladorTorneo.php",
                    type: "POST",
                    data: {
                        idTorneo: idTorneo,
                        accion: 'terminar'
                    }
                })
                        .done(function (datos) {
                            $("#DialogoTerminar").dialog("close");
                            location.replace("../listados/listaTorneosResultados.php");
                        })
                        .fail(function (err) {
                            alert(mensajesError.errorConexion + " " + err.status);
                        });
                return false; 
            },
            [mensajesError.cancelar]: function () {
                $(this).dialog("close");
            }
        }
    });
}