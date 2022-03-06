<?php
if (!session_start()) {
    session_start();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <head>
        <meta charset="UTF-8">
        <script src="<?php echo URL; ?>/public/js/modernizr.custom.47088.js"></script>
        <script src="<?php echo URL; ?>/public/js/jquery-1.11.0.js" type="text/javascript" ></script>
        <script src="<?php echo URL; ?>/public/js/google.js"></script>
        <link rel="shortcut icon" type="image/ico" href="<?php echo URL; ?>/public/img/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/styles.css">
        <meta name="viewport" content="width=device-width">
        <title>Administrar usuarios</title>
    </head>

    <body>
        <div id="todo">
            <div id="todomovil">  

                <?php
                $tipo = "";

                if (isset($_SESSION ["nombre"]) && isset($_SESSION ["pass"]) && $_SESSION ["admin"] == 'si') {
                    $nombre = $_SESSION ['nombre'];
                    // seccion de c�digo para destruir session y volver al index
                    print " <div id='derecha'>
						 <h3>Usted a iniciado sesión como $nombre </h3>
						<form name='salida' action='' method='post'>
						<input type='submit' name='salir' value='salir' />
						</form>
						
						";

                    if (isset($_REQUEST ['salir'])) {
                        session_destroy();
                        $url = URL;
                        header('Location: ' . $url);
                    }
                    include 'menus.php';
                    echo "</div><div id='izq'><h1>Administrar usuarios</h1>";
                    // compruebo que se envian datos
                    if (isset($_REQUEST ['usuario']) && isset($_REQUEST ['pass'])) {
                        Home::nuevo_usuario();
                    }

                    $creada2 = " ";


                    if (isset($_REQUEST ['musuario']) && isset($_REQUEST ['mpass'])) {
                        Home::modificar_usuario();
                    }
                    ?>
                    <h3>Crear Usuario</h3>
                    <form action='' method='post' name='alta'>
                        <br/>
                        Nombre usuario<br />
                        <input type='text' name='usuario' maxlength="20" /><br />
                        Contraseña<br />
                        <input type='text' name='pass' maxlength="20"  /><br /> 
                        <input type='hidden'  name='tipo' value='admin' checked>
                        Nombre<br />
                        <input type='text' name='nombre' maxlength="40"
                               /><br />
                        email<br />
                        <input type='text' name='mail' maxlength="50" /><br />
                        <input type='submit' name='envio1'value='Dar de alta'> <br />
                    </form>
                    <h3>Cambiar contraseña a usuario</h3>
                    <form action='' method='post' name='alta'>
                        <br/>
                        Nombre usuario a modificar<br />
                        <input type='text' name='musuario' maxlength="20" /><br />
                        Contraseña nueva<br />
                        <input type='text' name='mpass' maxlength="20"  /><br />                 
                        <input type='submit' name='envio2'value='Modificar contraseña'> <br />
                    </form>
                    <h3>Consultar usuarios </h3>
                    <form action='' method='post'
                          name='consulta'>
                        <input type='text' name='consultar' maxlength="10"
                               Value='Consultar usuarios' /> <input type='submit' name='envio3'
                               value='consulta'>
                    </form>
                    <?php
                    if (isset($_REQUEST ['consultar'])) {

                        Home::ver_usuarios();
                    }
                    ?>
                </div>								
                <?php
            } else {
                $url = URL;
                header('Location: ' . $url);
            }
            ?>
        </div>
    </div>
</body>
</html>