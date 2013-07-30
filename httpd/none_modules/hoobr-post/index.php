<?php
namespace php_require\hoobr_post;

$keyval = $require("php-keyval");
$render = $require("php-render-php");
$req = $require("php-http")->request;

$store = $keyval(__DIR__ . "/posts/");

$exports["listPosts"] = function () use($render, $req, $store) {

    $postIds = $store->getKeys();

    return $render(__DIR__ . "/views/list-posts.php.html", array(
        "postIds" => $postIds
    ));
};

$exports["createPost"] = function () use($render, $req, $store) {

    $toSave = $req->param("to-save");
    $saved = false;
    $postId = $req->param("post-id");
    $title = $req->param("title");
    $text = $req->param("text");

    if ($toSave && $postId) {
        // save the post
        $saved = $store->put($postId, array("title" => $title, "text" => $text));
    }

    if ($postId === null) {
        $postId = $store->genUuid();
    } else {
        // load the post
        $post = $store->get($postId);
        $title = $post["title"];
        $text = $post["text"];
    }

    return $render(__DIR__ . "/views/create-post.php.html", array(
        "postId" => $postId,
        "title" => $title,
        "text" => $text,
        "saved" => $saved ? "Saved" : ""
    ));
};
