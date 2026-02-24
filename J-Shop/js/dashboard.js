// ===== Dashboard JavaScript =====

document.addEventListener('DOMContentLoaded', () => {
    // Require authentication
    if (!requireAuth()) return;
    
    const currentUser = getCurrentUser();
    
    // Update user info throughout the page
    updateUserInfo(currentUser);
    
    // Load dashboard data
    loadDashboardStats();
    loadRecentOrders();
    loadWishlistPreview();
    
    // Handle tab navigation
    handleTabNavigation();
    
    // Check URL for tab parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if (tab) {
        switchTab(tab);
    }
    
    // Profile form
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        loadProfileData();
        profileForm.addEventListener('submit', handleProfileUpdate);
    }
    
    // Security form
    const securityForm = document.getElementById('security-form');
    if (securityForm) {
        securityForm.addEventListener('submit', handlePasswordChange);
    }
    
    // Load addresses
    loadAddresses();
    
    // Load orders
    loadOrders();
    
    // Load wishlist
    loadWishlist();
});

// Update user info in UI
function updateUserInfo(user) {
    const elements = {
        'nav-user-name': user.firstname + ' ' + user.lastname,
        'nav-user-email': user.email,
        'dashboard-user-name': user.firstname,
        'sidebar-user-name': user.firstname + ' ' + user.lastname,
        'sidebar-user-email': user.email,
        'member-since': new Date(user.createdAt || Date.now()).getFullYear()
    };
    
    Object.entries(elements).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    });
}

// Load dashboard statistics
function loadDashboardStats() {
    const stats = getUserStats();
    
    const elements = {
        'total-orders': stats.totalOrders,
        'total-spent': formatCurrency(stats.totalSpent),
        'wishlist-items': stats.wishlistItems,
        'cart-items': stats.cartItems,
        'orders-count': stats.totalOrders,
        'wishlist-count': stats.wishlistItems
    };
    
    Object.entries(elements).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    });
}

// Load recent orders
function loadRecentOrders() {
    const container = document.getElementById('recent-orders');
    if (!container) return;
    
    const orders = getUserOrders().slice(0, 3);
    
    if (orders.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>No orders yet</p>
                <a href="products.html" class="btn btn-primary">Start Shopping</a>
            </div>
        `;
        return;
    }
    
    container.innerHTML = orders.map(order => `
        <div class="order-card">
            <div class="order-header">
                <div class="order-info">
                    <span class="order-number">${order.orderNumber}</span>
                    <span class="order-date">${formatDate(order.createdAt)}</span>
                </div>
                <span class="order-status status-${order.status.toLowerCase()}">${order.status}</span>
            </div>
            <div class="order-items-preview">
                ${order.items.slice(0, 3).map(item => `
                    <div class="order-item-preview">
                        <div class="item-image" style="background-color: ${item.color || '#6366f1'}20">
                            <i class="fas ${getCategoryIcon(item.category)}"></i>
                        </div>
                        <div class="item-info">
                            <span class="item-name">${item.name}</span>
                            <span class="item-quantity">Qty: ${item.quantity}</span>
                        </div>
                    </div>
                `).join('')}
                ${order.items.length > 3 ? `<span class="more-items">+${order.items.length - 3} more</span>` : ''}
            </div>
            <div class="order-footer">
                <span class="order-total">Total: ${formatCurrency(order.total)}</span>
                <button class="btn btn-sm" onclick="viewOrder('${order.id}')">
                    View Details <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    `).join('');
}

// Load wishlist preview
function loadWishlistPreview() {
    const container = document.getElementById('wishlist-preview');
    if (!container) return;
    
    const wishlistIds = getWishlist();
    
    if (wishlistIds.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="far fa-heart"></i>
                <p>No items in wishlist</p>
                <a href="products.html" class="btn btn-primary">Browse Products</a>
            </div>
        `;
        return;
    }
    
    const wishlistProducts = products.filter(p => wishlistIds.includes(p.id)).slice(0, 4);
    
    container.innerHTML = `
        <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
            ${wishlistProducts.map(product => createProductCard(product)).join('')}
        </div>
    `;
}

