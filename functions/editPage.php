<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';

if (!empty($_POST)) {
    echo editPage($_POST);
}

/**
 * Save changes to the category
 * @param  array   $pageOptions
 * @return string
 */
function editPage(array $pageOptions): string
{
    $result = '';

    if (isFieldsEmpty([$pageOptions['name'], $pageOptions['slug']])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    }
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("UPDATE pages SET name = :name, slug = :slug, description = :description WHERE id = :id");

    $stmt->execute([
        'name'        => strip_tags($pageOptions['name']),
        'slug'        => strip_tags($pageOptions['slug']),
        'description' => htmlspecialchars_decode($pageOptions['description']),
        'id'          => strip_tags($pageOptions['pageId']),
    ]);

    if (hasDBErrors($stmt->errorInfo())) {
        errorLogsDB(__FUNCTION__, $stmt->errorInfo());
    } else {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Страница обновлена']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
