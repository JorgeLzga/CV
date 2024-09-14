<?php

    if (is_file("Classes/methods.php")) {
        require_once("Classes/Methods.php");
    } else {
        require_once("../Classes/Methods.php");
    }

    class User extends Methods
    {
        private string $name;
        private string $email;
        private string $password;
        private PDO $connection;

        public function __construct(PDO $connection)
        {
            parent::__construct($connection);
            $this->connection = $connection;
        }

        public function getAll(): array
        {
            return $this->query->getAllObjects("SELECT * FROM usuario");
        }

        public function getByID(int $id): array
        {
            return $this->query->getObjectByID("SELECT * FROM usuario WHERE id = ?", $id);
        }

        public function create(array $object, bool $admin = false): bool
        {
            $flag = false;
            
            if ($admin) {
                $flag = $this->query->createObject("INSERT INTO usuario (nombre, correo, contrasenia, id_rol) VALUES (?,?,?,'1')", $object);
            } else {
                $flag = $this->query->createObject("INSERT INTO usuario (nombre, correo, contrasenia, id_rol) VALUES (?,?,?,'2')", $object);
            }

            return $flag;
        }

        public function delete(int $id): bool
        {
            return $this->query->deleteObject("DELETE FROM usuario WHERE id = ?", $id);
        }

        public function update(int $id, array $object): bool
        {
            $sql = "UPDATE usuario SET nombre = ?, correo = ?, contrasenia = ?, id_rol = ? WHERE id = '$id'";

            return $this->query->updateObject($sql, $object);
        }

        public function isAdmin(int $idRol) : bool
        {
            return $idRol == 1;
        }

        public function isLogin(string $email, string $password) : bool
        {
            $stmt = $this->connection->prepare("SELECT * FROM usuario WHERE correo = '$email' AND contrasenia = '$password'");
            $stmt->execute();

            $row = $stmt->rowCount();

            if ($row > 0) {
                $flag = true;
            } else {
                $flag = false;
            }

            return $flag;
        }

        public function customId(string $email, string $password) : int
        {
            $stmt = $this->connection->prepare("SELECT * FROM usuario WHERE correo = '$email' AND contrasenia = '$password'");
            $stmt->execute();

            $user = $stmt->fetch();
            
            return $user["id"];
        }

        public function setName(string $name)
        {
            $this->name = $name;
        }

        public function getName() : string
        {
            return $this->name;
        }

        public function setEmail(string $email)
        {
            $this->email = $email;
        }

        public function getEmail() : string
        {
            return $this->email;
        }

        public function setPassword(string $password)
        {
            $this->password = $password;
        }

        public function getPassword() : string
        {
            return $this->password;
        }
    }

?>