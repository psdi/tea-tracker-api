<?php

namespace TeaTracker\Service;

use PDO;

class TeaService
{
    private const BASE_QUERY = '';

    public function __construct(
        private PDO $pdo
    ) {}

    public function selectOne($id)
    {
        $query = "SELECT t.id, t.name AS tea_name, t.type_id,
            oi.amount_in_grams, oi.price_paid, oi.form_id,
            oi.origin, oi.is_empty, v.name FROM tea t
            INNER JOIN order_item oi ON t.id = oi.tea_id
            INNER JOIN `order` o ON oi.order_id = o.id
            INNER JOIN vendor v ON o.vendor_id = v.id
            WHERE t.id = :id";

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
