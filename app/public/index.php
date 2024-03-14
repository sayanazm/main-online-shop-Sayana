<?php

use Core\App;
use Core\Autoloader;

require_once './../Core/Autoloader.php';

Autoloader::registrate(dirname(__DIR__));

$app = new App();
$app->run();