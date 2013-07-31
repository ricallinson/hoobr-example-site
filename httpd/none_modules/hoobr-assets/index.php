<?php
namespace php_require\hoobr_assets;

/*
    This module should have heavy caching and combo/minify options.
*/

$pathlib = $require("php-path");
$req = $require("php-http/lib/request");
$res = $require("php-http/lib/response");

/*
    Holds all the css URL's.
*/

$assetsCss = array();

/*
    Holds all the js URL's.
*/

$assetsJs = array();

/*
    Holds all the blob strings.
*/

$assetsBlob = array();

/*
    Convert relative paths to webroot paths.
*/

function normalizePath($path) {

    if ($path[0] != ".") {
        return $path;
    }

    global $pathlib, $req;

    return $pathlib->join($req->cfg("webroot"), $path);
}

function normalizePaths($paths) {

    foreach ($paths as &$path) {
        $path = normalizePath($path);
    }

    return $paths;
}

/*
    Add a css url.
*/

function addCss($assets, $location) {

    global $assetsCss;

    if (!isset($assetsCss[$location])) {
        $assetsCss[$location] = array();
    }

    $assetsCss[$location] = array_merge($assetsCss[$location], normalizePaths($assets));
}

function renderCss($location) {

    global $assetsCss;

    $blob = "";

    if (!isset($assetsCss[$location])) {
        return $blob;
    }

    foreach ($assetsCss[$location] as $url) {
        $blob .= "<link rel=\"stylesheet\" href=\"$url\">\n";
    }

    return $blob;
}

function addJs($assets, $location) {

    global $assetsJs;

    if (!isset($assetsJs[$location])) {
        $assetsJs[$location] = array();
    }

    $assetsJs[$location] = array_merge($assetsJs[$location], normalizePaths($assets));
}

function renderJs($location) {

    global $assetsJs;

    $blob = "";

    if (!isset($assetsJs[$location])) {
        return $blob;
    }

    foreach ($assetsJs[$location] as $url) {
        $blob .= "<script src=\"$url\"></script>";
    }

    return $blob;
}

function addBlob($assets, $location) {

    global $assetsBlob;

    if (!isset($assetsBlob[$location])) {
        $assetsBlob[$location] = array();
    }

    $assetsBlob[$location] = array_merge($assetsBlob[$location], normalizePaths($assets));
}

function renderBlob($location) {

    global $assetsBlob;

    $blob = "";

    if (!isset($assetsBlob[$location])) {
        return $blob;
    }

    foreach ($assetsBlob[$location] as $str) {
        $blob .= $str . "\n";
    }

    return $blob;
}

$exports["addCss"] = function ($assets, $location="top") {
    addCss($assets, $location);
};

$exports["addJs"] = function ($assets, $location="bottom") {
    addJs($assets, $location);
};

$exports["addBlob"] = function ($assets, $location="bottom") {
    addBlob($assets, $location);
};

$exports["addBundle"] = function ($bundle) {

    foreach ($bundle as $type => $typeBundle) {
        foreach ($typeBundle as $location => $assets) {
            switch (strtolower($type)) {
                case "css":
                    addcss($assets, $location);
                    break;
                case "js":
                    addJs($assets, $location);
                    break;
                case "blob":
                    addBlob($assets, $location);
                    break;
            }
        }
    }
};

$exports["render"] = function ($location) {
    return renderCss($location) . renderJs($location) . renderBlob($location);
};
