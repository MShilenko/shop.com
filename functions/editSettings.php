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
    $rowId = 1;

    if (isFieldsEmpty([
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
        UPDATE settings SET city = :city, street = :street, house = :house, metro = :metro, min_price = :min_price, delivery_cost = :delivery_cost 
            WHERE id = :id
    ");

    if ($stmt->execute([
        'city'        => htmlspecialchars($settings['city']),
        'street'        => htmlspecialchars($settings['street']),
        'house'        => htmlspecialchars($settings['house']),
        'min_price'        => htmlspecialchars($settings['min_price']),
        'delivery_cost'        => htmlspecialchars($settings['delivery_cost']),
        'metro'        => htmlspecialchars($settings['metro'] ?? ''),
        'id'          => htmlspecialchars($rowId),
    ])) {
        $dbConnect = null;
        return setJSONStatus(['status' => 'success', 'message' => 'Настройки обновлены']);
    }

    $dbConnect = null;
    return setJSONStatus(['status' => 'error', 'message' => 'Произошла ошибка при сохранении']);
}
