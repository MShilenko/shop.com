<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/pagination.php';

/**
 * Get all products for admin panel
 * @return array $result
 */
function getAllProductsForAdminPanel(): array
{
    $result   = [];
    $isActive = 1;
    $query    = "SELECT name, id, price, new, sale FROM products WHERE active = $isActive ORDER BY id DESC";

    $result['count'] = getQueryRowsCount($query);

    if (hasPagination($result['count'])) {
        $query .= getPaginationQuery($result['count']);
    }

    $dbConnect = connectDB();

    $stmt = $dbConnect->query($query);

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result['items'][] = $row + ['categories' => implode(", ", getCategoiresNamesForCurrrentProduct($row['id']))];
    }

    $dbConnect = null;

    return $result;
}

/**
 * Get all products for frontend
 * @return array $result
 */
function getAllProductsForFrontend(): array
{
    $result   = [];
    $isActive = 1;
    $query    = "SELECT products.name, products.id, products.price, products.image FROM products WHERE products.active = $isActive";

    if (hasFilterParameters()) {
        $query .= getFilterQuery();
    }

    if (isset($_GET['sort_q'])) {
        $query .= getOrderQuery($_GET['sort_d'], $_GET['sort_q']);
    }

    $result['count'] = getQueryRowsCount($query);

    if (hasPagination($result['count'])) {
        $query .= getPaginationQuery($result['count']);
    }

    $dbConnect = connectDB();

    $stmt = $dbConnect->query($query);

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result['items'][] = $row;
    }

    $dbConnect = null;

    return $result;
}

/**
 * Get all products for category
 * @param integer $categoryId
 * @return array $result
 */
function getAllProductsForCategory(int $categoryId): array
{
    $result   = [];
    $isActive = 1;
    $query    = "SELECT products.name, products.id, products.price, products.image FROM products
                    INNER JOIN category_product ON category_product.product_id = products.id
                    WHERE category_product.category_id = $categoryId
                    AND products.active = $isActive";

    if (hasFilterParameters()) {
        $query .= getFilterQuery();
    }                    

    if (isset($_GET['sort_q'])) {
        $query .= getOrderQuery($_GET['sort_d'], $_GET['sort_q']);
    }

    $result['count'] = getQueryRowsCount($query);

    if (hasPagination($result['count'])) {
        $query .= getPaginationQuery($result['count']);
    }

    $dbConnect = connectDB();

    $stmt = $dbConnect->query($query);

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result['items'][] = $row;
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

/**
 * Get the price range for products
 * @return array $result
 */
function getProductsRange(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->query('SELECT MIN(price) as min_price, MAX(price) as max_price FROM products');

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row;
    }

    $dbConnect = null;

    return $result[0];
}
