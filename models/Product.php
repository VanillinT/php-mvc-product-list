<?php

namespace app\models;

use app\Database;

class Product
{
    public $id = null;
    public $title = '';
    public $description = '';
    public $price = '';
    public $imagePath = null;
    public $imageFile = null;

    public function load($data)
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? null;
        $this->price = $data['price'];
        $this->imageFile = $data['imageFile'] ?? null;
        $this->imagePath = $data['image'] ?? null;
    }

    public function save()
    {
        $erorrs = [];
        if (!$this->title) {
            $errors['title'] = 'Product title is required';
        }
        if (!$this->price) {
            $errors['price'] = 'Price is required';
        }

        if (empty($errors)) {
            if (!is_dir(__DIR__ . '/../public/assets'))
                mkdir(__DIR__ . '/../public/assets');

            if ($this->imageFile && $this->imageFile['tmp_name']) {
                if (file_exists($this->imagePath)) unlink(__DIR__ . '/../public/' . $this->imagePath);
                $this->imagePath = 'assets/' . time() . '_' . $this->imageFile['name'];
                move_uploaded_file($this->imageFile['tmp_name'], __DIR__ . '/../public/' . $this->imagePath);
            }

            Database::$db->saveProduct($this);
        }

        return $errors;
    }

    public function remove()
    {
        Database::$db->removeProduct($this->id);
    }
}
