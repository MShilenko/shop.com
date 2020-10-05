<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

/**
 * Get all orders for admin panel
 * @return array $result
 */
function getAllOrdersForAdminPanel(): array
{
    $result     = [];
    $dbConnect  = connectDB();

    $stmt = $dbConnect->query(
        'SELECT ord.id, CONCAT(ord.customer_surname, " ",ord.customer_name, " ", ord.customer_thirdname) AS customer, ord.customer_email, ord.customer_phone, ord.delivery, ord.payment, ord.comment, CONCAT("г. ", ord.city, ", ул. ", ord.street, ", д. ", ord.house, ", кв. ", ord.apartment) AS address, ord.processed, products.price AS product_price
            FROM orders AS ord 
            INNER JOIN products ON ord.product_id = products.id
            ORDER BY processed, id DESC'
    );

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result;
}