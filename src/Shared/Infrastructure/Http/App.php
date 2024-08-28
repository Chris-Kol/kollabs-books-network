<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Http;

use Exception;
use KollabsBooks\BookCatalog\Infrastructure\Http\BookCatalogRoutes;
use KollabsBooks\Shared\Infrastructure\Container\ContainerFactory;
use Slim\Factory\AppFactory;
use Slim\App as SlimApp;

class App
{
    private SlimApp $app;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $container = ContainerFactory::create();
        AppFactory::setContainer($container);
        $this->app = AppFactory::create();
    }

    public function boot(): void
    {
        $this->app->addErrorMiddleware(true, true, true);

        Routes::register($this->app);
    }

    public function run(): void
    {
        $this->app->run();
    }
}