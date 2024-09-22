<?php

namespace Controllers;

//use Models\{WorkingHours, User};

session_start();
requireValidSession();

loadTemplateView('save_user');