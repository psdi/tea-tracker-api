<?php

namespace TeaTracker\Factory;

use Psr\Container\ContainerInterface;
use TeaTracker\Handler\SelectTeasHandler;
use TeaTracker\Service\TeaService;

class SelectTeasHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $service = $container->get(TeaService::class);

        return new SelectTeasHandler($service);
    }
}
