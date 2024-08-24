<?php

namespace Models;

use Config\Database;
use mysqli_result;

class Model
{
    protected static string $table_name = '';
    protected static array $columns = [];
    public array $values = [];

    public function __construct(array $arr)
    {
        $this->loadFromArray($arr);
    }

    public function loadFromArray(array $arr): void
    {
        if ($arr) {
            foreach ($arr as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function __get(string $key)
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    public function __set(string $key, mixed $value)
    {
        $this->values[$key] = $value;
    }

    public static function getOne(array $filters = [], string $columns = '*'): Model|null
    {
        $class = get_called_class();
        $result = static::getResultFromSelect($filters, $columns);

        return $result ? new $class($result->fetch_assoc()) : null;
    }

    public static function get(array $filters = [], string $columns = '*'): array
    {
        $objects = [];
        $class = get_called_class();
        $result = static::getResultFromSelect($filters, $columns);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $objects[] = new $class($row);
            }
        }
        return $objects;
    }

    public static function getResultFromSelect(array $filters = [], string $columns = '*'): null|bool|mysqli_result
    {
        $sql = "SELECT $columns FROM " . static::$table_name . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);

        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    private static function getFilters(array $filters): string
    {
        $sql = '';
        if (!empty($filters)) {
            $sql .= ' WHERE 1 = 1';
            foreach ($filters as $column => $value) {
                $sql .= " AND $column = " . static::getFormattedValue($value);
            }
        }
        return $sql;
    }

    public function insert(): void
    {
        $sql = "INSERT INTO " . static::$table_name . " (" . implode(",", static::$columns) . ") VALUES (";

        foreach (static::$columns as $column) {
            $sql .= static::getFormattedValue($this->$column) . ",";
        }
        $sql[strlen($sql) - 1] = ')';
        $id = Database::executeSQL($sql);
        $this->id = $id;
    }

    public function update(): void
    {
        $sql = "UPDATE " . static::$table_name . " SET ";

        foreach (static::$columns as $column) {
            $sql .= $column . " = " . static::getFormattedValue($this->$column) . ",";
        }
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id = {$this->id}";
        Database::executeSQL($sql);
    }

    private static function getFormattedValue(mixed $value)
    {
        if (is_null($value)) {
            return "null";
        } elseif (is_string($value)) {
            return "'$value'";
        } else {
            return $value;
        }
    }
}