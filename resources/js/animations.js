/**
 * Optimize animations with will-change property
 */
export function optimizeAnimations() {
    // Add will-change to elements that will animate
    const animatedElements = document.querySelectorAll(
        '.animate-fade-in, .animate-fade-up, .animate-scale-in, .hover-lift, .hover-scale, .scroll-reveal, .reveal'
    );
    
    animatedElements.forEach(element => {
        // Add will-change before animation
        element.style.willChange = 'transform, opacity';
        
        // Remove will-change after animation completes to free up resources
        const removeWillChange = () => {
            element.style.willChange = 'auto';
            element.removeEventListener('animationend', removeWillChange);
            element.removeEventListener('transitionend', removeWillChange);
        };
        
        element.addEventListener('animationend', removeWillChange);
        element.addEventListener('transitionend', removeWillChange);
    });
    
    // Optimize hover effects - add will-change on mouseenter, remove on mouseleave
    const hoverElements = document.querySelectorAll('.hover-lift, .hover-scale, .btn-primary, .card-premium');
    
    hoverElements.forEach(element => {
        element.addEventListener('mouseenter', () => {
            element.style.willChange = 'transform';
        });
        
        element.addEventListener('mouseleave', () => {
            element.style.willChange = 'auto';
        });
    });
}

/**
 * Smooth scroll behavior for anchor links
 */
export function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            
            // Skip if href is just "#"
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (!target) return;
            
            e.preventDefault();
            
            const offset = 80; // Header offset
            const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        });
    });
}

/**
 * Smooth scroll to top functionality
 */
export function scrollToTop(duration = 800) {
    const start = window.pageYOffset;
    const startTime = performance.now();
    
    function easeInOutCubic(t) {
        return t < 0.5 
            ? 4 * t * t * t 
            : 1 - Math.pow(-2 * t + 2, 3) / 2;
    }
    
    function scroll(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const eased = easeInOutCubic(progress);
        
        window.scrollTo(0, start * (1 - eased));
        
        if (progress < 1) {
            requestAnimationFrame(scroll);
        }
    }
    
    requestAnimationFrame(scroll);
}

/**
 * Initialize scroll behavior
 */
export function initScrollBehavior() {
    initSmoothScroll();
    optimizeAnimations();
    
    // Add scroll-to-top button if needed
    const scrollTopBtn = document.querySelector('[data-scroll-top]');
    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', () => scrollToTop());
        
        // Show/hide button based on scroll position
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('hidden');
            } else {
                scrollTopBtn.classList.add('hidden');
            }
        });
    }
}
