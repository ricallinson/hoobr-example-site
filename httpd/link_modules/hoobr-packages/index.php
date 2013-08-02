<?php
namespace php_require\hoobr_packages;

$req = $require("php-http/request");
$render = $require("php-render-php");
$pathlib = $require("php-path");

function inspectModule($dirpath, $pathlib) {

    $filepath = $pathlib->join($dirpath, "package.json");

    if (!is_file($filepath)) {
        return null;
    }

    $package = json_decode(file_get_contents($filepath), true);

    return $package;
}

function inspectDir($dirpath, $pathlib) {

    $modules = array();

    $files = scandir($dirpath);

    foreach ($files as $file) {

        if (!in_array($file, array(".", ".."))) {

            $fullpath = $pathlib->join($dirpath, $file);
            $package = inspectModule($fullpath, $pathlib);

            if ($package && isset($package["engines"]["hoobr"])) {
                $modules[$fullpath] = $package;
            }
        }
    }

    return $modules;
}

$exports["admin-menu"] = function () use ($req, $render, $pathlib) {

    // Odd, but we have to go up to the root and the back down to "node_modules".
    $dirpath = $pathlib->join(__DIR__, "..", "..", "node_modules");

    $modules = inspectDir($dirpath, $pathlib);

    $list = array();

    foreach ($modules as $fullpath => $package) {
        array_push($list, $package["name"]);
    }

    return $render($pathlib->join(__DIR__, "views", "admin-menu.php.html"), array(
        "list" => $list,
        "current" => $req->param("module")
    ));
};

$exports["admin-sidebar"] = function () use ($req, $render, $pathlib) {

    // Odd, but we have to go up to the root and the back down to "node_modules".
    $dirpath = $pathlib->join(__DIR__, "..", "..", "node_modules");

    $modules = inspectDir($dirpath, $pathlib);

    $list = array();

    foreach ($modules as $fullpath => $package) {
        array_push($list, $package["name"]);
    }

    return $render($pathlib->join(__DIR__, "views", "admin-sidebar.php.html"), array(
        "list" => $list,
        "current" => $req->param("module")
    ));
};

$exports["admin-main"] = function () use ($render, $pathlib) {

    // Odd, but we have to go up to the root and the back down to "node_modules".
    $dirpath = $pathlib->join(__DIR__, "..", "..", "node_modules");

    $modules = inspectDir($dirpath, $pathlib);

    $list = array();

    foreach ($modules as $fullpath => $package) {
        array_push($list, $package);
    }

    return $render($pathlib->join(__DIR__, "views", "admin-main.php.html"), array(
        "list" => $list
    ));
};
