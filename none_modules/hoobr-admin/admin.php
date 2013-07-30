<?php
require("../hoobr-app/index.php");

/*
    @route GET /admin
*/

$composite = $require("php-composite");

if ($req->cfg("loggedin") != true) {
    $res->render("./views/layout.php.html", $composite(
        array(
            "main" => array(
                "module" => "../hoobr-logon/logon",
                "action" => "render" // optional
            )
        ),
        array(
            "title" => "Admin Logon",
            "start" => microtime(true)
        )
    ));
    return;
}

$res->render("./views/layout.php.html", array(
    "title" => "Admin page.",
    "start" => microtime(true)
));
