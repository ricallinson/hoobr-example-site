<?php
namespace php_require\hoobr_default;

$render = $require("php-render-php");
$pathlib = $require("php-path");

$module->exports["menu"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "menu.php.html"));
};

$module->exports["sidebar"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "sidebar.php.html"));
};

$module->exports["main"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "main.php.html"));
};

$module->exports["admin-menu"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "admin-menu.php.html"));
};

$module->exports["admin-sidebar"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "admin-sidebar.php.html"));
};

$module->exports["admin-main"] = function () use ($render, $pathlib) {
    return $render($pathlib->join(__DIR__, "views", "admin-main.php.html"));
};
