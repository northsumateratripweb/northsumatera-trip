<?php

namespace Tests\Unit\Responsive;

use Tests\TestCase;

/**
 * Property 20: Images are optimized for the current device
 * **Validates: Requirements 8.5**
 * Feature: travel-website-redesign, Property 20: Responsive Images
 */
class ResponsiveImagesTest extends TestCase
{
    /**
     * @test
     * Property: For any image on any device, the image source MUST be 
     * appropriately sized for the screen dimensions
     */
    public function images_use_responsive_srcset_attributes()
    {
        // Test hero section image
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        // Verify srcset attribute exists for responsive images
        $this->assertStringContainsString('srcset=', $heroContent, 
            'Hero images must use srcset for responsive loading');
        
        // Verify multiple image sizes are defined
        $this->assertStringContainsString('320w', $heroContent, 
            'Hero images must include mobile size (320w)');
        $this->assertStringContainsString('640w', $heroContent, 
            'Hero images must include small tablet size (640w)');
        $this->assertStringContainsString('1024w', $heroContent, 
            'Hero images must include tablet size (1024w)');
        $this->assertStringContainsString('1920w', $heroContent, 
            'Hero images must include desktop size (1920w)');
    }

    /**
     * @test
     * Property: Images must use optimized formats (WebP/AVIF)
     */
    public function images_use_modern_formats()
    {
        // Test hero section
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        // Verify WebP support
        $this->assertStringContainsString('type="image/webp"', $heroContent, 
            'Hero images must support WebP format');
        
        // Verify AVIF support
        $this->assertStringContainsString('type="image/avif"', $heroContent, 
            'Hero images must support AVIF format');
        
        // Test package card
        $packageCardContent = file_get_contents(resource_path('views/components/tour-packages/package-card.blade.php'));
        
        $this->assertStringContainsString('type="image/webp"', $packageCardContent, 
            'Package card images must support WebP format');
        $this->assertStringContainsString('type="image/avif"', $packageCardContent, 
            'Package card images must support AVIF format');
    }

    /**
     * @test
     * Property: Images must use lazy loading for performance
     */
    public function images_use_lazy_loading()
    {
        // Test hero section
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        $this->assertStringContainsString('loading="lazy"', $heroContent, 
            'Hero images must use lazy loading');
        
        // Test package card
        $packageCardContent = file_get_contents(resource_path('views/components/tour-packages/package-card.blade.php'));
        $this->assertStringContainsString('loading="lazy"', $packageCardContent, 
            'Package card images must use lazy loading');
    }

    /**
     * @test
     * Property: Images must have appropriate sizes attribute for responsive loading
     */
    public function images_have_sizes_attribute()
    {
        // Test hero section
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        $this->assertStringContainsString('sizes=', $heroContent, 
            'Hero images must have sizes attribute for responsive loading');
        
        // Test package card
        $packageCardContent = file_get_contents(resource_path('views/components/tour-packages/package-card.blade.php'));
        $this->assertStringContainsString('sizes=', $packageCardContent, 
            'Package card images must have sizes attribute for responsive loading');
    }

    /**
     * @test
     * Property: Images must use picture element for format fallback
     */
    public function images_use_picture_element()
    {
        // Test hero section
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        $this->assertStringContainsString('<picture', $heroContent, 
            'Hero images must use picture element for format fallback');
        
        // Test package card
        $packageCardContent = file_get_contents(resource_path('views/components/tour-packages/package-card.blade.php'));
        $this->assertStringContainsString('<picture', $packageCardContent, 
            'Package card images must use picture element for format fallback');
    }

    /**
     * @test
     * Property: CSS provides shimmer placeholder for loading images
     */
    public function images_have_shimmer_placeholder()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify shimmer animation exists
        $this->assertStringContainsString('shimmer', $cssContent, 
            'CSS must define shimmer animation for image placeholders');
        
        // Verify lazy loading images have background
        $this->assertMatchesRegularExpression(
            '/img\[loading="lazy"\]\s*{[^}]*background:/s',
            $cssContent,
            'Lazy loading images must have background placeholder'
        );
    }
}

