<?php
namespace php_require\hoobr_admin;

$exports["layout"] = __DIR__ . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "layout.php.html";

$exports["config"] = array(
    "css" => array(
        "top" => array(
            "./node_modules/hoobr-bootstrap/assets/css/bootstrap.min.css",
            "./node_modules/hoobr-admin-theme/assets/css/main.css"
        )
    ),
    "js" => array(
        "bottom" => array(
            "./node_modules/hoobr-bootstrap/assets/js/jquery.min.js",
            "./node_modules/hoobr-bootstrap/assets/js/bootstrap.min.js"
        )
    )
);
