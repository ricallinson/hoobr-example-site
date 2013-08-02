<?php
namespace php_require\hoobr_admin;

$exports["layout"] = __DIR__ . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "layout.php.html";

$exports["config"] = array(
    "css" => array(
        "top" => array(
            "./node_modules/hoobr-bootstrap/assets/css/bootstrap.min.css",
            "./node_modules/hoobr-admin/assets/css/main.css"
        )
    )
);