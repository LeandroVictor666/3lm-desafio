<?php

namespace Core;

use PDO;
use Exception;

class SqlConnection
{
    static private $host = "localhost";
    static private $dbName = "3lm";
    static private $username = "root";
    static private $password = "";
    static private $dsn = "mysql:host=localhost:3306;dbname=3lm";
    public static function getPdo(): PDO | false
    {
        try {
            $pdo = new PDO(static::$dsn, static::$username, static::$password);
            return $pdo;
        } catch (Exception $err) {
            echo $err;
            return false;
        }
    }
}
