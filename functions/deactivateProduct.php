<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

if ($productID = (int) file_get_contents('php://input')){
    deactivateProduct($productID);
}

/**
 * Deactivate the product
 * @param  int    $productID [description]
 */
function deactivateProduct(int $productID)
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("UPDATE products SET active = 0 WHERE id = :productID");

    $stmt->bindParam(':productID', $productID, \PDO::PARAM_INT);
    $stmt->execute();

    $dbConnect = null;

}