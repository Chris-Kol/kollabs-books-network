<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Container;

use DI\ContainerBuilder;

interface DomainContainerInterface
{
    public static function getDefinitions(): array;
}