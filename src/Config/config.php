<?php

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.UTF-8', 'portuguese');

// folders
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../Models'));
define('VIEW_PATH', realpath(dirname(__FILE__) . '/../Views'));
define('TEMPLATE_PATH', realpath(dirname(__FILE__) . '/../Views/template'));
define('CONTROLLER_PATH', realpath(dirname(__FILE__) . '/../Controllers'));
define('EXCEPTION_PATH', realpath(dirname(__FILE__) . '/../Exceptions'));

// files
require_once realpath(dirname(__FILE__) . '/Database.php');
require_once realpath(dirname(__FILE__) . '/loader.php');
require_once realpath(dirname(__FILE__) . '/session.php');
require_once realpath(MODEL_PATH . '/Model.php');
require_once realpath(MODEL_PATH . '/User.php');
require_once realpath(EXCEPTION_PATH . '/AppException.php');
require_once realpath(EXCEPTION_PATH . '/ValidationException.php');