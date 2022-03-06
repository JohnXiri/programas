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
        <title>Nueva pagina</title>

        <script src="<?php echo URL; ?>/ckeditor/ckeditor.js"></script>

    </head>

    <body>
        <div id="todo">
            <div id="todomovil">  


                <?php
                if (isset($_SESSION ["nombre"]) && isset($_SESSION ["pass"]) && $_SESSION ["admin"] == 'si') {
                    $nombre = $_SESSION ['nombre'];
                    // seccion de codigo para destruir session y volver al index
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
                    $creada = "";
                    echo "</div><div id='izq'><h1>Crear nueva página</h1>";

                    // Aqu� a�adimos los nuevos articulos.
                    if (isset($_REQUEST ['titulo']) && isset($_REQUEST ['articulo'])) {
                        Home::nueva();
                    } else {
                        echo "Seleccionar categoría:<br/><br/><form action='' method='post' name='alta'><select name='categ'>";

                        foreach ($menu_model as $valor) {

                            $cat = $valor->nombre;
                            echo "<option  value='$valor->idcat'>$cat</option>";
                        }

                        print "</select><br/><br/>
			Título<br/><br/><input type='text' name='titulo' maxlength='90' size='80' /><br/><br/>			
			Mensaje<br/><br/>
                        
                        <textarea id='articulo' name='articulo' rows='8' cols='80'></textarea>
			<br /> <input type='submit' name='envio' value='Enviar Nueva pagina'> <br />
                        
                <script>
                
                CKEDITOR.replace('articulo', {
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
    </div>
</body>

</html>