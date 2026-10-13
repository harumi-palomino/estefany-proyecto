<?php

function responderJson($datos, $codigo = 200) {
    http_response_code($codigo);
    header("Content-Type: application/json; charset=utf-8");
    header("Access-Control-Allow-Origin: *");
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit;
}

function soloGet() {
    if ($_SERVER["REQUEST_METHOD"] !== "GET") {
        responderJson(["error" => "Método no permitido"], 405);
    }
}

const CONSULTA_PRODUCTOS = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock,
        p.categoria_id, c.nombre AS categoria, i.url AS imagen
    FROM productos p
    INNER JOIN categorias c ON c.id = p.categoria_id
    LEFT JOIN imagenes i ON i.producto_id = p.id";

function agruparProductos($filas) {
    $productos = [];

    foreach ($filas as $fila) {
        $id = (int) $fila["id"];

        if (!isset($productos[$id])) {
            $productos[$id] = [
                "id" => $id,
                "nombre" => $fila["nombre"],
                "descripcion" => $fila["descripcion"],
                "precio" => (float) $fila["precio"],
                "categoria" => $fila["categoria"],
                "categoria_id" => (int) $fila["categoria_id"],
                "stock" => (int) $fila["stock"],
                "imagenes" => []
            ];
        }

        if ($fila["imagen"] !== null) {
            $productos[$id]["imagenes"][] = $fila["imagen"];
        }
    }

    return array_values($productos);
}
