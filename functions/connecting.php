<?php

namespace functions;

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/functions/authentication.php';

$isAuth = false;

if (!empty($_POST['userAuthorization'])) {
    $isAuth = authenticationCheck();
}

sessionAuthentication($isAuth);
