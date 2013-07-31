<?php
require("../../node_modules/php-require/index.php");

/*
    Do some error logging.
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');

/*
    Require modules.
*/

$pathlib = $require("php-path");
$composite = $require("php-composite");
$assests = $require("../hoobr-assets");

/*
    Grab the $request, $response objects.
*/

$res = $require("php-http");
$req = $res->request; // done for convenience.

/*
    Set webroot and approot.
*/

$req->cfg("webroot", $pathlib->join($pathlib->dirname($req->getServerVar("PHP_SELF")), "..", ".."));
$req->cfg("approot", $pathlib->join(__DIR__, "..", ".."));

/*
    Set the renderer to be used by default.
*/

$res->renderer[".php.html"] = $require("php-render-php");

/*
    Trigger middleware.
*/

$require("../hoobr-users/middleware/auth");

/*
    Add local assets.
*/

$assests["addBundle"]($require("./config"));

/*
    @route GET /
    Renders the main page.
*/

$res->render($pathlib->join(__DIR__, "views", "layout.php.html"), $composite(
    array(
        "header" => array(
            "module" => "../hoobr-post",
            "action" => "listPosts"
        ),
        "main" => array(
            "module" => "../hoobr-post",
            "action" => "showPost"
        )
    ),
    array(
        "title" => "Hoobr Site",
        "footer" => "",
        "assetsTop" => $assests["render"]("top"),
        "assetsBottom" => $assests["render"]("bottom"),
        "start" => microtime(true)
    )
));
