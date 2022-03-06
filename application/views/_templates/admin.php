<?php
if (!session_start()) {
    session_start();
}
if (isset($_SESSION ["nombre"]) && isset($_SESSION ["pass"]) && $_SESSION ["admin"] == 'si') {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

    <html>
        <head>
            <meta charset="UTF-8">
            <script src="<?php echo URL; ?>/public/js/modernizr.custom.47088.js"></script>
            <link rel="shortcut icon" type="image/ico" href="./favicon.ico" />
            <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/styles.css">
            <title>Idea Alzira Administración</title>
        </head>
        <body>
            <div id="todo">
                <div id="todomovil">  

                    <?php
                    $nombre = $_SESSION ['nombre'];
                    // Area de administraci�n con enlaces a diversas funcionalidades de administrador

                    print " <div id='derecha'>
			<h3>Usted a iniciado sesión como $nombre </h3> 
			<form name='salida' action='' method='post'>
			<input type='submit' name='salir' value='salir' />
			</form>
			";
                    include 'menus.php';
                    $url = URL;
                    $cate = $url . "home/categorias/";
                    $users = $url . "home/admin_usuarios/";
                    $nueva = $url . "home/admin_nueva_pagina/";
                    $entrada = $url . "home/ver_paginas/";
                    print "</div>

			<div id='izq'>
                        
			<h2>Bienvenido $nombre, seleccione una acción:</h2>
			<br/>
                        <h3>Administrar página:</h3>
			<a href='$cate'>Categorias</a>
			<br/>
                        <a href='$nueva'>Nuevo articulo</a>
			<br/>
                        <a href='$entrada'>Administrar entradas</a>
                        <br/>
                        <h3>Gestión de usuarios:</h3>
                        <a href='$users'>Administrar Usuarios</a>
			<br/>
			</div>
			";
                    if (isset($_REQUEST ['salir'])) {
                        session_destroy();
                        $url = URL;
                        header('Location: ' . $url);
                    }
                    ?>

                </div>
            </div>
        </body>
    </html>
    <?php
} else {
    $url = URL;
    header('Location: ' . $url);
}
