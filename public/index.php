<?php

require implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);

use App\Components\Core\Application;

$_SERVER['PROJECT_ROOT'] = dirname(__DIR__) . DIRECTORY_SEPARATOR;

$application = new Application();
$application->run();
