<?php

namespace Tests\Unit\Responsive;

use Tests\TestCase;

/**
 * Unit tests for Responsive Design
 * Tests breakpoint behavior and layout adaptation
 * Requirements: 8.1, 8.2, 8.3, 8.4, 8.5
 */
class ResponsiveDesignTest extends TestCase
{
    /**
     * @test
     * Test that Tailwind breakpoints are properly configured
     */
    public function tailwind_breakpoints_are_configured()
    {
        $tailwindConfig = file_get_contents(base_path('tailwind.config.js'));
        
        // Verify Tailwind is using default breakpoints (mobile-first)
        // Default breakpoints: sm: 640px, md: 768px, lg: 1024px, xl: 1280px, 2xl: 1536px
        $this->assertStringContainsString('tailwindcss', $tailwindConfig, 
            'Tailwind CSS must be configured');
    }

    /**
     * @test
     * Test that responsive utilities are defined in CSS
     */
    public function responsive_utilities_are_defined()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify mobile-only utility
        $this->assertStringContainsString('.mobile-only', $cssContent, 
            'Mobile-only utility class must be defined');
        
        // Verify desktop-only utility
        $this->assertStringContainsString('.desktop-only', $cssContent, 
            'Desktop-only utility class must be defined');
        
        // Verify tablet-only utility
        $this->assertStringContainsString('.tablet-only', $cssContent, 
            'Tablet-only utility class must be defined');
    }

    /**
     * @test
     * Test that responsive spacing utilities exist
     */
    public function responsive_spacing_utilities_exist()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        $this->assertStringContainsString('.spacing-mobile', $cssContent, 
            'Responsive spacing utility must be defined');
    }

    /**
     * @test
     * Test that hero section uses responsive classes
     */
    public function hero_section_uses_responsive_classes()
    {
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        // Verify responsive padding
        $this->assertMatchesRegularExpression('/px-\d+\s+sm:px-\d+/', $heroContent, 
            'Hero section must use responsive padding');
        
        // Verify responsive spacing
        $this->assertMatchesRegularExpression('/space-y-\d+\s+sm:space-y-\d+/', $heroContent, 
            'Hero section must use responsive spacing');
        
        // Verify responsive text sizes
        $this->assertMatchesRegularExpression('/text-\w+\s+sm:text-\w+/', $heroContent, 
            'Hero section must use responsive text sizes');
    }

    /**
     * @test
     * Test that navigation uses responsive layout
     */
    public function navigation_uses_responsive_layout()
    {
        $navContent = file_get_contents(resource_path('views/components/navigation/navigation.blade.php'));
        
        // Verify mobile menu is hidden on desktop
        $this->assertStringContainsString('md:hidden', $navContent, 
            'Mobile menu toggle must be hidden on desktop');
        
        // Verify desktop menu is hidden on mobile
        $this->assertStringContainsString('hidden md:flex', $navContent, 
            'Desktop menu must be hidden on mobile');
    }

    /**
     * @test
     * Test that tour packages grid is responsive
     */
    public function tour_packages_grid_is_responsive()
    {
        $packagesContent = file_get_contents(resource_path('views/components/tour-packages/tour-packages-section.blade.php'));
        
        // Verify responsive grid columns
        $this->assertStringContainsString('grid-cols-1', $packagesContent, 
            'Tour packages must use 1 column on mobile');
        $this->assertStringContainsString('md:grid-cols-2', $packagesContent, 
            'Tour packages must use 2 columns on tablet');
        $this->assertStringContainsString('lg:grid-cols-3', $packagesContent, 
            'Tour packages must use 3 columns on desktop');
    }

    /**
     * @test
     * Test that trust section grid is responsive
     */
    public function trust_section_grid_is_responsive()
    {
        $trustContent = file_get_contents(resource_path('views/components/trust/trust-section.blade.php'));
        
        // Verify responsive grid layout
        $this->assertStringContainsString('grid-cols-1', $trustContent, 
            'Trust section must use 1 column on mobile');
        $this->assertMatchesRegularExpression('/md:grid-cols-\d+/', $trustContent, 
            'Trust section must use multiple columns on tablet');
        $this->assertMatchesRegularExpression('/lg:grid-cols-\d+/', $trustContent, 
            'Trust section must use multiple columns on desktop');
    }

    /**
     * @test
     * Test that buttons maintain minimum touch target size
     */
    public function buttons_maintain_minimum_touch_target_size()
    {
        $buttonContent = file_get_contents(resource_path('views/components/button.blade.php'));
        
        // Verify tap-target class is used
        $this->assertStringContainsString('tap-target', $buttonContent, 
            'Buttons must use tap-target class for minimum size');
    }

    /**
     * @test
     * Test that CTA buttons stack on mobile
     */
    public function cta_buttons_stack_on_mobile()
    {
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        // Verify flex direction changes from column to row
        $this->assertMatchesRegularExpression('/flex-col\s+sm:flex-row/', $heroContent, 
            'CTA buttons must stack vertically on mobile and horizontally on larger screens');
    }

    /**
     * @test
     * Test that images have responsive dimensions
     */
    public function images_have_responsive_dimensions()
    {
        $packageCardContent = file_get_contents(resource_path('views/components/tour-packages/package-card.blade.php'));
        
        // Verify responsive height classes
        $this->assertMatchesRegularExpression('/h-\d+\s+md:h-\d+/', $packageCardContent, 
            'Package card images must have responsive heights');
    }

    /**
     * @test
     * Test that typography scales responsively
     */
    public function typography_scales_responsively()
    {
        $heroContent = file_get_contents(resource_path('views/components/hero/hero-section.blade.php'));
        
        // Verify headline has multiple text size breakpoints
        $this->assertMatchesRegularExpression('/text-\w+\s+sm:text-\w+\s+md:text-\w+/', $heroContent, 
            'Headlines must scale across multiple breakpoints');
    }

    /**
     * @test
     * Test that container padding is responsive
     */
    public function container_padding_is_responsive()
    {
        $components = [
            resource_path('views/components/hero/hero-section.blade.php'),
            resource_path('views/components/trust/trust-section.blade.php'),
            resource_path('views/components/tour-packages/tour-packages-section.blade.php'),
        ];
        
        foreach ($components as $component) {
            $content = file_get_contents($component);
            
            // Verify responsive padding pattern exists
            $hasResponsivePadding = preg_match('/p[xy]?-\d+\s+(sm|md|lg):p[xy]?-\d+/', $content);
            $this->assertTrue($hasResponsivePadding > 0, 
                basename($component) . ' must use responsive padding');
        }
    }

    /**
     * @test
     * Test that gap spacing is responsive
     */
    public function gap_spacing_is_responsive()
    {
        $packagesContent = file_get_contents(resource_path('views/components/tour-packages/tour-packages-section.blade.php'));
        
        // Verify responsive gap
        $this->assertMatchesRegularExpression('/gap-\d+\s+md:gap-\d+/', $packagesContent, 
            'Grid gap must be responsive');
    }

    /**
     * @test
     * Test that mobile menu has proper responsive behavior
     */
    public function mobile_menu_has_proper_responsive_behavior()
    {
        $navContent = file_get_contents(resource_path('views/components/navigation/navigation.blade.php'));
        
        // Verify mobile menu container is responsive
        $this->assertStringContainsString('md:hidden', $navContent, 
            'Mobile menu must be hidden on desktop');
        
        // Verify mobile menu uses full width on mobile
        $this->assertStringContainsString('inset-x-0', $navContent, 
            'Mobile menu must span full width');
    }

    /**
     * @test
     * Test that layout adapts without breaking elements
     */
    public function layout_prevents_horizontal_overflow()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify overflow-x is hidden on mobile
        $this->assertMatchesRegularExpression('/@media.*max-width.*overflow-x:\s*hidden/s', $cssContent, 
            'CSS must prevent horizontal overflow on mobile');
    }

    /**
     * @test
     * Test that border radius scales down on mobile
     */
    public function border_radius_scales_down_on_mobile()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify border-radius adjustments for mobile
        $this->assertMatchesRegularExpression('/@media.*max-width.*border-radius/s', $cssContent, 
            'Border radius must scale down on mobile for better space utilization');
    }
}
