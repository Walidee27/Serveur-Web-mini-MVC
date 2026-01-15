<div class="container">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1>Mes Commandes</h1>
    </div>

    <?php if (empty($orders)): ?>
        <div style="text-align: center; padding: 4rem 0;">
            <p>Vous n'avez pas encore passé de commande.</p>
            <br>
            <a href="/" class="btn">Découvrir la collection</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>N° Commande</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= str_pad((string) $order->getId(), 6, '0', STR_PAD_LEFT) ?></td>
                        <td><?= date('d/m/Y', strtotime($order->getCreated_at())) ?></td>
                        <td>
                            <span style="padding: 4px 8px; background: #f5f5f5; font-size: 0.8rem; text-transform: uppercase;">
                                <?= htmlspecialchars($order->getStatus()) ?>
                            </span>
                        </td>
                        <td style="font-weight: bold;"><?= number_format($order->getTotalPrice(), 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>