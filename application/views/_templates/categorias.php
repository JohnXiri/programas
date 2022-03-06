<?php
if (!session_start()) {
    session_start();
} 

if (isset($_SESSION ["nombre"]) && isset($_SESSION ["pass"]) && $_SESSION ["admin"] == 'si') {
    $nombre = $_SESSION ["nombre"];
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
    <html>
        <head>
            <meta charset="UTF-8">
            <script src="<?php echo URL; ?>/public/js/modernizr.custom.47088.js"></script>
            <script src="<?php echo URL; ?>/public/js/jquery-1.11.0.js" type="text/javascript" ></script>
            <script src="<?php echo URL; ?>/public/js/google.js"></script>
            <link rel="shortcut icon" type="image/ico" href="./favicon.ico" />
            <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/styles.css">
            <meta name="viewport" content="width=device-width">
            <title>Categorías</title>
        </head>

        <body>
            <div id="todo">
                <?php
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
                echo "</div><div id='izq'><h1>Gestor de Categorías</h1>";
                // compruebo que se envian datos
                if (isset($_REQUEST ['categoria'])) {
                    Home::crear_categorias();
                }
                if (isset($_REQUEST ['desactivar']) ) {
                    if (isset($_REQUEST ['desactivar'])){
                    Home::desactivar_categoria();
                    } 
                } 
                else if (isset($_REQUEST ['activar'])){
                    Home::activar_categoria();
                }
                else {
                    print" <h2>Nueva Categoría</h2>
							<form action='' method='post' name='alta'>
							<br><input type='text' name='categoria'
							maxlength='40'/><br /> <input type='submit' name='envio1'
							value='Crear'> <br />
							</form>
                                                        <h2>Desactivar Categoria</h2>
							<form action='' method='post' name='baja'>
							<br><form action='' method='post' name='alta'><select name='categ'>";
                    foreach ($menu_model as $valor) {
                        if ($valor->activo == 'si') {
                            $cat = $valor->nombre;
                            $id = $valor->idcat;
                            echo "<option  value='$id'>$cat</option>";
                        }
                    }

                    print "</select>   <input type='submit' name='desactivar' value='Desactivar'> <br />
							</form>
							";
                    print" <h2>Activar Categoria</h2>
		<form action='' method='post' name='baja'>
		<br><form action='' method='post' name='alta'><select name='categ-ac'>";
                    foreach ($menu_model as $valor) {
                        if ($valor->activo == 'no') {
                            $cat = $valor->nombre;
                            $id = $valor->idcat;
                            echo "<option  value='$id'>$cat</option>";
                        }
                    }
                    print "</select>   <input type='submit' name='activar' value='Activar'> <br />
							</form>
							";
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

</body>

</html>