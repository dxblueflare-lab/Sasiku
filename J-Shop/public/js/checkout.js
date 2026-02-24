// ===== Checkout Page JavaScript =====

document.addEventListener('DOMContentLoaded', () => {
    const orderItemsContainer = document.getElementById('order-items');
    const subtotalElement = document.getElementById('subtotal');
    const shippingElement = document.getElementById('shipping');
    const taxElement = document.getElementById('tax');
    const totalElement = document.getElementById('total');
    const checkoutForm = document.getElementById('checkout-form');
    const successModal = document.getElementById('success-modal');
    const orderNumberElement = document.getElementById('order-number');
    
    // Load order summary
    loadOrderSummary();
    
    function loadOrderSummary() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            window.location.href = '/cart';
            return;
        }
        
        renderOrderItems(cart);
        updateOrderSummary(cart);
    }
    
    function renderOrderItems(cart) {
        if (!orderItemsContainer) return;
        
        orderItemsContainer.innerHTML = cart.map(item => `
            <div class="order-item">
                <div class="order-item-image" style="background-color: ${item.color || '#6366f1'}20; color: ${item.color || '#6366f1'}">
                    <i class="fas ${getCategoryIcon(item.category)}"></i>
                </div>
                <div class="order-item-info">
                    <h4>${item.name}</h4>
                    <p>Qty: ${item.quantity}</p>
                </div>
                <div class="order-item-price">${formatPrice(item.price * item.quantity)}</div>
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
    
    function updateOrderSummary(cart) {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const shipping = subtotal > 50 ? 0 : 9.99;
        const tax = subtotal * 0.1;
        const total = subtotal + shipping + tax;
        
        if (subtotalElement) subtotalElement.textContent = formatPrice(subtotal);
        if (shippingElement) shippingElement.textContent = shipping === 0 ? 'FREE' : formatPrice(shipping);
        if (taxElement) taxElement.textContent = formatPrice(tax);
        if (totalElement) totalElement.textContent = formatPrice(total);
    }
    
    // Form submission
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Generate random order number
            const orderNumber = 'J' + Math.random().toString(36).substr(2, 9).toUpperCase();
            
            // Show success modal
            if (orderNumberElement) orderNumberElement.textContent = orderNumber;
            if (successModal) successModal.classList.add('active');
            
            // Clear cart
            localStorage.removeItem('cart');
            updateCartCount();
            
            // Reset form
            checkoutForm.reset();
        });
    }
    
    // Close modal when clicking outside
    if (successModal) {
        successModal.addEventListener('click', (e) => {
            if (e.target === successModal) {
                successModal.classList.remove('active');
            }
        });
    }
});
