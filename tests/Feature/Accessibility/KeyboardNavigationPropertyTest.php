<?php

namespace Tests\Feature\Accessibility;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Property 27: Interactive elements are keyboard navigable
 * **Validates: Requirements 10.2**
 * 
 * Feature: travel-website-redesign, Property 27: Interactive elements are keyboard navigable
 */
class KeyboardNavigationPropertyTest extends TestCase
{
    /**
     * @test
     * Property: For any interactive element, the element MUST be reachable and usable via keyboard navigation
     */
    public function all_interactive_elements_are_keyboard_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all interactive elements (buttons, links, inputs)
        preg_match_all('/<(button|a|input|select|textarea)[^>]*>/i', $content, $matches);
        $interactiveElements = $matches[0];
        
        $this->assertNotEmpty($interactiveElements, 'No interactive elements found on the page');
        
        foreach ($interactiveElements as $element) {
            // Check if element is keyboard accessible
            // Elements should either:
            // 1. Be naturally focusable (button, a with href, input, select, textarea)
            // 2. Have tabindex="0" or positive tabindex
            // 3. NOT have tabindex="-1" (unless it's intentionally not keyboard accessible)
            
            // Skip elements with tabindex="-1" as they're intentionally not keyboard accessible
            if (preg_match('/tabindex\s*=\s*["\']?-1["\']?/i', $element)) {
                continue;
            }
            
            // Check if it's a naturally focusable element or has tabindex
            $isNaturallyFocusable = preg_match('/<(button|input|select|textarea|a\s+[^>]*href)/i', $element);
            $hasTabindex = preg_match('/tabindex\s*=\s*["\']?[0-9]+["\']?/i', $element);
            
            $this->assertTrue(
                $isNaturallyFocusable || $hasTabindex,
                "Interactive element is not keyboard accessible: {$element}"
            );
        }
    }
    
    /**
     * @test
     * Property: All buttons must be keyboard accessible
     */
    public function all_buttons_are_keyboard_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all button elements
        preg_match_all('/<button[^>]*>/i', $content, $matches);
        $buttons = $matches[0];
        
        foreach ($buttons as $button) {
            // Buttons should not have tabindex="-1" unless disabled
            $hasNegativeTabindex = preg_match('/tabindex\s*=\s*["\']?-1["\']?/i', $button);
            $isDisabled = preg_match('/disabled/i', $button);
            
            if ($hasNegativeTabindex) {
                $this->assertTrue(
                    $isDisabled,
                    "Button has tabindex=-1 but is not disabled: {$button}"
                );
            }
        }
    }
    
    /**
     * @test
     * Property: All links must be keyboard accessible
     */
    public function all_links_are_keyboard_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all anchor elements with href
        preg_match_all('/<a\s+[^>]*href\s*=\s*["\'][^"\']*["\'][^>]*>/i', $content, $matches);
        $links = $matches[0];
        
        foreach ($links as $link) {
            // Links with href are naturally keyboard accessible
            // They should not have tabindex="-1" unless intentionally hidden
            $hasNegativeTabindex = preg_match('/tabindex\s*=\s*["\']?-1["\']?/i', $link);
            
            // If a link has tabindex="-1", it should be hidden or aria-hidden
            if ($hasNegativeTabindex) {
                $isHidden = preg_match('/(aria-hidden\s*=\s*["\']?true["\']?|hidden)/i', $link);
                $this->assertTrue(
                    $isHidden,
                    "Link has tabindex=-1 but is not hidden: {$link}"
                );
            }
        }
    }
    
    /**
     * @test
     * Property: Navigation menu must be keyboard accessible
     */
    public function navigation_menu_is_keyboard_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Check for navigation element
        $this->assertMatchesRegularExpression(
            '/<nav[^>]*>/i',
            $content,
            'Navigation element not found'
        );
        
        // Extract navigation menu items
        preg_match('/<nav[^>]*>(.*?)<\/nav>/is', $content, $navMatch);
        
        if (!empty($navMatch[1])) {
            $navContent = $navMatch[1];
            
            // Navigation should contain keyboard-accessible links
            preg_match_all('/<a\s+[^>]*href\s*=\s*["\'][^"\']*["\'][^>]*>/i', $navContent, $navLinks);
            
            $this->assertNotEmpty($navLinks[0], 'Navigation should contain links');
            
            // Check if mobile menu toggle is keyboard accessible
            if (preg_match('/<button[^>]*mobile[^>]*>/i', $navContent, $mobileToggle)) {
                $this->assertMatchesRegularExpression(
                    '/aria-expanded|aria-controls/',
                    $mobileToggle[0],
                    'Mobile menu toggle should have ARIA attributes'
                );
            }
        }
    }
    
    /**
     * @test
     * Property: Form inputs must be keyboard accessible
     */
    public function form_inputs_are_keyboard_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all form inputs
        preg_match_all('/<(input|select|textarea)[^>]*>/i', $content, $matches);
        $formElements = $matches[0];
        
        foreach ($formElements as $element) {
            // Form elements should not have tabindex="-1" unless disabled
            $hasNegativeTabindex = preg_match('/tabindex\s*=\s*["\']?-1["\']?/i', $element);
            $isDisabled = preg_match('/disabled/i', $element);
            
            if ($hasNegativeTabindex) {
                $this->assertTrue(
                    $isDisabled,
                    "Form element has tabindex=-1 but is not disabled: {$element}"
                );
            }
        }
    }
    
    /**
     * @test
     * Property: Interactive elements should have appropriate ARIA roles
     */
    public function interactive_elements_have_appropriate_roles()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Check for elements with onclick but no button role
        preg_match_all('/<[^>]+onclick[^>]*>/i', $content, $matches);
        $clickableElements = $matches[0];
        
        foreach ($clickableElements as $element) {
            // If it's not a button or link, it should have role="button"
            $isButton = preg_match('/<button/i', $element);
            $isLink = preg_match('/<a\s+[^>]*href/i', $element);
            $hasButtonRole = preg_match('/role\s*=\s*["\']?button["\']?/i', $element);
            
            if (!$isButton && !$isLink) {
                $this->assertTrue(
                    $hasButtonRole,
                    "Clickable element should have role='button': {$element}"
                );
            }
        }
    }
}
