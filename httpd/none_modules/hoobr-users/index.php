<?php
namespace php_require\hoobr_users;

$render = $require("php-render-php");
$req = $require("php-http")->request;

/*
    Show the logon form.
*/

$module->exports["logon"] = function () use ($render) {
    return $render(__DIR__ . "/views/login.php.html");
};

/*
    Show logged in info.
*/

$module->exports["loggedin"] = function () use ($render, $req) {
    return $render(__DIR__ . "/views/loggedin.php.html", array(
        "user" => $req->cookie("username")
    ));
};
