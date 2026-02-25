/**
 * Color Contrast Checker
 * Verifies WCAG AA compliance for text color combinations
 * Validates: Requirements 10.3
 */

class ColorContrastChecker {
    constructor() {
        this.WCAG_AA_NORMAL = 4.5;
        this.WCAG_AA_LARGE = 3.0;
        this.WCAG_AAA_NORMAL = 7.0;
        this.WCAG_AAA_LARGE = 4.5;
    }

    /**
     * Calculate relative luminance of a color
     * @param {string} color - Hex color code
     * @returns {number} Relative luminance
     */
    getLuminance(color) {
        const rgb = this.hexToRgb(color);
        if (!rgb) return 0;

        const [r, g, b] = [rgb.r, rgb.g, rgb.b].map(val => {
            val = val / 255;
            return val <= 0.03928 ? val / 12.92 : Math.pow((val + 0.055) / 1.055, 2.4);
        });

        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    }

    /**
     * Convert hex color to RGB
     * @param {string} hex - Hex color code
     * @returns {object|null} RGB values
     */
    hexToRgb(hex) {
        // Remove # if present
        hex = hex.replace('#', '');

        // Handle shorthand hex
        if (hex.length === 3) {
            hex = hex.split('').map(char => char + char).join('');
        }

        const result = /^([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    }

    /**
     * Calculate contrast ratio between two colors
     * @param {string} color1 - First color (hex)
     * @param {string} color2 - Second color (hex)
     * @returns {number} Contrast ratio
     */
    getContrastRatio(color1, color2) {
        const lum1 = this.getLuminance(color1);
        const lum2 = this.getLuminance(color2);
        const lighter = Math.max(lum1, lum2);
        const darker = Math.min(lum1, lum2);
        return (lighter + 0.05) / (darker + 0.05);
    }

    /**
     * Check if contrast ratio meets WCAG AA standards
     * @param {number} ratio - Contrast ratio
     * @param {boolean} isLargeText - Whether text is large (18pt+ or 14pt+ bold)
     * @returns {object} Compliance status
     */
    meetsWCAG(ratio, isLargeText = false) {
        const threshold = isLargeText ? this.WCAG_AA_LARGE : this.WCAG_AA_NORMAL;
        const thresholdAAA = isLargeText ? this.WCAG_AAA_LARGE : this.WCAG_AAA_NORMAL;

        return {
            AA: ratio >= threshold,
            AAA: ratio >= thresholdAAA,
            ratio: ratio.toFixed(2)
        };
    }

    /**
     * Verify all text elements on the page
     * @returns {array} Array of elements that fail WCAG AA
     */
    verifyPageContrast() {
        const textElements = document.querySelectorAll('p, h1, h2, h3, h4, h5, h6, span, a, button, label, li');
        const failures = [];

        textElements.forEach(element => {
            const style = window.getComputedStyle(element);
            const color = this.rgbToHex(style.color);
            const backgroundColor = this.getBackgroundColor(element);
            
            if (!color || !backgroundColor) return;

            const fontSize = parseFloat(style.fontSize);
            const fontWeight = parseInt(style.fontWeight);
            const isLargeText = fontSize >= 18 || (fontSize >= 14 && fontWeight >= 700);

            const ratio = this.getContrastRatio(color, backgroundColor);
            const compliance = this.meetsWCAG(ratio, isLargeText);

            if (!compliance.AA) {
                failures.push({
                    element: element,
                    text: element.textContent.substring(0, 50),
                    color: color,
                    backgroundColor: backgroundColor,
                    ratio: compliance.ratio,
                    required: isLargeText ? this.WCAG_AA_LARGE : this.WCAG_AA_NORMAL,
                    isLargeText: isLargeText
                });
            }
        });

        return failures;
    }

    /**
     * Get effective background color of an element
     * @param {HTMLElement} element - Element to check
     * @returns {string|null} Background color in hex
     */
    getBackgroundColor(element) {
        let current = element;
        
        while (current) {
            const style = window.getComputedStyle(current);
            const bgColor = style.backgroundColor;
            
            if (bgColor && bgColor !== 'rgba(0, 0, 0, 0)' && bgColor !== 'transparent') {
                return this.rgbToHex(bgColor);
            }
            
            current = current.parentElement;
        }
        
        return '#ffffff'; // Default to white
    }

    /**
     * Convert RGB color to hex
     * @param {string} rgb - RGB color string
     * @returns {string} Hex color code
     */
    rgbToHex(rgb) {
        const match = rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)/);
        if (!match) return null;

        const r = parseInt(match[1]);
        const g = parseInt(match[2]);
        const b = parseInt(match[3]);

        return '#' + [r, g, b].map(x => {
            const hex = x.toString(16);
            return hex.length === 1 ? '0' + hex : hex;
        }).join('');
    }

    /**
     * Test predefined color combinations from design tokens
     * @returns {object} Test results
     */
    testDesignTokens() {
        const tests = [
            // Primary text on white
            { name: 'Primary Blue on White', fg: '#2563eb', bg: '#ffffff', isLarge: false },
            // Body text on white
            { name: 'Gray 900 on White', fg: '#0f172a', bg: '#ffffff', isLarge: false },
            { name: 'Gray 700 on White', fg: '#334155', bg: '#ffffff', isLarge: false },
            { name: 'Gray 600 on White', fg: '#475569', bg: '#ffffff', isLarge: false },
            // Light text on dark
            { name: 'White on Primary Blue', fg: '#ffffff', bg: '#2563eb', isLarge: false },
            { name: 'White on Gray 900', fg: '#ffffff', bg: '#0f172a', isLarge: false },
            // Light gray backgrounds
            { name: 'Gray 900 on Light Gray 50', fg: '#0f172a', bg: '#f8fafc', isLarge: false },
            { name: 'Gray 700 on Light Gray 100', fg: '#334155', bg: '#f1f5f9', isLarge: false },
        ];

        const results = tests.map(test => {
            const ratio = this.getContrastRatio(test.fg, test.bg);
            const compliance = this.meetsWCAG(ratio, test.isLarge);
            
            return {
                ...test,
                ratio: compliance.ratio,
                passAA: compliance.AA,
                passAAA: compliance.AAA
            };
        });

        return results;
    }

    /**
     * Log contrast test results to console
     */
    logTestResults() {
        console.group('🎨 Color Contrast Test Results');
        
        const tokenResults = this.testDesignTokens();
        console.table(tokenResults);
        
        const pageFailures = this.verifyPageContrast();
        if (pageFailures.length > 0) {
            console.warn(`⚠️ Found ${pageFailures.length} elements with insufficient contrast:`);
            console.table(pageFailures.map(f => ({
                text: f.text,
                color: f.color,
                background: f.backgroundColor,
                ratio: f.ratio,
                required: f.required.toFixed(1),
                isLarge: f.isLarge
            })));
        } else {
            console.log('✅ All text elements meet WCAG AA standards');
        }
        
        console.groupEnd();
        
        return {
            tokenTests: tokenResults,
            pageFailures: pageFailures
        };
    }
}

// Initialize and run tests in development mode
if (import.meta.env.DEV) {
    document.addEventListener('DOMContentLoaded', () => {
        const checker = new ColorContrastChecker();
        // Run tests after a short delay to ensure styles are loaded
        setTimeout(() => {
            checker.logTestResults();
        }, 1000);
    });
}

export default ColorContrastChecker;
