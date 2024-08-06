<?php

namespace TeaTracker\Factory;

use PDO;
use Psr\Container\ContainerInterface;
use TeaTracker\Mapper\TeaMapper;

class TeaMapperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $pdo = $container->get(PDO::class);

        return new TeaMapper($pdo);
    }
}
