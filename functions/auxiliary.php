<?php

namespace functions;

/**
 * Check for being in the administrative directory
 * @return boolean
 */
function isAdminFolder(): bool
{
    return preg_match('#^/admin.*#', $_SERVER['REQUEST_URI']);
}

/**
 * Checking fields for void
 * @param array $fields
 * @return boolean
 */
function isFieldsEmpty(array $fields): bool
{
    return in_array('', $fields);
}

/**
 * Сheck file type
 * @param  string $imageType
 * @return boolean
 */
function isCorrectFileType(string $imageName): bool
{
    $additionalsTypes = explode(',', ALLOWED_FILE_TYPES);
    $fileType         = mime_content_type($imageName);

    return in_array($fileType, $additionalsTypes);
}

/**
 * Check file size
 * @param  int $imageSize
 * @return boolean
 */
function isCorrectFileSize(string $imageName): bool
{
    return filesize($imageName) <= ALLOWED_FILE_SIZE;
}

/**
 * Check file
 * @param  string $imageName
 * @return array $result
 */
function checkFile(string $imageName): array
{
    $result  = [];
    $message = [];

    if (!isCorrectFileType($imageName)) {
        $message[] = 'Неверный тип файла или содержимое не соответствут заданному типу. Загрузить можно image/jpeg, image/png.';
    }

    if (!isCorrectFileSize($imageName)) {
        $message[] = 'Слишком большой размер файла. Максимльный размер файла 5Mb.';
    }

    $result['message'] = implode(' ', $message);
    $result['status']  = isCorrectFileType($imageName) && isCorrectFileSize($imageName);

    return $result;
}

/**
 * Upload image
 * @param  array $image
 * @return array $result
 */
function uploadImage(array $image): array
{
    $result     = [];
    $uploadPath = PRODUCTS_UPLOAD_FOLDER;

    $checkFile = checkFile($image['tmp_name']);

    if (!$checkFile['status']) {
        return $result = [
            'status'  => 'error',
            'message' => $image['name'] . ' - ' . $checkFile['message'],
        ];
    }

    if (move_uploaded_file($image['tmp_name'], $uploadPath . $image['name'])) {
        return $result = [
            'status'  => 'success',
            'message' => 'Изображение ' . $image['name'] . ' загружено.',
        ];
    }

    return $result = [
        'error'   => 'success',
        'message' => 'Изображение загрузить не удалось.',
    ];
}

/**
 * Convert array to json string
 * @param  array  $status
 * @return string
 */
function setJSONStatus(array $status): string
{
    return json_encode($status, JSON_UNESCAPED_UNICODE);
}

/**
 * Get all Ids from a specific table
 * @param  string $tableName
 * @return array $result
 */
function getAllIdsFromTable(string $tableName): array
{
    $result             = [];
    $allowedTablesNames = explode(", ", ALLOWED_TABLES_NAMES);

    if (in_array($tableName, $allowedTablesNames)) {
        $dbConnect = connectDB();

        $stmt = $dbConnect->prepare("SELECT id FROM $tableName");
        $stmt->execute();

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $result[] = $row['id'];
        }

        $dbConnect = null;
    }

    return $result;
}

/**
 * Сheck if there is a record in the database
 * @param  int $recordId
 * @param  string $tableName
 * @return boolean
 */
function issetRecord(int $recordId, string $tableName): bool
{
    return in_array($recordId, getAllIdsFromTable($tableName));
}

/**
 * Get the number of query lines
 * @param  string $query
 * @return integer
 */
function getQueryRowsCount(string $query): int
{

    $dbConnect = connectDB();
    $query     = preg_replace('#SELECT.*FROM#', 'SELECT COUNT(*) FROM', $query);

    $stmt = $dbConnect->query($query);

    $dbConnect = null;

    return $stmt->fetchColumn();
}

/**
 * the word in the correct case
 * @param  int    $count
 * @return string
 */
function getEnding(int $count): string
{
    $end           = 'ь';
    $lastNumber    = substr($count, -1);
    $lastTwoNumber = substr($count, -2);

    if (($lastTwoNumber > 10 && $lastTwoNumber < 15) || ($lastNumber >= 5 && $lastNumber <= 9) || ($lastNumber == 0)) {
        $end = 'ей';
    } elseif ($lastNumber >= 2 && $lastNumber <= 4) {
        $end = 'и';
    }

    return "модел" . $end;
}

/**
 * Get order query
 * @param  string $directing
 * @param  string $column
 * @return string $result
 */
function getOrderQuery(string $directing, string $column): string
{
    $result          = '';
    $allowDirections = ['asc', 'desc'];
    $allowСolumns   = ['name', 'price'];

    if (in_array($directing, $allowDirections) && in_array($column, $allowСolumns)) {
        $result = " ORDER BY $column $directing";
    }

    return $result;
}

/**
 * Check for filtering options
 * @return boolean
 */
function hasFilterParameters(): bool
{
    $filterParameters = [
        'minPrice',
        'maxPrice',
        'new',
        'sale',
    ];

    return array_intersect($filterParameters, array_keys($_GET)) ? true : false;
}

/**
 * Prepare the query string for the filter
 * @return string $result
 */
function getFilterQuery(): string
{
    $isActive = 1;
    $result   = '';

    if (isset($_GET['minPrice']) && isset($_GET['maxPrice'])) {
        $result .= ' AND (price BETWEEN ' . (int) $_GET['minPrice'] . ' AND ' . (int) $_GET['maxPrice'] . ')';
    }

    $result .= isset($_GET['new']) && $_GET['new'] == 'on' ? " AND new = $isActive" : "";
    $result .= isset($_GET['sale']) && $_GET['sale'] == 'on' ? " AND sale = $isActive" : "";

    return $result;
}

/**
 * Get all slugs from table
 * @param  string $tableName
 * @return array $result
 */
function getAllSlugs(string $tableName): array
{
    $result             = [];
    $allowedTablesNames = explode(", ", ALLOWED_TABLES_NAMES);

    if (in_array($tableName, $allowedTablesNames)) {
        $dbConnect = connectDB();

        $stmt = $dbConnect->query('SELECT slug FROM ' . $tableName);

        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $result[] = $row['slug'];
        }

        $dbConnect = null;
    }

    return $result;
}

/**
 * Get id by slug
 * @param  string $categorySlug
 * @param  string $tableName
 * @return integer $result
 */
function getIdBySlug(string $categorySlug, string $tableName): int
{
    $dbConnect          = connectDB();
    $result             = [];
    $allowedTablesNames = explode(", ", ALLOWED_TABLES_NAMES);

    if (in_array($tableName, $allowedTablesNames)) {
        $stmt = $dbConnect->prepare("SELECT id FROM $tableName WHERE slug = :slug");

        $stmt->bindParam(':slug', $categorySlug, \PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetchColumn();

        $dbConnect = null;
    }

    return $result;
}

/**
 * Check for errors when saving to the database
 * @return boolean
 */
function hasDBErrors(array $error): bool
{
    return $error[0] !== "00000";
}

/**
 * Write error logs
 * @param  string $functionName
 * @param  array  $error
 */
function errorLogsDB(string $functionName,  array $error)
{
    $file    = $_SERVER['DOCUMENT_ROOT'] . 'include/error_log.txt';
    $current = file_get_contents($file);
    $current .= date('d.m.Y G:i:s') . ' | ' . $functionName . ' | ' . json_encode($error) . PHP_EOL;
    file_put_contents($file, $current);
}
