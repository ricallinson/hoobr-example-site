<?php
require("./node_modules/php-require/index.php");

/*
    Require libraries.
*/

$req = $require("php-http/request");
$pathlib = $require("php-path");

/*
    Build the default application configuration.
*/

$webroot = $pathlib->join($pathlib->dirname($req->getServerVar("PHP_SELF")));
$approot = $pathlib->join(__DIR__);
$datroot = $pathlib->join($approot, "data");

$req->config = array(
    "webroot" => $webroot,
    "approot" => $approot,
    "datroot" => $datroot
);

/*
    Find the page we want.
*/

$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : "";
$module = "hoobr/page-public";

switch ($page) {
    case "admin":
        $module = "hoobr/page-admin";
        break;
}

/*
    Require the page module.
*/

$require($module);
