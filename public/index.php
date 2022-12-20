<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1);
use Core\Application;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application();

$app->run();
