# Projet E-Commerce PHP Vanilla

Ce projet est une application e-commerce développée en PHP pur (sans framework) suivant une architecture MVC stricte, basée sur le modèle `mini_mvc`.

## 🎓 Comment ça marche ? (Le cours)

Imaginez ce site comme un **Restaurant** :

1.  **Le Routeur (`Router.php`)** : C'est l'**Hôte d'accueil**.
    *   Le client (votre navigateur) arrive et demande une page (ex: `/products`).
    *   L'hôte regarde son carnet de réservation (`index.php`) et dirige le client vers le bon serveur.

2.  **Le Contrôleur (`Controller`)** : C'est le **Serveur**.
    *   Il prend la commande du client.
    *   Il ne cuisine pas lui-même, mais il sait qui appeler.
    *   *Exemple* : Le `ProductController` reçoit la demande "voir les produits". Il demande au Cuisinier (Modèle) de lui donner les produits, puis il les donne au Dresseur (Vue) pour les présenter.

3.  **Le Modèle (`Model`)** : C'est le **Cuisinier**.
    *   Il est le seul à avoir accès au "Frigo" (la **Base de Données**).
    *   Il prépare les données brutes (les ingrédients).
    *   *Exemple* : `Product::findAll()` va chercher la liste des T-shirts dans la table `products`.

4.  **La Vue (`View`)** : C'est le **Dresseur d'assiette**.
    *   Elle reçoit les données préparées par le serveur et les met en page (HTML) pour que ce soit joli.
    *   Dans ce projet, on utilise un "Layout" (`layout.php`) qui est comme le plateau repas (avec les couverts, le verre, etc. qui sont toujours là), et on change juste l'assiette principale au milieu.

### 🔄 Le flux d'une requête (Exemple concret)

1.  **URL** : Vous tapez `http://localhost:8000/product?id=1`
2.  **Routeur** : "Ah, c'est pour `ProductController`, méthode `show`".
3.  **Contrôleur** : "Ok, je dois montrer le produit n°1".
    *   Il appelle `Product::findById(1)` (Modèle).
    *   Le Modèle interroge la BDD et renvoie les infos du T-shirt.
    *   Le Contrôleur appelle `$this->render('products/show', ...)` (Vue).
4.  **Vue** : Elle génère le HTML avec le nom et le prix du T-shirt.
5.  **Réponse** : Vous voyez la page s'afficher.

## Architecture Technique

- **Core** :
    - `Router` : Gestion des routes et dispatching.
    - `Controller` : Classe de base avec méthode `render()` et gestion de layout.
    - `Model` : Classe de base pour les entités.
    - `Database` : Singleton pour la connexion PDO (`Database::getPDO()`).
- **Models** : Utilisation de méthodes statiques pour la récupération (`findAll`, `findById`) et d'instances pour la manipulation de données.
- **Views** : Templates HTML injectés dans un layout global (`layout.php`).

## Prérequis

- PHP 7.4 ou supérieur
- MySQL
- Serveur web (Apache avec `mod_rewrite`)

## Installation

1.  **Cloner le projet** dans votre dossier web.
2.  **Base de données** :
    - Importer `schema.sql`.
    - Configurer les accès dans `app/Core/Database.php`.
3.  **Lancement** :
    - **Option 1 (Serveur interne PHP)** :
        Ouvrez un terminal à la racine du projet et lancez :
        ```bash
        php -S localhost:8000 -t public public/index.php
        ```
        Accédez ensuite à `http://localhost:8000`.
    - **Option 2 (Apache/MAMP/XAMPP)** :
        Accédez à l'application via votre navigateur, par exemple : `http://localhost/Projet%20mini_mvc/public/`.

## Fonctionnalités

- **Authentification** : Inscription, Connexion, Déconnexion.
- **Catalogue Produits** : Liste avec filtres, Détail produit, Gestion des stocks.
- **Panier** : Ajout/Suppression, Calcul du total, Persistance (Session + BDD).
- **Commandes** : Validation, Historique des commandes.
- **Pages Statiques** :
    - Service Client (Contact, FAQ, Livraison).
    - La Maison (Histoire, Carrières, RSE, Presse).
    - Légal (CGV, Confidentialité, Cookies).
- **Design Premium** :
    - Thème "Maison Luxe" (Noir & Blanc, Typographie soignée).
    - Hero Banner avec effet Parallaxe.
    - Animations fluides (Fade-in).
    - Images haute qualité (Unsplash).
