<?php

    if (is_file("Classes/methods.php")) {
        require_once("Classes/Methods.php");
    } else {
        require_once("../Classes/Methods.php");
    }

    class Cart extends Methods
    {
        private PDO $connection;

        public function __construct(PDO $connection)
        {
            parent::__construct($connection);
            $this->connection = $connection;
        }

        public function getAll(bool $desc = false) : array
        {
            if ($desc) {
                $cart = $this->query->getAllObjects("SELECT * FROM comentario ORDER BY fecha DESC");
            } else {
                $cart = $this->query->getAllObjects("SELECT * FROM comentario");
            }

            return $cart;
        }

        public function getByID(int $id) : array
        {
            $sql = "SELECT carrito.id, carrito.cantidad, producto.imagen, 
            producto.nombre, producto.precio, producto.descuento
            FROM carrito
            INNER JOIN usuario
            ON carrito.id_usuario = usuario.id
            INNER JOIN producto
            ON carrito.id_producto = producto.id
            WHERE carrito.eliminado != '1' AND usuario.id = ?";

            return $this->query->getObjectByID($sql, $id);
        }

        public function create(array $cart) : bool
        {
            return $this->query->createObject("INSERT INTO carrito (id_usuario, id_producto, cantidad, eliminado, precio) values (?,?,?,'0',?)", $cart);
        }

        public function delete(int $id) : bool
        {
            $sql = "UPDATE carrito SET eliminado = '1' WHERE id = ?";

            return $this->query->deleteObject($sql, $id);
        }

        public function update(int $id, array $object) : bool
        {
            $sql = "UPDATE comentario SET comentario = ? WHERE id = '$id'";

            return $this->query->updateObject($sql, $object);
        }

        public function getAllCartByIdUser(int $id) : array
        {
            $sql = "SELECT carrito.id, carrito.cantidad, carrito.precio,
            producto.id AS id_product ,producto.imagen, 
            producto.nombre, producto.descuento,
            producto.existencia,
            producto.precio AS precio_original
            FROM carrito
            INNER JOIN usuario
            ON carrito.id_usuario = usuario.id
            INNER JOIN producto
            ON carrito.id_producto = producto.id
            WHERE carrito.eliminado != '1' AND usuario.id = '$id'
            ORDER BY carrito.id DESC";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        }

        public function getNumbersOfItem(int $id) : int
        {
            $sql = "SELECT COUNT(carrito.id) AS numero_items
            FROM carrito
            INNER JOIN usuario
            ON carrito.id_usuario = usuario.id
            INNER JOIN producto
            ON carrito.id_producto = producto.id
            WHERE carrito.eliminado != '1' AND usuario.id = '$id'";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            return $stmt->fetchColumn();
        }
    }

?>