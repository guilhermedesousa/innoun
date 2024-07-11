<?php

namespace models;

use config\Database;

class Model {
    protected static $table_name = '';
    protected static $columns = [];
    protected $values = [];

    public function __construct($arr) {
        $this->loadFromArray($arr);
    }

    public function loadFromArray($arr) {
        if ($arr) {
            foreach ($arr as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function __get($key) {
        return $this->values[$key];
    }

    public function __set($key, $value) {
        $this->values[$key] = $value;
    }

    public static function getOne($filters = [], $columns = '*') {
        $class = get_called_class();
        $result = static::getResultFromSelect($filters, $columns);

        return $result ? new $class($result->fetch_assoc()) : null;
    }

    public static function get($filters = [], $columns = '*') {
        $objects = [];
        $result = static::getResultFromSelect($filters, $columns);
        if ($result) {
            $class = get_called_class();
            while ($row = $result->fetch_assoc()) {
                array_push($objects, new $class($row));
            }
        }
        return $objects;
    }

    public static function getResultFromSelect($filters = [], $columns = '*') {
        $sql = "SELECT $columns FROM " . static::$table_name . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);

        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    private static function getFilters($filters) {
        $sql = '';
        if (!empty($filters)) {
            $sql .= ' WHERE 1 = 1';
            foreach ($filters as $column => $value) {
                $sql .= " AND $column = " . static::getFormattedValue($value);
            }
        }
        return $sql;
    }

    private static function getFormattedValue($value) {
        if (is_null($value)) {
            return "null";
        } elseif (is_string($value)) {
            return "'$value'";
        } else {
            return $value;
        }
    }
}