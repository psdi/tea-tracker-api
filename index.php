<?php

require 'vendor/autoload.php';
require 'config/container.php';
require 'helper/emitter.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config');
$dotenv->load();

$response = (require 'config/routes.php')($request, $container);

emit($response);
