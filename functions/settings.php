<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

/**
 * Get the settings data for the form
 * @return array $result
 */
function getSettingForAdminForm(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->query(
        'SELECT city, street, house, metro, min_price, delivery_cost FROM settings'
    );

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result[0];
}

/**
 * Get default delivery options
 * @return array $result
 */
function getDefaultDeliveryOptions(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $stmt = $dbConnect->query(
        'SELECT city, street, house, apartment, metro FROM settings'
    );

    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result[0];
}

/**
 * Get the value of the minimum price
 * @return int $result
 */
function getLowPrice(): int
{
    $result    = '';
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT min_price FROM settings'
    );

    $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchColumn();

    $dbConnect = null;

    return $result;
}

/**
 * Get the delivery price
 * @return int $result
 */
function getDeliveryPrice(): int
{
    $result    = '';
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare(
        'SELECT delivery_cost FROM settings'
    );

    $stmt->bindParam(':productId', $productId, \PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchColumn();

    $dbConnect = null;

    return $result;
}
