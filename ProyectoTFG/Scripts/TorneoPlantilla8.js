$(function () {
    generar();
    $('.enlaceTerminarCategoria').on('click', false);
    $("#b0").on("click", ronda1);
    $("#b1").on("click", ronda2);
    $("#b2").on("click", ronda3);
    $("#b3").on("click", ronda4);
    $("#b4").on("click", ronda5);
    $("#b5").on("click", ronda6);
    $("#b6").on("click", rondaFinal);
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
        for(let i = 0; i <= 14; i++) {
            $('#' + i).text("------");
            $('#dni' + i).val('');
            $('#p' + i).val('').prop('disabled', false); // Habilita los campos de puntuación
            //$('#b' + i).prop('disabled', true);
            //$('#b' + i).attr('src', '../img/guanteDesactivado.png'); // Cambiamos la imagen
        }
        let contadorRonda3 = 0; // Para semifinales
        let contadorRonda2 = 8; // Para semifinales
        let contadorFinal = 12; // Para la final, inicia en 2 porque es el índice del que está solo
        $.each(enfrentamientos, function (ind, enfrentamiento) {
            //Nota: El competidor 1 siempre va a ser el de arriba y el 2 el de abajo o si están
            //en lados opuestos el 1 será el de la izquierda y el 2 el de la derecha
            //Cuartos
            if( enfrentamiento.ronda == 3){
                if(enfrentamiento.competidor1.dni!==null) {
                    $('#' + contadorRonda3).text(enfrentamiento.competidor1.nombre);
                    $('#dni' + contadorRonda3).val(enfrentamiento.competidor1.dni);
                    if(enfrentamiento.puntuacion1 !== null) {
                        $('#p' + contadorRonda3).val(enfrentamiento.puntuacion1).prop('disabled', true);
                        //Para los botones que tengo debajo bloquearlos ya que tengo la puntuacion guardada
                        let indiceBoton=contadorRonda3/2;
                        deshabilitarBotonGuante(indiceBoton);
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
                if(enfrentamiento.competidor1.dni!==null) {
                    $('#' + contadorRonda2).text(enfrentamiento.competidor1.nombre);
                    $('#dni' + contadorRonda2).val(enfrentamiento.competidor1.dni);
                    if(enfrentamiento.puntuacion1 !== null) {
                        $('#p' + contadorRonda2).val(enfrentamiento.puntuacion1).prop('disabled', true);
                        let indiceBoton=contadorRonda2/2;
                        deshabilitarBotonGuante(indiceBoton);

                    }
                    contadorRonda2++; // Incrementa el contador para el próximo competidor
                }
                if(enfrentamiento.competidor2.dni!==null) {
                    $('#' + contadorRonda2).text(enfrentamiento.competidor2.nombre);
                    $('#dni' + contadorRonda2).val(enfrentamiento.competidor2.dni);
                    if(enfrentamiento.puntuacion2 !== null) {
                        $('#p' + contadorRonda2).val(enfrentamiento.puntuacion2).prop('disabled', true);
                    }
                    contadorRonda2++; // Incrementa el contador para el próximo competidor (o para el competidor solo)
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
        generarSinOponente4();
        generarSinOponente5();
        generarSinOponente6();
        
        
        //Bloqueo botones siguientes del que no está bloqueado para seguir un orden
        var indiceUltimoBotonDeshabilitado;
        //Cojo el ultimo boton deshabilitado
        for(let i = 0; i <= 16; i++) {
            if ($('#b'+i).prop('disabled')) {
                indiceUltimoBotonDeshabilitado=i;
            }
        }
        if(indiceUltimoBotonDeshabilitado==null){
           indiceUltimoBotonDeshabilitado=-1; 
        }
        //Deshabilito los guantes siguientes al no deshabilitado
        for(let i = indiceUltimoBotonDeshabilitado+2; i <= 16; i++) {
            deshabilitarBotonGuante(i);
        }
    })
    .fail(function (err) {
        alert("error de conexion al mostrar " + err.status);
    });
}

function generarSinOponente1() {
    procesarGenerarSinOponente(0, 1, 8);
}
function generarSinOponente2() {
    procesarGenerarSinOponente(2, 3, 9);
}
function generarSinOponente3() {
    procesarGenerarSinOponente(4, 5, 10);
}
function generarSinOponente4() {
    procesarGenerarSinOponente(6, 7, 11);
}
function generarSinOponente5() {
    procesarGenerarSinOponente(8, 9, 12);
}
function generarSinOponente6() {
    procesarGenerarSinOponente(10, 11, 13);
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
    procesarRonda(0, 1, 8, 3,9,0,0);
}
function ronda2() {
    procesarRonda(2, 3, 9, 3,8,1,1);
}
function ronda3() {
    procesarRonda(4, 5, 10, 3,11,0,2);
}
function ronda4() {
    procesarRonda(6, 7, 11, 3,10,1,3);
}
function ronda5() {
    procesarRonda(8, 9, 12, 2,13,0,4);
}
function ronda6() {
    procesarRonda(10, 11, 13, 2,12,1,5);
}
function rondaFinal() {
    procesarRonda(12, 13, 14, 1,null,null,6);
}

function guardarPosiciones() {
    procesarGuardadoDePosiciones(12, 13);
}

function procesarRonda(indice0, indice1, indiceGanador, rondaNumero, indiceNuevoContrincante, posicionDelContrincante,indiceBotonGuante) {
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
        $('#p' + (parseInt(indice0)-2)).prop('disabled', true);
        $('#p' + (parseInt(indice1)-2)).prop('disabled', true);


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
