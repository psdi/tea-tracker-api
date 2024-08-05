<?php

namespace TeaTracker;

use PDO;

class PdoFactory
{
    private const DSN_PREFIX = 'mysql';

    public function __invoke()
    {
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s',
            self::DSN_PREFIX,
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_NAME']
        );

        $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
