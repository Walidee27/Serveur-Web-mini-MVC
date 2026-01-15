<?php
declare(strict_types=1);

// Autoloader (copied from index.php)
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

use Mini\Core\Database;

try {
    $pdo = Database::getPDO();

    // 1. Supprimer les anciens articles qui n'ont pas d'image (ceux de l'ancien import)
    $count1 = $pdo->exec("DELETE FROM products WHERE image_url IS NULL");

    // 2. Supprimer les doublons exacts (même nom) en gardant le plus récent (ID le plus élevé)
    // Cette requête fonctionne sur MySQL
    $sql = "DELETE t1 FROM products t1 
            INNER JOIN products t2 
            WHERE t1.id < t2.id AND t1.name = t2.name";
    $count2 = $pdo->exec($sql);

    echo "<h1>Nettoyage terminé !</h1>";
    echo "<ul>";
    echo "<li>$count1 anciens articles (sans image) supprimés.</li>";
    echo "<li>$count2 doublons supprimés.</li>";
    echo "</ul>";
    echo "<p><a href='/'>Retour à la boutique</a></p>";

} catch (Exception $e) {
    echo "<h1>Erreur</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
