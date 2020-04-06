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

    if (!$delivery) {
        $stmt = $dbConnect->prepare("
        INSERT INTO orders (customer_surname, customer_name, customer_phone, customer_email, customer_thirdname, delivery, payment, comment, product_id)
            VALUES (:customer_surname, :customer_name, :customer_phone, :customer_email, :customer_thirdname, :delivery, :payment, :comment, :product_id)"
        );

        if ($stmt->execute([
            'customer_surname'   => htmlspecialchars($orderOptions['surname']),
            'customer_name'      => htmlspecialchars($orderOptions['name']),
            'customer_phone'     => htmlspecialchars($orderOptions['phone']),
            'customer_email'     => htmlspecialchars($orderOptions['email']),
            'delivery'           => htmlspecialchars($orderOptions['delivery']),
            'payment'            => htmlspecialchars($orderOptions['pay']),
            'customer_thirdname' => htmlspecialchars($orderOptions['thirdName'] ?? ''),
            'comment'            => htmlspecialchars($orderOptions['comment'] ?? ''),
            'product_id'         => $orderOptions['productId'],
        ])) {
            $dbConnect = null;
            return setJSONStatus(['status' => 'success', 'message' => 'Спасибо за заказ!']);
        }
    }

    $stmt = $dbConnect->prepare("
    INSERT INTO orders (customer_surname, customer_name, customer_phone, customer_email, customer_thirdname, delivery, payment, comment, city, street, house, apartment, product_id)
        VALUES (:customer_surname, :customer_name, :customer_phone, :customer_email, :customer_thirdname, :delivery, :payment, :comment, :city, :street, :house, :apartment, :product_id)"
    );

    if ($stmt->execute([
        'customer_surname'   => htmlspecialchars($orderOptions['surname']),
        'customer_name'      => htmlspecialchars($orderOptions['name']),
        'customer_phone'     => htmlspecialchars($orderOptions['phone']),
        'customer_email'     => htmlspecialchars($orderOptions['email']),
        'delivery'           => htmlspecialchars($orderOptions['delivery']),
        'payment'            => htmlspecialchars($orderOptions['pay']),
        'customer_thirdname' => htmlspecialchars($orderOptions['thirdName'] ?? ''),
        'comment'            => htmlspecialchars($orderOptions['comment'] ?? ''),
        'city'               => htmlspecialchars($orderOptions['city']),
        'street'             => htmlspecialchars($orderOptions['street']),
        'house'              => htmlspecialchars($orderOptions['home']),
        'apartment'          => htmlspecialchars($orderOptions['aprt']),
        'product_id'         => $orderOptions['productId'],
    ])) {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Спасибо за заказ!']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
