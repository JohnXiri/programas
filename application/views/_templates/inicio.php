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
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/jPaginate/css/style.css" media="screen"/>
        <!--[if IE]><link rel='stylesheet' type='text/css' href='<?php echo URL; ?>public/css/generalIE.css'><![endif]-->
        <title>Idea Alzira</title>
        <meta name="Title" content="Idea Alzira">
        <meta name="description" content="Agencia de Desarrollo Local del Ayuntamiento de Alzira (Formación, Empleo, Proyectos Europeos, Comercio y Emprendedurismo)
              ">
        <meta property="og:title" content="Idea Alzira"/>
        <meta property="og:description" content="Agencia de Desarrollo Local del Ayuntamiento de Alzira (Formación, Empleo, Proyectos Europeos, Comercio y Emprendedurismo)
              " />
        <meta itemprop="name" content="<?php echo $titulo; ?>">
        <meta itemprop="description" content="Agencia de Desarrollo Local del Ayuntamiento de Alzira (Formación, Empleo, Proyectos Europeos, Comercio y Emprendedurismo)
              ">
        <meta name="twitter:title" content="Idea Alzira">
        <meta name="twitter:description" content="Agencia de Desarrollo Local del Ayuntamiento de Alzira (Formación, Empleo, Proyectos Europeos, Comercio y Emprendedurismo)
              ">

    <div id="fb-root"></div>
   
</head>
<body>

    <div id="todo">
        <div id="todomovil">  

            <header>
                <a  href="<?php echo URL; ?>">
                    <div id="logo" ></div></a>          

                <hr />
                <nav>
                    <?php
                    echo "<ul>";
                    foreach ($model_menu as $valor) {

                        if (isset($valor->idcat) && isset($valor->nombre) && $valor->activo == 'si') {
                            $activas[] = $valor->idcat;
                            ?><li style='display:inline;'><a href="<?php echo URL; ?>home/seccion/<?php echo $valor->idcat ?>"><?php echo $valor->nombre ?></a></li>
                            <?php
                        }
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
                    </form>
                        ";
                    $url = URL;
                    print "<ul>
                        <li>
                        <a href='$url'>Volver al Inicio</a>
                        </li>
                        <li>
                        <a href='home/admin'>Administración</a>
                        </li>
                        <li>
                        <a href='home/admin_usuarios'>Usuarios</a>
                        </li>
                        <li>
                        <a href='home/admin_nueva_pagina'>Nuevo Artículo</a>
                        </li>
                        <li>
                        <a href='home/ver_paginas'>Administrar entradas</a>
                        </li>
                        <li>
                        <a href='home/categorias'>Categorias</a>
                        </li>        
                        </ul>";
                } else if (isset($_SESSION ["nombre"])) {
                    $nombre = $_SESSION ["nombre"];
                    // La Zona derecha se repite en todas las paginas para mostrar el menu y la opci�n de log off
                    print "<h3>Usted a iniciado sesión como $nombre </h3>
                    <form name='salida' action='' method='post'>";
                    if (isset($_SESSION ["imagen"])) {
                        $imagen = $_SESSION ["imagen"];
                        print "<img src='$imagen' id='imgHolder' /><br/>";
                    }
                    print"<input type='submit' name='salir' value='salir' onclick='myIFrame.location='https://www.google.com/accounts/Logout'; startLogoutPolling();return false;' />
                    </form>
                    ";
                } else {
                    $error = "";
                    $url = URL;
                    $url.= "home/sesion/";
                    print "
		<p>Escriba su nombre y contraseña</p>
                <form name='datos' id='login' action='$url' method='POST'>
		Nombre<br/><input type='text' name='nombre' id='nombre' /><br/>
		Contraseña<br/><input type='password' id='plog' name='pass' /><br/>
                <input type='hidden' id='externo' name='externo' value='' />
                <input type='hidden' id='imagen' name='imagen' value='' />
                <input type='hidden' id='email' name='email' value='' />
		<input type='submit' name='enviar' value='enviar' /> <input
			type='reset' name='limpiar' value='borrar' /><br />
		</form>
		";
                    ?>
                    <br/>    

                    <a href='#' onClick='login();' id="loginText">Inicia sesión con Google </a>
                    <a href="#" style="display:none" id="logoutText" target='myIFrame' onclick="myIFrame.location = 'https://www.google.com/accounts/Logout';
                                                    startLogoutPolling();
                                                    return false;">Cierra tu sesion de Google</a>
                    <iframe name='myIFrame' id="myIFrame" style='display:none'></iframe>
                    <div id='uName'></div>

                    <br/>
                    <?php
                }
                ?>
                <section id="social">
                    <div class="fb-like-box" id="fb-like-box" data-href="https://www.facebook.com/idealzira" 
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
            <?php
// La zona izquierda muestra las entradas en la p�gina principal y las opciones en el �rea de administraci�n
            echo "<section id='izq'>";
            Home::paginar($todos_articulos, $activas);
            ?>

            <div id="pages" >                   
            </div>

            <br/>
            <?php
            include_once 'application/views/_templates/menuf.php';
            ?>	

            </section>

            <script src="<?php echo URL; ?>public/jPaginate/jquery.paginate.js" type="text/javascript"></script>


        </div>
    </div>
</body>
</html>