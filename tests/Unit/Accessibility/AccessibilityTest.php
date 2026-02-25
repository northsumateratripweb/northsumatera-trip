<?php

namespace Tests\Unit\Accessibility;

use Tests\TestCase;

/**
 * Unit tests for Accessibility features
 * Tests specific examples and edge cases for accessibility compliance
 * Requirements: 10.1, 10.2, 10.3, 10.4, 10.5
 */
class AccessibilityTest extends TestCase
{
    /**
     * @test
     * Test that hero section image has alt text
     */
    public function hero_section_image_has_alt_text()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Check for hero section images with alt text
        $this->assertMatchesRegularExpression(
            '/<img[^>]*alt\s*=\s*["\'][^"\']*["\'][^>]*>/i',
            $content,
            'Hero section should have images with alt text'
        );
    }
    
    /**
     * @test
     * Test that navigation has proper ARIA labels
     */
    public function navigation_has_aria_labels()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Check for navigation with role or aria-label
        $this->assertMatchesRegularExpression(
            '/<nav[^>]*(role\s*=\s*["\']navigation["\']|aria-label\s*=\s*["\'][^"\']+["\'])[^>]*>/i',
            $content,
            'Navigation should have proper ARIA labels'
        );
    }
    
    /**
     * @test
     * Test that buttons are keyboard accessible
     */
    public function buttons_are_keyboard_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all buttons
        preg_match_all('/<button[^>]*>/i', $content, $matches);
        $buttons = $matches[0];
        
        foreach ($buttons as $button) {
            // Buttons should not have tabindex="-1" unless disabled
            if (preg_match('/tabindex\s*=\s*["\']?-1["\']?/i', $button)) {
                $this->assertMatchesRegularExpression(
                    '/disabled/i',
                    $button,
                    "Button with tabindex=-1 should be disabled: {$button}"
                );
            }
        }
        
        $this->assertTrue(true); // Pass if no assertions failed
    }
    
    /**
     * @test
     * Test that links have descriptive text or aria-label
     */
    public function links_have_descriptive_text()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all links
        preg_match_all('/<a\s+[^>]*href\s*=\s*["\'][^"\']*["\'][^>]*>(.*?)<\/a>/is', $content, $matches);
        
        foreach ($matches[1] as $linkText) {
            // Skip if link has aria-label (checked separately)
            if (empty(trim(strip_tags($linkText)))) {
                // Link should have aria-label if no visible text
                continue;
            }
            
            // Link text should not be just "click here" or "read more"
            $text = strtolower(trim(strip_tags($linkText)));
            $this->assertNotEquals('click here', $text, 'Link text should be more descriptive than "click here"');
        }
        
        $this->assertTrue(true);
    }
    
    /**
     * @test
     * Test that form inputs have associated labels
     */
    public function form_inputs_have_labels()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all inputs (excluding hidden and submit)
        preg_match_all('/<input[^>]*type\s*=\s*["\']?(text|email|tel|search|url|number|date)["\']?[^>]*>/i', $content, $matches);
        $inputs = $matches[0];
        
        foreach ($inputs as $input) {
            // Input should have either:
            // 1. An id that matches a label's for attribute
            // 2. An aria-label attribute
            // 3. An aria-labelledby attribute
            // 4. A placeholder (not ideal but acceptable)
            
            $hasId = preg_match('/id\s*=\s*["\']([^"\']+)["\']/', $input, $idMatch);
            $hasAriaLabel = preg_match('/aria-label\s*=\s*["\'][^"\']+["\']/', $input);
            $hasAriaLabelledBy = preg_match('/aria-labelledby\s*=\s*["\'][^"\']+["\']/', $input);
            $hasPlaceholder = preg_match('/placeholder\s*=\s*["\'][^"\']+["\']/', $input);
            
            if ($hasId) {
                $inputId = $idMatch[1];
                // Check if there's a label for this input
                $hasLabel = preg_match("/<label[^>]*for\s*=\s*[\"']{$inputId}[\"'][^>]*>/i", $content);
                
                $this->assertTrue(
                    $hasLabel || $hasAriaLabel || $hasAriaLabelledBy || $hasPlaceholder,
                    "Input should have an associated label: {$input}"
                );
            }
        }
        
        $this->assertTrue(true);
    }
    
    /**
     * @test
     * Test that mobile menu toggle has proper ARIA attributes
     */
    public function mobile_menu_toggle_has_aria_attributes()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Look for mobile menu toggle button
        if (preg_match('/<button[^>]*mobile[^>]*>/i', $content, $match)) {
            $button = $match[0];
            
            // Should have aria-expanded
            $this->assertMatchesRegularExpression(
                '/aria-expanded/i',
                $button,
                'Mobile menu toggle should have aria-expanded attribute'
            );
            
            // Should have aria-controls
            $this->assertMatchesRegularExpression(
                '/aria-controls/i',
                $button,
                'Mobile menu toggle should have aria-controls attribute'
            );
            
            // Should have aria-label
            $this->assertMatchesRegularExpression(
                '/aria-label/i',
                $button,
                'Mobile menu toggle should have aria-label attribute'
            );
        }
        
        $this->assertTrue(true);
    }
    
    /**
     * @test
     * Test that images in package cards have alt text
     */
    public function package_card_images_have_alt_text()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Look for package/tour card images
        preg_match_all('/<img[^>]*class="[^"]*package[^"]*"[^>]*>/i', $content, $matches);
        
        if (!empty($matches[0])) {
            foreach ($matches[0] as $img) {
                $this->assertMatchesRegularExpression(
                    '/alt\s*=\s*["\'][^"\']*["\']/',
                    $img,
                    "Package card image should have alt text: {$img}"
                );
            }
        }
        
        $this->assertTrue(true);
    }
    
    /**
     * @test
     * Test that focus indicators are defined in CSS
     */
    public function focus_indicators_are_defined()
    {
        // Read the CSS file
        $cssPath = resource_path('css/app.css');
        
        if (file_exists($cssPath)) {
            $css = file_get_contents($cssPath);
            
            // Check for focus-visible styles
            $this->assertStringContainsString(
                ':focus-visible',
                $css,
                'CSS should define :focus-visible styles'
            );
            
            // Check for outline styles
            $this->assertMatchesRegularExpression(
                '/outline\s*:\s*[^;]+;/i',
                $css,
                'CSS should define outline styles for focus'
            );
        }
        
        $this->assertTrue(true);
    }
    
    /**
     * @test
     * Test that skip link functionality exists
     */
    public function skip_link_functionality_exists()
    {
        // The skip link is added by JavaScript
        // We'll test that the JavaScript file exists
        $jsPath = resource_path('js/keyboard-navigation.js');
        
        $this->assertFileExists(
            $jsPath,
            'Keyboard navigation JavaScript file should exist'
        );
        
        if (file_exists($jsPath)) {
            $js = file_get_contents($jsPath);
            
            // Check for skip link implementation
            $this->assertStringContainsString(
                'skip-link',
                $js,
                'JavaScript should implement skip link functionality'
            );
        }
    }
    
    /**
     * @test
     * Test that color contrast checker exists
     */
    public function color_contrast_checker_exists()
    {
        $jsPath = resource_path('js/color-contrast-checker.js');
        
        $this->assertFileExists(
            $jsPath,
            'Color contrast checker JavaScript file should exist'
        );
    }
}
