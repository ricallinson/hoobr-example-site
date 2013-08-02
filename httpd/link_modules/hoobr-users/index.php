<?php
namespace php_require\hoobr_users;

$pathlib = $require("php-path");
$render = $require("php-render-php");
$req = $require("php-http/request");

/*
    Show the logon form.
*/

$module->exports["admin-menu"] = function () use ($req, $render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "admin-menu.php.html"));
};

$module->exports["admin-sidebar"] = function () use ($req, $render, $pathlib) {

    if ($req->cfg("loggedin") != true) {
        return $render($pathlib->join(__DIR__, "views", "admin-sidebar-login.php.html"));
    }

    return $render($pathlib->join(__DIR__, "views", "admin-sidebar.php.html"), array(
        "user" => $req->cookie("username")
    ));
};

$module->exports["admin-main"] = function () use ($req, $render, $pathlib) {

    return $render($pathlib->join(__DIR__, "views", "admin-main.php.html"), array(
        "users" => array()
    ));
};