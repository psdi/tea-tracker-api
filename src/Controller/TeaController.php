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

        $sortOrder = $queryParams['sort_by'] ?? null;
        if (isset($sortOrder)) {
            $sortOrder = $this->sanitizer->filter('sort_by', $sortOrder);
            unset($queryParams['sort_by']);
        }

        $queryParams = array_filter(
            $queryParams,
            function ($value, $key) {
                return $this->sanitizer->filter("tea.$key", $value);
            },
            ARRAY_FILTER_USE_BOTH
        );

        $data = match (true) {
            isset($id) => $this->teaMapper->fetchById($id),
            isset($page) || (bool) count($queryParams) =>
                $this->teaMapper->fetchByParams(
                    params: $queryParams,
                    sortOrder: $sortOrder,
                    page: $page,
                ),
            default => $this->teaMapper->fetchAll($sortOrder),
        };

        return new JsonResponse($data);
    }

    public function insert()
    {
        $data = json_decode($this->request->getBody()->getContents(), true);

        return new JsonResponse(
            [],
            201,
            [
                'Location: /teas/id',
            ]
        );
    }
}

