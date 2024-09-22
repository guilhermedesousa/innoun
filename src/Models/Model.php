<?php

namespace Models;

use Config\Database;
use mysqli_result;

class Model
{
    protected static string $table_name = '';
    protected static array $columns = [];
    public array $values = [];

    public function __construct(array $arr, $sanitize = true)
    {
        $this->loadFromArray($arr, $sanitize);
    }

    public function loadFromArray(array $arr, $sanitize = true): void
    {
        if ($arr) {
            // $conn = Database::getConnection();
            foreach ($arr as $key => $value) {
                $cleanValue = $value;
                if ($sanitize && isset($cleanValue)) {
                    $cleanValue = strip_tags(trim($cleanValue));
                    $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                    // $cleanValue = mysqli_real_escape_string($conn, $cleanValue);
                }

                $this->$key = $cleanValue;
            }
            // $conn->close();
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

    public function getValues(): array
    {
        return $this->values;
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
            $sql .= ' WHERE 1 = 1 ';
            foreach ($filters as $column => $value) {
                if ($column == 'raw') {
                    $sql .= "AND $value";
                } else {
                    $sql .= " AND $column = " . static::getFormattedValue($value);
                }
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

    public static function deleteById($id): void
    {
        $sql = "DELETE FROM " . static::$table_name . " WHERE id = {$id}";
        Database::executeSQL($sql);
    }

    public static function getCount($filters = [])
    {
        $result = static::getResultFromSelect($filters, 'count(*) as count');
        return $result->fetch_assoc()['count'];
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