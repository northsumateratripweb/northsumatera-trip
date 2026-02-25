<?php

namespace Tests\Feature\Accessibility;

use Tests\TestCase;

/**
 * Property 30: DOM order matches visual order
 * **Validates: Requirements 10.5**
 * 
 * Feature: travel-website-redesign, Property 30: DOM order matches visual order
 */
class DOMOrderPropertyTest extends TestCase
{
    /**
     * @test
     * Property: For any page layout, the DOM element order MUST match the visual reading order
     */
    public function dom_order_matches_visual_reading_order()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Define expected section order
        $expectedOrder = [
            'navigation',  // Navigation should come first
            'hero',        // Hero section
            'trust',       // Trust section
            'tours',       // Tour packages section
            'rental',      // Rental section (if present)
        ];
        
        // Find positions of each section in the DOM
        $positions = [];
        
        foreach ($expectedOrder as $section) {
            // Look for section identifiers (id, class, or data attributes)
            $patterns = [
                "/<[^>]*id\s*=\s*[\"']{$section}[\"'][^>]*>/i",
                "/<section[^>]*class\s*=\s*[\"'][^\"']*{$section}[^\"']*[\"'][^>]*>/i",
                "/<[^>]*data-section\s*=\s*[\"']{$section}[\"'][^>]*>/i",
            ];
            
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $content, $match, PREG_OFFSET_CAPTURE)) {
                    $positions[$section] = $match[0][1];
                    break;
                }
            }
        }
        
        // Verify sections appear in the correct order
        $previousPosition = -1;
        $previousSection = null;
        
        foreach ($expectedOrder as $section) {
            if (isset($positions[$section])) {
                $this->assertGreaterThan(
                    $previousPosition,
                    $positions[$section],
                    "Section '{$section}' appears before '{$previousSection}' in DOM, but should come after"
                );
                
                $previousPosition = $positions[$section];
                $previousSection = $section;
            }
        }
    }
    
    /**
     * @test
     * Property: Navigation appears before main content
     */
    public function navigation_appears_before_main_content()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Find navigation position
        preg_match('/<nav[^>]*>/i', $content, $navMatch, PREG_OFFSET_CAPTURE);
        $navPosition = $navMatch[0][1] ?? null;
        
        // Find main content position
        preg_match('/<main[^>]*>|<section[^>]*>/i', $content, $mainMatch, PREG_OFFSET_CAPTURE);
        $mainPosition = $mainMatch[0][1] ?? null;
        
        if ($navPosition !== null && $mainPosition !== null) {
            $this->assertLessThan(
                $mainPosition,
                $navPosition,
                'Navigation should appear before main content in DOM'
            );
        }
    }
    
    /**
     * @test
     * Property: Hero section appears before trust section
     */
    public function hero_section_appears_before_trust_section()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Find hero section
        $heroPatterns = [
            '/<[^>]*class\s*=\s*["\'][^"\']*hero[^"\']*["\'][^>]*>/i',
            '/<section[^>]*id\s*=\s*["\']hero["\'][^>]*>/i',
        ];
        
        $heroPosition = null;
        foreach ($heroPatterns as $pattern) {
            if (preg_match($pattern, $content, $match, PREG_OFFSET_CAPTURE)) {
                $heroPosition = $match[0][1];
                break;
            }
        }
        
        // Find trust section
        $trustPatterns = [
            '/<x-trust\.trust-section/i',
            '/<[^>]*class\s*=\s*["\'][^"\']*trust[^"\']*["\'][^>]*>/i',
        ];
        
        $trustPosition = null;
        foreach ($trustPatterns as $pattern) {
            if (preg_match($pattern, $content, $match, PREG_OFFSET_CAPTURE)) {
                $trustPosition = $match[0][1];
                break;
            }
        }
        
        if ($heroPosition !== null && $trustPosition !== null) {
            $this->assertLessThan(
                $trustPosition,
                $heroPosition,
                'Hero section should appear before trust section in DOM'
            );
        }
    }
    
    /**
     * @test
     * Property: Trust section appears before tour packages section
     */
    public function trust_section_appears_before_tour_packages()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Find trust section
        preg_match('/<x-trust\.trust-section/i', $content, $trustMatch, PREG_OFFSET_CAPTURE);
        $trustPosition = $trustMatch[0][1] ?? null;
        
        // Find tours section
        preg_match('/<section[^>]*id\s*=\s*["\']tours["\'][^>]*>/i', $content, $toursMatch, PREG_OFFSET_CAPTURE);
        $toursPosition = $toursMatch[0][1] ?? null;
        
        if ($trustPosition !== null && $toursPosition !== null) {
            $this->assertLessThan(
                $toursPosition,
                $trustPosition,
                'Trust section should appear before tour packages section in DOM'
            );
        }
    }
    
    /**
     * @test
     * Property: Headings follow hierarchical order
     */
    public function headings_follow_hierarchical_order()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Extract all heading tags with their positions
        preg_match_all('/<h([1-6])[^>]*>/i', $content, $matches, PREG_OFFSET_CAPTURE);
        
        $headings = [];
        foreach ($matches[1] as $index => $match) {
            $headings[] = [
                'level' => (int)$match[0],
                'position' => $match[1],
            ];
        }
        
        // Sort by position
        usort($headings, function($a, $b) {
            return $a['position'] - $b['position'];
        });
        
        // Verify heading hierarchy
        $previousLevel = 0;
        foreach ($headings as $heading) {
            // Headings should not skip levels (e.g., h1 -> h3)
            if ($previousLevel > 0) {
                $levelDiff = $heading['level'] - $previousLevel;
                $this->assertLessThanOrEqual(
                    1,
                    $levelDiff,
                    "Heading hierarchy skips levels: h{$previousLevel} followed by h{$heading['level']}"
                );
            }
            
            $previousLevel = $heading['level'];
        }
    }
    
    /**
     * @test
     * Property: Form labels appear before their inputs
     */
    public function form_labels_appear_before_inputs()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Find all label-input pairs
        preg_match_all('/<label[^>]*for\s*=\s*["\']([^"\']+)["\'][^>]*>.*?<\/label>/is', $content, $labelMatches, PREG_OFFSET_CAPTURE);
        
        foreach ($labelMatches[1] as $index => $match) {
            $inputId = $match[0];
            $labelPosition = $labelMatches[0][$index][1];
            
            // Find corresponding input
            if (preg_match("/<input[^>]*id\s*=\s*[\"']{$inputId}[\"'][^>]*>/i", $content, $inputMatch, PREG_OFFSET_CAPTURE)) {
                $inputPosition = $inputMatch[0][1];
                
                // Label should appear before input in most cases
                // (unless it's a checkbox/radio with label after)
                $isCheckboxOrRadio = preg_match('/type\s*=\s*["\']?(checkbox|radio)["\']?/i', $inputMatch[0][0]);
                
                if (!$isCheckboxOrRadio) {
                    $this->assertLessThan(
                        $inputPosition,
                        $labelPosition,
                        "Label for input '{$inputId}' should appear before the input in DOM"
                    );
                }
            }
        }
    }
    
    /**
     * @test
     * Property: ARIA landmarks are in logical order
     */
    public function aria_landmarks_are_in_logical_order()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        
        $content = $response->getContent();
        
        // Expected landmark order
        $expectedLandmarks = [
            'navigation',
            'main',
            'contentinfo', // footer
        ];
        
        $landmarkPositions = [];
        
        foreach ($expectedLandmarks as $landmark) {
            // Look for role attribute or semantic HTML5 elements
            $patterns = [
                "/<[^>]*role\s*=\s*[\"']{$landmark}[\"'][^>]*>/i",
                "/<{$landmark}[^>]*>/i",
            ];
            
            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $content, $match, PREG_OFFSET_CAPTURE)) {
                    $landmarkPositions[$landmark] = $match[0][1];
                    break;
                }
            }
        }
        
        // Verify landmarks appear in order
        $previousPosition = -1;
        foreach ($expectedLandmarks as $landmark) {
            if (isset($landmarkPositions[$landmark])) {
                $this->assertGreaterThan(
                    $previousPosition,
                    $landmarkPositions[$landmark],
                    "Landmark '{$landmark}' appears out of order in DOM"
                );
                $previousPosition = $landmarkPositions[$landmark];
            }
        }
    }
}
