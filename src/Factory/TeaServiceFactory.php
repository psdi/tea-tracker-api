<?php

namespace TeaTracker\Factory;

use PDO;
use Psr\Container\ContainerInterface;
use TeaTracker\Service\TeaService;

class TeaServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $pdo = $container->get(PDO::class);

        return new TeaService($pdo);
    }
}
