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
        <link rel="shortcut icon" type="image/ico" href="./favicon.ico" />
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/styles.css">
        <meta name="viewport" content="width=device-width">
        <title>Modificar pagina</title>

        <script src="<?php echo URL; ?>/ckeditor/ckeditor.js"></script>

    </head>

    <body>
        <div id="todo">
            <?php
            if (isset($_SESSION ["nombre"]) && isset($_SESSION ["pass"]) && $_SESSION ["admin"] == 'si') {
                $nombre = $_SESSION ['nombre'];
                // seccion de código para destruir session y volver al index
                print "<div id='derecha'>
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

                echo "</div><div id='izq'><h1>Modificar página</h1>";

                // Aqu� añadimos los nuevos articulos.
                if (isset($_REQUEST ['titulo']) && isset($_REQUEST ['mensaje']) && isset($_REQUEST ['envio'])) {
                    Home::modificar($model);
                }
                if (isset($_REQUEST ['modi'])) {
                    $id = $_REQUEST ['idmodi'];
                    $titulo = $_REQUEST ['tmodi'];
                    $mensaje = $_REQUEST ['menmodi'];

                    echo "Seleccionar categoría:<br/><form action='' method='post' name='alta'><select name='categ'>";

                    foreach ($menu_model as $valor) {
                        if ($valor->activo == 'si') {
                            $cat = $valor->nombre;
                            $idcat = $valor->idcat;
                            echo "<option  value='$idcat'>$cat</option>";
                        }
                    }

                    print "	</select><br/>
			Título<br/><input type='text' name='titulo' maxlength='90' size='80' value='$titulo' /><br />			
			Mensaje<br/>
                        <input  type='hidden' name='id2' value='$id' />
                        <textarea  name='mensaje' rows='8' cols='80'>$mensaje</textarea>
			<br /> <input type='submit' name='envio' value='Modificar pagina'> <br />
                        
                <script>
                
                CKEDITOR.replace('mensaje', {
                //filebrowserBrowseUrl: '//kcfinder/upload/',
            }); 
                 </script>
			</form>
                        ";
                }
            } else {
                $url = URL;
                header('Location: ' . $url);
            }
            ?>

        </div>
    </div>
</body>

</html>