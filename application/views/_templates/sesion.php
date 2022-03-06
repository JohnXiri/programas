<?php
$patron = "/^[[:alnum:]]{1,150}+$/i";
$nombre = $_REQUEST ['nombre'];
$pass = $_REQUEST ['pass'];
$user = "";
if (preg_match($patron, $nombre) && preg_match($patron, $pass)) {

    $pass = crypt($pass, '$2a$07$ideaalziraweb$');
    $result = Home::login($nombre, $pass);
    foreach ($result as $valor) {

        $user = $valor->login; //$valor ['login'];
        $password = $valor->password; //$valor ['password'];
        $admin = $valor->admin; //$valor ['tipo'];
    }

    if ($nombre == $user && $pass == $password && $admin == 'si') {
        if (!session_start()) {
            session_start();
        }
        $_SESSION ['nombre'] = $_REQUEST ['nombre'];
        $_SESSION ["pass"] = $_REQUEST ['pass'];
        $_SESSION ["admin"] = $admin;
        $error = '';
        $url = URL;
        $url.="home/admin/";
        ?>
        <script>
            window.location.replace("<?php echo $url; ?>");
        </script> 
        <?php
    } else {
        print "<div style='margin:10% auto;border:2px solid;padding:3%;width:20%;background:#F7BC79;'><p style='color:red';>Su nombre de usuario o contrase&ntilde;a no es correcto</p>			
		<p>Escriba su nombre y contrase&ntilde;a</p>
		<form name='datos' action='' method='post'>
		Nombre <br/><input type='text' name='nombre' /><br/><br/>
		Contrase&ntilde;a <br/><input type='password' name='pass' /><br/><br/>
		<br/> <input type='submit' name='enviar' value='enviar' /> <input
			type='reset' name='limpiar' value='borrar' /><br/>
		</form></div>
				";
    }
} else if ($_REQUEST['externo'] == "Google") {
    if (!session_start()) {
        session_start();
    }
    $_SESSION ['nombre'] = $_REQUEST ['nombre'];
    $_SESSION ["imagen"] = $_REQUEST ['imagen'];
    $_SESSION ["email"] = $_REQUEST ['email'];
    $_SESSION ["admin"] = "no";
    $url = URL;
    ?>
    <script>
        window.location.replace("<?php echo $url; ?>");
    </script>
    <?php
} else {
    $url = URL;
    echo "<p style='color:red';>Debe introducir letras y numeros solamente.</p>		
				<a href='$url'>Volver</a>
			";
}

