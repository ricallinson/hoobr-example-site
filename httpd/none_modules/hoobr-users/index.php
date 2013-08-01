<?php
namespace php_require\hoobr_users;

$pathlib = $require("php-path");
$render = $require("php-render-php");
$req = $require("php-http/request");

/*
    Show the logon form.
*/

$module->exports["admin-sidebar"] = function () use ($req, $render, $pathlib) {

    if ($req->cfg("loggedin") != true) {
        return $render($pathlib->join(__DIR__, "views", "login.php.html"));
    }

    return $render($pathlib->join(__DIR__, "views", "loggedin.php.html"), array(
        "user" => $req->cookie("username")
    ));
};
