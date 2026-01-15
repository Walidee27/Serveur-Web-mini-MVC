<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $filters = [];
        if (isset($_GET['gender'])) {
            $filters['gender'] = $_GET['gender'];
        }
        if (isset($_GET['category'])) {
            $filters['category_id'] = $_GET['category'];
        }

        $products = Product::findAll($filters);
        $this->render('products/index', ['products' => $products, 'title' => 'Nos Produits']);
    }

    public function show()
    {
        if (!isset($_GET['id'])) {
            $this->redirect('/');
        }

        $product = Product::find((int) $_GET['id']);

        if (!$product) {
            $this->redirect('/');
        }

        $this->render('products/show', ['product' => $product, 'title' => $product->getName()]);
    }
}
