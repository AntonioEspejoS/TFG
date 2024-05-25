$(function () {
    generar();
    $('.enlaceTerminarCategoria').on('click', false);
    $("#b0").on("click", function() { ronda1(); });
    $("#b1").on("click", function() { ronda2(); });
    $("#b2").on("click", function() { ronda3(); });
    $("#b3").on("click", function() { rondaFinal(); });
});

function generar() {
    $.ajax({
        url: "../Torneo/controladorTorneo.php",
        type: "POST",
        dataType: 'json',
        data: {
            idTorneo: $("#idTorneo").val(),
            peso: $("#peso").val(),
            sexo: $("#sexo").val(),
            edad: $("#edad").val(),
            modalidad: $("#modalidad").val(),
            accion: 'generar'
        }
    })
    .done(function (enfrentamientos) {
        for(let i = 0; i <= 8; i++) {
            $('#' + i).text("------");
            $('#dni' + i).val('');
            $('#p' + i).val('').prop('disabled', false); // Habilita los campos de puntuación
        }
        // Contadores por ronda para gestionar los índices
        let contadorRonda3 = 0; // Para semifinales
        let contadorRonda2 = 3; // Para semifinales
        let contadorFinal = 6; // Para la final, inicia en 2 porque es el índice del que está solo
        $.each(enfrentamientos, function (ind, enfrentamiento) {
            //console.log(enfrentamiento);
            //Nota: El competidor 1 siempre va a ser el de arriba y el 2 el de abajo o si están
            //en lados opuestos el 1 será el de la izquierda y el 2 el de la derecha
            //Cuartos
            if( enfrentamiento.ronda == 3){
                if(enfrentamiento.competidor1.dni!==null) {
                    $('#' + contadorRonda3).text(enfrentamiento.competidor1.nombre);
                    $('#dni' + contadorRonda3).val(enfrentamiento.competidor1.dni);
                    if(enfrentamiento.puntuacion1 !== null) {
                        $('#p' + contadorRonda3).val(enfrentamiento.puntuacion1).prop('disabled', true);
                        if(contadorRonda3==0){
                            deshabilitarBotonGuante(0);
                        }
                    }
                    contadorRonda3++; // Incrementa el contador para el próximo competidor
                }
                if(enfrentamiento.competidor2.dni!==null) {
                    $('#' + contadorRonda3).text(enfrentamiento.competidor2.nombre);
                    $('#dni' + contadorRonda3).val(enfrentamiento.competidor2.dni);
                    if(enfrentamiento.puntuacion2 !== null) {
                        $('#p' + contadorRonda3).val(enfrentamiento.puntuacion2).prop('disabled', true);
                    }
                    contadorRonda3++; // Incrementa el contador para el próximo competidor (o para el competidor solo)
                }
            }else if(enfrentamiento.ronda == 2) {
                // Semifinales
                var dniCompetidorSolo=$("#dni2").val();
                if(enfrentamiento.competidor1.dni!==null) {
                    $('#' + contadorRonda2).text(enfrentamiento.competidor1.nombre);
                    $('#dni' + contadorRonda2).val(enfrentamiento.competidor1.dni);
                    if(enfrentamiento.puntuacion1 !== null) {
                        $('#p' + contadorRonda2).val(enfrentamiento.puntuacion1).prop('disabled', true);
                        if(contadorRonda2==3){
                            deshabilitarBotonGuante(1);
                        }else if(contadorRonda2==5){
                            deshabilitarBotonGuante(2);

                        }
                    }
                    contadorRonda2++; // Incrementa el contador para el próximo competidor
                }
                if(enfrentamiento.competidor2.dni!==null && enfrentamiento.competidor2.dni!==dniCompetidorSolo) {
                    $('#' + contadorRonda2).text(enfrentamiento.competidor2.nombre);
                    $('#dni' + contadorRonda2).val(enfrentamiento.competidor2.dni);
                    if(enfrentamiento.puntuacion2 !== null) {
                        $('#p' + contadorRonda2).val(enfrentamiento.puntuacion2).prop('disabled', true);
                    }
                    contadorRonda2++; // Incrementa el contador para el próximo competidor (o para el competidor solo)
                }
                if(enfrentamiento.competidor2.dni==dniCompetidorSolo){
                    $('#2').text(enfrentamiento.competidor2.nombre);
                    $('#dni2').val(enfrentamiento.competidor2.dni);
                    if(enfrentamiento.puntuacion2 !== null) {
                        $('#p2').val(enfrentamiento.puntuacion2).prop('disabled', true);
                    }
                }
            }else if(enfrentamiento.ronda == 1){//Para la ronda final
            
                if(enfrentamiento.competidor1.dni!==null) {
                    $('#' + contadorFinal).text(enfrentamiento.competidor1.nombre);
                    $('#dni' + contadorFinal).val(enfrentamiento.competidor1.dni);
                    if(enfrentamiento.puntuacion1 !== null) {
                        $('#p' + contadorFinal).val(enfrentamiento.puntuacion1).prop('disabled', true);
                        let indiceBoton=contadorFinal/2;
                        deshabilitarBotonGuante(indiceBoton);
                    }
                    contadorFinal++; // Incrementa el contador para el próximo competidor
                }
                if(enfrentamiento.competidor2.dni!==null) {
                    $('#' + contadorFinal).text(enfrentamiento.competidor2.nombre);
                    $('#dni' + contadorFinal).val(enfrentamiento.competidor2.dni);
                    if(enfrentamiento.puntuacion2 !== null) {
                        $('#p' + contadorFinal).val(enfrentamiento.puntuacion2).prop('disabled', true);
                    }
                    contadorFinal++; // Incrementa el contador para el próximo competidor (o para el competidor solo)
                }
                //Mostrar ganador
                if(enfrentamiento.puntuacion1 !== null && enfrentamiento.puntuacion2 !== null){
                    var puntos1= parseInt(enfrentamiento.puntuacion1);
                    var puntos2= parseInt(enfrentamiento.puntuacion2);
                    if(puntos1>puntos2){
                        $('#'+contadorFinal).text(enfrentamiento.competidor1.nombre);
                   }else{
                       
                        $('#'+contadorFinal).text(enfrentamiento.competidor2.nombre);
                   }
                }      
            } 
        });

        generarSinOponente1();//Para los que han pasado y todavía no tienen oponente
        generarSinOponente2();
        generarSinOponente3();
        
        
        //Bloqueo botones siguientes del que no está bloqueado para seguir un orden
        var indiceUltimoBotonDeshabilitado;
        //Cojo el ultimo boton deshabilitado
        for(let i = 0; i <= 4; i++) {
            if ($('#b'+i).prop('disabled')) {
                indiceUltimoBotonDeshabilitado=i;
            }
        }
        if(indiceUltimoBotonDeshabilitado==null){
           indiceUltimoBotonDeshabilitado=-1; 
        }
        //Deshabilito los guantes siguientes al no deshabilitado
        for(let i = indiceUltimoBotonDeshabilitado+2; i <= 4; i++) {
            deshabilitarBotonGuante(i);
        }



    })
    .fail(function (err) {
        alert("error de conexion al mostrar " + err.status);
    });
}

