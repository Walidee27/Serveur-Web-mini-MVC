<div class="container fade-in">
    <h1>Tableau de Bord Admin</h1>

    <div class="grid-2" style="grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
        <div style="padding: 1.5rem; background: #f9f9f9; border: 1px solid #eee; text-align: center;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">
                <?= $stats['products'] ?>
            </h3>
            <p>Produits</p>
        </div>
        <div style="padding: 1.5rem; background: #f9f9f9; border: 1px solid #eee; text-align: center;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">
                <?= $stats['orders'] ?>
            </h3>
            <p>Commandes</p>
        </div>
        <div style="padding: 1.5rem; background: #f9f9f9; border: 1px solid #eee; text-align: center;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">
                <?= number_format($stats['revenue'], 2) ?> €
            </h3>
            <p>Chiffre d'affaires</p>
        </div>
        <div style="padding: 1.5rem; background: #f9f9f9; border: 1px solid #eee; text-align: center;">
            <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">
                <?= $stats['users'] ?>
            </h3>
            <p>Clients</p>
        </div>
    </div>

    <div class="grid-2" style="gap: 3rem;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>Dernières Commandes</h2>
                <a href="/admin/orders" class="btn">Voir tout</a>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #000;">
                        <th style="text-align: left; padding: 1rem 0;">ID</th>
                        <th style="text-align: left; padding: 1rem 0;">Total</th>
                        <th style="text-align: left; padding: 1rem 0;">Statut</th>
                        <th style="text-align: left; padding: 1rem 0;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 1rem 0;">#
                                <?= $order['id'] ?>
                            </td>
                            <td style="padding: 1rem 0;">
                                <?= number_format($order['total_price'], 2) ?> €
                            </td>
                            <td style="padding: 1rem 0;">
                                <?= ucfirst($order['status']) ?>
                            </td>
                            <td style="padding: 1rem 0;">
                                <?= date('d/m/Y', strtotime($order['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h2>Actions Rapides</h2>
            </div>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <a href="/admin/products" class="btn" style="text-align: center;">Gérer les Produits</a>
                <a href="/" class="btn"
                    style="text-align: center; background: transparent; color: black; border: 1px solid black;">Retour
                    au Site</a>
            </div>
        </div>
    </div>
</div>