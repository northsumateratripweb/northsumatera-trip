<?php

namespace Tests\Feature\Accessibility;

use Tests\TestCase;

/**
 * Property 28: Text meets WCAG contrast requirements
 * **Validates: Requirements 10.3**
 * 
 * Feature: travel-website-redesign, Property 28: Text meets WCAG contrast requirements
 */
class ColorContrastPropertyTest extends TestCase
{
    /**
     * WCAG AA contrast ratios
     */
    const WCAG_AA_NORMAL = 4.5;
    const WCAG_AA_LARGE = 3.0;
    
    /**
     * Calculate relative luminance of a color
     */
    private function getLuminance($hex)
    {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        $r = hexdec(substr($hex, 0, 2)) / 255;
        $g = hexdec(substr($hex, 2, 2)) / 255;
        $b = hexdec(substr($hex, 4, 2)) / 255;
        
        $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);
        
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }
    
    /**
     * Calculate contrast ratio between two colors
     */
    private function getContrastRatio($color1, $color2)
    {
        $lum1 = $this->getLuminance($color1);
        $lum2 = $this->getLuminance($color2);
        
        $lighter = max($lum1, $lum2);
        $darker = min($lum1, $lum2);
        
        return ($lighter + 0.05) / ($darker + 0.05);
    }
    
    /**
     * @test
     * Property: Primary blue on white must meet WCAG AA standards
     */
    public function primary_blue_on_white_meets_wcag_aa()
    {
        $primaryBlue = '#2563eb';
        $white = '#ffffff';
        
        $ratio = $this->getContrastRatio($primaryBlue, $white);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "Primary blue on white contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: Gray 900 on white must meet WCAG AA standards
     */
    public function gray_900_on_white_meets_wcag_aa()
    {
        $gray900 = '#0f172a';
        $white = '#ffffff';
        
        $ratio = $this->getContrastRatio($gray900, $white);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "Gray 900 on white contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: Gray 700 on white must meet WCAG AA standards
     */
    public function gray_700_on_white_meets_wcag_aa()
    {
        $gray700 = '#334155';
        $white = '#ffffff';
        
        $ratio = $this->getContrastRatio($gray700, $white);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "Gray 700 on white contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: Gray 600 on white must meet WCAG AA standards
     */
    public function gray_600_on_white_meets_wcag_aa()
    {
        $gray600 = '#475569';
        $white = '#ffffff';
        
        $ratio = $this->getContrastRatio($gray600, $white);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "Gray 600 on white contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: White on primary blue must meet WCAG AA standards
     */
    public function white_on_primary_blue_meets_wcag_aa()
    {
        $white = '#ffffff';
        $primaryBlue = '#2563eb';
        
        $ratio = $this->getContrastRatio($white, $primaryBlue);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "White on primary blue contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: White on gray 900 must meet WCAG AA standards
     */
    public function white_on_gray_900_meets_wcag_aa()
    {
        $white = '#ffffff';
        $gray900 = '#0f172a';
        
        $ratio = $this->getContrastRatio($white, $gray900);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "White on gray 900 contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: Gray 900 on light gray 50 must meet WCAG AA standards
     */
    public function gray_900_on_light_gray_50_meets_wcag_aa()
    {
        $gray900 = '#0f172a';
        $lightGray50 = '#f8fafc';
        
        $ratio = $this->getContrastRatio($gray900, $lightGray50);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "Gray 900 on light gray 50 contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: Gray 700 on light gray 100 must meet WCAG AA standards
     */
    public function gray_700_on_light_gray_100_meets_wcag_aa()
    {
        $gray700 = '#334155';
        $lightGray100 = '#f1f5f9';
        
        $ratio = $this->getContrastRatio($gray700, $lightGray100);
        
        $this->assertGreaterThanOrEqual(
            self::WCAG_AA_NORMAL,
            $ratio,
            "Gray 700 on light gray 100 contrast ratio ({$ratio}) does not meet WCAG AA standard (" . self::WCAG_AA_NORMAL . ")"
        );
    }
    
    /**
     * @test
     * Property: All design token color combinations meet WCAG AA
     */
    public function all_design_token_combinations_meet_wcag_aa()
    {
        $colorCombinations = [
            ['name' => 'Primary Blue on White', 'fg' => '#2563eb', 'bg' => '#ffffff'],
            ['name' => 'Gray 900 on White', 'fg' => '#0f172a', 'bg' => '#ffffff'],
            ['name' => 'Gray 700 on White', 'fg' => '#334155', 'bg' => '#ffffff'],
            ['name' => 'Gray 600 on White', 'fg' => '#475569', 'bg' => '#ffffff'],
            ['name' => 'White on Primary Blue', 'fg' => '#ffffff', 'bg' => '#2563eb'],
            ['name' => 'White on Gray 900', 'fg' => '#ffffff', 'bg' => '#0f172a'],
            ['name' => 'Gray 900 on Light Gray 50', 'fg' => '#0f172a', 'bg' => '#f8fafc'],
            ['name' => 'Gray 700 on Light Gray 100', 'fg' => '#334155', 'bg' => '#f1f5f9'],
        ];
        
        $failures = [];
        
        foreach ($colorCombinations as $combo) {
            $ratio = $this->getContrastRatio($combo['fg'], $combo['bg']);
            
            if ($ratio < self::WCAG_AA_NORMAL) {
                $failures[] = "{$combo['name']}: {$ratio} (required: " . self::WCAG_AA_NORMAL . ")";
            }
        }
        
        $this->assertEmpty(
            $failures,
            "The following color combinations do not meet WCAG AA standards:\n" . implode("\n", $failures)
        );
    }
    
    /**
     * @test
     * Property: Focus indicator has sufficient contrast
     */
    public function focus_indicator_has_sufficient_contrast()
    {
        // Focus indicator is primary blue (#2563eb) on white
        $primaryBlue = '#2563eb';
        $white = '#ffffff';
        
        $ratio = $this->getContrastRatio($primaryBlue, $white);
        
        // Focus indicators need at least 3:1 contrast ratio (WCAG 2.1 Level AA)
        $this->assertGreaterThanOrEqual(
            3.0,
            $ratio,
            "Focus indicator contrast ratio ({$ratio}) does not meet WCAG 2.1 AA standard (3:1)"
        );
    }
}
