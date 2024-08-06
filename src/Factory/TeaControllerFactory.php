<?php

namespace TeaTracker\Factory;

use Psr\Container\ContainerInterface;
use TeaTracker\Controller\TeaController;
use TeaTracker\Mapper\TeaMapper;

class TeaControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $service = $container->get(TeaMapper::class);

        return new TeaController($service);
    }
}
