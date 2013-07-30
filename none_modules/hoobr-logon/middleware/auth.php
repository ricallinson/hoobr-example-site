<?php
namespace php_require\hoobr_logon\middleware\auth;

/*
    Grab the $request, $response objects.
*/

$res = $require("php-http");
$req = $res->request; // done for convenience.

/*
    Check the users cookie to see if they are logged in.
*/

if ($req->cookies("security") == md5($req->getServerVar("HTTP_USER_AGENT")) && $req->cookies("username") != null) {
    $req->cfg("loggedin", true);
} else {
    $req->cfg("loggedin", false);
}
