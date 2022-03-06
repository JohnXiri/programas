<?php

class Categoria {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    function crear_categorias($nombre) {

        if ($this->db->query("INSERT into categoria (nombre,activo) VALUES ('$nombre','si')")) {
            return true;
        } else {
            return false;
        }
    }

    function desactivar_categoria($idcat) {

        if ($this->db->query("UPDATE categoria SET activo='no' WHERE idcat='$idcat'")) {

            return true;
        } else {
            return false;
        }
    }
    function activar_categoria($idcat) {

        if ($this->db->query("UPDATE categoria SET activo='si' WHERE idcat='$idcat'")) {

            return true;
        } else {
            return false;
        }
    }

}
