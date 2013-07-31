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

$req = $require("php-http/request");
$res = $require("php-http/response");

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
    @route GET|POST /admin
    If the user is not logged in show only the login form.
*/

if ($req->cfg("loggedin") !== true) {
    $res->render($pathlib->join(__DIR__, "views", "layout.php.html"), $composite(
        array(
            "sidebar" => array(
                "module" => "../hoobr-users",
                "action" => "sidebar"
            ),
            "header" => "",
            "main" => "",
            "footer" => "",
            "title" => "Admin Logon",
            "start" => microtime(true)
        )
    ));
}

/*
    Once the user is logged in work out what to show them.
*/

$mainModule = $req->param("module");
$mainAction = $req->param("action");

/*
    This dosen't feel right.
*/

if (!$mainModule) {
    $req->query["module"] = "hoobr-posts";
    $req->query["action"] = "main";
    $mainModule = $req->param("module");
    $mainAction = $req->param("action");
}

/*
    Show the admin site.
*/

$res->render($pathlib->join(__DIR__, "views", "layout.php.html"), $composite(
    array(
        "header" => array(
            "module" => "../hoobr-posts",
            "action" => "listPosts"
        ),
        "main" => array(
            "module" => "../" . $mainModule,
            "action" => $mainAction
        ),
        "sidebar" => array(
            array(
                "module" => "../hoobr-users",
                "action" => "sidebar"
            ),
            array(
                "module" => "../hoobr-module-inspector",
                "action" => "menu"
            )
        ),
        "title" => "Hoobr Admin",
        "footer" => "",
        "start" => microtime(true)
    )
));
