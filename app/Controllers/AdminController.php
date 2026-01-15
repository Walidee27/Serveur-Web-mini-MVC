<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;
use Mini\Models\Product;
use Mini\Models\Order;
use Mini\Core\Database;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $user = User::find($_SESSION['user_id']);
        if (!$user || !$user->isAdmin()) {
            $this->redirect('/');
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();

        // Simple stats
        $pdo = Database::getPDO();
        $stats = [
            'products' => $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
            'orders' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
            'revenue' => $pdo->query("SELECT SUM(total_price) FROM orders WHERE status != 'cancelled'")->fetchColumn() ?: 0,
            'users' => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn()
        ];

        $recentOrders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();

        $this->render('admin/dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'title' => 'Admin Dashboard'
        ]);
    }

    public function products()
    {
        $this->checkAdmin();
        $products = Product::findAll();
        $this->render('admin/products/index', ['products' => $products, 'title' => 'Gestion Produits']);
    }

    public function orders()
    {
        $this->checkAdmin();
        $pdo = Database::getPDO();
        $orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
        $this->render('admin/orders/index', ['orders' => $orders, 'title' => 'Gestion Commandes']);
    }

    public function orderView()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id)
            $this->redirect('/admin/orders');

        $pdo = Database::getPDO();
        $order = $pdo->query("SELECT * FROM orders WHERE id = $id")->fetch();
        $items = $pdo->query("
            SELECT oi.*, p.name, p.image_url 
            FROM order_items oi 
            LEFT JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = $id
        ")->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
            $stmt->execute(['status' => $status, 'id' => $id]);
            $this->redirect("/admin/orders/view?id=$id");
        }

        $this->render('admin/orders/view', ['order' => $order, 'items' => $items, 'title' => 'Détail Commande #' . $id]);
    }

    public function productCreate()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = new Product();
            $product->setName($_POST['name']);
            $product->setDescription($_POST['description']);
            $product->setPrice($_POST['price']);
            $product->setStock($_POST['stock']);
            $product->setImageUrl($_POST['image_url']);
            $product->setCategoryId($_POST['category_id']);
            $product->setGender($_POST['gender']);
            $product->save();
            $this->redirect('/admin/products');
        }
        $this->render('admin/products/form', ['title' => 'Nouveau Produit']);
    }

    public function productEdit()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id)
            $this->redirect('/admin/products');

        $product = Product::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product->setName($_POST['name']);
            $product->setDescription($_POST['description']);
            $product->setPrice($_POST['price']);
            $product->setStock($_POST['stock']);
            $product->setImageUrl($_POST['image_url']);
            $product->setCategoryId($_POST['category_id']);
            $product->setGender($_POST['gender']);
            $product->save(); // Will call update() internally
            $this->redirect('/admin/products');
        }
        $this->render('admin/products/form', ['product' => $product, 'title' => 'Modifier Produit']);
    }

    public function productDelete()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $pdo = Database::getPDO();
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);
        }
        $this->redirect('/admin/products');
    }
}
