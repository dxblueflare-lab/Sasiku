// ===== Cart Page JavaScript =====

document.addEventListener('DOMContentLoaded', () => {
    const cartItemsContainer = document.getElementById('cart-items');
    const emptyCartElement = document.getElementById('empty-cart');
    const subtotalElement = document.getElementById('subtotal');
    const shippingElement = document.getElementById('shipping');
    const taxElement = document.getElementById('tax');
    const totalElement = document.getElementById('total');
    const checkoutBtn = document.getElementById('checkout-btn');
    
    // Load cart
    loadCart();
    
    function loadCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            if (cartItemsContainer) cartItemsContainer.style.display = 'none';
            if (emptyCartElement) emptyCartElement.style.display = 'block';
            if (checkoutBtn) checkoutBtn.style.pointerEvents = 'none';
            if (checkoutBtn) checkoutBtn.style.opacity = '0.5';
        } else {
            if (cartItemsContainer) cartItemsContainer.style.display = 'block';
            if (emptyCartElement) emptyCartElement.style.display = 'none';
            if (checkoutBtn) checkoutBtn.style.pointerEvents = 'auto';
            if (checkoutBtn) checkoutBtn.style.opacity = '1';
        }
        
        renderCartItems(cart);
        updateCartSummary(cart);
    }
    
    function renderCartItems(cart) {
        if (!cartItemsContainer) return;
        
        cartItemsContainer.innerHTML = cart.map(item => `
            <div class="cart-item" data-id="${item.id}">
                <div class="cart-item-image" style="background-color: ${item.color || '#6366f1'}20; color: ${item.color || '#6366f1'}">
                    <i class="fas ${getCategoryIcon(item.category)}"></i>
                </div>
                <div class="cart-item-info">
                    <h3>${item.name}</h3>
                    <p>Category: ${item.category}</p>
                    <div class="cart-item-price">${formatPrice(item.price)}</div>
                </div>
                <div class="cart-item-actions">
                    <div class="quantity-control">
                        <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <i class="fas fa-trash remove-item" onclick="removeFromCart(${item.id})"></i>
                </div>
            </div>
        `).join('');
    }
    
    function getCategoryIcon(category) {
        const icons = {
            electronics: 'fa-laptop',
            clothing: 'fa-tshirt',
            accessories: 'fa-watch',
            home: 'fa-couch'
        };
        return icons[category] || 'fa-box';
    }
    
    function updateCartSummary(cart) {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const shipping = subtotal > 50 ? 0 : 9.99;
        const tax = subtotal * 0.1;
        const total = subtotal + shipping + tax;
        
        if (subtotalElement) subtotalElement.textContent = formatPrice(subtotal);
        if (shippingElement) shippingElement.textContent = shipping === 0 ? 'FREE' : formatPrice(shipping);
        if (taxElement) taxElement.textContent = formatPrice(tax);
        if (totalElement) totalElement.textContent = formatPrice(total);
    }
    
    // Update quantity
    window.updateQuantity = function(productId, change) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const item = cart.find(item => item.id === productId);
        
        if (item) {
            item.quantity += change;
            
            if (item.quantity <= 0) {
                removeFromCart(productId);
                return;
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
            updateCartCount();
        }
    };
    
    // Remove from cart
    window.removeFromCart = function(productId) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
        updateCartCount();
        showNotification('Item removed from cart');
    };
});
