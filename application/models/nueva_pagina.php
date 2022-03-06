<?php

class Nueva_pagina {

    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

       function nueva($titulo, $categoria, $narticulo, $usuario) {

        
// Aquí guardamos la entrada en la base de datos para luego importarlas en la pagina principal con un enlace
        if ($this->db->query("INSERT into entrada (titulo,mensaje,login,idcat) VALUES ('$titulo','$narticulo','$usuario','$categoria')")) {

            return true;
        } else {
           return false;
        }
    }
}
