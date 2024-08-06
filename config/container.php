<?php

use TeaTracker\Controller\TeaController;
use TeaTracker\Factory\TeaControllerFactory;
use TeaTracker\Factory\TeaMapperFactory;
use TeaTracker\Mapper\TeaMapper;
use TeaTracker\PdoFactory;

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(
    [
        \PDO::class => DI\factory(PdoFactory::class),

        TeaMapper::class => DI\factory(TeaMapperFactory::class),

        TeaController::class => DI\factory(TeaControllerFactory::class),
    ]
);

$container = $builder->build();

