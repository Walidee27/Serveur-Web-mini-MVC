<?php

namespace Mini\Models;

use Mini\Core\Model;
use Mini\Core\Database;
use PDO;

class Cart extends Model
{
    private $user_id;
    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


    public static function findByUserId(int $userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch();
    }

    public function save()
    {
        $pdo = Database::getPDO();
        if ($this->id) {
            return true;
        }

        $stmt = $pdo->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        $res = $stmt->execute(['user_id' => $this->user_id]);

        if ($res) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function addItem(int $productId, int $quantity, ?string $size = null)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id AND (size = :size OR (size IS NULL AND :size_check IS NULL))");
        $stmt->execute(['cart_id' => $this->id, 'product_id' => $productId, 'size' => $size, 'size_check' => $size]);
        $item = $stmt->fetch();

        if ($item) {
            $newQuantity = $item['quantity'] + $quantity;
            $stmt = $pdo->prepare("UPDATE cart_items SET quantity = :quantity WHERE id = :id");
            $stmt->execute(['quantity' => $newQuantity, 'id' => $item['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, size) VALUES (:cart_id, :product_id, :quantity, :size)");
            $stmt->execute(['cart_id' => $this->id, 'product_id' => $productId, 'quantity' => $quantity, 'size' => $size]);
        }
    }

    public function removeItem(int $productId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id");
        $stmt->execute(['cart_id' => $this->id, 'product_id' => $productId]);
    }

    public function getItems()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("
            SELECT ci.*, p.name, p.price, p.image_url 
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = :cart_id
        ");
        $stmt->execute(['cart_id' => $this->id]);
        return $stmt->fetchAll();
    }

    public function clear()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
        $stmt->execute(['cart_id' => $this->id]);
    }
}
