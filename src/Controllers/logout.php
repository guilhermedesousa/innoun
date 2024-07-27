<?php

namespace Controllers;

session_start();
session_destroy();
header('Location: login.php');