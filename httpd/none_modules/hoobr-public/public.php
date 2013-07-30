<?php
require("../hoobr-app/index.php");

/*
    @route GET /
*/

$composite = $require("php-composite");

/*
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
