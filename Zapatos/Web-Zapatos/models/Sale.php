<?php 

    if (is_file("Classes/methods.php")) {
        require_once("Classes/Methods.php");
    } else {
        require_once("../Classes/Methods.php");
    }

    require_once("Product.php");

    class Sale extends Methods
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
                $sale = $this->query->getAllObjects("SELECT * FROM venta ORDER BY id DESC");
            } else {
                $sale = $this->query->getAllObjects("SELECT * FROM venta");
            }

            return $sale;
        }

        public function getByID(int $id) : array
        {
            try {
                $sql = "SELECT venta.cantidad_producto AS cantidad, venta.total, venta.fecha, venta.subtotal, 
                venta.precio_real AS precio_actual, venta.municipio,
                producto.imagen, producto.nombre,
                producto.descuento
                FROM venta
                INNER JOIN producto
                ON venta.id_producto = producto.id 
                INNER JOIN usuario
                ON venta.id_usuario = usuario.id
                WHERE usuario.id = '$id'
                ORDER BY venta.fecha DESC";

                $stmt = $this->connection->prepare($sql);
                $stmt->execute();

                $row = $stmt->fetchAll();

                return $row;
            } catch (PDOException $e) {
                echo "Error: " . $e;
            }
        }

        public function create(array $sale) : bool
        {
            return $this->query->createObject("INSERT INTO venta (cantidad_producto, total, id_usuario, id_producto,
            subtotal, precio_real, municipio) values (?,?,?,?,?,?,?)", $sale);
        }

        public function saleCartFunction(array $saleCart) : bool
        {
            $sql = "INSERT INTO venta_carrito (total, id_carrito, id_usuario, id_producto, municipio, cantidad) VALUES (?,?,?,?,?,?)";
            return $this->query->createObject($sql, $saleCart);
        }

        public function saleCartByID($id) : array
        {
            try {
                $sql = "SELECT venta_carrito.total, venta_carrito.fecha, 
                venta_carrito.municipio, venta_carrito.cantidad,
                producto.imagen, producto.nombre,
                producto.descuento, producto.precio
                FROM venta_carrito
                INNER JOIN producto
                ON venta_carrito.id_producto = producto.id 
                INNER JOIN usuario
                ON venta_carrito.id_usuario = usuario.id
                WHERE usuario.id = '$id'
                ORDER BY venta_carrito.fecha DESC";

                $stmt = $this->connection->prepare($sql);
                $stmt->execute();

                $row = $stmt->fetchAll();

                return $row;
            } catch (PDOException $e) {
                echo "Error: " . $e;
            }
        }

        public function delete(int $id) : bool
        {
            return $this->query->deleteObject("UPDATE producto SET eliminado='1' WHERE id = ?", $id);
        }

        public function update(int $id, array $object, bool $void = false) : bool
        {
            $sql = "UPDATE producto SET nombre = ?, precio = ?, descripcion = ?, existencia = ?, imagen = ?, descuento = ? WHERE id = '$id'";
            
            if ($void) {
                $sql = "UPDATE producto SET nombre = ?, precio = ?, descripcion = ?, existencia = ?, imagen = 'imagen-default.png', descuento = ? WHERE id = '$id'";
            }

            return $this->query->updateObject($sql, $object);
        }
    }

?>