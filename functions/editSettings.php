<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';

if (!empty($_POST)) {
    echo editSettings($_POST);
}

/**
 * Save changes to the category
 * @param  array   $settings
 * @return string
 */
function editSettings(array $settings): string
{
    $result = '';
    $rowId  = 1;

    if (isFieldsEmpty([
        $settings['products_per_page'],
        $settings['city'],
        $settings['street'],
        $settings['house'],
        $settings['min_price'],
        $settings['delivery_cost'],
    ])) {
        return setJSONStatus(['status' => 'error', 'message' => 'Заполните поля']);
    }
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("
        UPDATE settings SET products_per_page = :products_per_page, city = :city, street = :street, house = :house, metro = :metro, min_price = :min_price, delivery_cost = :delivery_cost
            WHERE id = :id
    ");

    $stmt->execute([
        'products_per_page' => strip_tags($settings['products_per_page']),
        'city'              => strip_tags($settings['city']),
        'street'            => strip_tags($settings['street']),
        'house'             => strip_tags($settings['house']),
        'min_price'         => strip_tags($settings['min_price']),
        'delivery_cost'     => strip_tags($settings['delivery_cost']),
        'metro'             => strip_tags($settings['metro'] ?? ''),
        'id'                => strip_tags($rowId),
    ]);

    if (hasDBErrors($stmt->errorInfo())) {
        errorLogsDB(__FUNCTION__, $stmt->errorInfo());
    } else {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Настройки обновлены']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
