<?php

namespace TeaTracker\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use TeaTracker\Controller\Controller;
use TeaTracker\Mapper\TeaMapper;

class TeaController extends Controller
{
    public function __construct(
        private TeaMapper $teaMapper
    ) {}

    public function select()
    {
        $id = $this->request->getAttribute('id');
        $page = $this->request->getAttribute('page');
        
        $data = $this->teaMapper->fetchAll();

        return new JsonResponse($data);
    }
}

