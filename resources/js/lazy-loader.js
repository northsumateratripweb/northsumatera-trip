/**
 * Lazy loading utility for non-critical components
 * Implements code splitting to improve initial page load performance
 */

/**
 * Lazy load a module when it enters the viewport
 * @param {string} selector - CSS selector for the element
 * @param {Function} importFn - Dynamic import function
 * @param {Object} options - Intersection Observer options
 */
export function lazyLoadComponent(selector, importFn, options = {}) {
    const elements = document.querySelectorAll(selector);
    
    if (elements.length === 0) return;
    
    const defaultOptions = {
        root: null,
        rootMargin: '50px',
        threshold: 0.01,
        ...options
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Load the module when element enters viewport
                importFn()
                    .then(module => {
                        if (module.default) {
                            module.default(entry.target);
                        }
                    })
                    .catch(err => {
                        console.error('Failed to load component:', err);
                    });
                
                // Stop observing this element
                observer.unobserve(entry.target);
            }
        });
    }, defaultOptions);
    
    elements.forEach(element => observer.observe(element));
}

/**
 * Lazy load multiple components by section
 */
export function initLazyLoading() {
    // Lazy load trust section components
    lazyLoadComponent('[data-lazy="trust-section"]', () => 
        import('./components/trust-section.js')
    );
    
    // Lazy load tour packages section
    lazyLoadComponent('[data-lazy="tour-packages"]', () => 
        import('./components/tour-packages.js')
    );
    
    // Lazy load footer components
    lazyLoadComponent('[data-lazy="footer"]', () => 
        import('./components/footer.js')
    );
}

/**
 * Preload critical resources
 */
export function preloadCriticalResources() {
    // Preload hero section images
    const heroImages = document.querySelectorAll('[data-preload="hero"]');
    heroImages.forEach(img => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = img.dataset.src || img.src;
        document.head.appendChild(link);
    });
}

/**
 * Split code by route/section
 */
export function loadSectionModule(sectionName) {
    const moduleMap = {
        'hero': () => import('./sections/hero.js'),
        'trust': () => import('./sections/trust.js'),
        'packages': () => import('./sections/packages.js'),
        'navigation': () => import('./sections/navigation.js'),
    };
    
    const loader = moduleMap[sectionName];
    
    if (!loader) {
        console.warn(`No module found for section: ${sectionName}`);
        return Promise.resolve();
    }
    
    return loader()
        .then(module => {
            if (module.init) {
                module.init();
            }
            return module;
        })
        .catch(err => {
            console.error(`Failed to load section ${sectionName}:`, err);
        });
}
