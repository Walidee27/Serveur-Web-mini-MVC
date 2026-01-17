# Projet E-Commerce PHP Vanilla - "Maison Luxe"

Ce projet est une application e-commerce développée en **PHP pur (sans framework)** suivant une architecture **MVC stricte**, basée sur le modèle `mini_mvc`.

Il simule une boutique de luxe avec un design épuré, des fonctionnalités complètes (panier, paiement, admin, newsletter) et une gestion de base de données robuste.

## 🎓 Architecture & Concepts

Le projet suit le pattern **MVC (Modèle-Vue-Contrôleur)** :

1.  **Routeur (`Router.php`)** : Point d'entrée unique. Il analyse l'URL et dirige la requête vers le bon Contrôleur.
2.  **Contrôleurs (`app/Controllers`)** : Ils reçoivent les requêtes, interrogent les Modèles et renvoient les Vues.
3.  **Modèles (`app/Models`)** : Ils gèrent les données et la logique métier (Active Record). Ils interagissent avec la base de données via `PDO`.
4.  **Vues (`app/Views`)** : Fichiers HTML/PHP qui affichent l'interface utilisateur. Elles sont injectées dans un layout global (`layout.php`).

## ✨ Fonctionnalités

### 🛍️ Front-Office (Client)
-   **Navigation** :
    -   **Page d'accueil** : Bannière "Hero" et produits "Tendance" (sélection aléatoire).
    -   **Collections** : Page dédiée pour choisir son univers (Homme, Femme, Enfant, Tout voir).
    -   **Filtres** : Filtrage par genre (Homme/Femme/Enfant) et catégories.
-   **Produits** :
    -   Fiche produit détaillée.
    -   **Sélection de taille** (XS, S, M, L, XL).
    -   Indicateur de stock (En stock, Peu de stock, Rupture).
    -   **Favoris** : Ajout/Retrait des coups de cœur (nécessite connexion).
-   **Panier & Commande** :
    -   Gestion du panier (Ajout avec taille, Suppression, Calcul total).
    -   Persistance du panier en base de données.
    -   **Paiement** : Simulation de paiement par carte bancaire.
    -   Historique des commandes avec statut.
-   **Authentification** : Inscription, Connexion, Déconnexion.
-   **Newsletter** : Formulaire d'inscription fonctionnel en pied de page.
-   **Pages Institutionnelles** : Mentions légales, CGV, Politique de confidentialité, etc.

### ⚙️ Back-Office (Admin)
Accessible via `/admin` (rôle 'admin' requis).
-   **Dashboard** : Statistiques clés (CA, nombre de commandes, utilisateurs, produits) et dernières commandes.
-   **Gestion Produits** : Création, Modification, Suppression de produits.
-   **Gestion Commandes** : Voir le détail (articles + tailles), changer le statut (En attente, Validée, Expédiée, Annulée).

## 🛠️ Installation

### Prérequis
-   PHP 7.4 ou supérieur
-   MySQL
-   Serveur web (Apache avec `mod_rewrite` activé ou serveur interne PHP)

### Étapes
1.  **Cloner le projet** :
    ```bash
    git clone https://github.com/Walidee27/Serveur-Web-mini-MVC.git
    cd Serveur-Web-mini-MVC
    ```

2.  **Base de données** :
    -   Créez une base de données nommée `ecommerce_project`.
    -   Importez le fichier `schema.sql` pour créer la structure initiale.
    -   *Note : Le projet inclut des migrations automatiques pour les fonctionnalités récentes (tailles, newsletter), assurez-vous que votre schéma est à jour.*

3.  **Configuration** :
    -   Ouvrez `app/Core/Database.php`.
    -   Modifiez les paramètres de connexion (`$host`, `$port`, `$username`, `$password`) selon votre environnement (MAMP, XAMPP, etc.).

4.  **Lancement** :
    -   **Via le serveur interne PHP (Recommandé pour le dev)** :
        ```bash
        npm run dev
        # Ou manuellement : php -S localhost:8000 -t public public/index.php
        ```
        Accédez à `http://localhost:8000`.

## � Comptes de Démonstration

Pour tester l'application, vous pouvez utiliser les comptes suivants (créés par `schema.sql`) :

| Rôle | Email | Mot de passe |
| :--- | :--- | :--- |
| **Admin** | `admin@maisonluxe.com` | `admin123` |
| **Client** | *(Créez un compte via l'inscription)* | - |

## �📂 Structure du Projet

```
/
├── app/
│   ├── Controllers/    # Logique de l'application (Admin, Auth, Cart, Product...)
│   ├── Core/           # Cœur du framework (Router, Model, Database...)
│   ├── Models/         # Représentation des données (User, Product, Order...)
│   └── Views/          # Templates HTML (admin/, auth/, cart/, home/, products/...)
├── public/
│   ├── assets/         # CSS, Images, JS
│   └── index.php       # Point d'entrée unique
├── schema.sql          # Structure de la base de données
└── README.md           # Documentation
```

## 👤 Auteur
Projet réalisé par Walide.
