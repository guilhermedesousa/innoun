<?php

namespace Controllers;

use DateTime;
use Models\WorkingHours;

session_start();

requireValidSession();
loadModel('WorkingHours');

$date = new DateTime();
$today = $date->format('d \d\e F \d\e Y');
$today = getPtMonthName($today);

loadTemplateView('day_records', ['today' => $today]);