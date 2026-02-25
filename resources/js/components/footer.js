/**
 * Footer Component
 * Lazy-loaded for performance optimization
 */

export default function initFooter(element) {
    // Initialize footer animations
    const links = element.querySelectorAll('a');
    
    links.forEach(link => {
        link.addEventListener('mouseenter', () => {
            link.style.willChange = 'transform';
        });
        
        link.addEventListener('mouseleave', () => {
            link.style.willChange = 'auto';
        });
    });
    
    // Initialize newsletter form if present
    const newsletterForm = element.querySelector('[data-newsletter-form]');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Newsletter submission logic would go here
            console.log('Newsletter form submitted');
        });
    }
    
    console.log('Footer initialized');
}
