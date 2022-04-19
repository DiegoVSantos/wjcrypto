<?php
date_default_timezone_set('America/Sao_Paulo');

// load composer dependencies
use Pecee\SimpleRouter\SimpleRouter;

require_once '../vendor/autoload.php';
require_once '../routes/routes.php';

session_start();

SimpleRouter::start();
