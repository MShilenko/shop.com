<?php

namespace functions;

/**
 * Check username and password
 * @return boolean
 */
function authenticationCheck(): bool
{
    if (ifUserExists($_POST['email'], $_POST['password'])) {
        $_SESSION['auth']   = true;
        $_SESSION['userId'] = getCurrentUserId($_POST['email']);
        setcookie("login", $_POST['email'], time() + 60 * 60 * 24 * 30, '/');

        return true;
    }

    return false;
}

/**
 * Cookies and session variables for authentication
 */
function sessionAuthentication()
{
    if (isset($_GET['login']) && $_GET['login'] == 'no' && isset($_SESSION['auth'])) {
        unset($_SESSION['auth']);
    }

    if (isset($_GET['login']) && $_GET['login'] == 'no' && isset($_SESSION['userId'])) {
        unset($_SESSION['userId']);
    }

    if (isset($_SESSION['auth']) && isset($_COOKIE['login'])) {
        setcookie("login", $_COOKIE['login'], time() + 60 * 60 * 24 * 30, '/');
    }

    if (!isset($_SESSION['auth']) && preg_match('#^/admin/\w+#', $_SERVER['REQUEST_URI'])) {
        header("Location: /admin/");
        exit;
    }
}

/**
 * Check if the user is authorized
 * @return boolean
 */
function isAuth(): bool
{
    return isset($_SESSION['auth']);
}