// Handle tab navigation
function handleTabNavigation() {
    const navItems = document.querySelectorAll('.dashboard-nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            const tab = item.getAttribute('data-tab');
            if (tab) {
                e.preventDefault();
                switchTab(tab);
            }
        });
    });
}

// Switch tab
function switchTab(tabName) {
    // Update nav items
    document.querySelectorAll('.dashboard-nav-item').forEach(item => {
        item.classList.toggle('active', item.getAttribute('data-tab') === tabName);
    });
    
    // Update tabs
    document.querySelectorAll('.dashboard-tab').forEach(tab => {
        tab.classList.toggle('active', tab.id === `tab-${tabName}`);
    });
    
    // Update URL
    const url = new URL(window.location);
    url.searchParams.set('tab', tabName);
    window.history.pushState({}, '', url);
    
    // Load tab-specific content
    switch(tabName) {
        case 'orders':
            loadOrders();
            break;
        case 'profile':
            loadProfileData();
            break;
        case 'addresses':
            loadAddresses();
            break;
        case 'wishlist':
            loadWishlist();
            break;
    }
}

// Load all orders
function loadOrders() {
    const container = document.getElementById('orders-list');
    if (!container) return;
    
    const orders = getUserOrders();
    
    if (orders.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No orders yet</h3>
                <p>Start shopping to see your orders here</p>
                <a href="products.html" class="btn btn-primary">Browse Products</a>
            </div>
        `;
        return;
    }
    
    container.innerHTML = orders.map(order => `
        <div class="order-detail-card">
            <div class="order-detail-header">
                <div>
                    <h4>Order #${order.orderNumber}</h4>
                    <span class="order-date">${formatDate(order.createdAt)}</span>
                </div>
                <span class="order-status status-${order.status.toLowerCase()}">${order.status}</span>
            </div>
            <div class="order-detail-items">
                ${order.items.map(item => `
                    <div class="order-detail-item">
                        <div class="item-image" style="background-color: ${item.color || '#6366f1'}20">
                            <i class="fas ${getCategoryIcon(item.category)}"></i>
                        </div>
                        <div class="item-details">
                            <span class="item-name">${item.name}</span>
                            <span class="item-category">${item.category}</span>
                        </div>
                        <div class="item-quantity">x${item.quantity}</div>
                        <div class="item-price">${formatCurrency(item.price * item.quantity)}</div>
                    </div>
                `).join('')}
            </div>
            <div class="order-detail-footer">
                <div class="order-shipping">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>${order.shippingAddress?.address || 'N/A'}</span>
                </div>
                <div class="order-total">Total: ${formatCurrency(order.total)}</div>
            </div>
        </div>
    `).join('');
}

// Load profile data
function loadProfileData() {
    const user = getCurrentUser();
    const users = getUsers();
    const fullUser = users.find(u => u.id === user.id);
    
    if (!fullUser) return;
    
    const fields = {
        'profile-firstname': fullUser.firstname,
        'profile-lastname': fullUser.lastname,
        'profile-email': fullUser.email,
        'profile-phone': fullUser.phone || '',
        'profile-birthday': fullUser.birthday || ''
    };
    
    Object.entries(fields).forEach(([id, value]) => {
        const el = document.getElementById(id);
        if (el) el.value = value;
    });
}

// Handle profile update
function handleProfileUpdate(e) {
    e.preventDefault();
    
    const userData = {
        firstname: document.getElementById('profile-firstname').value,
        lastname: document.getElementById('profile-lastname').value,
        email: document.getElementById('profile-email').value,
        phone: document.getElementById('profile-phone').value,
        birthday: document.getElementById('profile-birthday').value
    };
    
    const result = updateProfile(userData);
    
    if (result.success) {
        showToast(result.message, 'success');
        updateUserInfo(getCurrentUser());
    } else {
        showToast(result.message, 'error');
    }
}

// Handle password change
function handlePasswordChange(e) {
    e.preventDefault();
    
    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    
    if (newPassword !== confirmPassword) {
        showToast('New passwords do not match!', 'error');
        return;
    }
    
    const result = changePassword(currentPassword, newPassword);
    
    if (result.success) {
        showToast(result.message, 'success');
        e.target.reset();
    } else {
        showToast(result.message, 'error');
    }
}

// Load addresses
function loadAddresses() {
    const container = document.getElementById('addresses-list');
    if (!container) return;
    
    const addresses = getUserAddresses();
    
    if (addresses.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-map-marker-alt"></i>
                <h3>No addresses saved</h3>
                <p>Add your first shipping address</p>
                <button class="btn btn-primary" onclick="showAddAddressModal()">Add Address</button>
            </div>
        `;
        return;
    }
    
    container.innerHTML = addresses.map(addr => `
        <div class="address-card ${addr.isDefault ? 'default' : ''}">
            <div class="address-header">
                <span class="address-type">${addr.isDefault ? '<i class="fas fa-star"></i> Default' : 'Address'}</span>
                <div class="address-actions">
                    <button onclick="editAddress('${addr.id}')" class="btn-icon"><i class="fas fa-edit"></i></button>
                    <button onclick="deleteAddress('${addr.id}')" class="btn-icon"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            <div class="address-body">
                <p class="address-name">${addr.name}</p>
                <p class="address-street">${addr.address}</p>
                <p class="address-city">${addr.city}, ${addr.zip}</p>
                <p class="address-country">${addr.country}</p>
                <p class="address-phone">${addr.phone}</p>
            </div>
        </div>
    `).join('');
}

