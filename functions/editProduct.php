<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/include/constants.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/products.php';
session_start();

if (isset($_POST)) {
    echo editProduct($_POST, $_SESSION['userId'], $_FILES['product-photo'] ?? []);
}

/**
 * Save changes to the product
 * @param  array   $productOptions
 * @param  int   $userId
 * @param  array   $image
 * @return string
 */
function editProduct(array $productOptions, int $userId, array $image = []): string
{
    $result = '';

    if (isFieldsEmpty([$productOptions['product-name'], $productOptions['product-price']])) {
        if (!is_numeric($productOptions['product-price'])) {
            return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля. Цена должна быть числом.']);
        }

        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    } else {
        if ($image['size'] > 0) {
            $uploadImage = uploadImage($image);

            if ($uploadImage['status'] == 'error') {
                return $result = setJSONStatus(['status' => 'error', 'message' => $uploadImage['status']]);
            }
        }

        $dbConnect = connectDB();

        $productNew  = $productOptions['new'] ?? 0;
        $productSale = $productOptions['sale'] ?? 0;
        $imageName   = $image['name'] ?? getImageName($productOptions['productId']);

        $stmt = $dbConnect->prepare("
            UPDATE products SET name = :name, price = :price, image = :image, new = :new, sale = :sale, user_id = :user_id WHERE id = :productId"
        );

        $stmt->bindParam(':name', $productOptions['product-name'], \PDO::PARAM_STR);
        $stmt->bindParam(':price', $productOptions['product-price'], \PDO::PARAM_INT);
        $stmt->bindParam(':new', $productNew, \PDO::PARAM_INT);
        $stmt->bindParam(':sale', $productSale, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productOptions['productId'], \PDO::PARAM_INT);
        $stmt->bindParam(':image', $imageName, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            $dbConnect = null;

            if (isset($productOptions['categories'])) {
                editCategoriesForProduct($productOptions['categories'], $productOptions['productId']);
            }

            return setJSONStatus(['status' => 'success', 'message' => 'Товар успешно обновлен']);
        }

        $dbConnect = null;
        return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
    }
}

/**
 * Edit categories for a new product
 * @param array $categories
 * @param int   $productId
 */
function editCategoriesForProduct(array $categories, int $productId)
{
    $categoriesIds = getCategoriesIdsForProduct($productId);
    $oldCategories = [];
    $dbConnect     = connectDB();

    $stmt = $dbConnect->prepare("
        INSERT INTO category_product (category_id, product_id)
            VALUES (:categoryId, :productId)"
    );

    $stmt->bindParam(':categoryId', $categoryId);
    $stmt->bindParam(':productId', $productId);

    foreach ($categories as $category) {
        if (!in_array($category, $categoriesIds)) {
            $categoryId = $category;
            $stmt->execute();
        }
    }

    $dbConnect = null;

    $oldCategories = array_diff($categoriesIds, $categories);

    if (!empty($oldCategories)) {
        removeBindingToOldCategories($oldCategories, $productId);
    }

}

/**
 * Remove binding to old categories
 * @param  array  $categories
 * @param  int  $productId
 */
function removeBindingToOldCategories(array $categories, int $productId)
{
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("
        DELETE FROM category_product
        WHERE category_id = :categoryId AND product_id = :productId"
    );

    $stmt->bindParam(':categoryId', $categoryId);
    $stmt->bindParam(':productId', $productId);

    foreach ($categories as $category) {
        $categoryId = $category;
        $stmt->execute();
    }

    $dbConnect = null;
}
