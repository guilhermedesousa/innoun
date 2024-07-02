<?php

namespace models;

require_once realpath(MODEL_PATH . '/Model.php');

class User extends Model {
    protected static $table_name = 'users';
    protected static $columns = ['id', 'name', 'password', 'email', 'start_date', 'end_date', 'is_admin'];
}