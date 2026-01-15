<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Order;
use Mini\Models\Cart;

class OrderController extends Controller
{
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cart = Cart::findByUserId($_SESSION['user_id']);
            if (!$cart) {
                $this->redirect('/cart');
            }

            $items = $cart->getItems();

            if (empty($items)) {
                $this->redirect('/cart');
            }

            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $orderId = Order::createWithItems($_SESSION['user_id'], $total, $items);

            if ($orderId) {
                $cart->clear();
                $this->render('orders/success', ['orderId' => $orderId, 'title' => 'Commande Validée']);
            } else {
                $this->redirect('/cart');
            }
        }
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $orders = Order::findByUser($_SESSION['user_id']);

        $this->render('orders/index', ['orders' => $orders, 'title' => 'Mes Commandes']);
    }
}
