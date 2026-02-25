/**
 * Trust Section Component
 * Lazy-loaded for performance optimization
 */

export default function initTrustSection(element) {
    // Initialize trust section animations
    const cards = element.querySelectorAll('.trust-card');
    
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('revealed');
        }, index * 100);
    });
    
    // Initialize any interactive elements
    const testimonialSlider = element.querySelector('[data-testimonial-slider]');
    if (testimonialSlider) {
        // Testimonial slider logic would go here
        console.log('Trust section initialized');
    }
}
