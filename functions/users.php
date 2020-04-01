<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

/**
 * Receive user data for authentication
 * @return array $result
 */
function getAllUSersForAuthentication(): array
{
    $result    = [];
    $dbConnect = connectDB();

    $smtm = $dbConnect->query('SELECT id, email, password FROM users');

    $result = $smtm->fetchAll(\PDO::FETCH_ASSOC);

    $dbConnect = null;

    return $result;
}

/**
 * Getting user roles
 * @param  int    $id
 * @return string $result
 */
function getUSerRolesForProfile(int $id): array
{
    $result    = [];
    $dbConnect = connectDB();

    $smtm = $dbConnect->prepare(
        "SELECT roles.name FROM roles
            INNER JOIN role_user ON role_user.role_id = roles.id
            AND role_user.user_id = :id"
    );

    $smtm->bindParam(':id', $id, \PDO::PARAM_INT);
    $smtm->execute();

    foreach ($smtm->fetchAll(\PDO::FETCH_ASSOC) as $group) {
        $result[] = $group['name'];
    }

    $dbConnect = null;

    return $result;
}

/**
 * Check user rights for administrator
 * @return boolean
 */
function isAdministrator(): bool
{
    $userRoles = getUSerRolesForProfile($_SESSION['userId']);

    return in_array('administrator', $userRoles);
}

/**
 * Check user rights for administrator
 * @return boolean
 */
function isRedactor(): bool
{
    $userRoles = getUSerRolesForProfile($_SESSION['userId']);

    return in_array('redactor', $userRoles);
}
