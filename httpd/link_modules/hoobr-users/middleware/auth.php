<?php
namespace php_require\hoobr_logon\middleware\auth;

/*
    Grab the $request, $response objects.
*/

$req = $require("php-http/request");
$res = $require("php-http/response");

/*
    Check the users cookie to see if they are logged in.
*/

if ($req->cookie("security") == md5($req->getServerVar("HTTP_USER_AGENT")) && $req->cookie("username") != null) {
    $req->cfg("loggedin", true);
} else {
    $req->cfg("loggedin", false);
}

/*
    If the user is logging in we do it here.
*/

if ($req->param("username") && $req->param("password")) {

    /*
        Validate the user is real here.
    */

    if (true) {
        $req->cfg("loggedin", true);
        $res->cookie("security", md5($req->getServerVar("HTTP_USER_AGENT")));
        $res->cookie("username", $req->param("username"));
    }

    $res->redirect();
}

/*
    If the user is logging out we do it here.
*/

if ($req->cfg("loggedin") && $req->param("logout")) {
    $req->cfg("loggedin", false);
    $res->clearCookie("security");
    $res->clearCookie("username");
    $res->redirect("./");
}
