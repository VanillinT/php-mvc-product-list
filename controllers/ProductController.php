<?php

namespace app\controllers;

use app\Database;
use app\models\Product;
use app\Router;

class ProductController
{
    public function index(Router $router)
    {
        $query = $_GET['search'] ?? '';
        $page = $_GET['page'] ?? 1;
        if ($page < 1) $page = 1;
        [$products, $total, $offset] = $router->db->getProducts($query, $page);
        $router->renderView(
            'products/index',
            [
                'products' => $products,
                'query' => $query,
                'page' => $page,
                'total' => $total,
                'offset' => $offset
            ]
        );
    }

    public function create(Router $router)
    {
        $errors = [];
        $productData = [
            'title' => '',
            'description' => '',
            'image' => '',
            'price' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = $_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if (empty($errors)) {
                header('Location: /products');
                exit;
            }
        }

        $router->renderView(
            'products/create',
            ['product' => $productData, 'errors' => $errors]
        );
    }

    public function update(Router $router)
    {
        $id = $_GET['id'] ?? null;

        $product = new Product();
        if ($id) {
            $product->load($router->db->findProduct($id));
            if (!$product->id) {
                header('Location: /products');
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product->title = $_POST['title'] ?? $product->title;
            $product->imageFile = $_FILES['image'] ?? $product->imageFile;
            $product->description = $_POST['description'] ?? $product->description;
            $product->price = $_POST['price'] ?? $product->price;

            $errors = $product->save();
            if (empty($errors)) {
                header('Location: /products');
                exit;
            }
        }

        $router->renderView(
            'products/update',
            ['product' => (array)$product, 'errors' => $errors]
        );
    }

    public function delete(Router $router)
    {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            header('Location: /products');
            exit;
        }
        $router->db->removeProduct($id);
        header('Location: /products');
    }
}
