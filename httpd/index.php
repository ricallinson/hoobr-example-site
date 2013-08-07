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
$cfgroot = $pathlib->join($approot, "config");

$req->config = array(
    "webroot" => $webroot,
    "approot" => $approot,
    "datroot" => $datroot,
    "cfgroot" => $cfgroot
);

/*
    See if we were given a page.
*/

$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : "public";

/*
    Require the page module.
*/

$require("hoobr/page-" . strtolower($page));
