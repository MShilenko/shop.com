<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

session_start();

if (isset($_POST)) {
    echo addCategory($_POST, $_SESSION['userId']);
}

/**
 * @param  array   $categoryOptions
 * @param  int   $userId
 * @return string $result
 */
function addCategory(array $categoryOptions, int $userId): string
{
    $result = '';

    if (empty($categoryOptions['name']) || empty($categoryOptions['slug'])) {
        $result = [
            'status' => 'error',
            'message' => 'Заполните поля',
        ];
    } else {
        $dbConnect = connectDB();

        $smtm = $dbConnect->prepare("
            INSERT INTO categories (name, slug, description, user_id)
                VALUES (:name, :slug, :description, :user_id)"
        );

        if ($smtm->execute([
            'name'        => htmlspecialchars($categoryOptions['name']),
            'slug'        => htmlspecialchars($categoryOptions['slug']),
            'description' => htmlspecialchars($categoryOptions['description'] ?? ''),
            'user_id'     => $userId,
        ])) {
            $result = [
                'status' => 'success',
                'message' => 'Категория добавлена',
            ];
        } else {
            $result = [
                'status' => 'error',
                'message' => 'Произошла ошибка при сохранении',
            ];
        }

        $dbConnect = null;
    }

    return json_encode($result, JSON_UNESCAPED_UNICODE);
}
