<div class="container fade-in">
    <h1>Gestion des Commandes</h1>

    <table style="width: 100%; border-collapse: collapse; margin-top: 2rem;">
        <thead>
            <tr style="border-bottom: 2px solid #000;">
                <th style="text-align: left; padding: 1rem;">ID</th>
                <th style="text-align: left; padding: 1rem;">Client ID</th>
                <th style="text-align: left; padding: 1rem;">Total</th>
                <th style="text-align: left; padding: 1rem;">Statut</th>
                <th style="text-align: left; padding: 1rem;">Date</th>
                <th style="text-align: right; padding: 1rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem;">#
                        <?= $order->getId() ?>
                    </td>
                    <td style="padding: 1rem;">
                        <?= $order->getUserId() ?>
                    </td>
                    <td style="padding: 1rem;">
                        <?= number_format($order->getTotalPrice(), 2) ?> €
                    </td>
                    <td style="padding: 1rem;">
                        <span style="padding: 0.25rem 0.5rem; background: #eee; border-radius: 4px;">
                            <?= ucfirst($order->getStatus()) ?>
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <?= date('d/m/Y H:i', strtotime($order->getCreated_at())) ?>
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <a href="/admin/orders/view?id=<?= $order->getId() ?>">Détails</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>