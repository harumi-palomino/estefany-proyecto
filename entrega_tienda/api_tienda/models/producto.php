<?php

require_once __DIR__ . "/../includes/conexion.php";

class Producto {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function filtrarProductos($datos) {

        $condiciones = [];
        $parametros = [];

        if (isset($datos["id"]) && $datos["id"] !== "") {
            $id = filter_var($datos["id"], FILTER_VALIDATE_INT);

            if ($id === false || $id < 1) {
                throw new InvalidArgumentException(
                    "El ID debe ser un entero positivo."
                );
            }

            $condiciones[] = "p.id = :id";
            $parametros["id"] = $id;
        }

        if (isset($datos["nombre"]) && trim($datos["nombre"]) !== "") {
            if (!is_string($datos["nombre"])) {
                throw new InvalidArgumentException(
                    "El nombre debe ser texto."
                );
            }

            $condiciones[] = "p.nombre LIKE :nombre";
            $parametros["nombre"] = "%" . trim($datos["nombre"]) . "%";
        }

        if (isset($datos["descripcion"]) &&
            trim($datos["descripcion"]) !== "") {

            if (!is_string($datos["descripcion"])) {
                throw new InvalidArgumentException(
                    "La descripción debe ser texto."
                );
            }

            $condiciones[] = "p.descripcion LIKE :descripcion";
            $parametros["descripcion"] =
                "%" . trim($datos["descripcion"]) . "%";
        }

        if (isset($datos["precio"]) && $datos["precio"] !== "") {
            if (!is_numeric($datos["precio"]) ||
                (float) $datos["precio"] < 0) {

                throw new InvalidArgumentException(
                    "El precio debe ser un número no negativo."
                );
            }

            $condiciones[] = "p.precio = :precio";
            $parametros["precio"] = (float) $datos["precio"];
        }

        if (isset($datos["stock"]) && $datos["stock"] !== "") {
            $stock = filter_var(
                $datos["stock"],
                FILTER_VALIDATE_INT
            );

            if ($stock === false || $stock < 0) {
                throw new InvalidArgumentException(
                    "El stock debe ser un entero no negativo."
                );
            }

            $condiciones[] = "p.stock = :stock";
            $parametros["stock"] = $stock;
        }

        if (isset($datos["categoria_id"]) &&
            $datos["categoria_id"] !== "") {

            $categoria = filter_var(
                $datos["categoria_id"],
                FILTER_VALIDATE_INT
            );

            if ($categoria === false || $categoria < 1) {
                throw new InvalidArgumentException(
                    "La categoría debe ser un ID positivo."
                );
            }

            $condiciones[] = "p.categoria_id = :categoria_id";
            $parametros["categoria_id"] = $categoria;
        }

        $sql = CONSULTA_PRODUCTOS;

        if (count($condiciones) > 0) {
            $sql .= " WHERE " . implode(" AND ", $condiciones);
        }

        $sql .= " ORDER BY p.id, i.id";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute($parametros);

        return agruparProductos($consulta->fetchAll());
    }
}