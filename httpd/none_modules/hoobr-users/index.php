<?php
namespace php_require\hoobr_users;

$render = $require("php-render-php");
$req = $require("php-http")->request;

/*
    Show the logon form.
*/

$module->exports["sidebar"] = function () use ($req, $render) {

    if ($req->cfg("loggedin") != true) {
        return $render(__DIR__ . "/views/login.php.html");
    }
    
    return $render(__DIR__ . "/views/loggedin.php.html", array(
        "user" => $req->cookie("username")
    ));
};