<?php
require_once __DIR__ . '/../app/Core/Database.php';

use Mini\Core\Database;

$pdo = Database::getPDO();

echo "Running migration: Adding size column to cart_items and order_items...\n";

try {
    // Add size to cart_items
    $pdo->exec("ALTER TABLE cart_items ADD COLUMN size VARCHAR(10) DEFAULT NULL AFTER quantity");
    echo "Added size to cart_items.\n";
} catch (PDOException $e) {
    echo "Error adding size to cart_items (maybe already exists): " . $e->getMessage() . "\n";
}

try {
    // Add size to order_items
    $pdo->exec("ALTER TABLE order_items ADD COLUMN size VARCHAR(10) DEFAULT NULL AFTER quantity");
    echo "Added size to order_items.\n";
} catch (PDOException $e) {
    echo "Error adding size to order_items (maybe already exists): " . $e->getMessage() . "\n";
}

echo "Migration complete.\n";
