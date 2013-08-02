<?php
namespace php_require\hoobr_default;

/*
    Imported library modules.
*/

$render = $require("php-render-php");
$pathlib = $require("php-path");

/*
    This action is for adding items to the public menu.
*/

$module->exports["menu"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "menu.php.html"));
};

/*
    This action is for adding blocks to the public sidebar.
*/

$module->exports["sidebar"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "sidebar.php.html"));
};

/*
    This action is for providing the main public module.
*/

$module->exports["main"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "main.php.html"));
};

/*
    This action is for adding items to the admin menu.
*/

$module->exports["admin-menu"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "admin-menu.php.html"));
};

/*
    This action is for adding blocks to the admin sidebar.
*/

$module->exports["admin-sidebar"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "admin-sidebar.php.html"));
};

/*
    This action is for providing the main admin module.
*/

$module->exports["admin-main"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "admin-main.php.html"));
};
