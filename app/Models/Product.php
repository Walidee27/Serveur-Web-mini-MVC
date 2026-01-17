<?php

namespace Mini\Models;

use Mini\Core\Model;
use Mini\Core\Database;
use PDO;

class Product extends Model
{
    private $name;
    private $description;
    private $price;
    private $stock;
    private $image_url;
    private $category_id;
    private $category_name;
    private $gender;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getStock()
    {
        return $this->stock;
    }
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getImageUrl()
    {
        return $this->image_url;
    }
    public function setImageUrl($image_url)
    {
        $this->image_url = $image_url;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function getGender()
    {
        return $this->gender;
    }
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }

    public static function findAll($filters = [])
    {
        $pdo = Database::getPDO();
        $sql = "
            SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['gender'])) {
            $sql .= " AND p.gender = :gender";
            $params['gender'] = $filters['gender'];
        }

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetchAll();
    }

    public static function getTrending($limit = 4)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY RAND() 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetchAll();
    }

    public static function find($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
            SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public function save()
    {
        $pdo = Database::getPDO();
        if ($this->id) {
            return $this->update();
        }

        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock, image_url, category_id, gender) VALUES (:name, :description, :price, :stock, :image_url, :category_id, :gender)");
        $res = $stmt->execute([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image_url' => $this->image_url,
            'category_id' => $this->category_id,
            'gender' => $this->gender ?? 'unisexe'
        ]);

        if ($res) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function update()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, stock = :stock, image_url = :image_url, category_id = :category_id, gender = :gender WHERE id = :id");
        return $stmt->execute([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'image_url' => $this->image_url,
            'category_id' => $this->category_id,
            'gender' => $this->gender,
            'id' => $this->id
        ]);
    }

    public function delete()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        return $stmt->execute(['id' => $this->id]);
    }

    public static function count()
    {
        $pdo = Database::getPDO();
        return (int) $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    }
}
