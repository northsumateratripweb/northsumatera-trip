/**
 * Alpine.js directives for animations
 */

/**
 * Fade-in animation directive
 * Usage: x-data="fadeIn" or x-data="fadeIn('slow')"
 */
export function fadeInDirective(Alpine) {
    Alpine.directive('fade-in', (el, { expression }, { evaluate }) => {
        const variant = expression ? evaluate(expression) : 'default';
        const config = getFadeInConfig(variant);
        
        // Set initial state
        el.style.opacity = '0';
        el.style.transition = `opacity ${config.duration}ms ${config.easing}`;
        
        // Create intersection observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        el.style.opacity = '1';
                    }, config.delay);
                    observer.unobserve(el);
                }
            });
        }, {
            threshold: config.threshold
        });
        
        observer.observe(el);
    });
}

/**
 * Hover effect directive
 * Usage: x-hover-effect
 */
export function hoverEffectDirective(Alpine) {
    Alpine.directive('hover-effect', (el) => {
        const config = getHoverConfig();
        
        el.style.transition = `transform ${config.duration}ms ${config.easing}, box-shadow ${config.duration}ms ${config.easing}`;
        
        el.addEventListener('mouseenter', () => {
            el.style.transform = config.transform;
        });
        
        el.addEventListener('mouseleave', () => {
            el.style.transform = 'translateY(0)';
        });
    });
}

/**
 * Alpine.js data component for fade-in animation
 */
export function fadeInComponent() {
    return {
        visible: false,
        variant: 'default',
        
        init() {
            const config = getFadeInConfig(this.variant);
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            this.visible = true;
                        }, config.delay);
                        observer.unobserve(this.$el);
                    }
                });
            }, {
                threshold: config.threshold
            });
            
            observer.observe(this.$el);
        }
    };
}

/**
 * Get fade-in configuration
 */
function getFadeInConfig(variant = 'default') {
    const configs = {
        'default': {
            duration: 800,
            easing: 'ease-out',
            delay: 0,
            threshold: 0.1,
        },
        'slow': {
            duration: 1200,
            easing: 'ease-out',
            delay: 0,
            threshold: 0.1,
        },
        'fast': {
            duration: 500,
            easing: 'ease-out',
            delay: 0,
            threshold: 0.1,
        }
    };
    
    return configs[variant] || configs['default'];
}

/**
 * Get hover effect configuration
 */
function getHoverConfig() {
    return {
        duration: 300,
        easing: 'ease-in-out',
        transform: 'translateY(-2px)',
        scale: 1.02,
    };
}

/**
 * Register all animation directives
 */
export function registerAnimationDirectives(Alpine) {
    fadeInDirective(Alpine);
    hoverEffectDirective(Alpine);
    
    // Register Alpine data components
    Alpine.data('fadeIn', fadeInComponent);
}
