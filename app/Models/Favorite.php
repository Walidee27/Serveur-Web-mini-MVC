<?php

namespace Mini\Models;

use Mini\Core\Model;
use Mini\Core\Database;
use PDO;

class Favorite extends Model
{
    private $user_id;
    private $product_id;

    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    public function save()
    {
        $pdo = Database::getPDO();
        // Check if already exists
        if ($this->exists($this->user_id, $this->product_id)) {
            return true;
        }

        $stmt = $pdo->prepare("INSERT INTO favorites (user_id, product_id) VALUES (:user_id, :product_id)");
        $res = $stmt->execute([
            'user_id' => $this->user_id,
            'product_id' => $this->product_id
        ]);

        if ($res) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public static function remove(int $userId, int $productId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = :user_id AND product_id = :product_id");
        return $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public static function exists(int $userId, int $productId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT 1 FROM favorites WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return (bool) $stmt->fetch();
    }

    public static function findAllByUser(int $userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
            SELECT p.* 
            FROM products p
            JOIN favorites f ON p.id = f.product_id
            WHERE f.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Product::class);
        return $stmt->fetchAll();
    }
}
