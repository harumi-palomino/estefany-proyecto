<?php

require_once __DIR__ . "/../includes/conexion.php";

soloGet();

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT, [
    "options" => ["min_range" => 1]
]);

if (!$id) {
    responderJson(["error" => "El id del producto no es válido"], 400);
}

try {
    $sql = CONSULTA_PRODUCTOS . " WHERE p.id = :id ORDER BY i.id";
    $consulta = $pdo->prepare($sql);
    $consulta->execute(["id" => $id]);
    $filas = $consulta->fetchAll();

    if (count($filas) === 0) {
        responderJson(["error" => "Producto no encontrado"], 404);
    }

    $productos = agruparProductos($filas);
    responderJson($productos[0]);
} catch (PDOException $e) {
    responderJson(["error" => "Error al obtener el producto"], 500);
}