<?php

namespace functions;

/**
 * Get pagination limit
 * @param string $tableName
 * @return int $result
 */
function getPaginationLimit(string $tableName): int
{
    $result = 0;

    if (isset($_GET['page'])) {
        $offset = getPaginationOffset() * ($_GET['page'] - 1);

        if ($offset < getTableRowCount($tableName)) {
            $result = $offset;
        }
    }

    return $result;
}

/**
 * Get the offset for pagination
 * @return int $result
 */
function getPaginationOffset(): int
{
    $result    = '';
    $dbConnect = connectDB();

    $stmt = $dbConnect->query('SELECT products_per_page FROM settings');

    $result = $stmt->fetchColumn();

    $dbConnect = null;

    return $result;
}

/**
 * Get table row count
 * @param string $tableName
 * @return int $result
 */
function getTableRowCount(string $tableName): int
{
    $result             = [];
    $allowedTablesNames = ['products', 'categories'];

    if (in_array($tableName, $allowedTablesNames)) {
        $result    = '';
        $dbConnect = connectDB();

        $stmt = $dbConnect->prepare("SELECT COUNT(*) FROM $tableName");
        $stmt->execute();

        $result = $stmt->fetchColumn();

        $dbConnect = null;
    }

    return $result;
}

/**
 * Check if a pagination block is needed
 * @param  string  $tableName
 * @return boolean
 */
function hasPagination(string $tableName): bool
{
    return getPaginationOffset() < getTableRowCount($tableName);
}

/**
 * Print the pagination pattern
 * @param  string $tableName [description]
 */
function getPagination(string $tableName)
{
    $rows = intdiv(getTableRowCount($tableName), getPaginationOffset());
    $rows = getTableRowCount($tableName) % getPaginationOffset() ? $rows + 1 : $rows;

    include $_SERVER['DOCUMENT_ROOT'] . '/templates/pagination.php';
}