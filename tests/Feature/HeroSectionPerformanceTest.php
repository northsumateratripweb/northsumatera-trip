<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Property 22: Hero section loads within performance threshold
 * **Validates: Requirements 9.1**
 * 
 * Property-based test: For any page load on standard mobile connections,
 * the hero section MUST be fully displayed within 3 seconds
 */
class HeroSectionPerformanceTest extends TestCase
{
    /**
     * Test hero section loads within 3 second threshold
     * 
     * @test
     * Feature: travel-website-redesign, Property 22: Hero section loads within performance threshold
     */
    public function hero_section_loads_within_performance_threshold(): void
    {
        // Property: For ANY page with hero section, load time must be <= 3000ms
        $pagesWithHero = [
            '/',
            '/packages',
        ];
        
        foreach ($pagesWithHero as $page) {
            $startTime = microtime(true);
            
            $response = $this->get($page);
            
            $executionTime = (microtime(true) - $startTime) * 1000; // Convert to milliseconds
            
            $response->assertStatus(200);
            
            // Verify hero section is present in response
            $response->assertSee('hero', false);
            
            // Property assertion: Hero section must load within 3000ms (3 seconds)
            $this->assertLessThan(
                3000,
                $executionTime,
                "Hero section on {$page} took {$executionTime}ms to load, exceeding 3000ms threshold"
            );
        }
    }
    
    /**
     * Test hero section has optimized image loading
     * 
     * @test
     * Feature: travel-website-redesign, Property 22: Hero section loads within performance threshold
     */
    public function hero_section_has_lazy_loading_attributes(): void
    {
        // Property: For ANY hero section, images must have lazy loading
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Verify lazy loading is implemented
        $content = $response->getContent();
        
        // Check for lazy loading attribute
        $this->assertStringContainsString('loading="lazy"', $content, 
            'Hero section images must have loading="lazy" attribute');
        
        // Check for responsive image formats (WebP/AVIF)
        $hasResponsiveImages = 
            str_contains($content, 'type="image/webp"') || 
            str_contains($content, 'type="image/avif"') ||
            str_contains($content, '<picture');
        
        $this->assertTrue($hasResponsiveImages, 
            'Hero section must use responsive image formats (WebP/AVIF) or picture element');
    }
    
    /**
     * Test hero section has placeholder for fast initial render
     * 
     * @test
     * Feature: travel-website-redesign, Property 22: Hero section loads within performance threshold
     */
    public function hero_section_has_loading_placeholder(): void
    {
        // Property: For ANY hero section, a placeholder must be present for fast initial render
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Check for placeholder element
        $hasPlaceholder = 
            str_contains($content, 'animate-pulse') ||
            str_contains($content, 'placeholder') ||
            str_contains($content, 'bg-gradient');
        
        $this->assertTrue($hasPlaceholder, 
            'Hero section must have a loading placeholder for fast initial render');
    }
    
    /**
     * Test hero section HTML size is optimized
     * 
     * @test
     * Feature: travel-website-redesign, Property 22: Hero section loads within performance threshold
     */
    public function hero_section_html_size_is_optimized(): void
    {
        // Property: For ANY page, hero section HTML should be reasonably sized
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        $contentLength = strlen($response->getContent());
        $contentLengthKB = $contentLength / 1024;
        
        // Hero section HTML should not exceed 100KB
        $this->assertLessThan(
            100,
            $contentLengthKB,
            "Hero section HTML size is {$contentLengthKB}KB, should be under 100KB"
        );
    }
    
    /**
     * Test multiple hero section loads maintain consistent performance
     * 
     * @test
     * Feature: travel-website-redesign, Property 22: Hero section loads within performance threshold
     */
    public function hero_section_maintains_consistent_performance(): void
    {
        // Property: For ANY sequence of page loads, performance should be consistent
        $loadTimes = [];
        $iterations = 5;
        
        for ($i = 0; $i < $iterations; $i++) {
            $startTime = microtime(true);
            
            $response = $this->get('/');
            
            $executionTime = (microtime(true) - $startTime) * 1000;
            
            $response->assertStatus(200);
            $loadTimes[] = $executionTime;
        }
        
        // Calculate average and max load time
        $avgLoadTime = array_sum($loadTimes) / count($loadTimes);
        $maxLoadTime = max($loadTimes);
        
        // Average should be under 3000ms
        $this->assertLessThan(
            3000,
            $avgLoadTime,
            "Average hero section load time is {$avgLoadTime}ms, should be under 3000ms"
        );
        
        // Max should not exceed 5000ms (allowing for some variance)
        $this->assertLessThan(
            5000,
            $maxLoadTime,
            "Maximum hero section load time is {$maxLoadTime}ms, should be under 5000ms"
        );
        
        // Variance should be reasonable (max should not be more than 2x average)
        $this->assertLessThan(
            $avgLoadTime * 2,
            $maxLoadTime,
            "Load time variance too high: max {$maxLoadTime}ms vs avg {$avgLoadTime}ms"
        );
    }
}
