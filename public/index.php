<?php

declare(strict_types=1);

use KollabsBooks\Shared\Infrastructure\Http\App;

require __DIR__ . '/../vendor/autoload.php';

$app = new App();
$app->boot();
$app->run();