/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=695877713783715&version=v2.0";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


function enableidea() {
    document.getElementById('divface').style.display = "none";
    document.getElementById('divgoogle').style.display = "none";
    document.getElementById("dividea").style.display = "";
}
function enableface() {
    document.getElementById("dividea").style.display = "none";
    document.getElementById('divgoogle').style.display = "none";
    document.getElementById('divface').style.display = "";

}
function enablegoogle() {
    document.getElementById("dividea").style.display = "none";
    document.getElementById('divface').style.display = "none";
    document.getElementById('divgoogle').style.display = "";
}

var map; //importante definirla fuera de la funcion initialize() para poderla usar desde otras funciones.

function initialize() {
    //39°09'10.3"N 0°26'29.4"W

    var punto = new google.maps.LatLng(39.152861, -0.4415);

    var myOptions = {
        center: punto,
        mapTypeId: google.maps.MapTypeId.ROADMAP, //Tipo de mapa inicial satélite para ver Idea
        draggable: true,
        KeyBoardShortcuts: true,
        mapTypeControl: true,
        navigationControl: true,
        scrollwheel: true,
        streetViewControl: true,
        zoom: 21,
    }
    map = new google.maps.Map(document.getElementById("mapa"), myOptions);

    marker = new google.maps.Marker({
        position: punto,
        animation: google.maps.Animation.BOUNCE,
        title: "Estamos aquí"
    });

    marker.setMap(map);

    var infowindow = new google.maps.InfoWindow({
        content: "Idea Alzira"
    });

    infowindow.open(map, marker);
}


function pedirPosicion(pos) {
    //Pido al navegador las coordenadas y se las paso a la variable en
    //la que usare luego en la función para ponerlo en pantalla.
    var lat = pos.coords.latitude;
    var lon = pos.coords.longitude;
    var centro = new google.maps.LatLng(lat, lon);
    map.setCenter(centro); //pedimos que centre el mapa..
    map.setMapTypeId(google.maps.MapTypeId.ROADMAP); //y lo volvemos un mapa callejero
    //alert("¡Hola! Estas en : " + pos.coords.latitude + "," + pos.coords.longitude + " Rango de localización de +/- " + pos.coords.accuracy + " metros");
    //la funcion que pone el punto saltando con las coordenadas que guardamos anteriormente en la variable centro
    marker = new google.maps.Marker({
        position: centro,
        animation: google.maps.Animation.BOUNCE,
        title: "Estas aquí"

    });

    marker.setMap(map);
}

function geolocalizame() {
    //llamo a la funcion que pide las coordenadas al navegador.
    navigator.geolocation.getCurrentPosition(pedirPosicion);
}
//Diferentes opciones para calcular la ruta en la página donde se escribe la calle
function estado() {
    var controltrafico = document.getElementById("controltrafico");
    if (document.getElementById("trafico").checked) {
        controltrafico.style.display = "";
        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map)
    } else {
        controltrafico.style.display = "none";
        window.onload()
    }
}
function meteorologia() {
    if (document.getElementById("meteo").checked) {
        var weatherLayer = new google.maps.weather.WeatherLayer({temperatureUnits: google.maps.weather.TemperatureUnit.CELSIUS});
        weatherLayer.setMap(map);
        var cloudLayer = new google.maps.weather.CloudLayer();
        cloudLayer.setMap(map)
    } else {
        var weatherLayer = null;
        var cloudLayer = null;
        window.onload()
    }
}
;
//Calculo la ruta en base a la calle que le puse
function calcRoute() {
    for (i = 0; i < markerArray.length; i++) {
        markerArray[i].setMap(null)
    }
    ;
    markerArray = [];
    var modo;
    if (document.getElementById('coche').checked) {
        modo = google.maps.DirectionsTravelMode.DRIVING
    } else if (document.getElementById('bicicleta').checked) {
        modo = google.maps.DirectionsTravelMode.BICYCLING
    } else if (document.getElementById('apie').checked) {
        modo = google.maps.DirectionsTravelMode.WALKING
    } else {
        alert('Escoja un modo de ruta')
    }
    ;
    var origen = document.getElementById('origen').value;
    var destino = document.getElementById('destino').value;
    var request = {origin: origen, destination: destino, travelMode: modo, avoidHighways: document.getElementById('autopista').checked, avoidTolls: document.getElementById('peaje').checked};
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setMap(map);
            directionsDisplay.setPanel(document.getElementById('direcciones'));
            directionsDisplay.setDirections(response)
        } else {
            alert("No existen rutas entre ambos puntos")
        }
    })
}
