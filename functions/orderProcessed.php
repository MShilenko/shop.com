<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

if ($order = file_get_contents('php://input')){
    orderProcessed($order);
}

/**
 * Set the processing value for the order
 * @param  string $order
 */
function orderProcessed(string $order)
{
    $orderArr    = explode(",", $order);
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("UPDATE orders SET processed = :processed WHERE id = :orderId");

    $stmt->bindParam(':orderId', $orderArr[0], \PDO::PARAM_INT);
    $stmt->bindParam(':processed', $orderArr[1], \PDO::PARAM_INT);
    $stmt->execute();

    $dbConnect = null;
}