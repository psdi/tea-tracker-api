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

    public function fetchAll()
    {
        $query = "SELECT t.id, n.name, ty.id AS type_id,
            t.amount_in_grams, t.price, t.form_id,
            t.origin, t.is_empty, v.name AS vendor FROM tea t
            LEFT JOIN `name` n ON t.name_id = n.id
            LEFT JOIN `type` ty ON n.type_id = ty.id
            LEFT JOIN `order` o ON t.order_id = o.id
            LEFT JOIN vendor v ON o.vendor_id = v.id";
        
        $stmt = $this->pdo->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchPerPage($page)
    {
        $query = self::BASE_QUERY . ' LIMIT :items OFFSET :offset';

        $stmt = $this->pdo->prepare($query);
        $pageSize = self::PAGE_SIZE;
        $offset = $pageSize * ($page - 1);
        $stmt->bindParam(':items', $pageSize, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchById($id)
    {
        // todo
    }

    public function fetchWithParams($params)
    {
        // todo
    }
}

