<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Favorite;

class FavoriteController extends Controller
{
    public function toggle()
    {
        if (!isset($_SESSION['user_id'])) {
            // If ajax, return 401, else redirect
            if ($this->isAjax()) {
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized']);
                return;
            }
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int) $_POST['product_id'];
            $userId = $_SESSION['user_id'];

            if (Favorite::exists($userId, $productId)) {
                Favorite::remove($userId, $productId);
                $status = 'removed';
            } else {
                $favorite = new Favorite();
                $favorite->setUserId($userId);
                $favorite->setProductId($productId);
                $favorite->save();
                $status = 'added';
            }

            if ($this->isAjax()) {
                echo json_encode(['status' => $status]);
            } else {
                $this->redirect($_SERVER['HTTP_REFERER'] ?? '/products');
            }
        }
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $products = Favorite::findAllByUser($_SESSION['user_id']);
        $this->render('products/index', ['products' => $products, 'title' => 'Mes Favoris']);
    }

    private function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}
