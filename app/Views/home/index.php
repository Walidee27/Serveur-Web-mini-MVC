<!-- Hero Banner -->
<div class="hero" style="margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%); width: 100vw;">
    <div class="hero-content fade-in">
        <h1>Automne-Hiver 2024</h1>
        <p>L'élégance intemporelle</p>
        <a href="/collections" class="btn">Découvrir la collection</a>
    </div>
</div>

<div class="container fade-in">
    <div class="section-header">
        <h2>Tendance</h2>
        <p>Nos coups de cœur du moment</p>
    </div>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card delay-1">
                <a href="/product?id=<?= $product->getId() ?>" style="text-decoration: none; color: inherit;">
                    <div class="product-image">
                        <img src="<?= htmlspecialchars($product->getImageUrl()) ?>"
                            alt="<?= htmlspecialchars($product->getName()) ?>">
                    </div>
                    <div class="product-info">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <h3>
                                <?= htmlspecialchars($product->getName()) ?>
                            </h3>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php
                                $isFav = \Mini\Models\Favorite::exists($_SESSION['user_id'], $product->getId());
                                ?>
                                <form action="/favorite/toggle" method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                                    <button type="submit"
                                        style="background:none; border:none; cursor:pointer; font-size: 1.2rem; color: <?= $isFav ? 'red' : '#ccc' ?>;">
                                        <?= $isFav ? '❤️' : '🤍' ?>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <p class="price">
                            <?= number_format($product->getPrice(), 2) ?> €
                        </p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 3rem;">
        <a href="/collections" class="btn btn-outline">Voir toute la collection</a>
    </div>
</div>