<?php
namespace php_require\hoobr_assets;

/*
    This module should have heavy caching and combo/minify options.
*/

$req = $require("php-http/request");

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

function normalizePath($path, $webroot) {

    if ($path[0] != ".") {
        return $path;
    }

    global $require;

    return $require("php-path")->join($webroot, $path);
}

function normalizePaths($paths, $webroot) {

    foreach ($paths as &$path) {
        $path = normalizePath($path, $webroot);
    }

    return $paths;
}

/*
    Add a css url.
*/

function addCss($assets, $location, $webroot) {

    global $assetsCss;

    if (!isset($assetsCss[$location])) {
        $assetsCss[$location] = array();
    }

    $assetsCss[$location] = array_merge($assetsCss[$location], normalizePaths($assets, $webroot));
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

function addJs($assets, $location, $webroot) {

    global $assetsJs;

    if (!isset($assetsJs[$location])) {
        $assetsJs[$location] = array();
    }

    $assetsJs[$location] = array_merge($assetsJs[$location], normalizePaths($assets, $webroot));
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

function addBlob($assets, $location, $webroot) {

    global $assetsBlob;

    if (!isset($assetsBlob[$location])) {
        $assetsBlob[$location] = array();
    }

    $assetsBlob[$location] = array_merge($assetsBlob[$location], normalizePaths($assets, $webroot));
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

$exports["addCss"] = function ($assets, $location="top") use ($req) {
    addCss($assets, $location, $req->cfg("webroot"));
};

$exports["addJs"] = function ($assets, $location="bottom") use ($req) {
    addJs($assets, $location, $req->cfg("webroot"));
};

$exports["addBlob"] = function ($assets, $location="bottom") use ($req) {
    addBlob($assets, $location, $req->cfg("webroot"));
};

$exports["addBundle"] = function ($bundle) use ($req) {

    foreach ($bundle as $type => $typeBundle) {
        foreach ($typeBundle as $location => $assets) {
            switch (strtolower($type)) {
                case "css":
                    addcss($assets, $location, $req->cfg("webroot"));
                    break;
                case "js":
                    addJs($assets, $location, $req->cfg("webroot"));
                    break;
                case "blob":
                    addBlob($assets, $location, $req->cfg("webroot"));
                    break;
            }
        }
    }
};

$exports["render"] = function ($location) {
    return renderCss($location) . renderJs($location) . renderBlob($location);
};
