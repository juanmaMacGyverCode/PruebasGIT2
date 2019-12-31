<?php

function connection()
{
    $mysqli = new mysqli('localhost', 'root', '', 'smallShop');
    if ($mysqli->connect_error) {
        die('Error de Conexión (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    } else {
        return $mysqli;
    }
}
