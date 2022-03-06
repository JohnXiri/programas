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
        <link rel="shortcut icon" type="image/ico" href="<?php echo URL; ?>/public/img/favicon.ico" />
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/styles.css">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/jPaginate/css/style.css" media="screen"/>

        <title>Administrar entradas</title>  


    </head>
    <body>
        <div id="todo">
            <div id="todomovil"> 
                <?php
                if (isset($_SESSION ["nombre"]) && isset($_SESSION ["pass"]) && $_SESSION ["admin"] == 'si') {

                    $nombre = $_SESSION ["nombre"];
                    // La Zona derecha se repite en todas las p�ginas para mostrar el menu y la opci�n de log off

                    print " <div id='derecha'>
                    <h3>Usted a iniciado sesión como $nombre </h3>
                    <form name='salida' action='' method='post'>
                    <input type='submit' name='salir' value='salir' />
                    </form><br/>
                    
                    ";
                    
                    include 'menus.php';
                    ?> 
                </div>
                <div id='izq'>

                    <table  width='100%' ><tr id="trverpaginas" >
                        <tr>
                            <th width='30%'>Titulo</td>
                            <th width='20%'>Modificar</td>
                            <th width='49%'>Mensaje</td>
                        </tr>
                    </table>
                    <?php
                    $result = Home::administrar_articulos();
   
                    Home::paginar_admin($result);
                    ?>
                    
                    <br/>   
                    <div id="pages" >                   
                    </div>
                </div>
                <br/>
    <?php
} else {
    header('Location: home');
}
?>
            <script src="<?php echo URL; ?>public/jPaginate/jquery.paginate.js" type="text/javascript"></script>
        </div>       
    </div>
</body>
</html>