// Show add address modal (simplified - inline prompt)
function showAddAddressModal() {
    const name = prompt('Address name (e.g., Home, Work):');
    if (!name) return;
    
    const address = prompt('Street address:');
    if (!address) return;
    
    const city = prompt('City:');
    if (!city) return;
    
    const zip = prompt('ZIP code:');
    if (!zip) return;
    
    const country = prompt('Country:');
    if (!country) return;
    
    const phone = prompt('Phone number:');
    
    const result = addAddress({ name, address, city, zip, country, phone });
    
    if (result.success) {
        showToast(result.message, 'success');
        loadAddresses();
    }
}

function editAddress(id) {
    showToast('Edit functionality coming soon', 'info');
}

function deleteAddress(id) {
    if (!confirm('Are you sure you want to delete this address?')) return;
    
    const users = getUsers();
    const currentUser = getCurrentUser();
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    
    if (userIndex === -1) return;
    
    users[userIndex].addresses = users[userIndex].addresses.filter(a => a.id !== id);
    saveUsers(users);
    
    showToast('Address deleted', 'success');
    loadAddresses();
}

// Load wishlist
function loadWishlist() {
    const container = document.getElementById('wishlist-grid');
    if (!container) return;
    
    const wishlistIds = getWishlist();
    
    if (wishlistIds.length === 0) {
        container.innerHTML = `
            <div class="empty-state" style="grid-column: 1 / -1;">
                <i class="far fa-heart"></i>
                <h3>Your wishlist is empty</h3>
                <p>Save products you love to your wishlist</p>
                <a href="products.html" class="btn btn-primary">Browse Products</a>
            </div>
        `;
        return;
    }
    
    const wishlistProducts = products.filter(p => wishlistIds.includes(p.id));
    container.innerHTML = wishlistProducts.map(product => createProductCard(product)).join('');
}

// Helper function to get category icon
function getCategoryIcon(category) {
    const icons = {
        electronics: 'fa-laptop',
        clothing: 'fa-shirt',
        accessories: 'fa-watch',
        home: 'fa-couch'
    };
    return icons[category] || 'fa-box';
}

// View order details
function viewOrder(orderId) {
    showToast('Order details coming soon', 'info');
}
