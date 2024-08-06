<?php

namespace TeaTracker\Controller;

use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
    protected ServerRequestInterface $request;

    public function __construct() {}

    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }
}

