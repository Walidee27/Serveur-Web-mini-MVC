document.addEventListener('DOMContentLoaded', () => {
    
    // --- Add to Cart (AJAX) ---
    const cartForms = document.querySelectorAll('form[action="/cart/add"]');
    
    cartForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerText;
            
            btn.disabled = true;
            btn.innerText = "Ajout...";

            try {
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.success) {
                        // Update cart count
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.innerText = data.cartCount;
                        }
                        
                        // Optional: Show success feedback
                        btn.innerText = "Ajouté !";
                        setTimeout(() => {
                            btn.innerText = originalText;
                            btn.disabled = false;
                        }, 2000);
                    } else {
                        // Handle error (e.g. redirect if not logged in)
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    }
                } else {
                    // Fallback for non-JSON errors
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
                window.location.reload();
            }
        });
    });

    // --- Toggle Favorite (AJAX) ---
    const favForms = document.querySelectorAll('form[action="/favorite/toggle"]');

    favForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const btn = form.querySelector('button');
            
            try {
                const response = await fetch('/favorite/toggle', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    if (data.status) {
                        // Toggle icon
                        if (data.status === 'added') {
                            btn.style.color = 'red';
                            btn.innerText = '❤️';
                        } else {
                            btn.style.color = '#ccc';
                            btn.innerText = '🤍';
                        }
                    }
                } else {
                    if (response.status === 401) {
                        window.location.href = '/login';
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});
