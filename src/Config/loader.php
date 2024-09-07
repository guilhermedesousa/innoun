<?php

use Models\WorkingHours;

function loadModel(string $modelName): void
{
    require_once MODEL_PATH . "/{$modelName}.php";
}

function loadView(string $viewName, array $params = []): void
{
    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            if (strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    require_once TEMPLATE_PATH . "/head.php";
    require_once VIEW_PATH . "/{$viewName}.php";
}

function loadTemplateView(string $viewName, array $params = []): void
{
    if (count($params) > 0) {
        foreach ($params as $key => $value) {
            if (strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    $user = $_SESSION['user'];
    $workingHours = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
    $workedTime = $workingHours->getWorkedTime()->format('%H:%I:%S');
    $exitTime = $workingHours->getExitTime()->format('H:i:s');
    $activeClock = $workingHours->getActiveClock();

    require_once TEMPLATE_PATH . "/head.php";
    require_once TEMPLATE_PATH . "/header.php";
    require_once TEMPLATE_PATH . "/aside.php";
    require_once VIEW_PATH . "/{$viewName}.php";
    require_once TEMPLATE_PATH . "/footer.php";
}

function renderTitle(string $title, string $subtitle, string $icon = null): void
{
    require_once TEMPLATE_PATH . "/title.php";
}