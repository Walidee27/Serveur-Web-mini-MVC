<?php

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $trendingProducts = Product::getTrending(4);
        $this->render('home/index', ['products' => $trendingProducts, 'title' => 'Accueil']);
    }
}
