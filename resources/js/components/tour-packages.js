/**
 * Tour Packages Component
 * Lazy-loaded for performance optimization
 */

export default function initTourPackages(element) {
    // Initialize tour packages animations
    const cards = element.querySelectorAll('.package-card');
    
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('revealed');
        }, index * 150);
    });
    
    // Initialize filtering/sorting if present
    const filterButtons = element.querySelectorAll('[data-filter]');
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.dataset.filter;
                // Filter logic would go here
                console.log('Filter applied:', filter);
            });
        });
    }
    
    console.log('Tour packages section initialized');
}
