<?php
namespace php_require\hoobr_packages;

$req = $require("php-http/request");
$render = $require("php-render-php");
$pathlib = $require("php-path");

function getModuleList($dirpath, $pathlib) {

    $dirpath = $pathlib->join($dirpath, "node_modules");

    $modules = inspectDir($dirpath, $pathlib);

    $list = array();

    foreach ($modules as $fullpath => $package) {
        if (isset($package["config"]["hoobr"]["type"]) && $package["config"]["hoobr"]["type"] === "module") {
            array_push($list, $package["name"]);
        }
    }

    return $list;
}

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

            if ($package && isset($package["config"]["hoobr"])) {
                $modules[$fullpath] = $package;
            }
        }
    }

    return $modules;
}

$exports["admin-menu"] = function () use ($req, $render, $pathlib) {

    $list = getModuleList($req->cfg("approot"), $pathlib);

    return $render($pathlib->join(__DIR__, "views", "admin-menu.php.html"), array(
        "list" => $list,
        "current" => $req->param("module")
    ));
};

$exports["admin-sidebar"] = function () use ($req, $render, $pathlib) {

    $list = getModuleList($req->cfg("approot"), $pathlib);

    return $render($pathlib->join(__DIR__, "views", "admin-sidebar.php.html"), array(
        "list" => $list,
        "current" => $req->param("module")
    ));
};

$exports["admin-main"] = function () use ($req, $render, $pathlib) {

    $dirpath = $pathlib->join($req->cfg("approot"), "node_modules");

    $modules = inspectDir($dirpath, $pathlib);

    $list = array();

    foreach ($modules as $fullpath => $package) {
        array_push($list, $package);
    }

    return $render($pathlib->join(__DIR__, "views", "admin-main.php.html"), array(
        "list" => $list
    ));
};
