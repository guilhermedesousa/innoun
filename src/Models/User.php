<?php

namespace Models;

class User extends Model
{
    protected static string $table_name = 'users';
    protected static array $columns = ['id', 'name', 'password', 'email', 'start_date', 'end_date', 'is_admin'];

    public static function getActiveUsersCount()
    {
        return static::getCount(['raw' => 'end_date IS NULL']);
    }
}