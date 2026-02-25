<?php

namespace Tests\Unit\DesignSystem;

use Tests\TestCase;

/**
 * Property 18: Typography hierarchy is maintained throughout
 * 
 * **Validates: Requirements 7.3, 7.4, 7.5**
 * 
 * Feature: travel-website-redesign, Property 18: Typography hierarchy
 */
class TypographyHierarchyTest extends TestCase
{
    private array $typography;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->typography = config('design-tokens.typography');
    }

    /**
     * @test
     * Property: For any text element, headlines MUST use bold font weight 
     * and body text MUST use light font weight
     */
    public function typography_hierarchy_is_maintained_throughout()
    {
        // Verify typography configuration exists
        $this->assertNotEmpty($this->typography, 'Typography configuration must be defined');
        
        // Verify font weights are defined
        $this->assertArrayHasKey('font-weight', $this->typography);
        $this->assertArrayHasKey('headline', $this->typography['font-weight']);
        $this->assertArrayHasKey('body', $this->typography['font-weight']);
        
        // Verify headline uses bold weight (700)
        $this->assertEquals(700, $this->typography['font-weight']['headline'], 
            'Headlines must use bold font weight (700)');
        
        // Verify body uses light weight (300)
        $this->assertEquals(300, $this->typography['font-weight']['body'], 
            'Body text must use light font weight (300)');
    }

    /**
     * @test
     * Property: Font family must be modern sans-serif
     */
    public function font_family_is_modern_sans_serif()
    {
        $this->assertArrayHasKey('font-family', $this->typography);
        $this->assertArrayHasKey('sans', $this->typography['font-family']);
        
        $fontFamily = $this->typography['font-family']['sans'];
        
        // Verify font family is defined
        $this->assertNotEmpty($fontFamily, 'Font family must be defined');
        
        // Verify it includes Figtree (modern sans-serif)
        $this->assertStringContainsString('Figtree', $fontFamily, 
            'Font family must include Figtree');
        
        // Verify it has fallbacks
        $this->assertStringContainsString('sans-serif', $fontFamily, 
            'Font family must have sans-serif fallback');
    }

    /**
     * @test
     * Property: Font size scale must be proportional and comprehensive
     */
    public function font_size_scale_is_proportional()
    {
        $this->assertArrayHasKey('font-size', $this->typography);
        
        $sizes = $this->typography['font-size'];
        
        // Verify all required sizes exist
        $requiredSizes = ['xs', 'sm', 'base', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl'];
        foreach ($requiredSizes as $size) {
            $this->assertArrayHasKey($size, $sizes, "Font size '{$size}' must be defined");
        }
        
        // Verify base size is 1rem
        $this->assertEquals('1rem', $sizes['base'], 'Base font size must be 1rem');
        
        // Verify sizes are in rem units
        foreach ($sizes as $key => $value) {
            $this->assertStringContainsString('rem', $value, 
                "Font size '{$key}' must use rem units");
        }
    }

    /**
     * @test
     * Property: Line height must be defined for readability
     */
    public function line_height_is_defined_for_readability()
    {
        $this->assertArrayHasKey('line-height', $this->typography);
        
        $lineHeights = $this->typography['line-height'];
        
        // Verify required line heights exist
        $this->assertArrayHasKey('tight', $lineHeights);
        $this->assertArrayHasKey('normal', $lineHeights);
        $this->assertArrayHasKey('relaxed', $lineHeights);
        
        // Verify line heights are numeric strings
        $this->assertIsString($lineHeights['tight']);
        $this->assertIsString($lineHeights['normal']);
        $this->assertIsString($lineHeights['relaxed']);
        
        // Verify normal line height is 1.5 for readability
        $this->assertEquals('1.5', $lineHeights['normal'], 
            'Normal line height should be 1.5 for optimal readability');
    }

    /**
     * @test
     * Property: CSS variables for typography must be defined
     */
    public function typography_css_variables_are_defined()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify font family CSS variable
        $this->assertStringContainsString('--font-family-sans:', $cssContent, 
            'Font family CSS variable must be defined');
        
        // Verify font weight CSS variables
        $this->assertStringContainsString('--font-weight-headline:', $cssContent, 
            'Headline font weight CSS variable must be defined');
        $this->assertStringContainsString('--font-weight-body:', $cssContent, 
            'Body font weight CSS variable must be defined');
        
        // Verify correct values
        $this->assertStringContainsString('--font-weight-headline: 700', $cssContent);
        $this->assertStringContainsString('--font-weight-body: 300', $cssContent);
    }

    /**
     * @test
     * Property: Typography utility classes must exist
     */
    public function typography_utility_classes_exist()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify headline utility class
        $this->assertStringContainsString('.headline', $cssContent, 
            'Headline utility class must exist');
        
        // Verify body text utility class
        $this->assertStringContainsString('.body-text', $cssContent, 
            'Body text utility class must exist');
        
        // Verify headline class uses bold weight
        $this->assertMatchesRegularExpression(
            '/\.headline\s*{[^}]*font-weight:\s*var\(--font-weight-headline\)/s',
            $cssContent,
            'Headline class must use headline font weight'
        );
        
        // Verify body class uses light weight
        $this->assertMatchesRegularExpression(
            '/\.body-text\s*{[^}]*font-weight:\s*var\(--font-weight-body\)/s',
            $cssContent,
            'Body text class must use body font weight'
        );
    }

    /**
     * @test
     * Property: Semibold weight must be available for intermediate hierarchy
     */
    public function semibold_weight_is_available()
    {
        $this->assertArrayHasKey('semibold', $this->typography['font-weight']);
        
        $semibold = $this->typography['font-weight']['semibold'];
        
        // Verify semibold is 600
        $this->assertEquals(600, $semibold, 
            'Semibold weight must be 600 for intermediate hierarchy');
        
        // Verify CSS variable exists
        $cssContent = file_get_contents(resource_path('css/app.css'));
        $this->assertStringContainsString('--font-weight-semibold:', $cssContent);
        $this->assertStringContainsString('--font-weight-semibold: 600', $cssContent);
    }
}
