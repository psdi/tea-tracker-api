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
        $queryParams = $this->request->getQueryParams();
    
        $page = $queryParams['page'] ?? null;
        if (!is_null($page) && is_numeric($page)) {
            $page = (int) $page;
            unset($queryParams['page']);
        }

        $data = [];

        $data = match (true) {
            !is_null($id) => $this->teaMapper->fetchById($id),
            !is_null($page) => $this->teaMapper->fetchPerPage($page),
            //count($queryParams) => $this->teaMapper->fetchByParam(),
            default => $this->teaMapper->fetchAll(),
        };

        return new JsonResponse($data);
    }

    public function insert($data)
    {
        // todo
    }
}

