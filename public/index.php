<?php

require_once('../vendor/autoload.php');

use app\Router;
use app\controllers\ProductController;

$router = new Router();

$router->get("/", function() { header('Location: /products?page=1'); });
$router->get("/products", [ProductController::class, "index"]);
$router->get("/products/create", [ProductController::class, "create"]);
$router->post("/products/create", [ProductController::class, "create"]);
$router->get("/products/update", [ProductController::class, "update"]);
$router->post("/products/update", [ProductController::class, "update"]);
$router->post("/products/delete", [ProductController::class, "delete"]);

$router->resolve();
