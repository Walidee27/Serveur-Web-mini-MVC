<div class="container fade-in" style="max-width: 500px; margin: 4rem auto;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1>Paiement Sécurisé</h1>
        <p>Total à payer : <strong>
                <?= number_format($total, 2) ?> €
            </strong></p>
    </div>

    <div style="background: #f9f9f9; padding: 2rem; border: 1px solid #eee; border-radius: 8px;">
        <form action="/payment/process" method="POST" id="payment-form">
            <div class="form-group">
                <label>Titulaire de la carte</label>
                <input type="text" placeholder="Jean Dupont" required
                    style="width: 100%; padding: 10px; margin-bottom: 1rem; border: 1px solid #ddd;">
            </div>

            <div class="form-group">
                <label>Numéro de carte</label>
                <div style="position: relative;">
                    <input type="text" placeholder="0000 0000 0000 0000" maxlength="19" required
                        style="width: 100%; padding: 10px; margin-bottom: 1rem; border: 1px solid #ddd;">
                    <span style="position: absolute; right: 10px; top: 10px;">💳</span>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <div class="form-group" style="flex: 1;">
                    <label>Expiration</label>
                    <input type="text" placeholder="MM/AA" maxlength="5" required
                        style="width: 100%; padding: 10px; margin-bottom: 1rem; border: 1px solid #ddd;">
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>CVC</label>
                    <input type="text" placeholder="123" maxlength="3" required
                        style="width: 100%; padding: 10px; margin-bottom: 1rem; border: 1px solid #ddd;">
                </div>
            </div>

            <button type="submit" class="btn"
                style="width: 100%; margin-top: 1rem; background: #000; color: #fff;">Payer
                <?= number_format($total, 2) ?> €
            </button>
        </form>

        <div style="text-align: center; margin-top: 1rem; font-size: 0.8rem; color: gray;">
            <p>🔒 Paiement sécurisé par SSL</p>
            <p>Ceci est une simulation de paiement.</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('payment-form').addEventListener('submit', function (e) {
        const btn = this.querySelector('button');
        btn.innerHTML = 'Traitement en cours...';
        btn.style.opacity = '0.7';
    });
</script>