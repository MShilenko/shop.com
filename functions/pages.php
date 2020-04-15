<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

/**
 * Get all pages
 * @return array $result
 */
function getAllPagesForAdminPanel(): array
{
    $result   = [];
    $isActive = 1;

    $dbConnect = connectDB();

    $stmt = $dbConnect->query("
        SELECT pages.id, pages.name, pages.slug, pages.description, users.email as user_email FROM pages
            INNER JOIN users ON pages.user_id = users.id
            WHERE active = $isActive
    ");

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result;
}

/**
 * Get page properties for admin panel
 * @param  int    $pageId
 * @return array $result
 */
function getPagePropertiesForAdminPanel(int $pageId): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT name, slug, description FROM pages
            WHERE id = :id'
    );

    $stmt->bindParam(':id', $pageId, \PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result[0];
}

/**
 * Prepare the description for admin
 * @param  string $description
 * @return string
 */
function prepareDescription(string $description): string
{
    return mb_strimwidth(strip_tags($description), 0, 50, "...");
}

/**
 * Get page id
 * @return integer $result
 */
function getpageId(): int
{
    foreach (getAllSlugs('pages') as $page) {
        $pageURL = '/' . $page . '/';
        if ($pageURL == parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) {
            return getIdBySlug($page, 'pages');
        }
    }

    return 0;
}

/**
 * Get page options
 * @param  int    $pageId
 * @return array $result
 */
function getPageOptionsForFront(int $pageId): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare('SELECT name, description FROM pages WHERE id = :pageId');

    $stmt->bindParam(':pageId', $pageId, \PDO::PARAM_INT);
    $stmt->execute();

    foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $result[] = $row;
    }

    $dbConnect = null;

    return $result[0];
}

/**
 * Check whether the main page
 * @return boolean
 */
function isMain(): bool
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/';
}

/**
 * Check whether the delivery page
 * @return boolean
 */
function isDelivery(): bool
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/delivery/';
}

/**
 * Replace information for the delivery page
 * @param  string $description
 * @return string
 */
function replaceDeliveryInformation(string $description): string
{
    return str_replace(
        ['<!--delivery_price-->', '<!--low_price-->', '<!--two_delivery_price-->'],
        [getDeliveryPrice(), getLowPrice(), getDeliveryPrice() * 2],
        $description
    );
}
