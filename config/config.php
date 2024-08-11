<?php

return [
    'sanitizer.collection' => [
        'general' => [
            'page' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => [],
            ],
            'id' => [
                'filter' => FILTER_SANITIZE_NUMBER_INT,
                'options' => [
                    'default' => -999,
                ],
            ],
            'sort_by' => [
                'filter' => FILTER_CALLBACK,
                'options' => [
                    'options' => function ($str) {
                        return in_array(strtolower($str), ['asc', 'desc'])
                            ? strtolower($str)
                            : false;
                    }
                ],
            ],
        ],
        'tea' => [
            'order_id' => [
                'filter' => FILTER_DEFAULT,
            ],
            'type_id' => [
                'filter' => FILTER_DEFAULT,
            ],
            'name_id' => [
                'filter' => FILTER_DEFAULT,
            ],
        ],
    ],
];

