<div class="container">
    <div class="product-detail">
        <div>
            <?php $img = $product->getImageUrl() ?: 'https://via.placeholder.com/600x800/f5f5f5/000000?text=MAISON+LUXE'; ?>
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($product->getName()) ?>"
                class="product-detail-image">
        </div>

        <div class="product-info" style="position: sticky; top: 100px;">
            <div class="product-category"><?= htmlspecialchars($product->getCategoryName()) ?></div>
            <h1><?= htmlspecialchars($product->getName()) ?></h1>
            <div class="product-price" style="font-size: 1.5rem; margin-bottom: 2rem;">
                <?= number_format($product->getPrice(), 2) ?> €
            </div>

            <div class="product-description">
                <?= nl2br(htmlspecialchars($product->getDescription())) ?>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form action="/cart/add" method="POST" style="margin: 0; max-width: 100%;">
                    <?= \Mini\Core\Csrf::renderInput() ?>
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">

                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 0.5rem;">Taille</label>
                        <select name="size"
                            style="width: 100%; padding: 10px; border: 1px solid black; margin-bottom: 1rem;">
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M" selected>M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                        </select>

                        <label style="display: block; margin-bottom: 0.5rem;">Quantité</label>
                        <select name="quantity" style="width: 100%; padding: 10px; border: 1px solid black;">
                            <?php for ($i = 1; $i <= min(5, $product->getStock()); $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <?php if ($product->getStock() > 0): ?>
                        <button type="submit" class="btn" style="width: 100%;">Ajouter au panier</button>
                    <?php else: ?>
                        <button disabled class="btn" style="width: 100%; opacity: 0.5; cursor: not-allowed;">Rupture de
                            stock</button>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <div style="margin-top: 2rem;">
                    <a href="/login" class="btn">Se connecter pour acheter</a>
                </div>
            <?php endif; ?>

            <div style="margin-top: 2rem; font-size: 0.8rem; color: gray;">
                <p>RÉF: <?= str_pad((string) $product->getId(), 6, '0', STR_PAD_LEFT) ?></p>
                <p>Livraison offerte & Retours gratuits sous 30 jours.</p>
            </div>
        </div>
    </div>
</div>