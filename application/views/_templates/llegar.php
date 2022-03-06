<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <script src="<?php echo URL; ?>/public/js/modernizr.custom.47088.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/public/css/styles.css">
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>/public/css/style_gmaps.css">
        <!--[if IE]><link rel='stylesheet' type='text/css' href='<?php echo URL; ?>public/css/generalIE.css'><![endif]-->
        <script src="<?php echo URL; ?>/public/js/general.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <title>Como llegar a Idea Alzira</title>
        <link rel="shortcut icon" type="image/ico" href="<?php echo URL; ?>/public/img/favicon.ico" />
        <script type="text/javascript" src="http://j.maxmind.com/app/geoip.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=weather&amp;language=es"></script>
        <script type="text/javascript">
            var map;
            var directionsDisplay = new google.maps.DirectionsRenderer();
            var directionsService = new google.maps.DirectionsService();
            var markerArray = [];
            window.onload = function() {
                var centro = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
                var opciones = {center: centro, zoom: 6, mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}, mapTypeId: google.maps.MapTypeId.HYBRID, scaleControl: true};
                map = new google.maps.Map(document.getElementById('map_canvas'), opciones);
                var rendererOptions = {map: map}
            };

        </script>
    </head>
    <body >   
        <div id="todo">
            <div id="todomovil" >
                <header>
                    <a  href="<?php echo URL; ?>">
                        <div id="logo"></div></a>  
                    <div id="separador"><hr /></div>

                </header>
                <div id="direcciones" style="float:right;clear:both;width:50%;height:840px;margin:1%;background:white;"> </div>

                <div id="cuerpo" style="background:white;width:40%;margin:1%;">
                    Origen
                    <br />
                    <input type="text" style="width:90%;" id="origen" value="" />
                    <br/>
                    Destino
                    <br />
                    <input type="text" style="width:90%;" id="destino" value="Calle de la Ronda de Algemesí 4
                           ,46600, Alcira, España"  disabled/>
                    <input type="submit" name="submit" class="navi" value="Calcular ruta" onclick="calcRoute()" />
                    <br/>
                    Opciones de ruta
                    <br />
                    <input type="radio" name="tipo" id="coche" value="DRIVING" checked="checked" onchange="calcRoute();" />
                    En coche
                    <input type="radio"name="tipo"id="bicicleta"value="BICYCLING" onchange="calcRoute();"/>
                    En bicicleta
                    <input type="radio" name="tipo" id="apie" value="WALKING" onchange="calcRoute();" />
                    A pie
                    <br/>
                    <input type="checkbox" id="autopista" onchange="calcRoute();" />
                    Evitar autopistas
                    <br/>
                    <input type="checkbox" id="peaje" onchange="calcRoute();" />
                    Evitar peajes
                    <br/>
                    <input type="checkbox" id="trafico" onclick="estado();" />
                    Ver estado del tráfico
                    <br/>
                    <input type="checkbox" id="meteo" onchange="meteorologia();" />
                    Habilitar superposición meteorológica

                </div>

            </div>
        </div>
        
            <div id="map_canvas" ></div> 
        
    </body>
</html>