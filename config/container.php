<?php

use TeaTracker\Factory\SelectTeasHandlerFactory;
use TeaTracker\Factory\TeaServiceFactory;
use TeaTracker\Handler\SelectTeasHandler;
use TeaTracker\PdoFactory;
use TeaTracker\Service\TeaService;

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(
    [
        \PDO::class => DI\factory(PdoFactory::class),

        TeaService::class => DI\factory(TeaServiceFactory::class),

        SelectTeasHandler::class => DI\factory(SelectTeasHandlerFactory::class),
    ]
);

$container = $builder->build();
