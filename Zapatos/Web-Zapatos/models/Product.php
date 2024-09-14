<?php

    if (is_file("Classes/methods.php")) {
        require_once("Classes/Methods.php");
    } else {
        require_once("../Classes/Methods.php");
    }

    class Product extends Methods
    {
        private string $name;
        private float $price;
        private string $description;
        private int $existence;
        private string $image;
        private float $discount;
        private bool $eliminated;

        private PDO $connection;

        public function __construct(PDO $connection)
        {
            parent::__construct($connection);
            $this->connection = $connection;

            $this->name = "";
            $this->price = 0.0;
            $this->description = "";
            $this->existence = 0;
            $this->image = "";
            $this->discount = 0;
            $this->eliminated = false;
        }

        public function getAll(bool $desc = false) : array
        {
            if ($desc) {
                $products = $this->query->getAllObjects("SELECT * FROM producto WHERE eliminado = '0' ORDER BY id DESC");
            } else {
                $products = $this->query->getAllObjects("SELECT * FROM producto WHERE eliminado = '0'");
            }

            return $products;
        }

        public function getByID(int $id) : array
        {
            try {
                return $this->query->getObjectByID("SELECT * FROM producto WHERE id = ?", $id);
            } catch (PDOException $e) {
                echo "Error: " . $e;
            }
        }

        public function create(array $product) : bool
        {
            return $this->query->createObject("INSERT INTO producto (nombre, precio, descripcion, existencia, imagen, descuento) values (?,?,?,?,?,?)", $product);
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

        public function updateStock(int $id, float $newStock) : bool
        {
            $sql = "UPDATE producto SET existencia = '$newStock' WHERE id = '$id'";

            $stmt = $this->connection->prepare($sql);

            $stmt->execute();

            $row = $stmt->rowCount();

            if ($row > 0) {
                $flag = true;
            } else {
                $flag = false;
            }

            return $flag;

        }

        public function getProductsDiscount() : array
        {
            $sql = "SELECT * FROM producto WHERE descuento > '0' AND eliminado != '1'";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $product = $stmt->fetchAll();

            return $product;
        }

        public function setName(string $name) : void
        {
            $this->name = $name;
        }

        public function getName() : string
        {
            return $this->name;
        }

        public function setPrice(string $price) : void
        {
            $this->price = $price;
        }

        public function getPrice() : float
        {
            return $this->price;
        }

        public function setDescription(string $description) : void
        {
            $this->description = $description;
        }

        public function getDescription() : string
        {
            return $this->description;
        }

        public function setExistence(string $existence) : void
        {
            $this->existence = $existence;
        }

        public function getExistence() : int
        {
            return $this->existence;
        }

        public function setImage(string $image) : void
        {
            $this->image = $image;
        }

        public function getImage() : string
        {
            return $this->image;
        }

        public function setEliminated(string $eliminated) : void
        {
            $this->eliminated = $eliminated;
        }

        public function getEliminated() : bool
        {
            return $this->eliminated;
        }

        public function setDiscount(float $discount) : void
        {
            $this->discount = $discount;
        }

        public function getDiscount() : bool
        {
            return $this->discount;
        }
    }

?>