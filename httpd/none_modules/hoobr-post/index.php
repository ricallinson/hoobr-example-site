<?php
namespace php_require\hoobr_post;

$keyval = $require("php-keyval");
$render = $require("php-render-php");
$res = $require("php-http");
$req = $res->request;

$store = $keyval(__DIR__ . "/posts/", 10);

function getPostsList($store, $from=0, $to=null) {

    $posts = array();
    $postIds = $store->getKeys($from, $to);

    foreach ($postIds as $postId) {
        $posts[$postId] = $store->get($postId)["title"];
    }

    return $posts;
}

/*
    List all posts as links.
*/

$exports["listPosts"] = function () use ($req, $render, $store) {

    $postId = $req->param("post-id");
    $posts = getPostsList($store);

    if (!$postId) {
        reset($posts);
        $postId = key($posts);
    }

    return $render(__DIR__ . "/views/list-posts.php.html", array(
        "posts" => $posts,
        "current" => $postId
    ));
};

/*
    Show a post.
*/

$exports["showPost"] = function () use ($req, $render, $store) {

    $postId = $req->param("post-id");

    if (!$postId) {
        // if there is no postId get the first one returned by store?
        $postId = $store->getKeys(0, 1)[0];
    }

    $post = $store->get($postId);

    return $render(__DIR__ . "/views/show-post.php.html", array(
        "post" => $post
    ));
};

/*
    CRUD Create, Read, Update, Delete
*/

$exports["createPost"] = function () use ($req, $res, $render, $store) {

    $action = strtolower($req->param("hoobr-post-action"));
    $saved = false;
    $postId = $req->param("post-id");
    $title = $req->param("title");
    $text = $req->param("text");

    if ($action === "delete" && $postId) {
        $store->delete($postId);
        $res->redirect("/hoobr/httpd/admin");
    } else if ($action === "save" && $postId) {

        if (!$title) {
            $title = "New Post";
        }

        // save the post
        $saved = $store->put($postId, array("title" => $title, "text" => $text));
    }

    if ($postId === null) {
        // starting a new post
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
