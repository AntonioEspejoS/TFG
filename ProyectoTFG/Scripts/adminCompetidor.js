var dni;
$(function () {
    $(".botonEditarCompetidor").on("click", dialogoEditar);
    $("#botonEditarCompetidor").on("click", editarCompetidor);
     $("#CompetidorNombreEditar").on("blur", verificarNombre);
    $("#CompetidorLicenciaEditar").on("blur", verificarLicencia);
    $(".botonEliminarCompetidor").on("click", eliminar);

    // Establecer inicialmente el peso basado en el valor actual
    var sexoActual = $('#sexoCompetidorEditar').val();
    var pesoActual = $('#pesoCompetidorEditar').data('peso-actual'); 
    if (sexoActual && pesoActual) {
        actualizarOpcionesDePeso(sexoActual, pesoActual);
    }
    // Escuchar cambios en el selector de sexo
    $('#sexoCompetidorEditar').change(function () {
        actualizarOpcionesDePeso($(this).val());
    });  
});



function verificarNombre() {
var formato = /^([A-Z][a-záéíóúñ]+)(\s(de|del|de\ los|de\ las|de\ la)\s[A-Z][a-záéíóúñ]+)*((\s[A-Z][a-záéíóúñ]+)*)(\s-\s|-|\s)([A-Z][a-záéíóúñ]+)((\s[A-Z][a-záéíóúñ]+)*)(\s[A-Z][a-záéíóúñ]+)*$/;
    if (formato.test($("#CompetidorNombreEditar").val())) {
        $("#errorNombre").text("");
        $('#botonEditarCompetidor').attr("disabled", false);
    } else {
        $("#errorNombre").text(mensajesError.errorNombre);
        $('#botonEditarCompetidor').attr("disabled", true);
    }
}
function verificarLicencia() {
    var formato = /^\d{1,10}$/;
    if (formato.test($("#CompetidorLicenciaEditar").val())) {
        $("#errorLicencia").text("");
        $('#botonEditarCompetidor').attr("disabled", false);
    } else {
        $("#errorLicencia").text(mensajesError.errorLicencia);
        $('#botonEditarCompetidor').attr("disabled", true);
    }
}
     // Función para actualizar las opciones de peso
    function actualizarOpcionesDePeso(sexo, pesoActual = null) {
        $('#pesoCompetidorEditar option').remove(); // Elimina opciones previas
        $('#pesoCompetidorEditar').append("<option value='' disabled='disabled'>"+ mensajesError.seleccionaPeso + "...</option>");
        
        var opcionesPeso = sexo === 'm' ? {
            '64': '<64 kg',
            '69': '<69 kg',
            '74': '<74 kg',
            '79': '<79 kg',
            '84': '<84 kg',
            '90': '>90 kg'
        } : {
            '49': '<49 kg',
            '59': '<59 kg',
            '64': '<64 kg',
            '69': '<69 kg',
            '74': '<74 kg',
            '79': '>79 kg'
        };

        $.each(opcionesPeso, function(valor, texto) {
            var seleccionado = pesoActual === valor ? " selected='selected'" : "";
            $('#pesoCompetidorEditar').append(`<option value='${valor}'${seleccionado}>${texto}</option>`);
        });
    }


function dialogoEditar() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../AdminFed/controladorAdminCompetidores.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (competidor) {
                    $("#CompetidorDniEditar").val(competidor.dni);
                    $("#CompetidorNombreEditar").val(competidor.nombre);
                    $("#CompetidorClubEditar").val(competidor.club);
                    $("#CompetidorLicenciaEditar").val(competidor.licencia);
                    $("#CompetidorFechaEditar").val(competidor.fech_nac);
                    $("#sexoCompetidorEditar").val(competidor.sexo);
                    if(competidor.estado == 0 || competidor.estado == 2){
                        $("#CompetidorEstadoEditar").val(0);
                    }else{
                        $("#CompetidorEstadoEditar").val(1);
                    }
                    $("#CompetidorEstadoReal").val(competidor.estado);
                    actualizarOpcionesDePeso(competidor.sexo, competidor.peso);
                    
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#editarCompetidor").dialog({
        resizable: false,
        width: 730,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
             $(this).find("input[type=button], button").button();
             $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#botonEditarCompetidor").click();
                        return false;
                    }
                });

            }
        
    }).dialog("open");
}
function editarCompetidor() {
    var dni = $("#CompetidorDniEditar").val();
    var nombre = $("#CompetidorNombreEditar").val();
    var club = $("#CompetidorClubEditar").val();
    var licencia = $("#CompetidorLicenciaEditar").val();
    var fechaNac = $("#CompetidorFechaEditar").val();
    var sexo = $('#sexoCompetidorEditar').val();
    var peso = $("#pesoCompetidorEditar").val();
    var estado =$("#CompetidorEstadoEditar").val();
    var estadoReal =$("#CompetidorEstadoReal").val();
        // Verificación de campos vacíos
    if(nombre === "" || licencia === "") {
        alert(mensajesError.errorCamposVacios);
        return;
    }
    var estadoEnviar;
     if( estado==1){
         if(estadoReal==0){
            estadoEnviar=1;
         }else if(estadoReal==2){
            estadoEnviar=3;
         }else{
             estadoEnviar=estadoReal;
         }   
     }else{
         if(estadoReal==1){
            estadoEnviar=0;
         }else if(estadoReal==3){
            estadoEnviar=2;
         }else{
             estadoEnviar=estadoReal;
         }
         
     }
    $.ajax({
        url: "../AdminFed/controladorAdminCompetidores.php",
        type: "POST",
        data: {
            dni: dni,
            nombre: nombre,
            club: club,
            fechaNac:fechaNac,
            sexo: sexo,
            peso:peso,
            licencia: licencia,
            estado:estadoEnviar,
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
                            $("#editarCompetidor").dialog("close");
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
                    url: "../AdminFed/controladorAdminCompetidores.php",
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
                return false;
            },
            [mensajesError.cancelar]: function () {
                $(this).dialog("close");
            }
        }
    });
}