// ===== Authentication Module =====

// Initialize users from localStorage
function getUsers() {
    return JSON.parse(localStorage.getItem('jshop_users')) || [];
}

function saveUsers(users) {
    localStorage.setItem('jshop_users', JSON.stringify(users));
}

// Get current logged in user
function getCurrentUser() {
    return JSON.parse(localStorage.getItem('jshop_current_user'));
}

function setCurrentUser(user) {
    localStorage.setItem('jshop_current_user', JSON.stringify(user));
}

function removeCurrentUser() {
    localStorage.removeItem('jshop_current_user');
}

// Check if user is logged in
function isLoggedIn() {
    return getCurrentUser() !== null;
}

// Register new user
function register(userData) {
    const users = getUsers();
    
    // Check if email already exists
    const existingUser = users.find(u => u.email === userData.email);
    if (existingUser) {
        return { success: false, message: 'Email already registered' };
    }
    
    // Create new user
    const newUser = {
        id: Date.now().toString(),
        firstname: userData.firstname,
        lastname: userData.lastname,
        email: userData.email,
        phone: userData.phone || '',
        password: userData.password, // In production, hash this!
        createdAt: new Date().toISOString(),
        orders: [],
        addresses: [],
        wishlist: []
    };
    
    users.push(newUser);
    saveUsers(users);
    
    // Auto login after registration
    setCurrentUser({
        id: newUser.id,
        email: newUser.email,
        firstname: newUser.firstname,
        lastname: newUser.lastname
    });
    
    return { success: true, message: 'Account created successfully!' };
}

// Login user
function login(email, password, remember = false) {
    const users = getUsers();
    const user = users.find(u => u.email === email && u.password === password);
    
    if (!user) {
        return { success: false, message: 'Invalid email or password' };
    }
    
    const userData = {
        id: user.id,
        email: user.email,
        firstname: user.firstname,
        lastname: user.lastname,
        phone: user.phone
    };
    
    setCurrentUser(userData);
    
    if (remember) {
        localStorage.setItem('jshop_remember', 'true');
    }
    
    return { success: true, message: `Welcome back, ${user.firstname}!` };
}

// Logout user
function logout() {
    removeCurrentUser();
    localStorage.removeItem('jshop_remember');
    window.location.href = 'index.html';
}

// Update user profile
function updateProfile(userData) {
    const users = getUsers();
    const currentUser = getCurrentUser();
    
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    if (userIndex === -1) {
        return { success: false, message: 'User not found' };
    }
    
    users[userIndex] = {
        ...users[userIndex],
        ...userData
    };
    
    saveUsers(users);
    setCurrentUser({
        id: users[userIndex].id,
        email: users[userIndex].email,
        firstname: users[userIndex].firstname,
        lastname: users[userIndex].lastname,
        phone: users[userIndex].phone
    });
    
    return { success: true, message: 'Profile updated successfully!' };
}

// Change password
function changePassword(currentPassword, newPassword) {
    const users = getUsers();
    const currentUser = getCurrentUser();
    
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    if (userIndex === -1) {
        return { success: false, message: 'User not found' };
    }
    
    if (users[userIndex].password !== currentPassword) {
        return { success: false, message: 'Current password is incorrect' };
    }
    
    users[userIndex].password = newPassword;
    saveUsers(users);
    
    return { success: true, message: 'Password changed successfully!' };
}

// Add order to user
function addOrder(orderData) {
    const users = getUsers();
    const currentUser = getCurrentUser();
    
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    if (userIndex === -1) {
        return { success: false, message: 'User not found' };
    }
    
    const order = {
        id: 'ORD' + Date.now(),
        orderNumber: 'J' + Math.random().toString(36).substr(2, 9).toUpperCase(),
        items: orderData.items,
        total: orderData.total,
        status: 'Processing',
        shippingAddress: orderData.shippingAddress,
        createdAt: new Date().toISOString()
    };
    
    users[userIndex].orders.unshift(order);
    saveUsers(users);
    
    return { success: true, order: order };
}

