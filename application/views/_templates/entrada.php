<?php
if (!session_start()) {
    session_start();
}
$email = "";
if (isset($_REQUEST['borrar'])) {
    $id = $_REQUEST['id'];
    Home::borrar_comentario($id);
}

if (isset($_SESSION['nombre'])) {

    $nombre = $_SESSION['nombre'];
}
if (isset($_REQUEST ['salir'])) {
    session_destroy();
    $url = URL;
    header('Location: ' . $url);
}
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}
if (isset($_REQUEST ['rname'])) {
    $rname = $_REQUEST['rname'];
}
foreach ($entrada as $valor) {
    $titulo = $valor->titulo;

    $mensaje = $valor->mensaje;

    $id = $valor->id_entrada;

    $rmensaje = Home::resumir_meta($mensaje);
}
$actual= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
        <script src="https://apis.google.com/js/plusone.js"></script>
        <title><?php echo $titulo; ?></title>
        <meta name="Title" content="<?php echo $titulo; ?>">
        <meta name="description" content="<?php echo $rmensaje; ?>">
        <meta property="og:title" content="<?php echo $titulo; ?>"/>
        <meta property="og:description" content="<?php echo $rmensaje; ?>" />
        <meta itemprop="name" content="<?php echo $titulo; ?>">
        <meta itemprop="description" content="<?php echo $rmensaje; ?>">
        <meta name="twitter:title" content="<?php echo $titulo; ?>">
        <meta name="twitter:description" content="<?php echo $rmensaje; ?>">
        <script>
            function mostrar_respuestas(m) {
                id = "respuestas" + m;
                // document.getElementById("respuestas").style.display = "";
                $("#" + id).toggle();
            }


            var ida = -1;
            var nombre = "";
            function response(id, id2, ide) {

                idn = id;
                if (id2 >= 0) {
                    id = id2;
                }
                else {
                    id2 = id;
                }
                // alert(id2);
                if (ida != id) {

<?php if (isset($_SESSION['nombre'])) { ?>
                        $("#" + id).append("<br/><div style='margin-left:5%;'><form name='moderar' action='' method='POST'>" +
                                "Nombre <input  type='text' name='nombre2' value='<?php echo $nombre; ?>'  style='margin-left: 3%;'  disabled/><br/>" +
                                "<input  type='hidden' name='admin' value='<?php echo $nombre; ?>' />" +
                                "<input type='hidden' id='email' name='email' style='margin-left:4.5%;' value='<?php echo $email ?>'/>" +
                                "<textarea name='responsearea' rows='5' cols='45'/><br/>" +
                                "<input type='hidden' name='nen' style='margin-left:4.5%;' value='" + ide + "' />" +
                                "<input type='hidden' name='rid' style='margin-left:4.5%;' value='" + id2 + "' />" +
                                "<input type='hidden' name='idr' value='" + idn + "' />" +
                                "<input type='hidden' id='id' name='id' style='margin-left:4.5%;' value='<?php echo $id ?>'/>" +
                                "<input type='submit' name='response' value='Enviar respuesta' />" +
                                "</form></div>");

<?php } else {
    ?>
                        $("#" + id).append("<br/><div style='margin-left:5%;'><form name='moderar' action='' method='POST'>" +
                                "Nombre <br/><input  type='text' name='nombreu'  style='margin-left: 3%;' /><br/>" +
                                "Mail <br/><input  type='text' name='email'  style='margin-left: 3%;' /><br/>" +
                                "<textarea name='responsearea' rows='5' cols='45'/>" +
                                "<input type='hidden' name='nen' style='margin-left:4.5%;' value='" + ide + "' />" +
                                "<input type='hidden' name='rid' style='margin-left:4.5%;' value='" + id2 + "' />" +
                                "<input type='hidden' name='idr' value='" + idn + "' /><br/>" +
                                "<input type='submit' name='response' value='Enviar respuesta' />" +
                                "</form></div>");

<?php } ?>

                    ida = id;
                }
            }

        </script>

    </head>
    <body>

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

                            if (isset($valor->idcat) && isset($valor->nombre) && $valor->activo == 'si') {
                                ?><li style='display:inline;'><a href="<?php echo URL; ?>home/seccion/<?php echo $valor->idcat ?>"><?php echo $valor->nombre ?></a></li>
                                <?php
                            }
                        }
                        echo "</ul>";
                        ?>
                    </nav>
                    <div id="separador"><hr /></div>

                </header>
                <aside id='derecha' >
                    <?php
                    if (isset($_SESSION ["nombre"]) && $_SESSION ["admin"] == 'si') {
                        $nombre = $_SESSION ["nombre"];
                        // La Zona derecha se repite en todas las paginas para mostrar el menu y la opcion de log off
                        ?>

                        <?php
                        print "<h3>Usted a iniciado sesión como $nombre </h3>
                        <form name='salida' action='' method='post'>";
                        if (isset($_SESSION ["imagen"]) && $_SESSION ["tipo"] == 'admin') {
                            $imagen = $_SESSION ["imagen"];
                            print "<img src='$imagen' id='imgHolder' /><br/>";
                        }
                        print"<input type='submit' name='salir' value='salir' onclick='myIFrame.location='https://www.google.com/accounts/Logout'; startLogoutPolling();return false;' />
                        </form><br/>
                        ";
                        include_once 'menus.php';
                        ?>
                        <br/>
                        <?php
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
                    } else {
                        ?>  

                        <?php
                        print " 
                        <p>Escriba su nombre y contraseña</p>
                        <form name='datos' id='login' action='";
                        echo URL;
                        print "home/sesion' method='POST'>
                        Nombre <input  type='text' name='nombre' id='nombre' /><br />
                        Contraseña <input type='password' id='plog' name='pass' /><br />
                        <input type='hidden' id='externo' name='externo' value='' />
                        <input type='hidden' id='imagen' name='imagen' value='' />
                        <input type='hidden' id='mail' name='email' value='$email' />
                        <input type='submit' name='enviar' value='enviar' /> <input
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
// La zona izquierda muestra las entradas en la p�gina principal y las opciones en el �rea de administraci�n
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
                <section id='izq' >

                    <?php
                    echo "<article><h3>$titulo</h3>";
                    echo $mensaje;
                    echo "</article><br>";
                    $nomcheck = "";
                    $mailcheck = "";
                    $comcheck = "";

                    if (isset($_SESSION['nombre']) && isset($_REQUEST ['comentar'])) {
                        $nombre = $_SESSION['nombre'];
                        $coment = $_REQUEST ['coment'];

                        Home::comentar($nombre, $coment, $id, $email);
                    } else if (!isset($_SESSION['nombre']) && isset($_REQUEST ['comentar'])) {

                        $nombre = $_REQUEST ['nombre'];
                        $mail = $_REQUEST ['mail'];
                        $coment = $_REQUEST ['coment'];

                        $patron = "/^[[:alnum:] -_áéíóúÇü\$]{4,30}+$/i";
                        $nomcheck = "";
                        $patronmail = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|biz|info|mobi|cat|es|ar)$/i";
                        $mailcheck = "";

                        $comcheck = "";
                        if (preg_match($patron, $nombre)) {
                            if (preg_match($patronmail, $mail)) {
                                Home::comentar($nombre, $coment, $id, $mail);
                            } else {

                                $mailcheck = "<p id='warning' >E-mail no valido<p>";
                            }
                        } else {

                            $nomcheck = "<p id='warning' >Solo se permiten nombres con letras,numeros,guiones '-',guiones bajos '_' o arrobas '@' , 4 carácteres mínimo<p>";
                        }
                    }
                    ?>
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        <a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal" pi:pinit:url="http://www.addthis.com/features/pinterest" pi:pinit:media="http://www.addthis.com/cms-content/images/features/pinterest-lg.png"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <script type="text/javascript">var addthis_config = {"data_track_addressbar": true};</script>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-535f9ce6161edcdf"></script>
                    <!-- AddThis Button END -->
                    </article>
                    <article>
                        <h3>Comentarios:</h3>
                        <input type='submit' onClick='enableidea()' id='ideac' value='Idea' />
                        <input type='submit' onClick='enableface()' id='facec' value='Facebook' />
                        <input type='submit' onClick='enablegoogle()' id='googlec' value='Google' />

                        <br/>


                        <div style="display:none;" id='divface'>	
                            <h2>Comentarios de facebook</h2>
                            <div id="fb-root"></div>
                            <div class="fb-comments" data-href="<?php echo $actual; ?>"
                                 data-width="600" data-numposts="15" data-colorscheme="light"></div>
                        </div>

                        <div style="display:none;" id='divgoogle'>
                            <h2>Comentarios de Google+</h2>
                            <div class="g-comments" data-first_party_property="BLOGGER" data-href="<?php echo $actual; ?>" data-view_type="FILTERED_POSTMOD" data-width="600">
                            </div> 

                        </div>

                        <div style="display:block;" id='dividea'>
                            <h2>Comentarios de Idea</h2>
                            <?php
                            if (isset($_SESSION['nombre'])) {
                                ?>
                                <h3>Dejar comentario:</h3>
                                <form name='datos' action='' method='POST'>
                                    Nombre <input id="nombre" type='text' name='nombre1' 
                                                  value='<?php echo $_SESSION['nombre']; ?>' disabled/>
                                    <input type='hidden' id='email' name='mail'  style='margin-left:4.5%;' value='<?php echo $email ?>' />
                                    <?php echo $comcheck ?> 
                                    <br/>Comentario<br/><textarea id="comentario" name='coment' style='margin-left:2%;width:80%;' rows="10" width="80%" maxlength="300"/></textarea>
                                    <br /> <input type='submit' name='comentar' value='enviar' /> <input
                                        type='reset' name='limpiar' value='borrar' /><br />
                                </form>

                            <?php } else { ?>

                                <form name='datos' action='' method='POST'>
                                    <h3>Dejar comentario:</h3>
                                    <?php echo $nomcheck ?> 
                                    Nombre <input id="nombre" type='text' name='nombre' />
                                    <?php echo $mailcheck ?> 
                                    <br/>E-mail <input id="mail" type='text' name='mail' />
                                    <?php echo $comcheck ?> 
                                    <br/>Comentario<br/><textarea id="comentario" name='coment'  rows="10" cols="70" maxlength="300"/></textarea>
                                    <br /> <input type='submit' name='comentar' value='enviar' /> 
                                    <input type='reset' name='limpiar' value='borrar' /><br/>
                                </form>

                                <?php
                            }
                            ?>
                            <div id='paginar' class='demo'>
                            <?php
                            Home::mostrar_comentarios($comentarios, $model);
                            ?>  

                                <!-- Fin Div superior de paginación--> 
                            </div>
                            <br/>
                            <div id="pages" >                   
                            </div>
                            <br/>
                            <!-- Fin Dividea ( comentarios de idea ) -->              
                        </div>

                        <!-- Fin article comentarios -->  
                    </article>  

                    <script src="<?php echo URL; ?>public/jPaginate/jquery.paginate.js" type="text/javascript"></script>

<?php
include_once 'menuf.php';

if (isset($_REQUEST['response'])) {

    Home::responder_comentario();
}
?> 
                    <!-- Fin section izq -->
                </section>

            </div>

        </div>

    </body>
</html>