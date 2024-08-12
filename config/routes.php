<?php

return function ($request, $container) {
    $serverParams = $request->getServerParams();

    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
        $r->addRoute(
            'GET',
            '/teas[/{id:\d+}]',
            [
                TeaTracker\Controller\TeaController::class,
                'select'
            ]
        );

        $r->addRoute(
            'POST',
            '/teas',
            [
                TeaTracker\Controller\TeaController::class,
                'insert'
            ]
        );
    });
    
    $httpMethod = $serverParams['REQUEST_METHOD'];
    $uri = $serverParams['REQUEST_URI'];
    
    // Strip query string (?foo=bar) and decode URI
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);
    
    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            // ... 404 Not Found
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            // ... 405 Method Not Allowed
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1][0];
            $method = $routeInfo[1][1];
            $vars = $routeInfo[2];
            
            foreach ($vars as $key => $value) {
                $request = $request->withAttribute($key, $value);
            }

            $controller = $container->get($handler);
            $controller->setRequest($request);

            $response = call_user_func([$controller, $method], $request);
            break;
    }

    return $response;
};
