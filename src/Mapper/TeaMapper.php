<?php

namespace TeaTracker\Mapper;

use PDO;

class TeaMapper
{
    private const BASE_QUERY = <<<EOT
        SELECT t.id, n.name, ty.id AS type_id,
        t.amount_in_grams, t.price, t.form_id,
        t.origin, t.is_empty, v.name AS vendor FROM tea t
        LEFT JOIN `name` n ON t.name_id = n.id
        LEFT JOIN `type` ty ON n.type_id = ty.id
        LEFT JOIN `order` o ON t.order_id = o.id
        LEFT JOIN vendor v ON o.vendor_id = v.id
EOT;

    private const PAGE_SIZE = 25;

    public function __construct(
        private PDO $pdo
    ) {}

    public function fetchAll($sortOrder = 'asc')
    {
        $stmt = $this->pdo->query(
            self::BASE_QUERY . " ORDER BY t.id $sortOrder"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchById($id)
    {
        $query = self::BASE_QUERY . ' WHERE t.id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchByParams(array $params = [], int $page = null, string $sortOrder = 'asc')
    {
        $query = self::BASE_QUERY;

        if (count($params)) {
            $conditions = array_map(
                function ($key) {
                    return match ($key) {
                        'order_id' => 'o.id = :order_id',
                        'vendor_id' => 'v.id = :vendor_id',
                        'type_id' => 'ty.id = :type_id',
                    };
                },
                array_keys($params),
            );

            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        if (isset($sortOrder)) {
            $query .= " ORDER BY t.id $sortOrder";
        }

        if (isset($page)) {
            $query .= ' LIMIT :items OFFSET :offset';
        }

        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if (isset($page)) {
            $pageSize = self::PAGE_SIZE;
            $offset = $pageSize * ($page - 1);
            $stmt->bindParam(':items', $pageSize, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

