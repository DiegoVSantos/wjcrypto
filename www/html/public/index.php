<?php

// load composer dependencies
use Pecee\SimpleRouter\SimpleRouter;

require_once '../vendor/autoload.php';
require_once '../routes/routes.php';

session_start();

SimpleRouter::start();
