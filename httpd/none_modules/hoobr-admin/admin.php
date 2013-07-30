<?php
require("../../node_modules/php-require/index.php");

/*
    Do some error logging.
*/

error_reporting(E_ALL);
ini_set('display_errors', 'on');

/*
    Grab the $request, $response objects.
*/

$res = $require("php-http");
$req = $res->request; // done for convenience.

/*
    Trigger middleware.
*/

$require("../hoobr-users/middleware/auth");

/*
    Set the renderer to be used by default.
*/

$res->renderer[".php.html"] = $require("php-render-php");

/*
    Grab the composite modules for building the page.
*/


$composite = $require("php-composite");

/*
    @route GET|POST /admin
    If the user is not logged in show only the login form.
*/

if ($req->cfg("loggedin") !== true) {
    $res->render("./views/layout.php.html", $composite(
        array(
            "main" => array(
                "module" => "../hoobr-users",
                "action" => "logon"
            )
        ),
        array(
            "header" => "",
            "footer" => "",
            "title" => "Admin Logon",
            "start" => microtime(true)
        )
    ));
}

/*
    Once the user is logged in show the admin site.
*/

$res->render("./views/layout.php.html", $composite(
    array(
        "header" => array(
            "module" => "../hoobr-users",
            "action" => "loggedin"
        ),
        "main" => array(
            "module" => "../hoobr-post",
            "action" => "createPost"
        ),
        "footer" => array(
            "module" => "../hoobr-post",
            "action" => "listPosts"
        )
    ),
    array(
        "title" => "Admin",
        "start" => microtime(true)
    )
));
