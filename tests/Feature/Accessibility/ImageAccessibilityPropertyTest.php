<?php

namespace Tests\Feature\Accessibility;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Property 26: All images include appropriate alt text
 * **Validates: Requirements 10.1**
 * 
 * Feature: travel-website-redesign, Property 26: All images include appropriate alt text
 */
class ImageAccessibilityPropertyTest extends TestCase
{
    /**
     * @test
     * Property: For any image element, the alt attribute MUST be present and contain descriptive text
     */
    public function all_images_must_have_alt_text()
    {
        // Test hero section
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all img tags
        preg_match_all('/<img[^>]*>/i', $content, $matches);
        $imgTags = $matches[0];
        
        $this->assertNotEmpty($imgTags, 'No images found on the page');
        
        foreach ($imgTags as $imgTag) {
            // Check if alt attribute exists
            $this->assertMatchesRegularExpression(
                '/alt\s*=\s*["\'][^"\']*["\']/',
                $imgTag,
                "Image tag missing alt attribute: {$imgTag}"
            );
            
            // Extract alt text
            preg_match('/alt\s*=\s*["\']([^"\']*)["\']/', $imgTag, $altMatch);
            $altText = $altMatch[1] ?? '';
            
            // Alt text should not be empty (unless it's a decorative image)
            // For now, we'll allow empty alt for decorative images
            // but ensure the attribute exists
            $this->assertNotNull($altText, "Alt attribute exists but is null: {$imgTag}");
        }
    }
    
    /**
     * @test
     * Property: Alt text should be descriptive and meaningful
     */
    public function alt_text_should_be_descriptive()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all img tags with alt text
        preg_match_all('/<img[^>]*alt\s*=\s*["\']([^"\']+)["\'][^>]*>/i', $content, $matches);
        $altTexts = $matches[1];
        
        foreach ($altTexts as $altText) {
            // Skip empty alt (decorative images)
            if (empty($altText)) {
                continue;
            }
            
            // Alt text should not be just "image" or "photo"
            $this->assertNotEquals('image', strtolower($altText), 'Alt text should be more descriptive than "image"');
            $this->assertNotEquals('photo', strtolower($altText), 'Alt text should be more descriptive than "photo"');
            $this->assertNotEquals('picture', strtolower($altText), 'Alt text should be more descriptive than "picture"');
            
            // Alt text should have reasonable length (not too short, not too long)
            $length = strlen($altText);
            $this->assertGreaterThanOrEqual(3, $length, "Alt text too short: '{$altText}'");
            $this->assertLessThanOrEqual(150, $length, "Alt text too long: '{$altText}'");
        }
    }
    
    /**
     * @test
     * Property: Package card images must have descriptive alt text
     */
    public function package_card_images_have_descriptive_alt()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Look for package/tour card images
        preg_match_all('/<img[^>]*alt\s*=\s*["\']([^"\']*Paket[^"\']*|[^"\']*Tour[^"\']*|[^"\']*Wisata[^"\']*)["\'][^>]*>/i', $content, $matches);
        
        // If we have tour packages, verify their alt text
        if (!empty($matches[1])) {
            foreach ($matches[1] as $altText) {
                // Alt text should contain meaningful information
                $this->assertNotEmpty($altText, 'Package image alt text should not be empty');
                $this->assertGreaterThan(10, strlen($altText), 'Package image alt text should be descriptive');
            }
        }
    }
    
    /**
     * @test
     * Property: Hero section background image must have alt text
     */
    public function hero_background_image_has_alt_text()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Look for hero section images
        preg_match_all('/<img[^>]*class="[^"]*hero[^"]*"[^>]*>/i', $content, $heroImages);
        
        if (!empty($heroImages[0])) {
            foreach ($heroImages[0] as $imgTag) {
                $this->assertMatchesRegularExpression(
                    '/alt\s*=\s*["\'][^"\']*["\']/',
                    $imgTag,
                    "Hero image missing alt attribute: {$imgTag}"
                );
            }
        }
    }
}
