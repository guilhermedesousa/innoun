<?php

namespace Controllers;

session_start();

requireValidSession();
loadTemplateView('day_records');