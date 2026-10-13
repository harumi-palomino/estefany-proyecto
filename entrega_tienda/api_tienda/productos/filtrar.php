<?php

require_once __DIR__ . "/../models/producto.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Allow: POST");

    responderJson(
        ["error" => "Método no permitido. Use POST."],
        405
    );
}

$datos = $_POST;

try {
    $modelo = new Producto($pdo);

    $productos = $modelo->filtrarProductos($datos);

    responderJson($productos);

} catch (InvalidArgumentException $e) {

    responderJson(
        ["error" => $e->getMessage()],
        400
    );

} catch (PDOException $e) {

    responderJson(
        ["error" => "Error al filtrar los productos."],
        500
    );
}