<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/settings.php';

if (!empty($_POST)) {
    echo saveOrder($_POST);
}

/**
 * Save the order in the database
 * @param  array $orderOptions
 * @return  string
 */
function saveOrder(array $orderOptions): string
{
    $defaultDeliveryOptions = getDefaultDeliveryOptions();
    $delivery               = (int) $orderOptions['delivery'];

    if (isFieldsEmpty([
        $orderOptions['surname'],
        $orderOptions['name'],
        $orderOptions['phone'],
        $orderOptions['email'],
    ])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    }

    if ($delivery && isFieldsEmpty([
        $orderOptions['city'],
        $orderOptions['street'],
        $orderOptions['home'],
        $orderOptions['aprt'],
    ])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    }

    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("
    INSERT INTO orders (customer_surname, customer_name, customer_phone, customer_email, customer_thirdname, delivery, payment, comment, city, street, house, apartment, product_id)
        VALUES (:customer_surname, :customer_name, :customer_phone, :customer_email, :customer_thirdname, :delivery, :payment, :comment, :city, :street, :house, :apartment, :product_id)"
    );

    $stmt->execute([
        'customer_surname'   => strip_tags($orderOptions['surname']),
        'customer_name'      => strip_tags($orderOptions['name']),
        'customer_phone'     => strip_tags($orderOptions['phone']),
        'customer_email'     => strip_tags($orderOptions['email']),
        'delivery'           => strip_tags($orderOptions['delivery'] ?? 0),
        'payment'            => strip_tags($orderOptions['pay']),
        'customer_thirdname' => strip_tags($orderOptions['thirdName'] ?? ''),
        'comment'            => strip_tags($orderOptions['comment'] ?? ''),
        'city'               => strip_tags($orderOptions['city']),
        'street'             => strip_tags($orderOptions['street']),
        'house'              => strip_tags((int) $orderOptions['home']),
        'apartment'          => strip_tags((int) $orderOptions['aprt']),
        'product_id'         => $orderOptions['productId'],
    ]);

    if (hasDBErrors($stmt->errorInfo())) {
        errorLogsDB(__FUNCTION__, $stmt->errorInfo());
    } else {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Спасибо за заказ!']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
