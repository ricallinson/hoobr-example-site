<?php
require("../hoobr-app/index.php");

/*
    @route GET /admin
*/

if ($req->cfg("loggedin") != true) {
    $res->redirect("/hoobr/logon");
}

$res->send("Admin page.");
