<?php

namespace Models;

use Exceptions\{AppException, ValidationException};

class Login extends Model
{
    /**
     * @throws ValidationException
     */
    public function validate(): void
    {
        $errors = [];

        if (!$this->email) {
            $errors['email'] = 'E-mail é um campo obrigatório';
        }

        if (!$this->password) {
            $errors['password'] = 'Por favor, informe a senha';
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

    /**
     * @throws AppException
     * @throws ValidationException
     */
    public function checkLogin(): User
    {
        $this->validate();
        $user = User::getOne(['email' => $this->email]);
        if ($user) {
            if ($user->end_date) {
                throw new AppException("Usuário está desligado da empresa");
            }
            if (password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        throw new AppException("Usuário/Senha inválidos");
    }
}