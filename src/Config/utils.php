<?php

function addSuccessMessage($message): void
{
    $_SESSION['message'] = [
        'type' => 'success',
        'message' => $message
    ];
}

function addErrorMessage($message): void
{
    $_SESSION['message'] = [
        'type' => 'error',
        'message' => $message
    ];
}