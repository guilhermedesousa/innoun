<?php

function requireValidSession(): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
}