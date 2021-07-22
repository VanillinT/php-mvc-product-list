<?php

namespace app;

use app\models\Product;
use PDO;

class Database
{
    const LIMIT = 5;
    public $pdo;
    public static $db;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1; port=3306; dbname=beb;', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function getProducts($filter = '', $page = 1)
    {
        $whereClause = "";
        if ($filter)
            $whereClause = "WHERE title LIKE :filter 
                                            OR description LIKE :filter";
        $limit = self::LIMIT;
        $offset = ($page - 1) * $limit;
        $selectStatement = $this->pdo->prepare("SELECT * FROM products $whereClause ORDER BY create_date DESC LIMIT $limit OFFSET $offset");
        $selectStatement->bindValue(":filter", "%$filter%");
        $selectStatement->execute();
        $products = $selectStatement->fetchAll(PDO::FETCH_ASSOC);

        $countStatement = $this->pdo->prepare("SELECT count(*) FROM products $whereClause");
        $countStatement->bindValue(":filter", "%$filter%");
        $countStatement->execute();
        [$count] = $countStatement->fetch(PDO::FETCH_NUM);
        $total = ceil($count / $limit);

        return [$products, $total, $offset];
    }

    public function findProduct($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM products WHERE id=:id');
        $statement->bindValue(':id', $id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function saveProduct(Product $product)
    {
        if ($product->id) {
            $statement = $this->pdo->prepare("UPDATE products SET 
                                            title=:title, 
                                            image=:image, 
                                            description=:description, 
                                            price=:price WHERE id=:id");
            $statement->bindValue(':id', $product->id);
        } else {
            $statement = $this->pdo->prepare("INSERT INTO products 
            (title, image, description, price, create_date) 
            VALUES (:title, :image,:description,:price,:create_date )");
            $statement->bindValue(':create_date', date('Y-m-d H:i:s'));
        }
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->execute();
    }

    public function removeProduct($id)
    {
        $statement  = $this->pdo->prepare('DELETE FROM products WHERE id=:id');
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
