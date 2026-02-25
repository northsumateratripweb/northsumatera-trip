/**
 * Performance Monitoring with Core Web Vitals
 * Tracks LCP, FID, CLS, FCP, TTFB
 */

/**
 * Core Web Vitals thresholds
 */
const THRESHOLDS = {
    LCP: { good: 2500, needsImprovement: 4000 },
    FID: { good: 100, needsImprovement: 300 },
    CLS: { good: 0.1, needsImprovement: 0.25 },
    FCP: { good: 1800, needsImprovement: 3000 },
    TTFB: { good: 800, needsImprovement: 1800 }
};

/**
 * Performance metrics storage
 */
const metrics = {
    LCP: null,
    FID: null,
    CLS: null,
    FCP: null,
    TTFB: null,
    heroLoadTime: null
};

/**
 * Get rating based on threshold
 */
function getRating(metric, value) {
    const threshold = THRESHOLDS[metric];
    if (!threshold) return 'unknown';
    
    if (value <= threshold.good) return 'good';
    if (value <= threshold.needsImprovement) return 'needs-improvement';
    return 'poor';
}

/**
 * Report metric to console (can be extended to send to analytics)
 */
function reportMetric(name, value, rating) {
    metrics[name] = { value, rating };
    
    console.log(`[Performance] ${name}: ${value.toFixed(2)}ms - ${rating}`);
    
    // You can extend this to send to analytics service
    // Example: sendToAnalytics({ metric: name, value, rating });
}

/**
 * Measure Largest Contentful Paint (LCP)
 */
function measureLCP() {
    if (!('PerformanceObserver' in window)) return;
    
    try {
        const observer = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            const lastEntry = entries[entries.length - 1];
            
            const value = lastEntry.renderTime || lastEntry.loadTime;
            const rating = getRating('LCP', value);
            
            reportMetric('LCP', value, rating);
        });
        
        observer.observe({ type: 'largest-contentful-paint', buffered: true });
    } catch (e) {
        console.warn('LCP measurement not supported:', e);
    }
}

/**
 * Measure First Input Delay (FID)
 */
function measureFID() {
    if (!('PerformanceObserver' in window)) return;
    
    try {
        const observer = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            
            entries.forEach(entry => {
                const value = entry.processingStart - entry.startTime;
                const rating = getRating('FID', value);
                
                reportMetric('FID', value, rating);
            });
        });
        
        observer.observe({ type: 'first-input', buffered: true });
    } catch (e) {
        console.warn('FID measurement not supported:', e);
    }
}

/**
 * Measure Cumulative Layout Shift (CLS)
 */
function measureCLS() {
    if (!('PerformanceObserver' in window)) return;
    
    try {
        let clsValue = 0;
        
        const observer = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            
            entries.forEach(entry => {
                if (!entry.hadRecentInput) {
                    clsValue += entry.value;
                }
            });
            
            const rating = getRating('CLS', clsValue);
            reportMetric('CLS', clsValue, rating);
        });
        
        observer.observe({ type: 'layout-shift', buffered: true });
    } catch (e) {
        console.warn('CLS measurement not supported:', e);
    }
}

/**
 * Measure First Contentful Paint (FCP)
 */
function measureFCP() {
    if (!('PerformanceObserver' in window)) return;
    
    try {
        const observer = new PerformanceObserver((list) => {
            const entries = list.getEntries();
            
            entries.forEach(entry => {
                if (entry.name === 'first-contentful-paint') {
                    const value = entry.startTime;
                    const rating = getRating('FCP', value);
                    
                    reportMetric('FCP', value, rating);
                }
            });
        });
        
        observer.observe({ type: 'paint', buffered: true });
    } catch (e) {
        console.warn('FCP measurement not supported:', e);
    }
}

/**
 * Measure Time to First Byte (TTFB)
 */
function measureTTFB() {
    if (!('performance' in window) || !performance.timing) return;
    
    try {
        const navigationTiming = performance.getEntriesByType('navigation')[0];
        
        if (navigationTiming) {
            const value = navigationTiming.responseStart - navigationTiming.requestStart;
            const rating = getRating('TTFB', value);
            
            reportMetric('TTFB', value, rating);
        }
    } catch (e) {
        console.warn('TTFB measurement not supported:', e);
    }
}

/**
 * Measure hero section load time
 */
function measureHeroLoadTime() {
    const heroSection = document.querySelector('[data-hero-section]');
    if (!heroSection) return;
    
    const observer = new PerformanceObserver((list) => {
        const entries = list.getEntries();
        
        entries.forEach(entry => {
            if (entry.element === heroSection) {
                const value = entry.loadTime || entry.renderTime;
                const rating = value <= 3000 ? 'good' : value <= 5000 ? 'needs-improvement' : 'poor';
                
                reportMetric('heroLoadTime', value, rating);
            }
        });
    });
    
    try {
        observer.observe({ type: 'element', buffered: true });
    } catch (e) {
        // Fallback: measure when hero image loads
        const heroImage = heroSection.querySelector('img, video');
        if (heroImage) {
            const startTime = performance.now();
            
            const measureLoad = () => {
                const value = performance.now() - startTime;
                const rating = value <= 3000 ? 'good' : value <= 5000 ? 'needs-improvement' : 'poor';
                
                reportMetric('heroLoadTime', value, rating);
            };
            
            if (heroImage.complete) {
                measureLoad();
            } else {
                heroImage.addEventListener('load', measureLoad);
            }
        }
    }
}

/**
 * Get all collected metrics
 */
export function getMetrics() {
    return { ...metrics };
}

/**
 * Initialize performance monitoring
 */
export function initPerformanceMonitoring() {
    // Wait for page to be fully loaded
    if (document.readyState === 'complete') {
        startMonitoring();
    } else {
        window.addEventListener('load', startMonitoring);
    }
}

/**
 * Start all performance measurements
 */
function startMonitoring() {
    console.log('[Performance] Starting Core Web Vitals monitoring...');
    
    measureLCP();
    measureFID();
    measureCLS();
    measureFCP();
    measureTTFB();
    measureHeroLoadTime();
    
    // Log summary after 5 seconds
    setTimeout(() => {
        console.log('[Performance] Summary:', getMetrics());
    }, 5000);
}

/**
 * Export metrics for external use
 */
export function exportMetrics() {
    return {
        metrics: getMetrics(),
        timestamp: new Date().toISOString(),
        userAgent: navigator.userAgent,
        connection: navigator.connection ? {
            effectiveType: navigator.connection.effectiveType,
            downlink: navigator.connection.downlink,
            rtt: navigator.connection.rtt
        } : null
    };
}
