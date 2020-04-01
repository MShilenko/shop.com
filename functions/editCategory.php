<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

if (isset($_POST)) {
    echo editCategory($_POST);
}

/**
 * @param  array   $categoryOptions
 * @return string $result
 */
function editCategory(array $categoryOptions): string
{
    $result = '';

    if (empty($categoryOptions['name']) || empty($categoryOptions['slug'])) {
        $result = [
            'status'  => 'error',
            'message' => 'Заполните поля',
        ];
    } else {
        $dbConnect = connectDB();

        $smtm = $dbConnect->prepare("UPDATE categories SET name = :name, slug = :slug, description = :description WHERE id = :id");

        if ($smtm->execute([
            'name'        => htmlspecialchars($categoryOptions['name']),
            'slug'        => htmlspecialchars($categoryOptions['slug']),
            'description' => htmlspecialchars($categoryOptions['description'] ?? ''),
            'id'          => htmlspecialchars($categoryOptions['categoryId']),
        ])) {
            $result = [
                'status'  => 'success',
                'message' => 'Категория обновлена',
            ];
        } else {
            $result = [
                'status'  => 'error',
                'message' => 'Произошла ошибка при сохранении',
            ];
        }

        $dbConnect = null;
    }

    return json_encode($result, JSON_UNESCAPED_UNICODE);
}
