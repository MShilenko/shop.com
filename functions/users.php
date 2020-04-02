<?php

namespace functions;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/connectDB.php';

/**
 * Check if the user exists
 * @param  string $email
 * @param  string $password
 * @return boolean
 */
function ifUserExists(string $email, string $password): bool
{
    $passwordHash = '';
    $dbConnect    = connectDB();

    $smtm = $dbConnect->prepare("SELECT password FROM users WHERE email = :email");

    $smtm->bindParam(':email', $email, \PDO::PARAM_STR);
    $smtm->execute();

    foreach ($smtm->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $passwordHash = $row['password'];
    }

    $dbConnect = null;

    return password_verify($password, $passwordHash);
}

/**
 * Get current user id
 * @param  string $email
 * @return integer $userId
 */
function getCurrentUserId(string $email): int
{
    $userId    = '';
    $dbConnect = connectDB();

    $smtm = $dbConnect->prepare(
        "SELECT id FROM users WHERE email = :email"
    );

    $smtm->bindParam(':email', $email, \PDO::PARAM_STR);
    $smtm->execute();

    foreach ($smtm->fetchAll(\PDO::FETCH_ASSOC) as $row) {
        $userId = $row['id'];
    }

    $dbConnect = null;

    return $userId;
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
