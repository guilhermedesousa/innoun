<?php

namespace Controllers;

use Models\Login;
use Exceptions\{AppException, ValidationException};

loadModel('Login');

$exception = null;

if (count($_POST) > 0) {
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        echo "Usuário {$user->name} logado";
    } catch (AppException | ValidationException $e) {
        $exception = $e;
    }
}

loadView('login', $_POST + ['exception' => $exception]);