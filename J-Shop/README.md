# J-Shop - Modern E-Commerce Website

A beautiful, modern e-commerce website with user authentication, built with HTML, CSS, and JavaScript.

## ✨ New Features

### 🔐 User Authentication
- **Login/Register System** - Secure user authentication
- **User Dashboard** - Personal dashboard for each user
- **Order History** - Track all your orders
- **Profile Management** - Update your personal information
- **Address Book** - Save multiple shipping addresses
- **Wishlist** - Save your favorite products
- **Password Change** - Update your password securely

### 🛍️ E-Commerce Functionality
- Product catalog with 16 items
- Shopping cart with localStorage
- Product filtering and search
- Protected checkout (requires login)
- Order tracking

## 📄 Pages

### Public Pages
1. **Home** (`index.html`) - Hero, features, featured products, promo
2. **Products** (`products.html`) - Product catalog with filters
3. **Cart** (`cart.html`) - Shopping cart

### Authentication Pages
4. **Login** (`login.html`) - User login
5. **Register** (`register.html`) - New user registration

### User Dashboard
6. **Dashboard** (`dashboard.html`) - User dashboard with tabs:
   - **Overview** - Stats, recent orders, wishlist preview
   - **My Orders** - Complete order history
   - **Profile Settings** - Update personal info
   - **Addresses** - Manage shipping addresses
   - **Wishlist** - Saved products
   - **Security** - Change password

## 🚀 How to Run

### Using Laragon (Recommended)

1. Make sure Laragon is installed and running
2. The website is already in `c:\laragon\www\J-Shop`
3. Open your browser and visit: **http://localhost/J-Shop/**

### Using Node.js

1. Install dependencies:
   ```bash
   npm install
   ```

2. Start the server:
   ```bash
   npm start
   ```

3. Visit: **http://localhost:3000/**

## 📁 File Structure

```
J-Shop/
├── index.html              # Homepage
├── products.html           # Product catalog
├── cart.html               # Shopping cart
├── checkout.html           # Checkout (protected)
├── login.html              # Login page
├── register.html           # Registration page
├── dashboard.html          # User dashboard
├── css/
│   └── styles.css          # All styles (2800+ lines)
├── js/
│   ├── data.js             # Product data
│   ├── auth.js             # Authentication module
│   ├── main.js             # Core functions + wishlist
│   ├── login.js            # Login page logic
│   ├── register.js         # Registration logic
│   ├── dashboard.js        # Dashboard functionality
│   ├── products.js         # Product filtering
│   ├── cart.js             # Cart management
│   └── checkout.js         # Checkout logic
└── README.md               # Documentation
```

## 🔑 Default Test Accounts

You can create a new account or use these test credentials:

**Test User:**
- Email: `test@jshop.com`
- Password: `password123`

*(Note: Create this account first by registering)*

## 🎨 Design Features

- **Gradient backgrounds** throughout the site
- **Glassmorphism effects** on cards and overlays
- **Smooth animations** (fadeIn, slideIn, bounce, pulse)
- **Hover effects** with transforms and shadows
- **Modern color palette** with CSS variables
- **Custom scrollbar** styling
- **Toast notifications** for user feedback
- **Responsive design** for all screen sizes

## 💾 Data Storage

All user data is stored in **localStorage**:
- `jshop_users` - All registered users
- `jshop_current_user` - Currently logged-in user
- `cart` - Shopping cart items
- `redirect_after_login` - Post-login redirect URL

### User Data Structure
```javascript
{
    id: "1234567890",
    firstname: "John",
    lastname: "Doe",
    email: "john@example.com",
    phone: "+1234567890",
    password: "password123",
    createdAt: "2026-02-18T...",
    orders: [...],
    addresses: [...],
    wishlist: [...]
}
```

## 🔒 Security Notes

⚠️ **Important:** This is a demo application. Passwords are stored in plain text in localStorage. For production use:
- Implement server-side authentication
- Hash passwords using bcrypt or similar
- Use HTTPS for all connections
- Implement JWT or session-based authentication
- Add CSRF protection
- Validate all inputs server-side

## 🎯 Key Features Explained

### Authentication Flow
1. User registers → Account created in localStorage
2. User logs in → Session stored in localStorage
3. Protected pages check `isLoggedIn()`
4. Logout clears session

### Order System
1. User adds items to cart
2. At checkout, order is saved to user's order history
3. Dashboard shows all orders with status
4. Order includes: items, total, shipping address, date

### Wishlist
1. Click heart icon on any product
2. Product ID saved to user's wishlist
3. View all wishlist items in dashboard
4. One-click remove from wishlist

## 🌐 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## 📝 Customization

### Change Colors
Edit CSS variables in `css/styles.css`:
```css
:root {
    --primary-color: #6366f1;
    --primary-dark: #4f46e5;
    /* ... more variables */
}
```

### Add Products
Edit `js/data.js` and add new product objects.

## 📧 Contact

For support or questions, create an issue in the repository.

## 📄 License

© 2026 J-Shop. All rights reserved.
