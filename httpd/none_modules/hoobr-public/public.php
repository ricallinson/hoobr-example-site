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
    @route GET /
    Renders the main page.
*/

$res->render("./views/layout.php.html", $composite(
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
        "start" => microtime(true)
    )
));
