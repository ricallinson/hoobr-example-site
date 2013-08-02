<?php
//@route GET /

require("../../node_modules/php-require/index.php");

/*
    Require modules.
*/

$loaded = $require("hoobr/lib/middleware/bootstrap");
$pathlib = $require("php-path");
$composite = $require("php-composite");
$assests = $require("hoobr-assets");

/*
    Grab the $request, $response objects.
*/

$req = $require("php-http/request");
$res = $require("php-http/response");

/*
    Find our look and feel.
*/

$lookFeelDir = $pathlib->join(__DIR__, "..", "hoobr-public");
$assests["addBundle"]($require($pathlib->join($lookFeelDir, "config")));

/*
    Renders the main page.
*/

$res->render($pathlib->join($lookFeelDir, "views", "layout.php.html"), $composite(
    array(
        "header" => array(
            "module" => "hoobr-posts",
            "action" => "menu"
        ),
        "main" => array(
            "module" => "hoobr-posts",
            "action" => "main"
        ),
        "title" => "Hoobr Site",
        "footer" => "",
        "assetsTop" => $assests["render"]("top"),
        "assetsBottom" => $assests["render"]("bottom"),
        "start" => microtime(true)
    )
));
