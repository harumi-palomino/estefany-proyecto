<?php

require_once __DIR__ . "/utilidades.php";

$host = "localhost";
$baseDatos = "tienda_db";
$usuario = "root";
$clave = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$baseDatos;charset=utf8mb4",
        $usuario,
        $clave,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    responderJson(["error" => "No se pudo conectar a la base de datos"], 500);
}
