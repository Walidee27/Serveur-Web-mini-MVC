<div class="container fade-in">
    <h1>
        <?= $title ?>
    </h1>

    <form action="" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: 2rem auto;">
        <?= \Mini\Core\Csrf::renderInput() ?>
        <div class="form-group">
            <label>Nom du produit</label>
            <input type="text" name="name" value="<?= isset($product) ? htmlspecialchars($product->getName()) : '' ?>"
                required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4"
                required><?= isset($product) ? htmlspecialchars($product->getDescription()) : '' ?></textarea>
        </div>

        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Prix (€)</label>
                <input type="number" step="0.01" name="price" value="<?= isset($product) ? $product->getPrice() : '' ?>"
                    required>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" value="<?= isset($product) ? $product->getStock() : '' ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Image du produit</label>
            <?php if (isset($product) && $product->getImageUrl()): ?>
                <div style="margin-bottom: 10px;">
                    <img src="<?= htmlspecialchars($product->getImageUrl()) ?>" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">
                </div>
                <input type="hidden" name="current_image_url" value="<?= htmlspecialchars($product->getImageUrl()) ?>">
            <?php endif; ?>
            <input type="file" name="image_file" accept="image/*" <?= isset($product) ? '' : 'required' ?>>
            <p style="font-size: 0.8rem; color: gray; margin-top: 5px;">Formats acceptés : JPG, PNG, WEBP</p>
        </div>

        <div class="grid-2" style="gap: 1rem;">
            <div class="form-group">
                <label>Catégorie</label>
                <select name="category_id" required>
                    <option value="1" <?= (isset($product) && $product->getCategoryId() == 1) ? 'selected' : '' ?>>
                        Vêtements Homme</option>
                    <option value="2" <?= (isset($product) && $product->getCategoryId() == 2) ? 'selected' : '' ?>>
                        Vêtements Femme</option>
                    <option value="3" <?= (isset($product) && $product->getCategoryId() == 3) ? 'selected' : '' ?>>
                        Accessoires</option>
                </select>
            </div>
            <div class="form-group">
                <label>Genre</label>
                <select name="gender" required>
                    <option value="homme" <?= (isset($product) && $product->getGender() == 'homme') ? 'selected' : '' ?>>
                        Homme</option>
                    <option value="femme" <?= (isset($product) && $product->getGender() == 'femme') ? 'selected' : '' ?>>
                        Femme</option>
                    <option value="enfant" <?= (isset($product) && $product->getGender() == 'enfant') ? 'selected' : '' ?>>
                        Enfant</option>
                    <option value="unisexe" <?= (isset($product) && $product->getGender() == 'unisexe') ? 'selected' : '' ?>>Unisexe</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn" style="width: 100%; margin-top: 2rem;">Enregistrer</button>
    </form>
</div>