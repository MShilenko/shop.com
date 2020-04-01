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

    $smtm = $dbConnect->query(
        'SELECT cat.id, cat.name, cat.slug, cat.description, users.email as user_email FROM categories as cat
            INNER JOIN users ON cat.user_id = users.id'
    );

    $result = $smtm->fetchAll(\PDO::FETCH_ASSOC);

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

    $smtm = $dbConnect->prepare(
        'SELECT name, slug, description FROM categories
            WHERE id = :id'
    );

    $smtm->bindParam(':id', $categoryId, \PDO::PARAM_INT);
    $smtm->execute();

    $result = $smtm->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result[0];
}

/**
 * Get id of all categories
 * @return array $result
 */
function getAllCategoriesIds(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $smtm = $dbConnect->query('SELECT id FROM categories');

    foreach ($smtm->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row['id'];
    }

    $dbConnect = null;

    return $result;
}

/**
 * Check if a category exists
 * @param  int $categoryId
 * @return boolean
 */
function issetCategory(int $categoryId): bool
{
    return in_array($categoryId, getAllCategoriesIds());
}
