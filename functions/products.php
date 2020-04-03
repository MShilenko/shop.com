<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

/**
 * Get all products for admin panel
 * @return array $result
 */
function getAllProductsForAdminPanel(): array
{
    $result     = [];
    $categories = [];
    $dbConnect  = connectDB();

    $stmt = $dbConnect->query(
        'SELECT products.name, products.id, products.price, products.new, products.sale FROM products
            WHERE products.active = 1'
    );

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row + ['categories' => implode(", ", getCategoiresNamesForCurrrentProduct($row['id']))];
    }

    $dbConnect = null;

    return $result;
}

/**
 * Get categories names for a specific product
 * @param  int    $productId
 * @return array $result
 */
function getCategoiresNamesForCurrrentProduct(int $productId): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT categories.name FROM categories
            INNER JOIN category_product ON categories.id = category_product.category_id
            AND category_product.product_id = :productId'
    );

    $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
    $stmt->execute();

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row['name'];
    }

    $dbConnect = null;

    return $result;
}

/**
 * Receive category data for the form
 * @return array $result
 */
function getCategoiresDataForTheForm(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->query('SELECT id, name FROM categories');

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[$row['id']] = $row['name'];
    }

    $dbConnect = null;

    return $result;
}
