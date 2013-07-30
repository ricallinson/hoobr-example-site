<?php
require("../hoobr-app/index.php");

/*
    @route GET /
*/

$res->render("./views/layout.php.html", array(
    "title" => "Public page.",
    "header" => "",
    "main" => "Content.",
    "footer" => "",
    "start" => microtime(true)
));
