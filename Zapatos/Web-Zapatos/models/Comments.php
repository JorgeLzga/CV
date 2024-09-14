<?php

    if (is_file("Classes/methods.php")) {
        require_once("Classes/Methods.php");
    } else {
        require_once("../Classes/Methods.php");
    }

    class Comments extends Methods
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
                $comments = $this->query->getAllObjects("SELECT * FROM comentario ORDER BY fecha DESC");
            } else {
                $comments = $this->query->getAllObjects("SELECT * FROM comentario");
            }

            return $comments;
        }

        public function getByID(int $id) : array
        {
            try {
                $sql = "SELECT * FROM comentario WHERE id = ?";

                return $this->query->getObjectByID($sql, $id);
            } catch (PDOException $e) {
                echo "Error: " . $e;
            }
        }

        public function create(array $comment) : bool
        {
            return $this->query->createObject("INSERT INTO comentario (comentario, id_usuario, id_producto) values (?,?,?)", $comment);
        }

        public function delete(int $id) : bool
        {
            return $this->query->deleteObject("UPDATE comentario SET eliminado='1' WHERE id = ?", $id);
        }

        public function update(int $id, array $object) : bool
        {
            $sql = "UPDATE comentario SET comentario = ? WHERE id = '$id'";

            return $this->query->updateObject($sql, $object);
        }

        public function getCommentsByID(int $idProduct) : array
        {
            $sql = "SELECT comentario.id, comentario.comentario, comentario.fecha, usuario.nombre, usuario.id AS id_usuario FROM comentario
            INNER JOIN usuario
            on comentario.id_usuario = usuario.id
            INNER JOIN producto
            ON comentario.id_producto = producto.id  WHERE producto.id = '$idProduct' AND comentario.eliminado != 1
            ORDER BY comentario.fecha DESC";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $commentCustom = $stmt->fetchAll();
            return $commentCustom;
        }
    }

?>