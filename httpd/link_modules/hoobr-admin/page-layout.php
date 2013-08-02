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
$assests = $require("hoobr-assets");

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

$require("hoobr-users/middleware/auth");

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
                "module" => "hoobr-users",
                "action" => "admin-sidebar"
            ),
            "header" => "",
            "main" => "",
            "footer" => "",
            "assetsTop" => $assests["render"]("top"),
            "assetsBottom" => $assests["render"]("bottom"),
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
    $req->query["module"] = "hoobr-packages";
    $req->query["action"] = "main";
    $mainModule = $req->param("module");
    $mainAction = $req->param("action");
}

/*
    Organize the main and sidebar slots.
*/

$header = array(
    array(
        "module" => (!in_array($mainModule, array("hoobr-packages", "hoobr-users")) ? $mainModule : null),
        "action" => "admin-menu"
    ),
    array(
        "module" => "hoobr-users",
        "action" => "admin-menu"
    ),
    array(
        "module" => "hoobr-packages",
        "action" => "admin-menu"
    )
);

$main = array(
    "module" => $mainModule,
    "action" => "admin-" . $mainAction
);

$sidebar = array(
    array(
        "module" => $mainModule,
        "action" => "admin-sidebar"
    )
);

/*
    Show the admin site.
*/

$res->render($pathlib->join(__DIR__, "views", "layout.php.html"), $composite(
    array(
        "header" => $header,
        "main" => $main,
        "sidebar" => $sidebar,
        "title" => "Hoobr Admin",
        "footer" => "",
        "assetsTop" => $assests["render"]("top"),
        "assetsBottom" => $assests["render"]("bottom"),
        "start" => microtime(true)
    )
));
