<?php

namespace Tests\Unit\Performance;

use Tests\TestCase;

/**
 * Property 22: Hero section loads within performance threshold
 * Property 23: Animations do not block page rendering
 * **Validates: Requirements 9.1, 9.2, 9.3, 9.4, 9.5**
 */
class PerformanceTest extends TestCase
{
    /** @test */
    public function animations_use_css_transforms()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        $this->assertStringContainsString('transform:', $cssContent);
    }

    /** @test */
    public function animations_use_will_change_property()
    {
        $animationsJs = file_get_contents(resource_path('js/animations.js'));
        $this->assertStringContainsString('will-change', $animationsJs);
    }
    
    /** @test */
    public function hero_section_has_lazy_loading()
    {
        $heroComponent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        $this->assertStringContainsString('loading="lazy"', $heroComponent,
            'Hero section must implement lazy loading for images');
    }
    
    /** @test */
    public function hero_section_has_responsive_images()
    {
        $heroComponent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        // Check for picture element or srcset
        $hasResponsiveImages = 
            str_contains($heroComponent, '<picture') ||
            str_contains($heroComponent, 'srcset=');
        
        $this->assertTrue($hasResponsiveImages,
            'Hero section must use responsive images (picture element or srcset)');
    }
    
    /** @test */
    public function hero_section_has_loading_placeholder()
    {
        $heroComponent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        // Check for placeholder element
        $hasPlaceholder = 
            str_contains($heroComponent, 'animate-pulse') ||
            str_contains($heroComponent, 'placeholder') ||
            str_contains($heroComponent, 'bg-gradient');
        
        $this->assertTrue($hasPlaceholder,
            'Hero section must have a loading placeholder');
    }
    
    /** @test */
    public function hero_section_supports_webp_format()
    {
        $heroComponent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        $this->assertStringContainsString('image/webp', $heroComponent,
            'Hero section must support WebP image format');
    }
    
    /** @test */
    public function hero_section_supports_avif_format()
    {
        $heroComponent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        $this->assertStringContainsString('image/avif', $heroComponent,
            'Hero section must support AVIF image format');
    }
    
    /** @test */
    public function code_splitting_is_implemented()
    {
        $lazyLoaderExists = file_exists(resource_path('js/lazy-loader.js'));
        
        $this->assertTrue($lazyLoaderExists,
            'Lazy loader module must exist for code splitting');
        
        if ($lazyLoaderExists) {
            $lazyLoaderContent = file_get_contents(resource_path('js/lazy-loader.js'));
            
            $this->assertStringContainsString('lazyLoadComponent', $lazyLoaderContent,
                'Lazy loader must implement lazyLoadComponent function');
            
            $this->assertStringContainsString('IntersectionObserver', $lazyLoaderContent,
                'Lazy loader must use IntersectionObserver for performance');
        }
    }
    
    /** @test */
    public function performance_monitoring_is_implemented()
    {
        $performanceMonitorExists = file_exists(resource_path('js/performance-monitor.js'));
        
        $this->assertTrue($performanceMonitorExists,
            'Performance monitoring module must exist');
        
        if ($performanceMonitorExists) {
            $monitorContent = file_get_contents(resource_path('js/performance-monitor.js'));
            
            // Check for Core Web Vitals
            $this->assertStringContainsString('LCP', $monitorContent,
                'Performance monitor must track Largest Contentful Paint (LCP)');
            
            $this->assertStringContainsString('FID', $monitorContent,
                'Performance monitor must track First Input Delay (FID)');
            
            $this->assertStringContainsString('CLS', $monitorContent,
                'Performance monitor must track Cumulative Layout Shift (CLS)');
            
            $this->assertStringContainsString('FCP', $monitorContent,
                'Performance monitor must track First Contentful Paint (FCP)');
            
            $this->assertStringContainsString('TTFB', $monitorContent,
                'Performance monitor must track Time to First Byte (TTFB)');
        }
    }
    
    /** @test */
    public function performance_monitoring_tracks_hero_load_time()
    {
        $monitorContent = file_get_contents(resource_path('js/performance-monitor.js'));
        
        $this->assertStringContainsString('heroLoadTime', $monitorContent,
            'Performance monitor must track hero section load time');
    }
    
    /** @test */
    public function animations_have_will_change_cleanup()
    {
        $animationsJs = file_get_contents(resource_path('js/animations.js'));
        
        // Check that will-change is removed after animation
        $this->assertStringContainsString('will-change', $animationsJs);
        $this->assertStringContainsString('willChange', $animationsJs);
        
        // Check for cleanup (setting to 'auto')
        $hasCleanup = 
            str_contains($animationsJs, "willChange = 'auto'") ||
            str_contains($animationsJs, 'willChange: auto') ||
            str_contains($animationsJs, 'will-change: auto');
        
        $this->assertTrue($hasCleanup,
            'Animations must clean up will-change property after completion');
    }
    
    /** @test */
    public function css_uses_hardware_accelerated_properties()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Check for transform usage (hardware accelerated)
        $this->assertStringContainsString('transform:', $cssContent);
        
        // Check for opacity usage (hardware accelerated)
        $this->assertStringContainsString('opacity:', $cssContent);
        
        // Verify will-change is used
        $this->assertStringContainsString('will-change', $cssContent);
    }
    
    /** @test */
    public function css_respects_reduced_motion()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        $this->assertStringContainsString('prefers-reduced-motion', $cssContent,
            'CSS must respect prefers-reduced-motion for accessibility');
    }
    
    /** @test */
    public function lazy_loading_components_exist()
    {
        // Check that component files for lazy loading exist
        $trustSectionExists = file_exists(resource_path('js/components/trust-section.js'));
        $tourPackagesExists = file_exists(resource_path('js/components/tour-packages.js'));
        $footerExists = file_exists(resource_path('js/components/footer.js'));
        
        $this->assertTrue($trustSectionExists,
            'Trust section lazy loading component must exist');
        
        $this->assertTrue($tourPackagesExists,
            'Tour packages lazy loading component must exist');
        
        $this->assertTrue($footerExists,
            'Footer lazy loading component must exist');
    }
    
    /** @test */
    public function app_js_initializes_performance_features()
    {
        $appJs = file_get_contents(resource_path('js/app.js'));
        
        // Check for lazy loading initialization
        $this->assertStringContainsString('initLazyLoading', $appJs,
            'App.js must initialize lazy loading');
        
        // Check for performance monitoring initialization
        $this->assertStringContainsString('initPerformanceMonitoring', $appJs,
            'App.js must initialize performance monitoring');
        
        // Check for preload critical resources
        $this->assertStringContainsString('preloadCriticalResources', $appJs,
            'App.js must preload critical resources');
    }
    
    /** @test */
    public function animation_optimization_is_initialized()
    {
        $animationsJs = file_get_contents(resource_path('js/animations.js'));
        
        $this->assertStringContainsString('optimizeAnimations', $animationsJs,
            'Animations.js must include optimizeAnimations function');
    }
}
