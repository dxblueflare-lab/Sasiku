// ===== Product Data =====

const products = [
    {
        id: 1,
        name: "Wireless Bluetooth Headphones",
        price: 79.99,
        category: "electronics",
        rating: 4.5,
        color: "#6366f1",
        description: "Premium wireless headphones with active noise cancellation and 30-hour battery life"
    },
    {
        id: 2,
        name: "Smart Watch Pro",
        price: 199.99,
        category: "electronics",
        rating: 4.8,
        color: "#8b5cf6",
        description: "Advanced smartwatch with health monitoring, GPS, and water resistance"
    },
    {
        id: 3,
        name: "Premium Cotton T-Shirt",
        price: 29.99,
        category: "clothing",
        rating: 4.3,
        color: "#22c55e",
        description: "Comfortable 100% organic cotton t-shirt with modern fit"
    },
    {
        id: 4,
        name: "Classic Denim Jacket",
        price: 89.99,
        category: "clothing",
        rating: 4.6,
        color: "#3b82f6",
        description: "Timeless denim jacket perfect for all seasons and occasions"
    },
    {
        id: 5,
        name: "Leather Wallet",
        price: 49.99,
        category: "accessories",
        rating: 4.7,
        color: "#f59e0b",
        description: "Genuine leather wallet with RFID protection and multiple card slots"
    },
    {
        id: 6,
        name: "Designer Sunglasses",
        price: 129.99,
        category: "accessories",
        rating: 4.4,
        color: "#ef4444",
        description: "UV protection polarized lenses with elegant frame design"
    },
    {
        id: 7,
        name: "Modern Table Lamp",
        price: 59.99,
        category: "home",
        rating: 4.5,
        color: "#f97316",
        description: "Minimalist LED table lamp with adjustable brightness and USB charging"
    },
    {
        id: 8,
        name: "Cozy Throw Blanket",
        price: 44.99,
        category: "home",
        rating: 4.8,
        color: "#ec4899",
        description: "Ultra-soft fleece blanket perfect for cozy nights in"
    },
    {
        id: 9,
        name: "Portable Bluetooth Speaker",
        price: 69.99,
        category: "electronics",
        rating: 4.6,
        color: "#14b8a6",
        description: "Waterproof speaker with 360° sound and 20-hour battery life"
    },
    {
        id: 10,
        name: "Running Sneakers",
        price: 119.99,
        category: "clothing",
        rating: 4.7,
        color: "#64748b",
        description: "Lightweight athletic shoes with advanced cushion support"
    },
    {
        id: 11,
        name: "Canvas Backpack",
        price: 54.99,
        category: "accessories",
        rating: 4.5,
        color: "#84cc16",
        description: "Durable vintage backpack with padded laptop compartment"
    },
    {
        id: 12,
        name: "Ceramic Plant Pot Set",
        price: 34.99,
        category: "home",
        rating: 4.4,
        color: "#06b6d4",
        description: "Set of 3 decorative ceramic plant pots with drainage holes"
    },
    {
        id: 13,
        name: "Wireless Charging Pad",
        price: 39.99,
        category: "electronics",
        rating: 4.3,
        color: "#a855f7",
        description: "Fast wireless charger compatible with all Qi-enabled devices"
    },
    {
        id: 14,
        name: "Slim Fit Jeans",
        price: 64.99,
        category: "clothing",
        rating: 4.5,
        color: "#1e40af",
        description: "Modern fit stretch denim jeans with classic five-pocket design"
    },
    {
        id: 15,
        name: "Stainless Steel Water Bottle",
        price: 24.99,
        category: "accessories",
        rating: 4.8,
        color: "#0891b2",
        description: "Double-wall insulated bottle keeps drinks cold for 24 hours"
    },
    {
        id: 16,
        name: "Aromatherapy Candle Set",
        price: 29.99,
        category: "home",
        rating: 4.6,
        color: "#db2777",
        description: "Set of 4 natural soy candles with essential oil blends"
    }
];
