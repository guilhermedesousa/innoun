<?php

use Models\WorkingHours;
use Exceptions\AppException;

session_start();

requireValidSession();

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

$currentTime = new DateTime();
$currentTime = $currentTime->format("H:i:s");

try {
    if (isset($_POST['forcedTime'])) {
        $currentTime = $_POST['forcedTime'];
    }
    $records->clockInAndOut($currentTime);
    addSuccessMessage('Ponto inserido com sucesso');
} catch (AppException $e) {
    addErrorMessage($e->getMessage());
}

header("Location: day_records.php");