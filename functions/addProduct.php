<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/constants.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';

session_start();

if (isset($_POST) && isset($_FILES)) {
    echo addProduct($_POST, $_FILES['product-photo'], $_SESSION['userId']);
}

/**
 * Add product to the database
 * @param  array   $productOptions
 * @param  array   $image
 * @param  int   $userId
 * @return string
 */
function addProduct(array $productOptions, array $image, int $userId): string
{
    if (!is_numeric($productOptions['product-price']) || $productOptions['product-price'] == 0) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поле Цена корректно.']);
    }

    if (isFieldsEmpty([$productOptions['product-name'], $productOptions['product-price'], $image['tmp_name']])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    } else {
        $uploadImage = uploadImage($image);

        if ($uploadImage['status'] == 'error') {
            return $result = setJSONStatus(['status' => 'error', 'message' => $uploadImage['status']]);
        }

        $dbConnect = connectDB();

        $stmt = $dbConnect->prepare("
            INSERT INTO products (name, price, image, new, sale, user_id)
                VALUES (:name, :price, :image, :new, :sale, :user_id)"
        );

        if ($stmt->execute([
            'name'    => htmlspecialchars($productOptions['product-name']),
            'price'   => htmlspecialchars((int) $productOptions['product-price']),
            'image'   => htmlspecialchars($image['name']),
            'new'     => htmlspecialchars($productOptions['new'] ?? 0),
            'sale'    => htmlspecialchars($productOptions['sale'] ?? 0),
            'user_id' => $userId,
        ])) {
            $newProductId = $dbConnect->lastInsertId();
            $dbConnect    = null;

            if (isset($productOptions['categories'])) {
                addCategoriesForProduct($productOptions['categories'], $newProductId);
            }

            return setJSONStatus(['status' => 'success', 'message' => 'Товар успешно добавлен']);
        }

        $dbConnect = null;
        return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
    }
}

/**
 * Add categories for a new product
 * @param array $categories
 * @param int   $productId
 */
function addCategoriesForProduct(array $categories, int $productId)
{
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("
        INSERT INTO category_product (category_id, product_id)
            VALUES (:categoryId, :productId)"
    );

    $stmt->bindParam(':categoryId', $categoryId);
    $stmt->bindParam(':productId', $productId);

    foreach ($categories as $category) {
        $categoryId = $category;
        $stmt->execute();
    }

    $dbConnect = null;
}