function generarSinOponente1() {
    procesarGenerarSinOponente(0, 1, 5);
}
function generarSinOponente2() {
    procesarGenerarSinOponente(3, 4, 7);
}
function generarSinOponente3() {
    procesarGenerarSinOponente(5, 2, 6);
}
function generarSinOponente4() {
    procesarGenerarSinOponente(6, 7, 8);
}

function procesarGenerarSinOponente(indice0, indice1, indiceGanador) {    
    var puntuacion0 = parseInt($("#p" + indice0).val());
    var puntuacion1 = parseInt($("#p" + indice1).val());
    var dni0 = $("#dni" + indice0).val();
    var dni1 = $("#dni" + indice1).val();
if ((puntuacion0 !== 0 && !puntuacion0) || (puntuacion1 !== 0 && !puntuacion1) || puntuacion0 === puntuacion1) {
    }else{
        if (puntuacion0 > puntuacion1) {
                $("#" + indiceGanador).text($("#"+indice0).text());
                $("#dni"+ indiceGanador).val(dni0);
            } else if (puntuacion0 < puntuacion1) {
                $("#" + indiceGanador).text($("#"+indice1).text());
                $("#dni"+ indiceGanador).val(dni1);
            }
    }
}




function ronda1() {
    procesarRonda(0, 1, 5, 3, 2, 0, 0);
}
function ronda2() {
    procesarRonda(3, 4, 7, 2, 6, 1, 1);
}
function ronda3() {
    procesarRonda(5, 2, 6, 2, 7, 0, 2);
}
function rondaFinal() {
    procesarRonda(6, 7, 8, 1,null,null, 3);
}

