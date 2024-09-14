<?php

    class Connection
    {
        private static string $host;
        private static string $dbName;
        private static string $user;
        private static string $password;

        private function __construct() {}

        public static function getConnection() : PDO
        {
            $dsn = "localhost=" . self::getHost() . ";dbname=" . self::getDbName();

            try {
                $connection = new PDO("mysql:{$dsn}", self::getUser(), self::getPassword());
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            return $connection;
        }

        public static function setHost(string $host)
        {
            self::$host = $host;
        }

        private static function getHost() : string
        {
            return self::$host;
        }

        public static function setDbName(string $dbName)
        {
            self::$dbName = $dbName;
        }

        private static function getDbName() : string
        {
            return self::$dbName;
        }

        public static function setUser(string $user)
        {
            self::$user = $user;
        }

        private static function getUser() : string
        {
            return self::$user;
        }

        public static function setPassword(string $password)
        {
            self::$password = $password;
        }

        private static function getPassword() : string
        {
            return self::$password;
        }
    }

?>