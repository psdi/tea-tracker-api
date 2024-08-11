<?php

namespace TeaTracker\Factory;

use Psr\Container\ContainerInterface;
use TeaTracker\Controller\TeaController;
use TeaTracker\Mapper\TeaMapper;
use TeaTracker\Sanitizer;

class TeaControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $mapper = $container->get(TeaMapper::class);
        $sanitizer = $container->get(Sanitizer::class);

        return new TeaController($mapper, $sanitizer);
    }
}
