<?php
require("../hoobr-app/index.php");

/*
    @route GET|POST /admin
*/

$composite = $require("php-composite");

/*
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
        "title" => "Admin Logon",
        "start" => microtime(true)
    )
));
