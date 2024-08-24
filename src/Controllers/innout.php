<?php

use Models\WorkingHours;
use Exceptions\AppException;

session_start();

requireValidSession();
loadModel('WorkingHours');

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

$currentTime = new DateTime();
$currentTime = $currentTime->format("H:i:s");

try {
    $records->clockInAndOut($currentTime);
    addSuccessMessage('Ponto inserido com sucesso');
} catch (AppException $e) {
    addErrorMessage($e->getMessage());
}

header("Location: day_records.php");