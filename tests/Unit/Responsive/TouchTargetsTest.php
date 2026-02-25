<?php

namespace Tests\Unit\Responsive;

use Tests\TestCase;

/**
 * Property 9: Touch targets meet minimum size requirements on mobile
 * 
 * **Validates: Requirements 5.1**
 * 
 * Feature: travel-website-redesign, Property 9: Touch targets
 */
class TouchTargetsTest extends TestCase
{
    /**
     * @test
     * Property: For any interactive element on mobile devices, 
     * the touch target area MUST be at least 44x44 pixels
     */
    public function touch_targets_meet_minimum_size_requirements()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify tap-target utility class exists
        $this->assertStringContainsString('.tap-target', $cssContent, 
            'Tap target utility class must exist');
        
        // Verify minimum width is 44px
        $this->assertStringContainsString('min-width: 44px', $cssContent, 
            'Touch targets must have minimum width of 44px');
        
        // Verify minimum height is 44px
        $this->assertStringContainsString('min-height: 44px', $cssContent, 
            'Touch targets must have minimum height of 44px');
    }

    /**
     * @test
     * Property: Buttons must have adequate touch target size
     */
    public function buttons_have_adequate_touch_target_size()
    {
        $buttonContent = file_get_contents(resource_path('views/components/button.blade.php'));
        
        // Verify button uses tap-target class
        $this->assertStringContainsString('tap-target', $buttonContent, 
            'Button component must use tap-target class');
    }

    /**
     * @test
     * Property: Interactive elements have proper display and alignment
     */
    public function tap_target_class_has_proper_display_properties()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify tap-target uses flex display for centering
        $this->assertMatchesRegularExpression(
            '/\.tap-target\s*{[^}]*display:\s*inline-flex/s',
            $cssContent,
            'Tap target must use inline-flex display'
        );
        
        // Verify alignment properties
        $this->assertMatchesRegularExpression(
            '/\.tap-target\s*{[^}]*align-items:\s*center/s',
            $cssContent,
            'Tap target must center items vertically'
        );
        
        $this->assertMatchesRegularExpression(
            '/\.tap-target\s*{[^}]*justify-content:\s*center/s',
            $cssContent,
            'Tap target must center items horizontally'
        );
    }
}
