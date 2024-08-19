<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Http;

use KollabsBooks\BookCatalog\Infrastructure\Http\BookCatalogRoutes;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

class Routes
{
    public static function register(App $app): void
    {
        // General routes
        $app->get('/', function (Request $request, Response $response) {
            $response->getBody()->write("Welcome to KollabsBooks API!");
            return $response;
        });

        // Domain-specific routes
        BookCatalogRoutes::registerRoutes($app);
    }
}