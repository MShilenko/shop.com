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

    $stmt = $dbConnect->query('SELECT name, id, price, new, sale FROM products WHERE active = 1');

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

/**
 * Get product properties for admin panel
 * @param  int    $categoryId
 * @return array $result
 */
function getProductPropertiesForAdminPanel(int $productId): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT name, price, image, sale, new FROM products
            WHERE id = :id'
    );

    $stmt->bindParam(':id', $productId, \PDO::PARAM_INT);
    $stmt->execute();

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row + ['categoriesIds' => getCategoriesIdsForProduct($productId)];
    }

    $dbConnect = null;

    return $result[0];
}

/**
 * Get Ids categories for a specific product
 * @param  int    $productId
 * @return array $result
 */
function getCategoriesIdsForProduct(int $productId): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT category_id FROM category_product
            WHERE product_id = :productId'
    );

    $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
    $stmt->execute();

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row['category_id'];
    }

    $dbConnect = null;

    return $result;
}

/**
 * Get the name of the image
 * @param  int    $productId
 * @return string $result
 */
function getImageName(int $productId): string
{
    $result    = '';
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT image FROM products
            WHERE id = :productId'
    );

    $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchColumn();

    $dbConnect = null;

    return $result;
}

/**
 * Compare the price with the minimum value
 * @param  int     $price
 * @return boolean
 */
function isLowPrice(int $price): bool
{
    return $price < getLowPrice();
}

/**
 * Get the final price of the goods
 * @param  int    $price
 * @return int
 */
function getTheFinalPrice(int $price): int
{
    return isLowPrice($price) ? $price + getDeliveryPrice() : $price;
}
