<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" type="image/ico" href="./favicon.ico" />
        <link rel="stylesheet" type="text/css" href="./css/styles.css">


    </head>
    <body>
        <?php
//La carpeta install debe ir en la carpeta raiz
//configurar antes las conexiones de la BDD en application/config/config.php       
        require '../application/config/config.php';

            function instalador() {
                try {
                    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

                    // generate a database connection, using the PDO connector
                    // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                    $db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
                    
                } catch (PDOException $e) {
                    //cabecera ( 'Error grave', MENU_PRINCIPAL );
                    print "<p>Error: No puede conectarse con la base de datos.</p>\n";
                    print "<p>Error: " . $e->getMessage() . "</p>\n";
                    pie();
                    exit();
                }

                $usuario = $_REQUEST ['usuario'];
                $nombre = $_REQUEST ['nombre'];
                $mail = $_REQUEST ['mail'];
                $pass = $_REQUEST ['pass'];
                $patron = "/^[[:alnum:]]{1,150}+$/i";

                if (preg_match($patron, $usuario) && preg_match($patron, $pass)) {

                    $db->query("CREATE DATABASE ideaf
		DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;		
		");
                    
 //introducir las lineas comentadas de abajo antes de "Create table usuario"
 // si se necesitan eliminar tablas antes
                    /*
                      drop table IF EXISTS comentario;
                      drop table IF EXISTS entrada;
                      drop table IF EXISTS categoria;
                      drop table IF EXISTS usuario;
                     */
                    $db->query("
                    Create table usuario (
                            login Varchar(20) NOT NULL,
                            password Varchar(60) NOT NULL,
                            admin Char(2) NOT NULL,
                            nombre Char(20) NOT NULL,
                            email Varchar(30),
                            id_nombre Int NOT NULL AUTO_INCREMENT,
                            UNIQUE (login),
                            UNIQUE (id_nombre),
                     Primary Key (id_nombre)) ;

                    Create table categoria (
                            idcat Int NOT NULL AUTO_INCREMENT,
                            nombre Varchar(20) NOT NULL,
                            activo Char(2) NOT NULL,
                     Primary Key (idcat)) ;

                    Create table entrada (
                            id_entrada Int NOT NULL AUTO_INCREMENT,
                            titulo Varchar(255) NOT NULL,
                            mensaje Text,
                            idcat Int NOT NULL,
                            login Varchar(20) NOT NULL,
                            UNIQUE (id_entrada),
                     Primary Key (id_entrada)) ;

                    Create table comentario (
                            idcom Int NOT NULL AUTO_INCREMENT,
                            comentario Varchar(255) NOT NULL,
                            nombre Varchar(20),
                            email Varchar(20),
                            padre Int,
                            id_entrada Int NOT NULL,
                            UNIQUE (idcom),
                     Primary Key (idcom)) ;

                    ");

                    $pass = crypt($pass, '$2a$07$ideaalziraweb$');

                    $db->query("INSERT into usuario (login,password,admin,nombre,email) VALUES ('$usuario','$pass','si','$nombre','$mail') ");

                    print "<p style='color:green';>Base de datos creada correctamente, puede borrar el directorio \"install\" para mayor seguridad</p>";
                } else {
                    print "<p style='color:red';>Introducir datos de MYSQL</p>
	<p style='color:red';>Debe introducir letras y numeros solamente</p>
		Nombre usuario<br />
                    <input type='text' name='usuario' maxlength='20' /><br />
                    Contraseña<br />
                    <input type='text' name='pass' maxlength='20'  /><br /> 
                    <input type='hidden'  name='tipo' value='admin' checked>
                    Nombre<br />
                    <input type='text' name='nombre' maxlength='40'
                                      /><br />
                    email<br />
                    <input type='text' name='mail' maxlength='50' /><br />
                    <input type='submit' name='envio1'value='Dar de alta'> <br />
		</form>
				";
                }
            }

        if (isset($_REQUEST ['usuario']) && isset($_REQUEST ['pass'])) {
            instalador();
        } else {
            print "<p style='color:green';>Introducir datos de MYSQL</p>
		
		<form name='datos' action='' method='post'>
		Nombre usuario<br />
                    <input type='text' name='usuario' maxlength='20' /><br />
                    Contraseña<br />
                    <input type='text' name='pass' maxlength='20'  /><br /> 
                    <input type='hidden'  name='tipo' value='admin' checked>
                    Nombre<br />
                    <input type='text' name='nombre' maxlength='40'
                                      /><br />
                    email<br />
                    <input type='text' name='mail' maxlength='50' /><br/><br/>
                 <input type='submit' name='envio3' value='Enviar'>   
                <input type='reset' name='limpiar' value='borrar' />
                
                
		</form>
				";
   }