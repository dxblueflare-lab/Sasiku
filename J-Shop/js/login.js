// ===== Login Page JavaScript =====

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');

    // Check if already logged in
    if (isLoggedIn()) {
        const redirect = localStorage.getItem('redirect_after_login') || 'dashboard.html';
        localStorage.removeItem('redirect_after_login');
        window.location.href = redirect;
        return;
    }

    // Handle login form submission
    if (loginForm) {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            const remember = document.getElementById('remember-me').checked;

            const result = login(email, password, remember);

            if (result.success) {
                showToast(result.message, 'success');
                setTimeout(() => {
                    const redirect = localStorage.getItem('redirect_after_login') || 'dashboard.html';
                    localStorage.removeItem('redirect_after_login');
                    window.location.href = redirect;
                }, 1000);
            } else {
                showToast(result.message, 'error');
            }
        });
    }

    // Mock Social Login for Demo (Optional - Remove in production)
    const googleBtn = document.querySelector('.social-btn.google');
    const facebookBtn = document.querySelector('.social-btn.facebook');

    if (googleBtn) {
        googleBtn.addEventListener('click', () => {
            // Demo mode - create a mock Google user
            const mockUser = {
                id: 'google_' + Date.now(),
                email: 'demo@gmail.com',
                firstname: 'Google',
                lastname: 'Demo User',
                provider: 'google',
                createdAt: new Date().toISOString()
            };

            // Save to users array
            const users = JSON.parse(localStorage.getItem('jshop_users')) || [];
            users.push(mockUser);
            localStorage.setItem('jshop_users', JSON.stringify(users));

            // Set as current user
            localStorage.setItem('jshop_current_user', JSON.stringify({
                id: mockUser.id,
                email: mockUser.email,
                firstname: mockUser.firstname,
                lastname: mockUser.lastname
            }));

            showToast('Logged in with Google (Demo Mode)', 'success');
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 1500);
        });
    }

    if (facebookBtn) {
        facebookBtn.addEventListener('click', () => {
            // Demo mode - create a mock Facebook user
            const mockUser = {
                id: 'facebook_' + Date.now(),
                email: 'demo@facebook.com',
                firstname: 'Facebook',
                lastname: 'Demo User',
                provider: 'facebook',
                createdAt: new Date().toISOString()
            };

            // Save to users array
            const users = JSON.parse(localStorage.getItem('jshop_users')) || [];
            users.push(mockUser);
            localStorage.setItem('jshop_users', JSON.stringify(users));

            // Set as current user
            localStorage.setItem('jshop_current_user', JSON.stringify({
                id: mockUser.id,
                email: mockUser.email,
                firstname: mockUser.firstname,
                lastname: mockUser.lastname
            }));

            showToast('Logged in with Facebook (Demo Mode)', 'success');
            setTimeout(() => {
                window.location.href = 'dashboard.html';
            }, 1500);
        });
    }

    // Add floating label effect
    const inputs = document.querySelectorAll('.auth-form input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', () => {
            if (!input.value) {
                input.parentElement.classList.remove('focused');
            }
        });
    });
});
