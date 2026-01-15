<div class="container fade-in">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Gestion des Produits</h1>
        <a href="/admin/products/create" class="btn">Nouveau Produit</a>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid #000;">
                <th style="text-align: left; padding: 1rem;">Image</th>
                <th style="text-align: left; padding: 1rem;">Nom</th>
                <th style="text-align: left; padding: 1rem;">Prix</th>
                <th style="text-align: left; padding: 1rem;">Stock</th>
                <th style="text-align: left; padding: 1rem;">Genre</th>
                <th style="text-align: right; padding: 1rem;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 1rem;">
                        <img src="<?= htmlspecialchars($product->getImageUrl()) ?>"
                            style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td style="padding: 1rem;">
                        <?= htmlspecialchars($product->getName()) ?>
                    </td>
                    <td style="padding: 1rem;">
                        <?= number_format($product->getPrice(), 2) ?> €
                    </td>
                    <td style="padding: 1rem;">
                        <?php
                        $stock = $product->getStock();
                        $color = $stock == 0 ? 'red' : ($stock < 5 ? 'orange' : 'green');
                        ?>
                        <span style="color: <?= $color ?>; font-weight: bold;">
                            <?= $stock ?>
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <?= ucfirst($product->getGender() ?? 'Unisexe') ?>
                    </td>
                    <td style="padding: 1rem; text-align: right;">
                        <a href="/admin/products/edit?id=<?= $product->getId() ?>" style="margin-right: 1rem;">Modifier</a>
                        <a href="/admin/products/delete?id=<?= $product->getId() ?>" style="color: red;"
                            onclick="return confirm('Supprimer ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>