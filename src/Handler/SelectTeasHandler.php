<?php

namespace TeaTracker\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use TeaTracker\Service\TeaService;

class SelectTeasHandler
{
    public function __construct(
        private TeaService $service
    ) {}

    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $data = $this->service->selectOne($id);

        return new JsonResponse($data);
    }
}
