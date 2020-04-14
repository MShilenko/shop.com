<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

if ($pageID = (int) file_get_contents('php://input')) {
    deactivatePage($pageID);
}

var_dump($pageID);

/**
 * Deactivate the page
 * @param  int    $pageID
 */
function deactivatePage(int $pageID)
{
    $dbConnect = connectDB();

    $stmt = $dbConnect->prepare("UPDATE pages SET active = 0 WHERE id = :pageID");

    $stmt->bindParam(':pageID', $pageID, \PDO::PARAM_INT);
    $stmt->execute();

    $dbConnect = null;

}
