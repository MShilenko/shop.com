<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

/**
 * Get all categories for admin panel
 * @return array $result
 */
function getAllCategoriesForAdminPanel(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->query(
        'SELECT cat.id, cat.name, cat.slug, cat.description, users.email as user_email FROM categories AS cat
            INNER JOIN users ON cat.user_id = users.id'
    );

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result;
}

/**
 * Get category properties for admin panel
 * @param  int    $categoryId
 * @return array $result
 */
function getCategoryPropertiesForAdminPanel(int $categoryId): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT name, slug, description FROM categories
            WHERE id = :id'
    );

    $stmt->bindParam(':id', $categoryId, \PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result[0];
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
 * Get slugs for all categories
 * @return array $result
 */
function getAllCategoriesSlugs(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->query('SELECT slug FROM categories');

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row['slug'];
    }

    $dbConnect = null;

    return $result;
}

/**
 * Get category id
 * @return integer $result
 */
function getCategoryId(): int
{
    foreach (getAllCategoriesSlugs() as $category) {
        $categoryURL = PRODUCTS_CATEGORIES_PATH . $category . '/';
        if ($categoryURL == parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) {
            return getCategoryIdFromSlug($category);
        }
    }

    return 0;
}

/**
 * Get category id by slug
 * @param  string $categorySlug
 * @return integer $result
 */
function getCategoryIdFromSlug(string $categorySlug): int
{
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare('SELECT id FROM categories WHERE slug = :slug');

    $stmt->bindParam(':slug', $categorySlug, \PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchColumn();

    $dbConnect = null;

    return $result;
}

/**
 * Get category options
 * @param  int    $categoryId [description]
 * @return array $result
 */
function getCategoryOptionsForFront(int $categoryId): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare('SELECT name, description FROM categories WHERE id = :categoryId');

    $stmt->bindParam(':categoryId', $categoryId, \PDO::PARAM_INT);
    $stmt->execute();

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row;
    }

    $dbConnect = null;

    return $result[0];
}


/**
 * Get category options for menu
 * @return array $result
 */
function getCategoriesMenu(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->query('SELECT name, slug FROM categories');

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result;
}