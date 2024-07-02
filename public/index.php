<?php

use models\User;

require_once dirname(__FILE__, 2) . '/src/config/config.php';
require_once dirname(__FILE__, 2) . '/src/models/User.php';

$user = new User(['name' => 'Gui', 'email' => 'guilhermedesousa.dev@gmail.com']);
print_r($user);