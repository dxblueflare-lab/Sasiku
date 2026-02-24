// ===== Products Page JavaScript =====

document.addEventListener('DOMContentLoaded', () => {
    const productsContainer = document.getElementById('products-container');
    const categoryFilter = document.getElementById('category-filter');
    const sortFilter = document.getElementById('sort-filter');
    const searchInput = document.getElementById('search-input');
    
    let filteredProducts = [...products];
    
    // Load products
    function loadProducts() {
        if (productsContainer) {
            productsContainer.innerHTML = filteredProducts.map(product => createProductCard(product)).join('');
        }
    }
    
    // Filter by category
    if (categoryFilter) {
        categoryFilter.addEventListener('change', (e) => {
            const category = e.target.value;
            
            if (category === 'all') {
                filteredProducts = [...products];
            } else {
                filteredProducts = products.filter(p => p.category === category);
            }
            
            applySorting();
            loadProducts();
        });
    }
    
    // Sort products
    if (sortFilter) {
        sortFilter.addEventListener('change', applySorting);
    }
    
    function applySorting() {
        const sortValue = sortFilter.value;
        
        switch(sortValue) {
            case 'price-low':
                filteredProducts.sort((a, b) => a.price - b.price);
                break;
            case 'price-high':
                filteredProducts.sort((a, b) => b.price - a.price);
                break;
            case 'name':
                filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
                break;
            default:
                // Default - keep as is
                break;
        }
    }
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            
            if (searchTerm === '') {
                filteredProducts = [...products];
            } else {
                filteredProducts = products.filter(p => 
                    p.name.toLowerCase().includes(searchTerm) ||
                    p.description.toLowerCase().includes(searchTerm) ||
                    p.category.toLowerCase().includes(searchTerm)
                );
            }
            
            const category = categoryFilter.value;
            if (category !== 'all') {
                filteredProducts = filteredProducts.filter(p => p.category === category);
            }
            
            applySorting();
            loadProducts();
        });
    }
    
    // Initial load
    loadProducts();
});
