<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';

session_start();

if (isset($_POST)) {
    echo addPage($_POST, $_SESSION['userId']);
}

/**
 * @param  array   $pageOptions
 * @param  integer  $userId
 * @return string
 */
function addPage(array $pageOptions, int $userId): string
{
    if (isFieldsEmpty([$pageOptions['name'], $pageOptions['slug'], $pageOptions['description']])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    }

    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("
        INSERT INTO pages (name, slug, description, user_id)
            VALUES (:name, :slug, :description, :id)"
    );

    $stmt->execute([
        'name'        => strip_tags($pageOptions['name']),
        'slug'        => strip_tags($pageOptions['slug']),
        'description' => htmlspecialchars_decode($pageOptions['description']),
        'id'          => $userId,
    ]);

    if (hasDBErrors($stmt->errorInfo())) {
        errorLogsDB(__FUNCTION__, $stmt->errorInfo());
    } else {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Страница добавлена']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
