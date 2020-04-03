<?php

namespace functions;

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/include/constants.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/auxiliary.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/users.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/authentication.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/categories.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/products.php';

if (!empty($_POST['userAuthorization'])) {
    authenticationCheck();
}

sessionAuthentication();
