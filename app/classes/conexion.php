<?php

try {
    $manejador = 'mysql';
    $servidor = 'localhost';
    $base = 'cafeteriadb';
    $usuario = 'root';
    $pass = '';

    $cadena = "$manejador:host=$servidor;dbname=$base";

    $cnx = new PDO($cadena, $usuario, $pass, array(
        PDO::ATTR_PERSISTENT => TRUE,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));
} catch (\Throwable $th) {
    throw $th;
}
