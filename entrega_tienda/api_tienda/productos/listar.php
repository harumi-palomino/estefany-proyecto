<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../includes/conexion.php";

soloGet();

try {
    $sql = CONSULTA_PRODUCTOS . " ORDER BY p.id, i.id";
    $filas = $pdo->query($sql)->fetchAll();

    responderJson(agruparProductos($filas));
} catch (PDOException $e) {
    responderJson(["error" => "Error al obtener los productos"], 500);
}