// Get user orders
function getUserOrders() {
    const currentUser = getCurrentUser();
    if (!currentUser) return [];
    
    const users = getUsers();
    const user = users.find(u => u.id === currentUser.id);
    return user ? user.orders : [];
}

// Add address
function addAddress(addressData) {
    const users = getUsers();
    const currentUser = getCurrentUser();
    
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    if (userIndex === -1) {
        return { success: false, message: 'User not found' };
    }
    
    const address = {
        id: Date.now().toString(),
        ...addressData,
        isDefault: users[userIndex].addresses.length === 0
    };
    
    users[userIndex].addresses.push(address);
    saveUsers(users);
    
    return { success: true, message: 'Address added successfully!' };
}

// Get user addresses
function getUserAddresses() {
    const currentUser = getCurrentUser();
    if (!currentUser) return [];
    
    const users = getUsers();
    const user = users.find(u => u.id === currentUser.id);
    return user ? user.addresses : [];
}

// Toggle wishlist
function toggleWishlist(productId) {
    const users = getUsers();
    const currentUser = getCurrentUser();
    
    const userIndex = users.findIndex(u => u.id === currentUser.id);
    if (userIndex === -1) {
        return { success: false, message: 'User not found' };
    }
    
    const wishlist = users[userIndex].wishlist || [];
    const index = wishlist.indexOf(productId);
    
    if (index === -1) {
        wishlist.push(productId);
        return { success: true, message: 'Added to wishlist', added: true };
    } else {
        wishlist.splice(index, 1);
        return { success: true, message: 'Removed from wishlist', added: false };
    }
}

// Get wishlist
function getWishlist() {
    const currentUser = getCurrentUser();
    if (!currentUser) return [];
    
    const users = getUsers();
    const user = users.find(u => u.id === currentUser.id);
    return user ? (user.wishlist || []) : [];
}

// Get user stats
function getUserStats() {
    const orders = getUserOrders();
    const wishlist = getWishlist();
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    const totalSpent = orders.reduce((sum, order) => sum + order.total, 0);
    
    return {
        totalOrders: orders.length,
        totalSpent: totalSpent,
        wishlistItems: wishlist.length,
        cartItems: cart.reduce((sum, item) => sum + item.quantity, 0)
    };
}

// Check authentication on protected pages
function requireAuth() {
    if (!isLoggedIn()) {
        window.location.href = 'login.html';
        return false;
    }
    return true;
}

// Toast notification
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('toast-hide');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength checker
function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    return strength;
}

function updatePasswordStrength(password) {
    const strengthBar = document.querySelector('.strength-bar');
    if (!strengthBar) return;
    
    const strength = checkPasswordStrength(password);
    const colors = ['#ef4444', '#f97316', '#fbbf24', '#84cc16', '#22c55e'];
    const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    
    strengthBar.style.width = `${(strength / 5) * 100}%`;
    strengthBar.style.backgroundColor = colors[strength - 1] || colors[0];
    strengthBar.setAttribute('data-label', labels[strength - 1] || 'Very Weak');
}

// Format date
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

// Format currency
function formatCurrency(amount) {
    return '$' + amount.toFixed(2);
}

// Export functions for global use
window.register = register;
window.login = login;
window.logout = logout;
window.isLoggedIn = isLoggedIn;
window.getCurrentUser = getCurrentUser;
window.updateProfile = updateProfile;
window.changePassword = changePassword;
window.addOrder = addOrder;
window.getUserOrders = getUserOrders;
window.addAddress = addAddress;
window.getUserAddresses = getUserAddresses;
window.toggleWishlist = toggleWishlist;
window.getWishlist = getWishlist;
window.getUserStats = getUserStats;
window.requireAuth = requireAuth;
window.showToast = showToast;
window.togglePassword = togglePassword;
window.updatePasswordStrength = updatePasswordStrength;
window.formatDate = formatDate;
window.formatCurrency = formatCurrency;
