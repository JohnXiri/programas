<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller {

    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index() { /*
      // debug message to show where you are, just for the demo
      echo 'Message from Controller: You are in the controller home, using the method index()';
      // load views. within the views we can echo out $songs and $amount_of_songs easily
      require 'application/views/_templates/header.php';
      require 'application/views/home/index.php';
      require 'application/views/_templates/footer.php';
     * 
     */
        $model = $this->loadModel('Model');
        $model_menu = $model->menu();
        $todos_articulos = $model->todos_articulos();

        require 'application/views/_templates/inicio.php';
    }

    public function seccion($cat) {
        $model = $this->loadModel('Model');
        $model_menu = $model->menu();

        $articulos_categoria = $model->articulos_categoria($cat);
        require 'application/views/_templates/seccion.php';
    }

    public function menu() {
        $model = $this->loadModel('Model');
        $menu_model = $model->menu();
    }

    public function entrada($id) {
        $model = $this->loadModel('Model');
        $model_menu = $model->menu();
        $entrada = $model->obtener_producto($id);
        $comentarios = $model->cargar_comentarios($id);

        require 'application/views/_templates/entrada.php';
    }

    public function cargar_respuestas($idc, $model) {
        $respuestas = $model->cargar_respuestas($idc);
        return $respuestas;
    }

    public function contacto() {
        $model = $this->loadModel('Model');
        $model_menu = $model->menu();
        require 'application/views/_templates/contacto.php';
    }

    public function llegar() {
        $model = $this->loadModel('Model');
        $model_menu = $model->menu();
        require 'application/views/_templates/llegar.php';
    }

    public function sesion() {

        require 'application/views/_templates/sesion.php';
    }

    public function login($nombre, $pass) {
//echo "$nombre $pass";
        $model = $this->loadModel('Model');
        $result = $model->login($nombre, $pass);
        return $result;
    }

    public function admin() {
        require 'application/views/_templates/admin.php';
    }

    function comentar($nombre, $coment, $nentrada, $mail) {

        $comentarios = $this->loadModel('Comentarios');

        if (!isset($_SESSION['nombre'])) {
            $tipo = "visitante";
//limpio el comentario antes de introducirlo en la base de datos.
            htmlspecialchars(stripslashes(strip_tags(trim($coment))));
            $result = $comentarios->comentar($nombre, $coment, $nentrada, $tipo, $mail);
        }

        if (isset($_SESSION['nombre'])) {

            htmlspecialchars(stripslashes(strip_tags(trim($coment))));
            $tipo = "usuario";
            $result = $comentarios->comentar($nombre, $coment, $nentrada, $tipo, $mail);

            if ($result) {
                echo "El comentario se ha podido guardar $nombre";
            } else {
                echo "El comentario no se ha podido guardar $nombre";
            }
        }
// redireciono a la misma pagina para que no me vuelva a guardar el comentario si se refresca

        $location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <script>
            window.location.replace("<?php echo $location; ?>");
        </script>
        <?php
    }

    function borrar_comentario($id) {
        $comentarios = $this->loadModel('Comentarios');
        if ($comentarios->borrar_comentario($id)) {
            echo "<p style='color:red;'/>Se borro el comentario con éxito</p>";
        } else {
            echo "<p style='color:red;'/>No se pudo borrar el comentario</p>";
        }

        $location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <script>
            window.location.replace("<?php echo $location; ?>");
        </script>
        <?php
    }

    function responder_comentario() {

        global $url_parameter_1;
        $id = $_REQUEST['idr'];
        $idn = $_REQUEST['nen'];
        $resid = $_REQUEST['rid'];
        if (isset($_REQUEST['admin'])) {
            $usuario = $_REQUEST['admin'];
        } else {
            $usuario = $_REQUEST['nombreu'];
        }
        $mail = "";
        if (isset($_REQUEST['email'])) {
            $mail = $_REQUEST['email'];
        } else {
            $mail = $_REQUEST['email'];
        }

        $coment = $_REQUEST['responsearea'];
//limpio el comentario antes de introducirlo en la base de datos.
        $coment = htmlspecialchars(stripslashes(strip_tags(trim($coment))));
        $comentarios = $this->loadModel('Comentarios');

        if (isset($_SESSION ['nombre'])) {
            if ($comentarios->responder_comentario($idn, $id, $usuario, $mail, $coment, $resid)) {
                echo "La respuesta se guardo correctamente $usuario";
            } else {
                echo "La respuesta no se ha podido guardar $usuario";
            }
        } else {
            $patron = "/^[[:alnum:] -_áéíóúÇü\$]{5,30}+$/i";
            $patronmail = "/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.(?:[A-Z]{2}|com|org|net|biz|info|mobi|cat|es|ar)$/i";

            if (preg_match($patron, $usuario)) {
                if (preg_match($patronmail, $mail)) {
                    if ($comentarios->responder_comentario($idn, $id, $usuario, $mail, $coment, $resid)) {
                        echo "La respuesta se guardo correctamente $usuario $resid";
                    } else {
                        echo "<script>alert('La respuesta no se ha podido guardar $usuario')</script> ";
                    }
                } else {

                    echo "<script>alert('E-mail no valido $mail')</script>";
                }
            } else {
                echo "<script>alert('Solo se permiten nombres con letras,numeros,guiones \'-\' , guiones bajos \'_\' ó arrobas \'@\' , minimo 5 carácteres')</script>";
            }
        }

        $location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <script>
            window.location.replace("<?php echo $location; ?>");
        </script> 
        <?php
    }

    function resumir($texto, $enlace) {
        $resumido = '';

        if (strlen($texto) >= 998) {
            for ($i = 0; $i <= 998; $i++) {

                $resumido .=$texto[$i];

                if (strlen($resumido) == 999) {
                    $resumido .= $enlace;
                }
            }
        } else {
            for ($i = 0; $i < strlen($texto); $i++) {
                $resumido .= $texto[$i];
                if ($i == strlen($texto) - 7) {
                    $resumido .= $enlace;
                }
            }
        }
        return $resumido;
    }

    function resumir_meta($texto) {
        $resumido = '';

        $texto = htmlspecialchars(stripslashes(strip_tags(trim($texto))));
        if (strlen($texto) >= 199) {

            for ($i=0; $i<=199; $i++) {
                
                if ($texto[$i]=="&" && $i>=192) {
                    break;
                }
                if ($texto[$i] == '"' || $texto[$i] == "'" || $texto[$i] == "<" || $texto[$i] == ">") {
                    $texto[$i] = "";
                }
                $resumido .=$texto[$i];
                
                if (strlen($resumido) == 200) {
                    break;
                }
            }
        } else {
            for ($i = 0; $i < strlen($texto); $i++) {
                if ($texto[$i] == '"' || $texto[$i] == "'" || $texto[$i] == "<" || $texto[$i] == ">") {
                    $texto[$i] = "";
                }
                if ($i==strlen($texto)&&$texto[$i]=="&") {
                    break;
                }
                $resumido .= $texto[$i];
                
            }
        }

        return $resumido;
    }

    function categorias() {

        $model = $this->loadModel('Model');
        $menu_model = $model->menu();
        require 'application/views/_templates/categorias.php';
    }

    function crear_categorias() {

        $categoria = $this->loadModel('Categoria');
        $nombre = $_REQUEST ['categoria'];
        $patron = "/^[[:alnum:] -_áéíóú]{1,150}+$/i";
// compruebo que solo se envian car�cteres alfanumericos
        if (preg_match($patron, $nombre)) {

            if ($categoria->crear_categorias($nombre)) {


                echo " Categoria $nombre creada correctamente <br/>
			
			";
            } else {
                echo "Error al insertar la nueva categoria en la base de datos";
                echo " <br/>";
            }
        } else {
            echo "Debe introducir letras, numeros, guiones y guiones bajos solamente.";
        }
        $location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        ?>
        <script>
            window.location.replace("<?php echo $location; ?>");
        </script> 
        <?php
    }

    function desactivar_categoria() {

        $idcat = $_REQUEST ['categ'];
        $categoria = $this->loadModel('Categoria');
// compruebo que solo se envian carácteres alfanumericos


        if ($categoria->desactivar_categoria($idcat)) {

            echo " Categoria desactivada correctamente <br/>	
			";
        } else {
            echo "Error al desactivar la categoria en la base de datos";
            echo " <br/>";
        }
    }

    function activar_categoria() {

        $idcat = $_REQUEST ['categ-ac'];
        $categoria = $this->loadModel('Categoria');
// compruebo que solo se envian carácteres alfanumericos


        if ($categoria->activar_categoria($idcat)) {

            echo " Categoria activada correctamente <br/>";
        } else {
            echo "Error al activar la categoria en la base de datos";
            echo " <br/>";
        }
    }

    function ver_paginas() {
        require 'application/views/_templates/ver_paginas.php';
    }

    function administrar_articulos() {

        $administrar_articulos = $this->loadModel('Model');
        $result = $administrar_articulos->administrar_articulos();
        return $result;
    }

    function modificar_pagina() {
        $model = $this->loadModel('Model');
        $menu_model = $model->menu();
        require 'application/views/_templates/modificar_pagina.php';
    }

    function modificar($model) {
        $nombre = $_SESSION['nombre'];
        $id = $_REQUEST ['id2'];
        $titulo = $_REQUEST ['titulo'];
        $mensaje = $_REQUEST ['mensaje'];
        $categoria = $_REQUEST ['categ'];
        $narticulo = '';
        for ($n = 0; $n < strlen($mensaje); $n++) {
            if ($mensaje[$n] == "'" || $mensaje[$n] == '"') {
                $narticulo .= "\\" . $mensaje[$n];
            } else {
                $narticulo .= $mensaje[$n];
            }
        }
        $usuario = $_SESSION ['nombre'];
        $consulta = $model->modificar($id, $titulo, $categoria, $narticulo, $nombre);
        if ($consulta) {
            echo " Articulo $titulo Modificado correctamente <br/>
				<a href='admin'>Volver al area de administración</a><br/>
				<a href='ver_paginas'>Ver más páginas</a>
					";
        } else {
            echo "No se han podido modificar los datos de la entrada";
        }
    }

    function admin_nueva_pagina() {
        $model = $this->loadModel('Model');
        $menu_model = $model->menu();
        require 'application/views/_templates/admin_nueva_pagina.php';
    }

    function nueva() {
        $model = $this->loadModel('Nueva_pagina');
        $titulo = $_REQUEST ['titulo'];
        $articulo = $_REQUEST ['articulo'];
        $categoria = $_REQUEST ['categ'];
        $narticulo = '';
        for ($n = 0; $n < strlen($articulo); $n++) {
            if ($articulo[$n] == "'" || $articulo[$n] == '"') {
                $narticulo .= "\\" . $articulo[$n];
            } else {
                $narticulo .= $articulo[$n];
            }
        }
        $usuario = $_SESSION ['nombre'];
        if ($model->nueva($titulo, $categoria, $narticulo, $usuario)) {

            echo " Articulo $titulo creado correctamente <br/>
		<a href='admin'>Volver al area de administración</a><br/>
		<a href='admin_nueva_pagina'>Crear otro artículo</a>
					";
        } else {
            echo "No se han podido guardar los datos de la nueva página";
        }
    }

    function admin_usuarios() {
        require 'application/views/_templates/admin_usuarios.php';
    }

    function nuevo_usuario() {
        $patron = "/^[[:alnum:]]{1,150}+$/i";
        $usuario = $_REQUEST ['usuario'];
        $nombre = $_REQUEST ['nombre'];
        $mail = $_REQUEST ['mail'];
// compruebo que solo se envian carácteres alfanumericos

        if (preg_match($patron, $usuario)) {
            $pass = $_REQUEST ['pass'];
            $tipo = 'admin';

            $pass = crypt($pass, '$2a$07$ideaalziraweb$');

            $user = '';
            $model = $this->loadModel('Model');

            $result = $model->usuario_existe($usuario);

            foreach ($result as $valor) {

                if ($usuario == $valor->login) {
                    $user = $valor->login;
                }
            }
            if ($user == $usuario) {
                echo "El usuario $user existe! ";
            } else {
                if ($model->nuevo_usuario($usuario, $pass, $nombre, $mail)) {
                    echo " Usuario $user creado correctamente <br/>			
					";
                } else {
                    echo "Fallo al guardar el nuevo usuario";
                }
            }
        } else {
            echo "Debe introducir letras y numeros solamente .";
        }
    }

    function modificar_usuario() {

        $patron = "/^[[:alnum:]]{1,150}+$/i";
        $usuario = $_REQUEST ['musuario'];

// compruebo que solo se envian carácteres alfanumericos

        if (preg_match($patron, $usuario)) {
            $pass = $_REQUEST ['mpass'];
            $tipo = 'admin';

            $pass = crypt($pass, '$2a$07$ideaalziraweb$');

            $user = '';
            $model = $this->loadModel('Model');
            if ($model->modificar_usuario($usuario, $pass)) {
                echo " Usuario $user modificado correctamente <br/>			
					";
//<a href='admin'>Volver al area de administración</a><br/>
//<a href='admin_usuarios'>Crear otro usuario</a>
            } else {
                echo "Fallo al modificar el nuevo usuario";
            }
        } else {
            echo "Debe introducir letras y numeros solamente .";
        }
    }

    function ver_usuarios() {
        $model = $this->loadModel('Model');
        $result = $model->ver_usuarios();
        print "<table style='text-align:center;'><tr ><th>Nombre</th><th >Email</th></tr>";
        foreach ($result as $valor) {
            $user = $valor->login;
            $email = $valor->email;
            print "<tr><td> $user </td><td> $email </td></tr>";
        }
        echo "</table>";
    }

    function paginar($todos_articulos, $activas) {
        $j = 0;

        foreach ($todos_articulos as $listar) {
            for ($n = 0; $n < count($activas); $n++) {

                if (isset($listar->idcat) && $listar->idcat == $activas[$n]) {
                    $idcat [$j] = $listar->idcat;

                    if (isset($listar->id_entrada))
                        $idn [$j] = $listar->id_entrada;

                    if (isset($listar->titulo))
                        $titu [$j] = $listar->titulo;

                    if (isset($listar->mensaje))
                        $arti [$j] = $listar->mensaje;

                    if (isset($listar->login))
                        $usu [$j] = $listar->login;

                    $j ++;
                }
            }
        }

//divido el total entre el numero de entradas por pagina y me da las paginas

        $npaginas = 1;
        $entradas = 1;
//contador de entradas comun para todas las paginas
//antes de terminar el bucle cuenta una mas por lo que hay que quitarla
        $i = $j - 1;
        if ($j > 0) {
            echo "<div id='paginar' class='demo'>";

//cuento las entradas que imprimo
            while ($i >= 0) {

                if ($entradas == 1 && $npaginas == 1) {
                    echo "<div id='p$npaginas' class='pagedemo _current' style=''>";
                }
                if ($entradas == 1 && $npaginas > 1) {
                    echo "<div id='p$npaginas' class='pagedemo' style='display:none;'>";
                }
                $url = URL;
                $url.="home/entrada/$idn[$i]";
                $enlaces["url"][] = $url;
                $enlaces["titulo"][] = $titu[$i];
                $enlaces["mensaje"][] = Home::resumir_meta($arti[$i]);
                $enlace = "<a href='$url'> (Leer mas).</a>";
                $mensaje = Home::resumir($arti[$i], $enlace);
                ?><article><a href="<?php echo URL; ?>home/entrada/<?php echo $idn[$i]; ?>"><h3><?php echo $titu[$i]; ?></h3></a>
                    <?php
                    echo "$mensaje";

                    echo " </article><br/>";

                    if ($entradas == 10 || $i <= 0) {
                        if ($i != 0) {
                            $npaginas++;
                        }

                        echo "</div>";
                    }
                    if ($entradas == 10) {
                        $entradas = 1;
                    } else {
                        $entradas++;
                    }
                    $i--;
                }
                if (isset($_SESSION['nombre']) && $_SESSION['admin'] == 'si') {
                    Home::sitemap($enlaces, $activas);
                    Home::rss($enlaces);
                }
                echo "</div>";
                ?>
                <script type="text/javascript">
                    $(function() {
                        $("#pages").paginate({
                            count: <?php echo $npaginas; ?>,
                            start: 1,
                            display: 15,
                            border: false,
                            text_color: '#888',
                            background_color: '#EEE',
                            text_hover_color: 'black',
                            background_hover_color: '#CFCFCF',
                            onChange: function(page) {
                                $('._current', '#paginar').removeClass('_current').hide();
                                $('#p' + page).addClass('_current').show();
                            }
                        });
                    });
                </script>
                <?php
            }
        }

        function paginar_admin($todos_articulos) {
            $j = 1;
            foreach ($todos_articulos as $listar) {

                if (isset($listar->id_entrada)) {
                    $idn [$j] = $listar->id_entrada;

                    if (isset($listar->titulo))
                        $titu [$j] = $listar->titulo;

                    if (isset($listar->mensaje))
                        $arti [$j] = $listar->mensaje;

                    if (isset($listar->login))
                        $usu [$j] = $listar->login;

                    if (isset($listar->idcat))
                        $idcat [$j] = $listar->idcat;

                    $j ++;
                }
            }

            $npaginas = 1;
            $entradas = 1;
            //contador de entradas comun para todas las paginas
            //j aumenta una ultima vez antes de salir por lo que resto 1
            $i = $j - 1;

            echo "<div id='paginar' class='demo'>";
            if ($j > 1) {
                //cuento las entradas que imprimo
                while ($i >= 1) {

                    if ($entradas == 1 && $npaginas == 1) {
                        echo "<div id='p$npaginas' class='pagedemo _current' style=''>";
                    }
                    if ($entradas == 1 && $npaginas > 1) {
                        echo "<div id='p$npaginas' class='pagedemo' style='display:none;'>";
                    }

                    $url = URL;
                    $url.="home/entrada/$idn[$i]";
                    $enlace = "<a href='$url'><p>(Leer mas)</p></a>";
                    $menfull = $arti [$i];
                    $mensaje = Home::resumir($arti[$i], $enlace);

                    //muestro cada articulo en una columna con su titulo y cuerpo del mensaje 

                    echo "<table width='100%' height='200px' style='table-layout:fixed;overflow:hidden;'><tr width='100%'>"
                    . "<td style='width:30%;height:50px;text-align:center;'><a href='$url' >$titu[$i]</a></td>";


                    echo "<td width='20%' height='50px' style='text-align:center;'>"
                    . "<form name='modificar'  action='";
                    echo URL;
                    print "home/modificar_pagina' method='post' style='text-align:center;'>"
                            . "<input  type='hidden' name='idmodi' value='$idn[$i]' />"
                            . " <input  type='hidden' name='tmodi' value='$titu[$i]' />"
                            . " <input  type='hidden' name='menmodi' value='$menfull' />"
                            . " <input type='submit' name='modi' value='Modificar' /></form>"
                            . "</td>";

                    echo "<td height='200px' style='width:49%;text-align:center;50px;text-align:center;overflow:hidden;'>$mensaje</td></tr></table>";


                    if ($entradas == 10 && $npaginas == 1 || $entradas == 10 && $npaginas > 1) {
                        echo " ";
                    }

                    if ($entradas == 10 || $i <= 0) {
                        if ($i != 0) {
                            $npaginas++;
                        }
                        echo "</div>";
                    }
                    //reinicio el contador de entradas para que me vuelva a cerrar el div a las 10
                    if ($entradas == 10) {
                        $entradas = 1;
                    } else {
                        $entradas++;
                    }
                    $i--;
                }
                echo "</div>";
                ?>
                <script type="text/javascript">
                    $(function() {
                        $("#pages").paginate({
                            count: <?php echo $npaginas; ?>,
                            start: 1,
                            display: 15,
                            border: false,
                            text_color: '#888',
                            background_color: '#EEE',
                            text_hover_color: 'black',
                            background_hover_color: '#CFCFCF',
                            onChange: function(page) {
                                $('._current', '#paginar').removeClass('_current').hide();
                                $('#p' + page).addClass('_current').show();
                            }
                        });
                    });
                </script>
                <?php
            }
        }

        function mostrar_comentarios($comentarios, $model) {

            $n = 0;
            $npaginas = 1;
            $idrespuesta = 0;
            $j = 1;
            foreach ($comentarios as $valor) {
                $idc[$j] = $valor->idcom; //$valor ['idcom'];
                $ide[$j] = $valor->id_entrada;
                $padre[$j] = $valor->padre; //$valor ['padre'];
                $nombre[$j] = $valor->nombre;
                $comentario[$j] = $valor->comentario;
                //la ultima la cuenta antes de salir (tomarlo en cuenta)
                $j++;
            }
            //j se incrementa una ultima vez antes de salir por lo que hay que quitarle uno.
            for ($m = $j - 1; $m >= 1; $m--) {
                //si no es padre puede pasar por aqui otra vez sin aumentar por lo que empezaria el div 2 veces
                if ($npaginas == 1 && $n == 0 && $padre[$m] == NULL) {
                    echo "<div id='p$npaginas' class='pagedemo _current' style=''>";
                } else if ($npaginas > 1 && $n == 1 && $padre[$m] == NULL) {
                    echo "<div id='p$npaginas' class='pagedemo' style='display:none;'>";
                }

                if ($padre[$m] == NULL) {

                    echo "<br/><div style=' border-style: solid; border-color:orange;padding:1%;display:block;' id='$idc[$m]'>";
                    echo $nombre[$m];
                    echo "<br/>";
                    echo $comentario[$m];
                    echo "<br/>";

                    //borrar y responder para el comentario padre
                    if (isset($_SESSION['nombre']) && $_SESSION['admin'] == 'si') {
                        echo "<br/>";
                        print "<form name='moderar' action='' method='POST'>"
                                . "<input type='button' name='responder' value='responder' onClick='response($idc[$m]);' />"
                                . "<input type='submit' name='borrar' value='borrar' />"
                                . "<input type='hidden' name='nentrada' value='$ide[$m]' />"
                                . "<input type='hidden' name='id' value='$idc[$m]' />"
                                . "</form>";
                    } else if (isset($_SESSION['nombre']) && $_SESSION['admin'] == 'no') {
                        echo "<br/>";
                        print "<form name='moderar' action='' method='POST'>"
                                . "<input type='button' name='responder' value='responder' onClick='response($idc[$m]);' />"
                                . "<input type='hidden' name='nentrada' value='$ide[$m]' />"
                                . "<input type='hidden' name='id' value='$idc[$m]' />"
                                . "</form>";
                    } else {
                        print "<form name='moderar' action='' method='POST'>"
                                . "<input type='button' name='responder' value='responder' onClick='response($idc[$m]);' />"
                                . "<input type='hidden' name='nentrada' value='$ide[$m]' />"
                                . "<input type='hidden' name='id' value='$idc[$m]' />"
                                . "</form>";
                    }
                    echo "</div>";
                    //cuento solo los comentarios principales
                    $n++;
                }

                if ($padre[$m] >= 0) {

                    //SI el padre no es null significa que es una respuesta

                    $respuestas = Home::cargar_respuestas($idc[$m], $model);
                    $nrespuestas = count($respuestas);
                    //si hay respuestas pongo el botón si no, no
                    if ($nrespuestas > 0) {
                        echo"<button onclick='mostrar_respuestas($idrespuesta)' style='margin-left:5%;'>Mostrar respuestas ($nrespuestas)</button>";
                        echo "<section id='respuestas$idrespuesta' style='display:none;'>";
                    }
                    foreach ($respuestas as $valor2) {

                        $padre2 = $valor2->padre;
                        $idc2 = $valor2->idcom;
                        echo"<br/><div style='margin-left: 5%; border-style: solid; border-color:orange;padding:1%;background:#EFEFE8;' id='$idc2'>";

                        $usuario2 = $valor2->nombre;
                        echo"$usuario2";
                        echo"<br/>";
                        $comentario2 = $valor2->comentario;
                        echo"$comentario2";
                        echo"<br/>";
                        //borrar y responder para las respuestas,llama a js para poner el textarea    
                        if (isset($_SESSION['nombre']) && $_SESSION['admin'] == 'si') {
                            print "<form name='moderar' action='' method='POST'>"
                                    . "<input type='submit' name='borrar' value='borrar' />"
                                    . "<input type='button' name='responder' value='responder' onClick='response($idc[$m],$idc2,$ide[$m]);'/>"
                                    . "<input type='hidden' name='rname' value='$usuario2' />"
                                    . "<input type='hidden' name='nentrada' value='$ide[$m]' />"
                                    . "<input type='hidden' name='id' value='$idc2' />"
                                    . "</form>";
                        } else if (isset($_SESSION['nombre']) && $_SESSION ["admin"] == 'no') {
                            print "<form name='moderar' action='' method='POST'>"
                                    . "<input type='button' name='responder' value='responder' onClick='response($idc[$m],$idc2,$ide[$m]);'/>"
                                    . "<input type='hidden' name='rname' value='$usuario2' />"
                                    . "<input type='hidden' name='id' value='$idc2' />"
                                    . "</form>";
                        } else {
                            print "<form name='moderar' action='' method='POST'>"
                                    . "<input type='button' name='responder' value='responder' onClick='response($idc[$m],$idc2,$ide[$m]);' />"
                                    . "<input type='hidden' name='rname' value='$usuario2' />"
                                    . "<input type='hidden' name='id' value='$idc2' />"
                                    . "</form>";
                        }
                        //fin cuadro respuesta individual
                        echo "</div>";
                    }
                    //cierro el cuadro oculto de respuestas
                    if ($nrespuestas > 0) {
                        echo '</section>';
                    }
                    //fin respuestas
                }

                //cerrar cuadro de página actual
                if ($n >= 10 && $m > 1) {
                    echo "</div>";
                    $n = 1;
                    if ($m > 1) {
                        $npaginas++;
                    }
                }
                //si $n no llega al maximo pero se acaban las entradas cierro el cuadro     
                else if ($m == 1) {
                    echo "</div>";
                    $n = 1;
                    break;
                    //si me pone una página mas antes de salir luego tendre una página en blanco
                    if ($m > 1) {
                        $npaginas++;
                    }
                }

                $idrespuesta++;
            }
            ?>
            <script type="text/javascript">

                $(function() {
                    $("#pages").paginate({
                        count:<?php echo $npaginas; ?>,
                        start: 1,
                        display: 15,
                        border: false,
                        text_color: '#888',
                        background_color: '#EEE',
                        text_hover_color: 'black',
                        background_hover_color: '#CFCFCF',
                        onChange: function(page) {
                            $('._current', '#paginar').removeClass('_current').hide();
                            $('#p' + page).addClass('_current').show();
                        }
                    });
                });
            </script>   
            <?php
        }

        function sitemap($link, $activas) {

            $url = URL;
            //poner páginas estaticas aqui
            $link["url"][] = $url . "contacto/";
            $link["url"][] = $url . "llegar/";
            $link["url"][] = $url . "sitemap.xml";
            $link["url"][] = $url . "rss.xml";
            //fin páginas estaticas
            $url .="home/seccion/";
            //todas las categorias activas
            foreach ($activas as $valor) {
                $link["url"][] = "$url$valor";
            }

            //página de inicio
            $link["url"][] = URL;
            $link["url"] = array_values(array_unique($link["url"])); // Eliminar duplicados
            $dt = date('Y-m-d\TH:i:s') . '+00:00';
            $file = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset
                  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                  http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
            ';
            //todas las entradas activas
            foreach ($link["url"] as $k => $url) {
                $priority = ($k < 1) ? "1.0" : "0.8";
                $file .= "<url>
                <loc>$url</loc>
                <priority>$priority</priority>
                <lastmod>$dt</lastmod>
                <changefreq>daily</changefreq>
            </url>
            ";
            }
            $file .= "</urlset>";
            file_put_contents('sitemap.xml', $file); // crear fichero
        }

        function rss($link) {
            $dt = date('Y-m-d\TH:i:s') . '+00:00';
            $rss = "<?xml version='1.0' encoding='UTF-8' ?>
                <rss version='2.0'><channel>"
                    . "<title>Idea Alzira RSS</title>
                <link>http://www.idea-alzira.com/</link>
                <description>Entradas RSS de Idea Alzira</description>
                <language>es</language>
                <copyright>Copyright (C) 2009 idea-alzira.com</copyright>";

            for ($n = 0; $n < count($link["url"]); $n++) {
                $titulo = $link['titulo'][$n];
                $enlace = $link['url'][$n];
                $mensaje = $link['mensaje'][$n];
                $rss.= "<item>
                        <title>$titulo</title>
                        <description>$mensaje </description>
                        <link>$enlace</link>
                        <pubDate>$dt</pubDate>
                        </item>
                        ";
            }
            $rss .="</channel></rss>";
            file_put_contents('rss.xml', $rss);
        }

    }
    