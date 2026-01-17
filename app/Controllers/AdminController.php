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
        $stats = [
            'products' => Product::count(),
            'orders' => Order::count(),
            'revenue' => Order::sumRevenue(),
            'users' => User::count()
        ];

        $recentOrders = Order::findAll(); // Getting all for now, could optimize to get only 5 if needed but findAll is fine for mini_mvc
        $recentOrders = array_slice($recentOrders, 0, 5); // Just slice it here

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
        $orders = Order::findAll();
        $this->render('admin/orders/index', ['orders' => $orders, 'title' => 'Gestion Commandes']);
    }

    public function orderView()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id)
            $this->redirect('/admin/orders');

        $data = Order::findWithItems($id);
        if (!$data) {
            $this->redirect('/admin/orders');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            Order::updateStatus($id, $status);
            $this->redirect("/admin/orders/view?id=$id");
        }

        $this->render('admin/orders/view', ['order' => $data['order'], 'items' => $data['items'], 'title' => 'Détail Commande #' . $id]);
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
            $product = Product::find($id);
            if ($product) {
                $product->delete();
            }
        }
        $this->redirect('/admin/products');
    }
}
