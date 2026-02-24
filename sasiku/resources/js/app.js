import './bootstrap';
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;
Alpine.start();

// Lucide icons will be loaded via CDN in the layout
// Create a safe wrapper that doesn't cause infinite recursion
const originalLucide = window.lucide;
window.lucide = {
    createIcons: () => {
        // Call the original lucide.createIcons if available
        if (originalLucide && typeof originalLucide.createIcons === 'function') {
            originalLucide.createIcons();
        }
    },
    // Preserve other lucide methods if they exist
    ...(originalLucide || {})
};
