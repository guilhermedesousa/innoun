<?php

namespace Controllers;

use DateTime;
use Models\User;
use Exception;

session_start();
requireValidSession(true);

$exception = null;

if (isset($_GET['delete'])) {
    try {
        User::deleteById($_GET['delete']);
        addSuccessMessage("Usuário excluído com sucesso!");
    } catch (Exception $e) {
        if (stripos($e->getMessage(), 'FOREIGN KEY')) {
            addErrorMessage("Não é possível excluir usuário com registros de ponto.");
        } else {
            $exception = $e;
        }
    }
}

$users = User::get();

foreach ($users as $user) {
    $user->start_date = (new DateTime($user->start_date))->format('d/m/Y');
    if ($user->end_date) {
        $user->end_date = (new DateTime($user->end_date))->format('d/m/Y');
    }
}

loadTemplateView('users', [
    'users' => $users,
    'exception' => $exception
]);