<?php

use TeaTracker\Controller\TeaController;
use TeaTracker\Factory\TeaControllerFactory;
use TeaTracker\Factory\TeaMapperFactory;
use TeaTracker\Mapper\TeaMapper;
use TeaTracker\PdoFactory;
use TeaTracker\Sanitizer;

$builder = new DI\ContainerBuilder();
$config = require_once 'config.php';

$builder->addDefinitions(
    [
        \PDO::class => DI\factory(PdoFactory::class),
        Sanitizer::class => DI\factory(function () use ($config) {
            return new Sanitizer($config['sanitizer.collection']);
        }),

        TeaMapper::class => DI\factory(TeaMapperFactory::class),

        TeaController::class => DI\factory(TeaControllerFactory::class),
    ]
);

$container = $builder->build();

