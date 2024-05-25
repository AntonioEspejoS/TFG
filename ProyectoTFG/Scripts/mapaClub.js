$(function () {
    var latitudClub = $("#latitudClub").val();
    var longitudClub = $("#longitudClub").val();
    var nombreClub = $("#identificadorNombreDelClub").text();
    if (latitudClub && longitudClub) {
        var mapa = L.map('mapaClub').setView([latitudClub, longitudClub], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(mapa);

        L.marker([latitudClub, longitudClub]).addTo(mapa)
            .bindPopup(nombreClub)
            .openPopup();
    }
    $("#btnCambiarUbicacion").on("click", abrirDialogoSeleccionUbicacion);
    $("#btnConfirmarUbicacion").on("click", actualizarUbicacion);
});

function abrirDialogoSeleccionUbicacion() {
    // Coordenadas predeterminadas, ejemplo: Centro de Madrid
    var latPredeterminada = 40.416775;
    var lngPredeterminada = -3.703790;

    // Intenta obtener las coordenadas actuales del club
    var latitudClub = $("#latitudClub").val();
    var longitudClub = $("#longitudClub").val();

    // Verifica si el club ya tiene coordenadas
    var latInicial = latitudClub ? parseFloat(latitudClub) : latPredeterminada;
    var lngInicial = longitudClub ? parseFloat(longitudClub) : lngPredeterminada;
    $("#latitudNueva").val(latInicial);
    $("#longitudNueva").val(lngInicial);

    setTimeout(function() {
        var mapaSeleccion = L.map('mapaSeleccion').setView([latInicial, lngInicial], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(mapaSeleccion);

        var marcador = L.marker([latInicial, lngInicial], {
            draggable: true
        }).addTo(mapaSeleccion);


        // Añadiendo el buscador al mapa
        L.Control.geocoder({
            defaultMarkGeocode: false
        })
        .on('markgeocode', function(e) {
            var bbox = e.geocode.bbox;
            var poly = L.polygon([
                bbox.getSouthEast(),
                bbox.getNorthEast(),
                bbox.getNorthWest(),
                bbox.getSouthWest()
            ]).addTo(mapaSeleccion);
            mapaSeleccion.fitBounds(poly.getBounds());
            marcador.setLatLng(e.geocode.center);
            $("#latitudNueva").val(e.geocode.center.lat.toFixed(6));
            $("#longitudNueva").val(e.geocode.center.lng.toFixed(6));
        })
        .addTo(mapaSeleccion);
        //Fin buscador


        mapaSeleccion.on('click', function(e) {
            var latLng = e.latlng;
            marcador.setLatLng(latLng); // Mueve el marcador a la nueva ubicación
            $("#latitudNueva").val(latLng.lat.toFixed(6)); // Actualiza el valor de latitud
            $("#longitudNueva").val(latLng.lng.toFixed(6)); // Actualiza el valor de longitud
        });

        marcador.on('dragend', function(event) {
            var posicion = event.target.getLatLng();
            $("#latitudNueva").val(posicion.lat.toFixed(6));
            $("#longitudNueva").val(posicion.lng.toFixed(6));
        });
    }, 500);

    $("#dialogoMapaSeleccion").dialog({
        resizable: false,
        width: 700,
        height: 560,
        modal: true,
        open: function(event, ui) {
            $(this).find("input[type=button], button").button();
            var distanciaDesdeArriba = 10;
            $(this).parent().css({
                "position": "fixed",
                "top": distanciaDesdeArriba + "%"
            });
        }
    }).dialog("open");
}

function actualizarUbicacion(latitud, longitud) {
    var idClub = $("#idClub").val();
    var latitudNueva = $("#latitudNueva").val();
    var longitudNueva = $("#longitudNueva").val();
    $.ajax({
        url: "../listados/controladorListaMiClub.php",
        type: "POST",
        data: {
            idClub: idClub,
            latitud: latitudNueva,
            longitud: longitudNueva,
            accion: 'actualizarUbicacion'
        }
    })
    .done(function(respuesta) {
        $("#dialogoMapaSeleccion").dialog("close");
        location.reload();
    })
    .fail(function(err) {
        alert("Error al actualizar la ubicación: " + err.status);
    });
}
