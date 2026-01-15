<div class="container fade-in">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Commande #
            <?= $order['id'] ?>
        </h1>
        <a href="/admin/orders" class="btn"
            style="background: transparent; color: black; border: 1px solid black;">Retour</a>
    </div>

    <div class="grid-2" style="gap: 3rem; align-items: start;">
        <div>
            <h3>Articles</h3>
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr style="border-bottom: 1px solid #eee;">
                        <th style="text-align: left; padding: 0.5rem;">Produit</th>
                        <th style="text-align: center; padding: 0.5rem;">Qté</th>
                        <th style="text-align: right; padding: 0.5rem;">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <img src="<?= htmlspecialchars($item['image_url']) ?>"
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                    <span>
                                        <?= htmlspecialchars($item['name']) ?>
                                        <?php if (!empty($item['size'])): ?>
                                            <span
                                                style="color: gray; font-size: 0.8rem;">(<?= htmlspecialchars($item['size']) ?>)</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                            <td style="text-align: center; padding: 1rem 0.5rem;">
                                <?= $item['quantity'] ?>
                            </td>
                            <td style="text-align: right; padding: 1rem 0.5rem;">
                                <?= number_format($item['price_at_purchase'], 2) ?> €
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right; padding: 1rem; font-weight: bold;">Total</td>
                        <td style="text-align: right; padding: 1rem; font-weight: bold;">
                            <?= number_format($order['total_price'], 2) ?> €
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div style="background: #f9f9f9; padding: 2rem; border: 1px solid #eee;">
            <h3>Gestion de la commande</h3>
            <p style="margin: 1rem 0;"><strong>Date :</strong>
                <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
            </p>
            <p style="margin-bottom: 2rem;"><strong>Client ID :</strong>
                <?= $order['user_id'] ?>
            </p>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Statut</label>
                    <select name="status" style="width: 100%; padding: 10px; margin-top: 0.5rem;">
                        <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>En attente</option>
                        <option value="validated" <?= $order['status'] == 'validated' ? 'selected' : '' ?>>Validée</option>
                        <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Expédiée</option>
                        <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Annulée</option>
                    </select>
                </div>
                <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>