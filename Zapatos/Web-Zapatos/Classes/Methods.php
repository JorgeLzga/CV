<?php

    if (is_file("db/Querys.php")) {
        require_once("db/Querys.php");
    } else {
        require_once("../db/Querys.php");
    }

    abstract class Methods 
    {
        protected Querys $query;

        public function __construct(PDO $connection)
        {
            $this->query = new Querys($connection);
        }

        public abstract function getAll() : array;
        public abstract function getByID(int $id) : array;
        public abstract function create(array $object) : bool;
        public abstract function delete(int $id) : bool;
        public abstract function update(int $id, array $object) : bool;
    }

?>
