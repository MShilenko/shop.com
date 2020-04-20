<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';

session_start();

if (isset($_POST)) {
    echo addCategory($_POST, $_SESSION['userId']);
}

/**
 * @param  array   $categoryOptions
 * @param  int   $userId
 * @return string
 */
function addCategory(array $categoryOptions, int $userId): string
{
    if (isFieldsEmpty([$categoryOptions['name'], $categoryOptions['slug']])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    }

    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("
        INSERT INTO categories (name, slug, description, user_id)
            VALUES (:name, :slug, :description, :user_id)"
    );

    $stmt->execute([
        'name'        => strip_tags($categoryOptions['name']),
        'slug'        => strip_tags($categoryOptions['slug']),
        'description' => strip_tags($categoryOptions['description'] ?? ''),
        'user_id'     => $userId,
    ]);

    if (hasDBErrors($stmt->errorInfo())) {
        errorLogsDB(__FUNCTION__, $stmt->errorInfo());
    } else {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Категория добавлена']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
