<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';

if (!empty($_POST)) {
    echo editCategory($_POST);
}

/**
 * Save changes to the category
 * @param  array   $categoryOptions
 * @return string
 */
function editCategory(array $categoryOptions): string
{
    $result = '';

    if (isFieldsEmpty([$categoryOptions['name'], $categoryOptions['slug']])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    }
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("UPDATE categories SET name = :name, slug = :slug, description = :description WHERE id = :id");

    $stmt->execute([
        'name'        => strip_tags($categoryOptions['name']),
        'slug'        => strip_tags($categoryOptions['slug']),
        'description' => strip_tags($categoryOptions['description'] ?? ''),
        'id'          => strip_tags($categoryOptions['categoryId']),
    ]);

    if (hasDBErrors($stmt->errorInfo())) {
        errorLogsDB(__FUNCTION__, $stmt->errorInfo());
    } else {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Категория обновлена']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
