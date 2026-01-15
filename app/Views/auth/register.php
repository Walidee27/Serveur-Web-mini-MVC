<div style="max-width: 400px; margin: 0 auto; padding: 4rem 0;">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1>Inscription</h1>
        <p style="color: gray;">Rejoignez l'univers Maison Luxe</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form action="/register" method="POST">
        <div class="form-group">
            <label>Prénom</label>
            <input type="text" name="first_name" required>
        </div>
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="last_name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Créer mon compte</button>
    </form>

    <div style="text-align: center; margin-top: 2rem;">
        <p>Déjà membre ? <a href="/login" style="text-decoration: underline;">Se connecter</a></p>
    </div>
</div>