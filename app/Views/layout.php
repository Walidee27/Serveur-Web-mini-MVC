<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' - MAISON LUXE' : 'MAISON LUXE' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <header>
        <div class="container">
            <nav>
                <a href="/" class="logo">MAISON LUXE</a>
                <div class="nav-links">
                    <a href="/collections">Collections</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/cart">Panier</a>
                        <a href="/orders">Commandes</a>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <a href="/admin" style="color: red;">Admin</a>
                        <?php endif; ?>
                        <a href="/logout">Déconnexion</a>
                    <?php else: ?>
                        <a href="/login">Connexion</a>
                        <a href="/register">Inscription</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Service Client</h3>
                    <ul>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/delivery">Livraison & Retours</a></li>
                        <li><a href="/faq">FAQ</a></li>
                        <li><a href="/orders">Suivre ma commande</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>La Maison</h3>
                    <ul>
                        <li><a href="/history">Histoire de la Maison</a></li>
                        <li><a href="/careers">Carrières</a></li>
                        <li><a href="/sustainability">Développement Durable</a></li>
                        <li><a href="/press">Presse</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Mentions Légales</h3>
                    <ul>
                        <li><a href="/cgv">Conditions Générales de Vente</a></li>
                        <li><a href="/privacy">Politique de Confidentialité</a></li>
                        <li><a href="/cookies">Cookies</a></li>
                        <li><a href="/legal">Mentions Légales</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Newsletter</h3>
                    <p style="color: #999; margin-bottom: 1rem;">Inscrivez-vous pour recevoir nos actualités.</p>
                    <form action="#" style="display: flex; gap: 10px;">
                        <input type="email" placeholder="Votre email"
                            style="background: transparent; border: 1px solid #333; color: white; padding: 5px;">
                        <button type="button" class="btn" style="padding: 5px 10px; font-size: 0.7rem;">OK</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; <?= date('Y') ?> MAISON LUXE. Tous droits réservés.
            </div>
        </div>
    </footer>
</body>

</html>