<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Http;

use Slim\App;

interface DomainRoutesInterface
{
    public static function registerRoutes(App $app): void;
}