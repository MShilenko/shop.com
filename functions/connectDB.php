<?php

namespace functions;

/**
 * Establish a connection to the database
 */
function connectDB()
{
    $host     = 'localhost';
    $user     = 'root';
    $password = '211187';
    $db       = 'shop';

    static $connection = null;

    if ($connection === null) {
        $connection = new \PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password) or die('error connection');
    }

    return $connection;
}
