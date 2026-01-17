<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Cart;

class CartController extends Controller
{
    private function getCart()
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $cart = Cart::findByUserId($_SESSION['user_id']);
        if (!$cart) {
            $cart = new Cart();
            $cart->setUserId($_SESSION['user_id']);
            $cart->save();
        }
        return $cart;
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $cart = $this->getCart();
        $items = $cart->getItems();

        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $this->render('cart/index', ['items' => $items, 'total' => $total, 'title' => 'Mon Panier']);
    }

    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!\Mini\Core\Csrf::validateToken($_POST['csrf_token'] ?? '')) {
                $this->redirect($_SERVER['HTTP_REFERER'] ?? '/products');
            }
            $productId = (int) $_POST['product_id'];
            $quantity = (int) $_POST['quantity'];
            $size = $_POST['size'] ?? null;

            $cart = $this->getCart();
            $cart->addItem($productId, $quantity, $size);

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'cartCount' => Cart::countItems($_SESSION['user_id'])
                ]);
                return;
            }

            $this->redirect('/cart');
        }
    }

    public function remove()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!\Mini\Core\Csrf::validateToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/cart');
            }
            $productId = (int) $_POST['product_id'];

            $cart = $this->getCart();
            $cart->removeItem($productId);

            $this->redirect('/cart');
        }
    }
}
