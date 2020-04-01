<?php

namespace functions;

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/functions/users.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/authentication.php';
include $_SERVER['DOCUMENT_ROOT'] . '/functions/categories.php';

if (!empty($_POST['userAuthorization'])) {
    authenticationCheck();
}

sessionAuthentication();
