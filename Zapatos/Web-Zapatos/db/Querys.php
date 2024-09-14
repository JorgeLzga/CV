<?php

    class Querys
    {
        private PDO $connection;

        public function __construct(PDO $connection) {
            $this->connection = $connection;
        }

        public function getAllObjects(string $sql) : array
        {
            $stmt = $this->connection->prepare($sql);
            
            $stmt->execute();

            $object = $stmt->fetchAll();

            return $object;
        }

        public function getObjectByID(string $sql, int $id) : array
        {
            $stmt = $this->connection->prepare($sql);
            
            $stmt->execute([$id]);

            $object = $stmt->fetch();

            return $object;
        }

        public function createObject(string $sql, array $object) : bool
        {
            $stmt = $this->connection->prepare($sql);

            $stmt->execute($object);

            $row = $stmt->rowCount();

            if ($row > 0) {
                $flag = true;
            } else {
                $flag = false;
            }

            return $flag;
        }

        public function deleteObject(string $sql, int $id) : bool
        {
            $stmt = $this->connection->prepare($sql);

            $stmt->execute([$id]);

            $row = $stmt->rowCount();

            if ($row > 0) {
                $flag = true;
            } else {
                $flag = false;
            }

            return $flag;
        }

        public function updateObject(string $sql, array $object)
        {
            $stmt = $this->connection->prepare($sql);

            $stmt->execute($object);

            $row = $stmt->rowCount();

            if ($row > 0) {
                $flag = true;
            } else {
                $flag = false;
            }

            return $flag;
        }
    }

?>