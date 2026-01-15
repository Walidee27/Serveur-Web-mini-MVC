<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Cart;
use Mini\Models\Order;

class PaymentController extends Controller
{
    public function checkout()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $cart = Cart::findByUserId($_SESSION['user_id']);
        if (!$cart) {
            $this->redirect('/cart');
        }

        // Create instance to get items
        $cartModel = new Cart();
        $cartModel->setId($cart['id']);
        $items = $cartModel->getItems();

        if (empty($items)) {
            $this->redirect('/cart');
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $this->render('payment/checkout', ['items' => $items, 'total' => $total, 'title' => 'Paiement Sécurisé']);
    }

    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Simulate processing delay
            sleep(2);
            $this->redirect('/payment/success');
        }
    }

    public function success()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $cart = Cart::findByUserId($_SESSION['user_id']);
        if ($cart) {
            $cartModel = new Cart();
            $cartModel->setId($cart['id']);
            $items = $cartModel->getItems();

            if (!empty($items)) {
                $total = 0;
                foreach ($items as $item) {
                    $total += $item['price'] * $item['quantity'];
                }

                // Create order
                $orderId = Order::createWithItems($_SESSION['user_id'], $total, $items);

                // Clear cart
                $cartModel->clear();

                $this->render('orders/success', ['orderId' => $orderId]);
                return;
            }
        }

        $this->redirect('/');
    }

    public function cancel()
    {
        $this->redirect('/cart');
    }
}
