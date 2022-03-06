<?php
if (!session_start()) {
    session_start();
}
if (isset($_REQUEST ['salir'])) {
    session_destroy();
    $url = URL;
    header('Location: ' . $url);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="UTF-8">

        <script src="<?php echo URL; ?>/public/js/modernizr.custom.47088.js"></script>
        <script src="<?php echo URL; ?>/public/js/jquery-1.11.0.js" type="text/javascript" ></script>
        <script src="<?php echo URL; ?>/public/js/google.js"></script>
        <script src="<?php echo URL; ?>/public/js/general.js"></script>
        <link rel="shortcut icon" type="image/ico" href="<?php echo URL; ?>/public/img/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/styles.css">
        <!--[if IE]><link rel='stylesheet' type='text/css' href='<?php echo URL; ?>public/css/generalIE.css'><![endif]-->
        <meta name="viewport" content="width=device-width">
        <title>Contacto Idea Alzira</title>
    <div id="fb-root"></div>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

</head>
<body onload="initialize();">
    <div id="todo">
        <div id="todomovil">
            <header>
                <a  href="<?php echo URL; ?>">
                    <div id="logo"></div></a>  

                <hr />
                <nav>
                    <?php
                    echo "<ul>";
                    foreach ($model_menu as $valor) {

                        if (isset($valor->nombre))
                            
                            ?><li style='display:inline;'><a href="<?php echo URL; ?>home/seccion/<?php echo $valor->nombre ?>"><?php echo $valor->nombre ?></a></li>
                        <?php
                       
                    }
                    echo "</ul>";
                    ?>
                </nav>
                <div id="separador"><hr /></div>

            </header>
            <aside id='derecha'>
                <?php
                if (isset($_SESSION ["nombre"]) && $_SESSION ["admin"] == 'si') {
                    $nombre = $_SESSION ["nombre"];
                    // La Zona derecha se repite en todas las paginas para mostrar el menu y la opci�n de log off
                    print "<h3>Usted a iniciado sesión como $nombre </h3>
                    <form name='salida' action='' method='post'>";
                    if (isset($_SESSION ["imagen"])) {
                        $imagen = $_SESSION ["imagen"];
                        print "<img src='$imagen' id='imgHolder' /><br/>";
                    }
                    print"<input type='submit' name='salir' value='salir' onclick='myIFrame.location='https://www.google.com/accounts/Logout'; startLogoutPolling();return false;' />
                    </form><br/>
                    ";
                    include_once 'menus.php';
                    
                    echo "<br/>";
                } else if (isset($_SESSION ["nombre"])) {
                    $nombre = $_SESSION ["nombre"];
                    // La Zona derecha se repite en todas las paginas para mostrar el menu y la opci�n de log off
                    print " 
                    <h3>Usted a iniciado sesión como $nombre </h3>
                    <form name='salida' action='' method='post'>";
                    if (isset($_SESSION ["imagen"])) {
                        $imagen = $_SESSION ["imagen"];
                        print "<img src='$imagen' id='imgHolder' /><br/>";
                    }
                    print"<input type='submit' name='salir' value='salir' onclick='myIFrame.location='https://www.google.com/accounts/Logout'; startLogoutPolling();return false;' />
                    </form>
                    ";
                    ?>

                    <?php
                } else {
                    $error = "";
                    $url = URL;
                    $url.= "home/sesion/";
                    print "<p>Escriba su nombre y contraseña</p>
                  <form name='datos' id='login' action='$url' method='POST'>
		Nombre <input type='text' name='nombre' id='nombre' /><br />
		Contraseña <input type='password' id='plog' name='pass' /><br />
                <input type='hidden' id='externo' name='externo' value='' />
                <input type='hidden' id='imagen' name='imagen' value='' />
                <input type='hidden' id='email' name='email' value='' />
		<br /> <input type='submit' name='enviar' value='enviar' /> <input
			type='reset' name='limpiar' value='borrar' /><br />
		</form>
			
		";
                    ?>


                    <a href='#' onClick='login();' id="loginText">Inicia sesión con Google </a>
                    <a href="#" style="display:none" id="logoutText" target='myIFrame' onclick="myIFrame.location = 'https://www.google.com/accounts/Logout';
                                startLogoutPolling();
                                return false;">Cierra tu sesion de Google</a>
                    <iframe name='myIFrame' id="myIFrame" style='display:none'></iframe>
                    <div id='uName'></div>
                    <br/>

                    <?php
                }
                // La zona izquierda muestra las entradas en la página principal y las opciones en el area de administración
                ?>
                <section id="social">
                    <div class="fb-like-box" data-href="https://www.facebook.com/idealzira" 
                         data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false"
                         data-show-border="true" data-width="190px" data-height="500px"></div>

                    <a class="twitter-timeline"  href="https://twitter.com/IdeaAlzira"  data-widget-id="471203220077809664">Tweets por @IdeaAlzira</a>
                    <script>!function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = p + "://platform.twitter.com/widgets.js";
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, "script", "twitter-wjs");</script>
                </section>
            </aside>
            <section id='izq'>
                <article>
                    <h4>IDEA.- Iniciativa per al Desenvolupament Econòmic d'Alzira </h4>
                    <p>c/ Ronda d'Algemesí, 4 - 46600 ALZIRA</p>
                    <p>Tel.: 96 245 51 01 - Fax: 96 245 53 90</p>
                    <p>E-mail: adl@idea-alzira.com</p>
                </article>
                <br/>
                <article>
                    <div id="mapa" style="width:100%; height:500px; margin:0 auto">

                    </div>    
                    <br/>
                    <a href="#" onclick="geolocalizame()">Mostrarme mi ubicación</a>
                </article>
                <?php
                include_once 'menuf.php';
                ?>
            </section>
        </div>
    </div>
</body>
</html>