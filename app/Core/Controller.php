<?php

declare(strict_types=1);

namespace Mini\Core;

class Controller
{
    protected function render(string $view, array $params = []): void
    {
        extract($params);

        $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
        $layoutFile = dirname(__DIR__) . '/Views/layout.php';

        if (file_exists($viewFile)) {
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo "View $view not found";
        }
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
