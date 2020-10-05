<?php

namespace functions;

include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

/**
 * Establish a connection to the database
 */
function connectDB()
{
    $host     = HOST;
    $user     = USER;
    $password = PASSWORD;
    $db       = DB;

    static $connection = null;

    if ($connection === null) {
        $connection = new \PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password) or die('error connection');
    }

    return $connection;
}

try {
    connectDB();
} catch (\Exception $e) {
    echo '<div class="db_error">Произошла ошибка при подключении к БД. ' . $e->getMessage() . '</div>';
    die;
}
