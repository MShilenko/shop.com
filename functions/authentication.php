<?php

namespace functions;

include $_SERVER['DOCUMENT_ROOT'] . '/functions/users.php';

/**
 * Check username and password
 * @return boolean
 */
function authenticationCheck(): bool
{
    $users = getAllUSersForAuthentication();

    for ($i = 0; $i < count($users); $i++) {
        if ($users[$i]['email'] === $_POST['email'] && password_verify($_POST['password'], $users[$i]['password'])) {
            $_SESSION['userId'] = $users[$i]['id'];
            setcookie("login", $users[$i]['email'], time() + 60 * 60 * 24 * 30, '/');

            return true;
        }
    }

    return false;
}

namespace functions;

/**
 * Cookies and session variables for authentication
 * @param  bool   $isAuth
 */
function sessionAuthentication(bool $isAuth)
{
    if ($isAuth && !isset($_SESSION['auth'])) {
        $_SESSION['auth'] = true;
    }

    if (isset($_GET['login']) && $_GET['login'] == 'no' && isset($_SESSION['auth'])) {
        unset($_SESSION['auth']);
    }

    if (isset($_GET['login']) && $_GET['login'] == 'no' && isset($_SESSION['userId'])) {
        unset($_SESSION['userId']);
    }

    if (isset($_SESSION['auth']) && isset($_COOKIE['login'])) {
        setcookie("login", $_COOKIE['login'], time() + 60 * 60 * 24 * 30, '/');
    }

    if(!isset($_SESSION['auth']) && preg_match('#^/admin#', $_SERVER['REQUEST_URI'])){
        header("Location: /");
        exit;
    }
}
