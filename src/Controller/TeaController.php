<?php

namespace TeaTracker\Controller;

use Laminas\Diactoros\Response\JsonResponse;
use TeaTracker\Controller\Controller;
use TeaTracker\Mapper\TeaMapper;
use TeaTracker\Sanitizer;

class TeaController extends Controller
{
    public function __construct(
        private TeaMapper $teaMapper,
        private Sanitizer $sanitizer,
    ) {}

    public function select()
    {
        $id = $this->request->getAttribute('id');
        $queryParams = $this->request->getQueryParams();
    
        if (isset($id)) {
            $id = $this->sanitizer->filter('id', $id);
        }

        $page = $queryParams['page'] ?? null;
        if (isset($page) && is_numeric($page)) {
            $page = $this->sanitizer->filter('page', (int) $page);
            unset($queryParams['page']);
        }

        $queryParams = array_filter(
            $queryParams,
            function ($value, $key) {
                return $this->sanitizer->filter("tea.$key", $value);
            },
            ARRAY_FILTER_USE_BOTH
        );

        $data = match (true) {
            !is_null($id) => $this->teaMapper->fetchById($id),
            !is_null($page) => $this->teaMapper->fetchPerPage($page),
            count($queryParams) => $this->teaMapper->fetchByParams($queryParams),
            default => $this->teaMapper->fetchAll(),
        };

        return new JsonResponse($data);
    }

    public function insert($data)
    {
        // todo
    }
}

