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
    $allowedTablesNames = ['products', 'categories'];

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
 * @param  int $categoryId
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
    $query = preg_replace('#SELECT.*FROM#', 'SELECT COUNT(*) FROM', $query);

    $stmt = $dbConnect->query($query);

    $dbConnect = null;

    return $stmt->fetchColumn();
}