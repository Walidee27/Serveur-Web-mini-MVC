<?php

namespace Mini\Models;

use Mini\Core\Model;
use Mini\Core\Database;
use PDO;

class Order extends Model
{
    private $user_id;
    private $total_price;
    private $status;

    // Getters and Setters
    public function getUserId()
    {
        return $this->user_id;
    }
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }
    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }



    public static function findByUser(int $userId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetchAll();
    }

    public function save()
    {
        $pdo = Database::getPDO();
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
            return $stmt->execute(['status' => $this->status, 'id' => $this->id]);
        }

        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (:user_id, :total_price, :status)");
        $res = $stmt->execute([
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'status' => $this->status ?? 'pending'
        ]);

        if ($res) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public static function createWithItems(int $userId, float $totalPrice, array $items)
    {
        $pdo = Database::getPDO();
        try {
            $pdo->beginTransaction();

            $order = new Order();
            $order->setUserId($userId);
            $order->setTotalPrice($totalPrice);
            $order->setStatus('validated');

            if (!$order->save()) {
                throw new \Exception("Failed to create order");
            }

            $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase, size) VALUES (:order_id, :product_id, :quantity, :price, :size)");
            $stmtStock = $pdo->prepare("UPDATE products SET stock = stock - :quantity WHERE id = :id");

            foreach ($items as $item) {
                $stmtItem->execute([
                    'order_id' => $order->getId(),
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'size' => $item['size'] ?? null
                ]);

                $stmtStock->execute(['quantity' => $item['quantity'], 'id' => $item['product_id']]);
            }

            $pdo->commit();
            return $order->getId();
        } catch (\Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}
