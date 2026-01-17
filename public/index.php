<?php

declare(strict_types=1);

// Support pour le serveur interne de PHP (php -S)
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file(__DIR__ . $path)) {
        return false;
    }
}

session_start();

// Custom Autoloader since composer might not be available
spl_autoload_register(function ($class) {
    $prefix = 'Mini\\';
    $base_dir = dirname(__DIR__) . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use Mini\Core\Router;

// Define routes
$routes = [
    // Auth
    ['GET', '/login', [Mini\Controllers\AuthController::class, 'showLogin']],
    ['POST', '/login', [Mini\Controllers\AuthController::class, 'login']],
    ['GET', '/register', [Mini\Controllers\AuthController::class, 'showRegister']],
    ['POST', '/register', [Mini\Controllers\AuthController::class, 'register']],
    ['GET', '/logout', [Mini\Controllers\AuthController::class, 'logout']],

    // Home & Products
    // Home & Products
    ['GET', '/', [Mini\Controllers\HomeController::class, 'index']],
    ['GET', '/collections', [Mini\Controllers\CollectionsController::class, 'index']],
    ['GET', '/products', [Mini\Controllers\ProductController::class, 'index']],
    ['GET', '/product', [Mini\Controllers\ProductController::class, 'show']],

    // Cart
    ['GET', '/cart', [Mini\Controllers\CartController::class, 'index']],
    ['POST', '/cart/add', [Mini\Controllers\CartController::class, 'add']],
    ['POST', '/cart/remove', [Mini\Controllers\CartController::class, 'remove']],

    // Orders
    ['POST', '/order/create', [Mini\Controllers\OrderController::class, 'create']],
    ['GET', '/orders', [Mini\Controllers\OrderController::class, 'index']],

    // Favorites
    ['POST', '/favorite/toggle', [Mini\Controllers\FavoriteController::class, 'toggle']],
    ['GET', '/favorites', [Mini\Controllers\FavoriteController::class, 'index']],

    // Admin
    ['GET', '/admin', [Mini\Controllers\AdminController::class, 'dashboard']],
    ['GET', '/admin/products', [Mini\Controllers\AdminController::class, 'products']],
    ['GET', '/admin/products/create', [Mini\Controllers\AdminController::class, 'productCreate']],
    ['POST', '/admin/products/create', [Mini\Controllers\AdminController::class, 'productCreate']],
    ['GET', '/admin/products/edit', [Mini\Controllers\AdminController::class, 'productEdit']],
    ['POST', '/admin/products/edit', [Mini\Controllers\AdminController::class, 'productEdit']],
    ['GET', '/admin/products/delete', [Mini\Controllers\AdminController::class, 'productDelete']],
    ['GET', '/admin/orders', [Mini\Controllers\AdminController::class, 'orders']],
    ['GET', '/admin/orders/view', [Mini\Controllers\AdminController::class, 'orderView']],
    ['POST', '/admin/orders/view', [Mini\Controllers\AdminController::class, 'orderView']],

    // Payment
    ['GET', '/payment/checkout', [Mini\Controllers\PaymentController::class, 'checkout']],
    ['POST', '/payment/checkout', [Mini\Controllers\PaymentController::class, 'checkout']], // Allow POST from cart
    ['POST', '/payment/process', [Mini\Controllers\PaymentController::class, 'process']],
    ['GET', '/payment/success', [Mini\Controllers\PaymentController::class, 'success']],
    ['GET', '/payment/cancel', [Mini\Controllers\PaymentController::class, 'cancel']],

    // Static Pages
    ['GET', '/contact', [Mini\Controllers\PageController::class, 'contact']],
    ['GET', '/delivery', [Mini\Controllers\PageController::class, 'delivery']],
    ['GET', '/faq', [Mini\Controllers\PageController::class, 'faq']],
    ['GET', '/history', [Mini\Controllers\PageController::class, 'history']],
    ['GET', '/careers', [Mini\Controllers\PageController::class, 'careers']],
    ['GET', '/sustainability', [Mini\Controllers\PageController::class, 'sustainability']],
    ['GET', '/press', [Mini\Controllers\PageController::class, 'press']],
    ['GET', '/cgv', [Mini\Controllers\PageController::class, 'cgv']],
    ['GET', '/privacy', [Mini\Controllers\PageController::class, 'privacy']],
    ['GET', '/cookies', [Mini\Controllers\PageController::class, 'cookies']],
    ['GET', '/legal', [Mini\Controllers\PageController::class, 'legal']],

    // Newsletter
    ['POST', '/newsletter/subscribe', [Mini\Controllers\NewsletterController::class, 'subscribe']],
];

// Dispatch
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
