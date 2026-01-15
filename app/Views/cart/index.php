<div class="container">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1>Votre Panier</h1>
    </div>

    <?php if (empty($items)): ?>
        <div style="text-align: center; padding: 4rem 0;">
            <p style="margin-bottom: 2rem;">Votre panier est actuellement vide.</p>
            <a href="/" class="btn">Continuer mes achats</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td style="display: flex; align-items: center; gap: 1rem;">
                            <?php $img = $item['image_url'] ?: 'https://via.placeholder.com/50x50/f5f5f5/000000?text=ML'; ?>
                            <img src="<?= htmlspecialchars($img) ?>" alt=""
                                style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <div style="font-weight: bold;"><?= htmlspecialchars($item['name']) ?></div>
                                <?php if (!empty($item['size'])): ?>
                                    <div style="font-size: 0.8rem; color: gray;">Taille : <?= htmlspecialchars($item['size']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td><?= number_format($item['price'], 2) ?> €</td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity'], 2) ?> €</td>
                        <td>
                            <form action="/cart/remove" method="POST" style="margin: 0;">
                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                <button type="submit"
                                    style="background: none; border: none; text-decoration: underline; cursor: pointer; font-size: 0.8rem;">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div
            style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid black;">
            <a href="/" style="text-decoration: underline;">Continuer mes achats</a>
            <div style="text-align: right;">
                <div class="cart-summary">
                    <h3>Total</h3>
                    <p class="total-price"><?= number_format($total, 2) ?> €</p>
                    <form action="/payment/checkout" method="POST">
                        <button type="submit" class="btn btn-block">Payer par Carte Bancaire</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>