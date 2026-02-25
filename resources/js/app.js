import './bootstrap';

import Alpine from 'alpinejs';
import { registerAnimationDirectives } from './alpine-directives';
import { initScrollBehavior } from './animations';
import { initLazyLoading, preloadCriticalResources } from './lazy-loader';
import { initPerformanceMonitoring } from './performance-monitor';
import './keyboard-navigation';

window.Alpine = Alpine;

// Register animation directives
registerAnimationDirectives(Alpine);

Alpine.start();

// Initialize performance monitoring as early as possible
initPerformanceMonitoring();

// Initialize scroll behavior and lazy loading after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Preload critical resources first
    preloadCriticalResources();
    
    // Initialize scroll behavior (critical)
    initScrollBehavior();
    
    // Initialize lazy loading for non-critical components
    initLazyLoading();
});
