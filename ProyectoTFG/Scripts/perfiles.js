$(function () {
    $("#mostrarPass").on("click",mostrarPass);
    $(".cambiarPeso").on("click", dialogoEditarPeso);
    $("#editar").on("click", editarPeso);
    //Competidor
    $(".cambiarCorreo").on("click", dialogoEditarCorreo);
    $("#editarCorreo").on("click", editarCorreo);
    $("#CorreoCambiado").on("blur", verificarCorreo);
    //Coach
    $(".cambiarCorreoCoach").on("click", dialogoEditarCorreoCoach);
    $("#editarCorreoCoach").on("click", editarCorreoCoach);
    //Arbitro
    $(".cambiarCorreoArbitro").on("click", dialogoEditarCorreoArbitro);
    $("#editarCorreoArbitro").on("click", editarCorreoArbitro);
    //AdminFed
    $(".cambiarCorreoAdminFed").on("click", dialogoEditarCorreoAdminFed);
    $("#editarCorreoAdminFed").on("click", editarCorreoAdminFed);
    //Admin
    $(".cambiarCorreoAdmin").on("click", dialogoEditarCorreoAdmin);
    $("#editarCorreoAdmin").on("click", editarCorreoAdmin);
});
function mostrarPass() {
    if ($("#password1").attr("type") == "password") {
        $("#password1").attr("type", "text");
        $("#mostrarPass").removeClass("ver");
        $("#mostrarPass").addClass("ocultar");
    } else if ($("#password1").attr("type") == "text") {
        $("#password1").attr("type", "password");
        $("#mostrarPass").removeClass("ocultar");
        $("#mostrarPass").addClass("ver");
    }
}
function verificarCorreo() {
    var formato = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/;
    if (formato.test($("#CorreoCambiado").val())) {
        $("#errorEmail").text("");
        $('#editarCorreo').attr("disabled", false);
        $('#editarCorreoCoach').attr("disabled", false);
        $('#editarCorreoArbitro').attr("disabled", false);
        $('#editarCorreoAdminFed').attr("disabled", false);
        $('#editarCorreoAdmin').attr("disabled", false);
    } else {
        $("#errorEmail").text(mensajesError.errorCorreo);
        $('#editarCorreo').attr("disabled", true);
        $('#editarCorreoCoach').attr("disabled", true);
        $('#editarCorreoArbitro').attr("disabled", true);
        $('#editarCorreoAdminFed').attr("disabled", true);
        $('#editarCorreoAdmin').attr("disabled", true);

    }
}

function dialogoEditarPeso() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../perfiles/controladorPerfilCompetidor.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrar'
        },
        dataType: 'json'
    })
            .done(function (competidor) {
                    $("#PesoCambiado").val(competidor.peso);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#dialogoCambiarPeso").dialog({
        resizable: false,
        width: 300,
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



function editarPeso() {
    var peso = $("#PesoCambiado").val();
    var dni = $("#celdaDNI").text();
    $.ajax({
        url: "../perfiles/controladorPerfilCompetidor.php",
        type: "POST",
        data: {
            peso: peso,
            dni: dni,
            accion:'editarPeso'
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
                            $("#dialogoCambiarPeso").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
}




function dialogoEditarCorreo() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../perfiles/controladorPerfilCompetidor.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrarCorreo'
        },
        dataType: 'json'
    })
            .done(function (competidor) {
                    $("#CorreoCambiado").val(competidor.correo);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#dialogoCambiarCorreo").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#editarCorreo").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}

function editarCorreo() {
    var correo = $("#CorreoCambiado").val();
    var dni = $("#celdaDNI").text();
    $.ajax({
        url: "../perfiles/controladorPerfilCompetidor.php",
        type: "POST",
        data: {
            correo: correo,
            dni: dni,
            accion:'editarCorreo'
        }
    })
            .done(function (datos) {
                $("#dlgEditarCorreo").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#dialogoCambiarCorreo").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
}



function dialogoEditarCorreoCoach() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrarCorreoCoach'
        },
        dataType: 'json'
    })
            .done(function (coach) {
                    $("#CorreoCambiado").val(coach.correo);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#dialogoCambiarCorreoCoach").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#editarCorreoCoach").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function editarCorreoCoach() {
    var correo = $("#CorreoCambiado").val();
    var dni = $("#celdaDNI").text();
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            correo: correo,
            dni: dni,
            accion:'editarCorreoCoach'
        }
    })
            .done(function (datos) {
                $("#dlgEditarCorreo").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#dialogoCambiarCorreoCoach").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
}


function dialogoEditarCorreoArbitro() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrarCorreoArbitro'
        },
        dataType: 'json'
    })
            .done(function (arbitro) {
                    $("#CorreoCambiado").val(arbitro.correo);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#dialogoCambiarCorreoArbitro").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#editarCorreoArbitro").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function editarCorreoArbitro() {
    var correo = $("#CorreoCambiado").val();
    var dni = $("#celdaDNI").text();
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            correo: correo,
            dni: dni,
            accion:'editarCorreoArbitro'
        }
    })
            .done(function (datos) {
                $("#dlgEditarCorreo").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#dialogoCambiarCorreoArbitro").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
}


function dialogoEditarCorreoAdminFed() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrarCorreoAdminFed'
        },
        dataType: 'json'
    })
            .done(function (adminFed) {
                    $("#CorreoCambiado").val(adminFed.correo);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#dialogoCambiarCorreoAdminFed").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#editarCorreoAdminFed").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function editarCorreoAdminFed() {
    var correo = $("#CorreoCambiado").val();
    var dni = $("#celdaDNI").text();
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            correo: correo,
            dni: dni,
            accion:'editarCorreoAdminFed'
        }
    })
            .done(function (datos) {
                $("#dlgEditarCorreo").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#dialogoCambiarCorreoAdminFed").dialog("close");
                            location.reload();
                        }
                    }
                });

            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
}


function dialogoEditarCorreoAdmin() {
    var dni = $(this).attr("id");
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            dni: dni,
            accion: 'mostrarCorreoAdmin'
        },
        dataType: 'json'
    })
            .done(function (admin) {
                    $("#CorreoCambiado").val(admin.correo);
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
    $("#dialogoCambiarCorreoAdmin").dialog({
        resizable: false,
        width: 300,
        modal: true,
        open: function(event, ui) {
            //Para el tema de JqueryUI
                $(this).find("input[type=button], button").button();
                $(this).keypress(function(e) {
                    if (e.keyCode == 13) {
                        $("#editarCorreoAdmin").click();
                        return false;
                    }
                });
            }
        
    }).dialog("open");
}
function editarCorreoAdmin() {
    var correo = $("#CorreoCambiado").val();
    var dni = $("#celdaDNI").text();
    console.log(dni);
    $.ajax({
        url: "../perfiles/controladorPerfiles.php",
        type: "POST",
        data: {
            correo: correo,
            dni: dni,
            accion:'editarCorreoAdmin'
        }
    })
            .done(function (datos) {
                $("#dlgEditarCorreo").dialog({
                    resizable: false,
                    width: 300,
                    modal: true,
                    buttons: {
                        [mensajesError.aceptar]: function () {
                            $(this).dialog("close");
                            $("#dialogoCambiarCorreoAdmin").dialog("close");
                            location.reload();
                        }
                    }
                });
            })
            .fail(function (err) {
                alert(mensajesError.errorConexion + " "  + err.status);
            });
}

