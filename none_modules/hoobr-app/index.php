<?php
require("../../node_modules/php-require/index.php");

/*
    Do some error logging.
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');

/*
    Grab the $request, $response objects.
*/

$res = $require("php-http");
$req = $res->request; // done for convenience.

/*
    Trigger middleware.
*/

$require("../hoobr-logon/middleware/auth");

/*
    Set the renderer's to be used for each template type.
*/

$res->renderer[".mu.html"] = $require("php-render-mu");
$res->renderer[".php.html"] = $require("php-render-php");
