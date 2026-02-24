# Social Login Setup Guide

## ⚠️ Important Notice

The social login buttons (Google, Facebook) on the login page are **UI placeholders only**. 
To make them functional, you need backend integration with OAuth APIs.

---

## 🔧 Requirements for Social Login

### 1. Backend Server Required
You need a backend server (Node.js, PHP, Python, etc.) to:
- Handle OAuth callbacks securely
- Store API credentials safely
- Create user sessions
- Communicate with Google/Facebook APIs

### 2. API Credentials
You need to register your application with each provider:

#### Google OAuth 2.0
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Get **Client ID** and **Client Secret**
6. Set authorized redirect URIs

#### Facebook Login
1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create a new app
3. Add Facebook Login product
4. Get **App ID** and **App Secret**
5. Set valid OAuth redirect URIs

---

## 📝 Implementation Options

### Option 1: Using Firebase Authentication (Recommended)

Firebase provides easy social login integration:

```html
<!-- Add Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth.js"></script>

<script>
// Initialize Firebase
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    authDomain: "YOUR_PROJECT.firebaseapp.com",
    projectId: "YOUR_PROJECT_ID",
    // ... other config
};
firebase.initializeApp(firebaseConfig);

// Google Sign In
function signInWithGoogle() {
    const provider = new firebase.auth.GoogleAuthProvider();
    firebase.auth().signInWithPopup(provider)
        .then((result) => {
            const user = result.user;
            // Save user to your system
            window.location.href = 'dashboard.html';
        })
        .catch((error) => {
            console.error(error);
            showToast('Login failed: ' + error.message, 'error');
        });
}

// Facebook Sign In
function signInWithFacebook() {
    const provider = new firebase.auth.FacebookAuthProvider();
    firebase.auth().signInWithPopup(provider)
        .then((result) => {
            const user = result.user;
            window.location.href = 'dashboard.html';
        })
        .catch((error) => {
            console.error(error);
            showToast('Login failed: ' + error.message, 'error');
        });
}
</script>
```

### Option 2: Using Node.js Backend

**server.js:**
```javascript
const express = require('express');
const passport = require('passport');
const GoogleStrategy = require('passport-google-oauth20').Strategy;
const session = require('express-session');

const app = express();

app.use(session({ secret: 'your-secret', resave: false, saveUninitialized: true }));
app.use(passport.initialize());
app.use(passport.session());

// Google OAuth Strategy
passport.use(new GoogleStrategy({
    clientID: 'YOUR_GOOGLE_CLIENT_ID',
    clientSecret: 'YOUR_GOOGLE_CLIENT_SECRET',
    callbackURL: '/auth/google/callback'
}, (accessToken, refreshToken, profile, done) => {
    // Find or create user
    return done(null, profile);
}));

// Routes
app.get('/auth/google',
    passport.authenticate('google', { scope: ['profile', 'email'] })
);

app.get('/auth/google/callback',
    passport.authenticate('google', { failureRedirect: '/login.html' }),
    (req, res) => {
        res.redirect('/dashboard.html');
    }
);

app.listen(3000);
```

### Option 3: Using PHP Backend

**login.php:**
```php
<?php
session_start();
require 'vendor/autoload.php';

$google_client = new Google_Client();
$google_client->setClientId('YOUR_GOOGLE_CLIENT_ID');
$google_client->setClientSecret('YOUR_GOOGLE_CLIENT_SECRET');
$google_client->setRedirectUri('http://localhost/J-Shop/callback.php');
$google_client->addScope('email');
$google_client->addScope('profile');

if (!isset($_SESSION['access_token'])) {
    $login_url = $google_client->createAuthUrl();
    echo "<a href='$login_url'>Login with Google</a>";
}
?>
```

---

## 🎯 Quick Solution for Demo

If you just want to demonstrate the functionality without full backend setup:

### Mock Social Login (For Demo Only)

Add this to `js/login.js`:

```javascript
// Mock Google Login (Demo Only)
document.querySelector('.social-btn.google')?.addEventListener('click', () => {
    const mockUser = {
        id: 'google_' + Date.now(),
        email: 'user@gmail.com',
        firstname: 'Google',
        lastname: 'User',
        provider: 'google'
    };
    
    localStorage.setItem('jshop_current_user', JSON.stringify(mockUser));
    showToast('Logged in with Google (Demo)', 'success');
    setTimeout(() => {
        window.location.href = 'dashboard.html';
    }, 1000);
});

// Mock Facebook Login (Demo Only)
document.querySelector('.social-btn.facebook')?.addEventListener('click', () => {
    const mockUser = {
        id: 'facebook_' + Date.now(),
        email: 'user@facebook.com',
        firstname: 'Facebook',
        lastname: 'User',
        provider: 'facebook'
    };
    
    localStorage.setItem('jshop_current_user', JSON.stringify(mockUser));
    showToast('Logged in with Facebook (Demo)', 'success');
    setTimeout(() => {
        window.location.href = 'dashboard.html';
    }, 1000);
});
```

⚠️ **Warning:** This is for demonstration only! Don't use in production.

---

## ✅ Current Implementation

The current login page now shows an informational message explaining that social login requires backend integration. Users should use email/password login which works fully with localStorage.

---

## 📚 Resources

- [Google OAuth Documentation](https://developers.google.com/identity/protocols/oauth2)
- [Facebook Login Documentation](https://developers.facebook.com/docs/facebook-login/)
- [Firebase Authentication](https://firebase.google.com/docs/auth/)
- [OAuth 2.0 Simplified](https://aaronparecki.com/oauth-2-simplified/)

---

## 🆘 Need Help?

For production-ready social login, consider:
1. Using Firebase Authentication (easiest)
2. Using Auth0 or similar services
3. Hiring a backend developer for custom implementation
