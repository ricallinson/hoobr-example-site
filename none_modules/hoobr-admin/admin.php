<?php
require("../hoobr-app/index.php");

/*
    @route GET /admin
*/

if ($req->cfg("loggedin") != true) {
    $res->redirect("/hoobr/logon");
}

$res->render("./views/layout.php.html", array(
    "title" => "Admin page.",
    "start" => microtime(true)
));