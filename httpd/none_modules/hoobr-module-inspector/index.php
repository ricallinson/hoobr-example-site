<?php
namespace php_require\hoobr_module_inspector;

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

            if ($package) {
                $modules[$fullpath] = $package;
            }
        }
    }

    return $modules;
}

$exports["menu"] = function () use ($req, $render, $pathlib) {

    $dirpath = $pathlib->join(__DIR__, "..");

    $modules = inspectDir($dirpath, $pathlib);

    $list = array();

    foreach ($modules as $fullpath => $package) {
        array_push($list, $package["name"]);
    }

    return $render($pathlib->join(__DIR__, "views", "menu.php.html"), array(
        "list" => $list,
        "current" => $req->param("module")
    ));
};
