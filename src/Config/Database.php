<?php

namespace Config;

use Exception;
use mysqli;
use mysqli_result;

class Database
{
    public static function getConnection(): mysqli
    {
        $env_path = realpath(dirname(__FILE__) . '/../env.ini');
        $env = parse_ini_file($env_path);
        $connection = new mysqli($env['host'], $env['username'], $env['password'], $env['database']);

        if ($connection->connect_error) {
            die("Error: " . $connection->connect_error);
        }

        return $connection;
    }

    public static function getResultFromQuery(string $sql): bool|mysqli_result
    {
        $connection = self::getConnection();
        $result = $connection->query($sql);
        $connection->close();
        return $result;
    }

    public static function executeSQL(string $sql): int|string
    {
        $connection = self::getConnection();
        if (!mysqli_query($connection, $sql)) {
            throw new Exception(mysqli_error($connection));
        }
        $id = $connection->insert_id;
        $connection->close();
        return $id;
    }
}