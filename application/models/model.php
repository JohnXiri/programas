<?php

class Model {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function login($nombre, $pass) {

        $consulta = "SELECT * FROM `usuario`
	WHERE `login` LIKE '$nombre' AND
	`password` LIKE '$pass'
	";
        $result = $this->db->prepare($consulta);
        $result->execute();

        return $result->fetchAll();
    }

    function ver_usuarios() {
        $consulta = "SELECT * FROM usuario";
        $result = $this->db->prepare($consulta);
        $result->execute();
        return $result->fetchAll();
    }

    function nuevo_usuario($usuario, $pass, $nombre, $mail) {

        if ($this->db->query("INSERT into usuario (login,password,admin,nombre,email) VALUES ('$usuario','$pass','si','$nombre','$mail') ")) {
            return true;
        } else {
            return false;
        }
    }

    function modificar_usuario($usuario,$pass) {

        if ($this->db->query(
                        "UPDATE usuario SET login='$usuario',password='$pass' WHERE login LIKE'$usuario' ")) {
            return true;
        } else {
            return false;
        }
    }

    function usuario_existe($nombre) {
        $consulta = "SELECT * FROM usuario
				WHERE login LIKE '$nombre'
				";
        $result = $this->db->prepare($consulta);
        $result->execute();
        return $result->fetchAll();
    }

    function crear_categorias() {

        if ($this->db->query("INSERT into categoria (nombre,usuario) VALUES ('$nombre','$usuario')")) {
            return true;
        } else {
            return false;
        }
    }

    function menu() {

        $consulta = "SELECT * FROM categoria
		";
        $result = $this->db->prepare($consulta);
        $result->execute();

        return $result->fetchAll();
    }

    public function todos_articulos() {

// Seleccionamos de la base de datos todas las entradas y mostramos de la ultima a la primera

        $consulta = " SELECT * FROM entrada";

        $result = $this->db->prepare($consulta);

        $result->execute();

        return $result->fetchAll();
    }

    function obtener_producto($idn) {

        $consulta = " SELECT * FROM entrada WHERE id_entrada=$idn";
        $result = $this->db->prepare($consulta);
        $result->execute();
        return $result->fetchAll();
    }

    function articulos_categoria($categoria) {

        $consulta = "SELECT * FROM entrada WHERE `idcat`=$categoria;";

        $result = $this->db->prepare($consulta);

        $result->execute();

        return $result->fetchAll();
    }

//funcion para ver articulos y borrarlos
    function administrar_articulos() {

// Seleccionamos de la base de datos todas las entradas y mostramos de la ultima a la primera

        $consulta = " SELECT * FROM entrada";

        $result = $this->db->prepare($consulta);

        $result->execute();

        return $result->fetchAll();
    }

    function resumir($texto) {
        $resumido = '';

        if (strlen($texto) >= 300) {
            for ($i = 0; $i <= 300; $i++) {

                $resumido .=$texto[$i];
            }
            $resumido .="...";
        } else {

            $resumido = $texto . "...";
        }
        return $resumido;
    }

    function modificar($id, $titulo, $categoria, $narticulo, $nombre) {

        if ($this->db->query("UPDATE entrada SET titulo='$titulo',mensaje='$narticulo',"
                        . "idcat='$categoria',login='$nombre'  WHERE id_entrada='$id'")) {
            return true;
        } else {
            return false;
        }
    }

    function cargar_comentarios($idn) {

        // Seleccionamos de la base de datos todos los comentarios 

        $consulta = " SELECT * FROM comentario WHERE id_entrada=$idn";

        $result = $this->db->prepare($consulta);

        $result->execute();

        return $result->fetchAll();
    }

    function cargar_respuestas($idc) {

        $consulta2 = "SELECT * FROM comentario WHERE padre=$idc";
        $result2 = $this->db->prepare($consulta2);
        $result2->execute();
        return $result2->fetchAll();
    }

}
