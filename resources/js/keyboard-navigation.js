/**
 * Keyboard Navigation System
 * Implements keyboard shortcuts and focus management for accessibility
 * Validates: Requirements 10.2
 */

class KeyboardNavigation {
    constructor() {
        this.focusableElements = [
            'a[href]',
            'button:not([disabled])',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])'
        ].join(', ');
        
        this.init();
    }

    init() {
        this.setupKeyboardShortcuts();
        this.setupFocusTrap();
        this.setupSkipLinks();
        this.enhanceInteractiveElements();
    }

    /**
     * Setup keyboard shortcuts for common actions
     */
    setupKeyboardShortcuts() {
        document.addEventListener('keydown', (e) => {
            // Skip if user is typing in an input field
            if (e.target.matches('input, textarea, select')) {
                return;
            }

            // Alt + H: Go to home/hero section
            if (e.altKey && e.key === 'h') {
                e.preventDefault();
                this.scrollToSection('hero');
            }

            // Alt + T: Go to tour packages section
            if (e.altKey && e.key === 't') {
                e.preventDefault();
                this.scrollToSection('tour-packages');
            }

            // Alt + C: Go to contact/trust section
            if (e.altKey && e.key === 'c') {
                e.preventDefault();
                this.scrollToSection('trust');
            }

            // Escape: Close mobile menu if open
            if (e.key === 'Escape') {
                this.closeMobileMenu();
            }

            // Tab: Ensure visible focus indicators
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        // Remove keyboard navigation class on mouse use
        document.addEventListener('mousedown', () => {
            document.body.classList.remove('keyboard-navigation');
        });
    }

    /**
     * Setup focus trap for modals and mobile menu
     */
    setupFocusTrap() {
        document.addEventListener('keydown', (e) => {
            if (e.key !== 'Tab') return;

            const mobileMenu = document.querySelector('[x-data*="mobileMenu"]');
            if (!mobileMenu) return;

            // Check if mobile menu is open
            const isOpen = mobileMenu.querySelector('[x-show="mobileMenu"]')?.style.display !== 'none';
            if (!isOpen) return;

            const focusableContent = mobileMenu.querySelectorAll(this.focusableElements);
            const firstFocusable = focusableContent[0];
            const lastFocusable = focusableContent[focusableContent.length - 1];

            // Trap focus within mobile menu
            if (e.shiftKey) {
                if (document.activeElement === firstFocusable) {
                    e.preventDefault();
                    lastFocusable.focus();
                }
            } else {
                if (document.activeElement === lastFocusable) {
                    e.preventDefault();
                    firstFocusable.focus();
                }
            }
        });
    }

    /**
     * Setup skip links for screen readers
     */
    setupSkipLinks() {
        // Create skip link if it doesn't exist
        if (!document.querySelector('.skip-link')) {
            const skipLink = document.createElement('a');
            skipLink.href = '#main-content';
            skipLink.className = 'skip-link';
            skipLink.textContent = 'Skip to main content';
            skipLink.style.cssText = `
                position: absolute;
                top: -40px;
                left: 0;
                background: var(--color-primary);
                color: white;
                padding: 8px 16px;
                text-decoration: none;
                z-index: 9999;
                border-radius: 0 0 4px 0;
                font-weight: 600;
            `;

            // Show on focus
            skipLink.addEventListener('focus', () => {
                skipLink.style.top = '0';
            });

            skipLink.addEventListener('blur', () => {
                skipLink.style.top = '-40px';
            });

            document.body.insertBefore(skipLink, document.body.firstChild);
        }
    }

    /**
     * Enhance interactive elements with proper ARIA attributes
     */
    enhanceInteractiveElements() {
        // Ensure all buttons have proper roles
        document.querySelectorAll('button:not([role])').forEach(button => {
            if (!button.getAttribute('role')) {
                button.setAttribute('role', 'button');
            }
        });

        // Ensure all links have proper roles
        document.querySelectorAll('a[href]:not([role])').forEach(link => {
            if (link.getAttribute('href') === '#' || link.getAttribute('href') === '#!') {
                link.setAttribute('role', 'button');
            }
        });

        // Add keyboard support for custom interactive elements
        document.querySelectorAll('[onclick]:not(button):not(a)').forEach(element => {
            if (!element.hasAttribute('tabindex')) {
                element.setAttribute('tabindex', '0');
            }
            if (!element.hasAttribute('role')) {
                element.setAttribute('role', 'button');
            }

            // Add keyboard event listener
            element.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    element.click();
                }
            });
        });
    }

    /**
     * Scroll to a specific section
     */
    scrollToSection(sectionId) {
        const section = document.getElementById(sectionId) || 
                       document.querySelector(`[data-section="${sectionId}"]`);
        
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Focus the section for screen readers
            if (!section.hasAttribute('tabindex')) {
                section.setAttribute('tabindex', '-1');
            }
            section.focus();
        }
    }

    /**
     * Close mobile menu
     */
    closeMobileMenu() {
        const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
        if (mobileMenuButton && mobileMenuButton.getAttribute('aria-expanded') === 'true') {
            mobileMenuButton.click();
        }
    }

    /**
     * Get all focusable elements in a container
     */
    getFocusableElements(container = document) {
        return Array.from(container.querySelectorAll(this.focusableElements))
            .filter(el => {
                return el.offsetWidth > 0 && 
                       el.offsetHeight > 0 && 
                       !el.hasAttribute('disabled');
            });
    }

    /**
     * Move focus to next/previous element
     */
    moveFocus(direction = 'next') {
        const focusableElements = this.getFocusableElements();
        const currentIndex = focusableElements.indexOf(document.activeElement);
        
        let nextIndex;
        if (direction === 'next') {
            nextIndex = (currentIndex + 1) % focusableElements.length;
        } else {
            nextIndex = currentIndex - 1;
            if (nextIndex < 0) nextIndex = focusableElements.length - 1;
        }
        
        focusableElements[nextIndex]?.focus();
    }
}

// Initialize keyboard navigation when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new KeyboardNavigation();
    });
} else {
    new KeyboardNavigation();
}

// Export for use in other modules
export default KeyboardNavigation;
