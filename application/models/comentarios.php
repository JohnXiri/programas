<?php

class Comentarios {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    function comentar($nombre, $coment, $idn, $tipo, $mail) {

        if ($tipo = "visitante") {

            if ($this->db->query("INSERT into comentario (comentario,nombre,email,id_entrada)" . " VALUES ('$coment','$nombre','$mail','$idn')")) {
                return true;
            } else {

                return false;
            }
        }
        if ($tipo = "usuario") {

            if ($this->db->query("INSERT into comentario (comentario,email,id_entrada,usuario)" . " VALUES ('$coment','$mail','$idn','$nombre')")) {
                return true;
            } else {

                return false;
            }
        }
    }

    function borrar_comentario($id) {
        if ($this->db->query("DELETE FROM comentario WHERE padre=$id")) {
            if ($this->db->query("DELETE FROM comentario WHERE idcom=$id")) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function responder_comentario($idn, $id, $usuario, $mail, $coment, $resid) {


        $result = $this->db->query("SELECT nombre FROM `comentario` WHERE `idcom`=$resid");
        $nombre = "";
        foreach ($result as $valor) {
            $nombre = $valor->nombre;
        }
        $coment2 = "@$nombre: ";
        $coment2 .= $coment;

        if ($this->db->query("INSERT into comentario (comentario,email,id_entrada,nombre,padre)" . " VALUES ('$coment2','$mail','$idn','$usuario','$id')")) {
            return true;
        } else {
            return false;
        }
    }

}
