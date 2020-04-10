<?php

namespace functions;

/**
 * Get pagination limit
 * @param int $rowsCount
 * @return int $result
 */
function getPaginationLimit(string $rowsCount): int
{
    $result = 0;

    if (isset($_GET['page'])) {
        $offset = getPaginationOffset() * ($_GET['page'] - 1);

        if ($offset < $rowsCount) {
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
function getTablerowsCount(string $tableName): int
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
 * Get properties for pagination
 * @param  int $rowsCount
 * @return [type] [description]
 */
function getPaginationQuery(int $rowsCount): string
{
    $paginationLimit  = getPaginationLimit($rowsCount);
    $paginationOffset = getPaginationOffset();

    return " LIMIT $paginationLimit, $paginationOffset";
}

/**
 * Check if a pagination block is needed
 * @param  int $rowsCount
 * @return boolean
 */
function hasPagination(int $rowsCount): bool
{
    return getPaginationOffset() < $rowsCount;
}

/**
 * Print the pagination pattern
 * @param  int $rowsCount
 */
function getPagination(int $rowsCount)
{
    $rows = intdiv($rowsCount, getPaginationOffset());
    $rows = $rowsCount % getPaginationOffset() ? $rows + 1 : $rows;

    include $_SERVER['DOCUMENT_ROOT'] . '/templates/pagination.php';
}