function guardarPosiciones() {
    procesarGuardadoDePosiciones(6, 7);
}

function procesarRonda(indice0, indice1, indiceGanador, rondaNumero,indiceNuevoContrincante,posicionDelContrincante, indiceBotonGuante) {
    var puntuacion0 = parseInt($("#p" + indice0).val());
    var puntuacion1 = parseInt($("#p" + indice1).val());
    var dni0 = $("#dni" + indice0).val();
    var dni1 = $("#dni" + indice1).val();
    if(indiceNuevoContrincante!=null){
        var dniNuevoContrincante= $("#dni" + indiceNuevoContrincante).val();
    }else{
        var dniNuevoContrincante=null;
    }
if ((puntuacion0 !== 0 && !puntuacion0) || (puntuacion1 !== 0 && !puntuacion1) || puntuacion0 === puntuacion1) {
    }else{
        if (puntuacion0 > puntuacion1) {
                $("#" + indiceGanador).text($("#"+indice0).text());
                $("#dni"+ indiceGanador).val(dni0);
            } else if (puntuacion0 < puntuacion1) {
                $("#" + indiceGanador).text($("#"+indice1).text());
                $("#dni"+ indiceGanador).val(dni1);
            }
            
        //Desbloqueo siguiente boton
        habilitarBotonGuante(indiceBotonGuante+1);
        //Bloqueo el anterior por si no lo está y sus input de texto
        deshabilitarBotonGuante(indiceBotonGuante-1);
        var indice0Numero=parseInt(indice0);
        var indice0Numer1=parseInt(indice1);
        if(indice0Numero==3){
           $('#p0').prop('disabled', true);
           $('#p1').prop('disabled', true);
        }else if(indice0Numero==5) {
            $('#p3').prop('disabled', true);
           $('#p4').prop('disabled', true); 
       }else if (indice0Numero==6){
           $('#p5').prop('disabled', true);
           $('#p2').prop('disabled', true); 
       }    
        
        $.ajax({
            url: "../Torneo/controladorTorneo.php",
            type: "POST",
            data: {
                idTorneo: $("#idTorneo").val(),
                peso: $("#peso").val(),
                sexo: $("#sexo").val(),
                edad: $("#edad").val(),
                modalidad: $("#modalidad").val(),
                accion: 'insertarEnfrentamiento',
                dni0: dni0,
                dni1: dni1,
                dniNuevoContrincante: dniNuevoContrincante,
                posicionDelContrincante: posicionDelContrincante,
                puntuacion0: puntuacion0,
                puntuacion1: puntuacion1,
                ronda: rondaNumero
            }
        })
        .done(function (datos) {
            // Manejar respuesta exitosa
        })
        .fail(function (err) {
            alert("error de conexion al mostrar " + err.status);
        });
    }    
}


function deshabilitarBotonGuante(indiceBotonGuante) {
  $('#b' + indiceBotonGuante).prop('disabled', true);// Dehabilitamos botón del guante
  $('#b' + indiceBotonGuante).attr('src', '../img/guanteDesactivado.png'); // Cambiamos la imagen
}
function habilitarBotonGuante(indiceBotonGuante) {
  $('#b' + indiceBotonGuante).prop('disabled', false);// Dehabilitamos botón del guante
  $('#b' + indiceBotonGuante).attr('src', '../img/guante.png'); // Cambiamos la imagen
}
