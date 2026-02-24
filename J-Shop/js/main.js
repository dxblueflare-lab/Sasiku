// ===== Main JavaScript =====

// Update cart count in navigation
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartCountElements = document.querySelectorAll('.cart-count');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    cartCountElements.forEach(element => {
        element.textContent = totalItems;
    });
}

// Check and update user menu
function updateUserMenu() {
    const userMenu = document.querySelector('.user-menu');
    const navLinks = document.querySelector('.nav-links');

    if (!navLinks) return;

    // Remove existing user menu/login buttons if any
    const existingUserMenu = navLinks.querySelector('.user-menu');
    const existingLoginBtns = navLinks.querySelector('.auth-buttons');
    if (existingUserMenu) existingUserMenu.remove();
    if (existingLoginBtns) existingLoginBtns.remove();

    if (isLoggedIn()) {
        const user = getCurrentUser();
        const userMenuHtml = `
            <li class="user-menu">
                <a href="dashboard.html" class="user-avatar">
                    <i class="fas fa-user"></i>
                </a>
                <div class="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="user-avatar-large">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-dropdown-info">
                            <span class="user-name">${user.firstname} ${user.lastname}</span>
                            <span class="user-email">${user.email}</span>
                        </div>
                    </div>
                    <ul class="user-dropdown-menu">
                        <li><a href="dashboard.html"><i class="fas fa-th-large"></i> Dashboard</a></li>
                        <li><a href="dashboard.html?tab=orders"><i class="fas fa-box"></i> My Orders</a></li>
                        <li><a href="dashboard.html?tab=profile"><i class="fas fa-user"></i> Profile</a></li>
                        <li><a href="dashboard.html?tab=addresses"><i class="fas fa-map-marker-alt"></i> Addresses</a></li>
                        <li><a href="dashboard.html?tab=wishlist"><i class="fas fa-heart"></i> Wishlist</a></li>
                    </ul>
                    <div class="user-dropdown-footer">
                        <button onclick="logout()" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </li>
            <li>
                <a href="cart.html" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </a>
            </li>
        `;
        navLinks.insertAdjacentHTML('beforeend', userMenuHtml);
        updateCartCount();
    } else {
        const loginBtnHtml = `
            <li class="auth-buttons">
                <a href="login.html" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <a href="register.html" class="btn btn-primary btn-register">
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </a>
            </li>
        `;
        navLinks.insertAdjacentHTML('beforeend', loginBtnHtml);
    }
}

// Add to cart function
function addToCart(productId) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity++;
    } else {
        const product = products.find(p => p.id === productId);
        if (product) {
            cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                category: product.category,
                quantity: 1
            });
        }
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showNotification('Product added to cart!');
}

// Show notification
function showNotification(message) {
    // Remove existing notifications
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
    notification.style.cssText = `
        position: fixed;
        top: 80px;
        right: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 50px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 3000;
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 2500);
}

// Mobile navigation toggle
document.addEventListener('DOMContentLoaded', () => {
    const navToggle = document.querySelector('.nav-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (navToggle) {
        navToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    }
    
    updateCartCount();
    updateUserMenu();
    
    // Newsletter form handling
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            showNotification('Thank you for subscribing!');
            newsletterForm.reset();
        });
    }
});

// Format price
function formatPrice(price) {
    return '$' + price.toFixed(2);
}

// Create product card HTML
function createProductCard(product) {
    const categoryIcons = {
        electronics: 'fa-laptop',
        clothing: 'fa-shirt',
        accessories: 'fa-watch',
        home: 'fa-couch'
    };
    
    const icon = categoryIcons[product.category] || 'fa-box';
    const ratingStars = getRatingStars(product.rating);
    const wishlistIcon = isWishlisted(product.id) ? 'fas' : 'far';
    
    return `
        <div class="product-card" data-id="${product.id}">
            <div class="product-wishlist-btn" onclick="toggleWishlistBtn(${product.id})">
                <i class="${wishlistIcon} fa-heart"></i>
            </div>
            <div class="product-image" style="background: linear-gradient(135deg, ${product.color}20, ${product.color}40); color: ${product.color}">
                <i class="fas ${icon}"></i>
            </div>
            <div class="product-info">
                <div class="product-category">${product.category}</div>
                <h3 class="product-title">${product.name}</h3>
                <div class="product-rating">${ratingStars}</div>
                <div class="product-price">${formatPrice(product.price)}</div>
                <button class="add-to-cart" onclick="addToCart(${product.id})">
                    <i class="fas fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>
    `;
}

// Check if product is in wishlist
function isWishlisted(productId) {
    if (!isLoggedIn()) return false;
    const wishlist = getWishlist();
    return wishlist.includes(productId);
}

// Toggle wishlist button
function toggleWishlistBtn(productId) {
    if (!isLoggedIn()) {
        showToast('Please login to add items to wishlist', 'info');
        localStorage.setItem('redirect_after_login', window.location.pathname);
        window.location.href = 'login.html';
        return;
    }
    
    const result = toggleWishlist(productId);
    if (result.success) {
        showToast(result.message, 'success');
        // Re-render to update wishlist icon
        const productsContainer = document.getElementById('products-container');
        if (productsContainer) {
            const filteredProducts = getFilteredProducts();
            productsContainer.innerHTML = filteredProducts.map(product => createProductCard(product)).join('');
        }
        // Update wishlist count in dashboard
        const wishlistCount = document.getElementById('wishlist-count');
        if (wishlistCount) {
            const stats = getUserStats();
            wishlistCount.textContent = stats.wishlistItems;
        }
    }
}

// Get filtered products (for re-rendering)
function getFilteredProducts() {
    let filtered = [...products];
    
    // Get current filter values
    const categoryFilter = document.getElementById('category-filter');
    const sortFilter = document.getElementById('sort-filter');
    const searchInput = document.getElementById('search-input');
    
    if (categoryFilter && categoryFilter.value !== 'all') {
        filtered = filtered.filter(p => p.category === categoryFilter.value);
    }
    
    if (searchInput && searchInput.value) {
        const term = searchInput.value.toLowerCase();
        filtered = filtered.filter(p => 
            p.name.toLowerCase().includes(term) ||
            p.description.toLowerCase().includes(term) ||
            p.category.toLowerCase().includes(term)
        );
    }
    
    if (sortFilter) {
        switch(sortFilter.value) {
            case 'price-low':
                filtered.sort((a, b) => a.price - b.price);
                break;
            case 'price-high':
                filtered.sort((a, b) => b.price - a.price);
                break;
            case 'name':
                filtered.sort((a, b) => a.name.localeCompare(b.name));
                break;
        }
    }
    
    return filtered;
}

// Get rating stars HTML
function getRatingStars(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= rating) {
            stars += '<i class="fas fa-star"></i>';
        } else if (i === Math.ceil(rating) && !Number.isInteger(rating)) {
            stars += '<i class="fas fa-star-half-alt"></i>';
        } else {
            stars += '<i class="far fa-star"></i>';
        }
    }
    return stars;
}

// Load featured products on homepage
document.addEventListener('DOMContentLoaded', () => {
    const featuredContainer = document.getElementById('featured-products');
    if (featuredContainer && typeof products !== 'undefined') {
        const featuredProducts = products.slice(0, 4);
        featuredContainer.innerHTML = featuredProducts.map(product => createProductCard(product)).join('');
    }
});

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
