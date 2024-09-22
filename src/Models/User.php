<?php

namespace Models;

use Exceptions\ValidationException;
use DateTime;

class User extends Model
{
    protected static string $table_name = 'users';
    protected static array $columns = ['id', 'name', 'password', 'email', 'start_date', 'end_date', 'is_admin'];

    public static function getActiveUsersCount(): mixed
    {
        return static::getCount(['raw' => 'end_date IS NULL']);
    }

    public function insert(): void
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if (!$this->end_date) {
            $this->end_date = NULL;
        }
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::insert();
    }

    public function update(): void
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if (!$this->end_date) {
            $this->end_date = NULL;
        }
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::update();
    }

    private function validate(): void
    {
        $errors = [];

        if (!$this->name) {
            $errors['name'] = 'Nome é um campo obrigatório';
        }

        if (!$this->email) {
            $errors['email'] = 'E-mail é um campo obrigatório';
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'E-mail inválido';
        }

        if (!$this->start_date) {
            $errors['start_date'] = 'Data de admissão é um campo obrigatório';
        } else if (!DateTime::createFromFormat('Y-m-d', $this->start_date)) {
            $errors['start_date'] = 'Data de admissão inválida';
        }

        if ($this->end_date && !DateTime::createFromFormat('m-d-Y', $this->start_date)) {
            $errors['end_date'] = 'Data de desligamento inválida';
        }

        if (!$this->password) {
            $errors['password'] = 'Senha é um campo obrigatório';
        }

        if (!$this->confirm_password) {
            $errors['confirm_password'] = 'Confirmação de senha é um campo obrigatório';
        }

        if ($this->password && $this->confirm_password && $this->password !== $this->confirm_password) {
            $errors['confirm_password'] = 'A senha não confere';
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}