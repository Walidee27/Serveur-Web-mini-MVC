<div style="max-width: 400px; margin: 0 auto; padding: 4rem 0;">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1>Connexion</h1>
        <p style="color: gray;">Accédez à votre espace personnel</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form action="/login" method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Se connecter</button>
    </form>

    <div style="text-align: center; margin-top: 2rem;">
        <p>Pas encore de compte ? <a href="/register" style="text-decoration: underline;">Créer un compte</a></p>
    </div>
</div>