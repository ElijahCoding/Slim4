<?php

use Slim\Factory\AppFactory;

// Container before creating apps
require 'container.php';

$app = AppFactory::create();

require 'middleware.php';

require '../routes/web.php';
