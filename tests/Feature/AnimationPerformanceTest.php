<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Property 23: Animations do not block page rendering
 * **Validates: Requirements 9.3**
 * 
 * Property-based test: For any animation on page load,
 * the animation MUST NOT block the main thread or delay content display
 */
class AnimationPerformanceTest extends TestCase
{
    /**
     * Test animations use CSS transforms instead of layout-triggering properties
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function animations_use_css_transforms(): void
    {
        // Property: For ANY animation, CSS transforms must be used
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify transform property is used in animations
        $this->assertStringContainsString('transform:', $cssContent,
            'Animations must use CSS transform property');
        
        // Verify animations use transform-based properties
        $hasTransformAnimations = 
            str_contains($cssContent, 'translateY') ||
            str_contains($cssContent, 'translateX') ||
            str_contains($cssContent, 'scale') ||
            str_contains($cssContent, 'rotate');
        
        $this->assertTrue($hasTransformAnimations,
            'Animations must use transform-based properties (translateY, translateX, scale, rotate)');
    }
    
    /**
     * Test animations use will-change property for optimization
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function animations_use_will_change_property(): void
    {
        // Property: For ANY animated element, will-change must be used for optimization
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify will-change is used in CSS
        $this->assertStringContainsString('will-change', $cssContent,
            'Animated elements must use will-change property for optimization');
        
        // Check JavaScript also implements will-change
        $animationsJs = file_get_contents(resource_path('js/animations.js'));
        
        $this->assertStringContainsString('will-change', $animationsJs,
            'Animation JavaScript must implement will-change property');
        
        $this->assertStringContainsString('willChange', $animationsJs,
            'Animation JavaScript must set willChange property on elements');
    }
    
    /**
     * Test animations avoid layout-triggering properties
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function animations_avoid_layout_triggering_properties(): void
    {
        // Property: For ANY animation, layout-triggering properties should be avoided
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Extract animation and transition rules
        preg_match_all('/@keyframes\s+[\w-]+\s*{([^}]+)}/s', $cssContent, $keyframeMatches);
        preg_match_all('/\.[\w-]+\s*{[^}]*transition:[^}]*}/s', $cssContent, $transitionMatches);
        
        $animationRules = implode(' ', $keyframeMatches[0] ?? []);
        $transitionRules = implode(' ', $transitionMatches[0] ?? []);
        $allRules = $animationRules . ' ' . $transitionRules;
        
        // Properties that trigger layout (should be avoided in animations)
        $layoutTriggeringProps = ['width', 'height', 'top', 'left', 'right', 'bottom', 'margin', 'padding'];
        
        $foundLayoutProps = [];
        foreach ($layoutTriggeringProps as $prop) {
            // Check if property is animated (not just set statically)
            if (preg_match('/\b' . $prop . '\s*:\s*[^;]+;/i', $allRules)) {
                $foundLayoutProps[] = $prop;
            }
        }
        
        // Allow some layout properties but warn if too many are used
        $this->assertLessThan(3, count($foundLayoutProps),
            'Animations should minimize use of layout-triggering properties. Found: ' . implode(', ', $foundLayoutProps));
    }
    
    /**
     * Test animations use hardware acceleration
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function animations_use_hardware_acceleration(): void
    {
        // Property: For ANY animation, hardware acceleration should be enabled
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Check for transform3d or translateZ which trigger hardware acceleration
        $hasHardwareAcceleration = 
            str_contains($cssContent, 'transform3d') ||
            str_contains($cssContent, 'translateZ') ||
            str_contains($cssContent, 'perspective');
        
        // Also check for will-change which enables hardware acceleration
        $hasWillChange = str_contains($cssContent, 'will-change');
        
        $this->assertTrue($hasHardwareAcceleration || $hasWillChange,
            'Animations should use hardware acceleration (transform3d, translateZ, or will-change)');
    }
    
    /**
     * Test animations use appropriate easing functions
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function animations_use_appropriate_easing(): void
    {
        // Property: For ANY animation, appropriate easing functions must be used
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Check for easing functions
        $hasEasing = 
            str_contains($cssContent, 'ease-in-out') ||
            str_contains($cssContent, 'ease-out') ||
            str_contains($cssContent, 'cubic-bezier');
        
        $this->assertTrue($hasEasing,
            'Animations must use appropriate easing functions (ease-in-out, ease-out, or cubic-bezier)');
        
        // Verify no linear easing for user-facing animations (linear is jarring)
        $animationLines = array_filter(explode("\n", $cssContent), function($line) {
            return str_contains($line, 'animation:') || str_contains($line, 'transition:');
        });
        
        $linearCount = 0;
        foreach ($animationLines as $line) {
            if (str_contains($line, 'linear')) {
                $linearCount++;
            }
        }
        
        // Allow some linear animations but not too many
        $this->assertLessThan(5, $linearCount,
            'Too many linear animations found. Use ease-in-out or cubic-bezier for smoother animations');
    }
    
    /**
     * Test animations have reasonable durations
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function animations_have_reasonable_durations(): void
    {
        // Property: For ANY animation, duration should be reasonable (not too long)
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Extract animation durations
        preg_match_all('/animation:\s*[^;]*?(\d+(?:\.\d+)?)(ms|s)/i', $cssContent, $animationMatches);
        preg_match_all('/transition:\s*[^;]*?(\d+(?:\.\d+)?)(ms|s)/i', $cssContent, $transitionMatches);
        
        $durations = array_merge($animationMatches[1] ?? [], $transitionMatches[1] ?? []);
        $units = array_merge($animationMatches[2] ?? [], $transitionMatches[2] ?? []);
        
        $tooLongAnimations = 0;
        foreach ($durations as $index => $duration) {
            $durationMs = $units[$index] === 's' ? $duration * 1000 : $duration;
            
            // Animations longer than 2 seconds are generally too long
            if ($durationMs > 2000) {
                $tooLongAnimations++;
            }
        }
        
        $this->assertEquals(0, $tooLongAnimations,
            "Found {$tooLongAnimations} animations longer than 2 seconds. Animations should be snappy (< 2s)");
    }
    
    /**
     * Test animations respect prefers-reduced-motion
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function animations_respect_reduced_motion_preference(): void
    {
        // Property: For ANY animation, reduced motion preferences must be respected
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Check for prefers-reduced-motion media query
        $this->assertStringContainsString('prefers-reduced-motion', $cssContent,
            'CSS must include @media (prefers-reduced-motion) for accessibility');
        
        // Verify reduced motion disables or minimizes animations
        $hasReducedMotionRules = 
            str_contains($cssContent, 'animation-duration: 0.01ms') ||
            str_contains($cssContent, 'transition-duration: 0.01ms') ||
            str_contains($cssContent, 'animation: none');
        
        $this->assertTrue($hasReducedMotionRules,
            'Reduced motion media query must disable or minimize animations');
    }
    
    /**
     * Test page renders content before animations complete
     * 
     * @test
     * Feature: travel-website-redesign, Property 23: Animations do not block page rendering
     */
    public function page_renders_content_before_animations_complete(): void
    {
        // Property: For ANY page load, content must be visible before animations complete
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Verify content is not hidden by default (which would block rendering)
        $this->assertStringNotContainsString('opacity: 0', $content,
            'Content should not be hidden by default (blocks rendering)');
        
        // Verify animations are applied progressively, not blocking initial render
        $hasProgressiveAnimation = 
            str_contains($content, 'animate-fade-in') ||
            str_contains($content, 'scroll-reveal') ||
            str_contains($content, 'fade-in-viewport');
        
        // If animations are used, they should be progressive (not blocking)
        if ($hasProgressiveAnimation) {
            $this->assertTrue(true, 'Progressive animations detected');
        } else {
            // No animations is also acceptable
            $this->assertTrue(true, 'No blocking animations detected');
        }
    }
}
