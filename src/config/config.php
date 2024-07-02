<?php

date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_TIME, 'pt_BR', 'pt_BR.UTF-8', 'portuguese');

// folders
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));

require_once realpath(dirname(__FILE__) . '/Database.php');