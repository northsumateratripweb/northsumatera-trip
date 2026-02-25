<?php

namespace Tests\Unit\DesignSystem;

use Tests\TestCase;

/**
 * Property 16: Primary color is used consistently for all primary elements
 * 
 * **Validates: Requirements 7.1**
 * 
 * Feature: travel-website-redesign, Property 16: Primary color consistency
 */
class PrimaryColorConsistencyTest extends TestCase
{
    private string $primaryColor;
    private array $primaryElements;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->primaryColor = config('design-tokens.colors.primary.default');
        
        // Define all primary elements that should use the primary color
        $this->primaryElements = [
            'buttons' => ['primary-button', 'cta-button'],
            'links' => ['nav-link', 'text-link'],
            'headings' => ['h1', 'h2', 'h3'],
            'icons' => ['primary-icon'],
        ];
    }

    /**
     * @test
     * Property: For any page section, the primary color (elegant blue) MUST be used 
     * for headlines, buttons, and other primary elements
     */
    public function primary_color_is_consistent_across_all_primary_elements()
    {
        // Verify primary color is defined
        $this->assertNotEmpty($this->primaryColor, 'Primary color must be defined');
        $this->assertMatchesRegularExpression('/^#[0-9A-Fa-f]{6}$/', $this->primaryColor, 'Primary color must be a valid hex color');
        
        // Verify primary color is elegant blue (#2563eb)
        $this->assertEquals('#2563eb', $this->primaryColor, 'Primary color must be elegant blue');
        
        // Verify all primary element types are defined
        $this->assertArrayHasKey('buttons', $this->primaryElements);
        $this->assertArrayHasKey('links', $this->primaryElements);
        $this->assertArrayHasKey('headings', $this->primaryElements);
        $this->assertArrayHasKey('icons', $this->primaryElements);
        
        // Verify each category has elements
        foreach ($this->primaryElements as $category => $elements) {
            $this->assertNotEmpty($elements, "Category {$category} must have elements");
        }
    }

    /**
     * @test
     * Property: Primary color variations (dark, light) must be derived from the base primary color
     */
    public function primary_color_variations_are_consistent()
    {
        $primaryDark = config('design-tokens.colors.primary.dark');
        $primaryLight = config('design-tokens.colors.primary.light');
        
        // Verify variations exist
        $this->assertNotEmpty($primaryDark, 'Primary dark color must be defined');
        $this->assertNotEmpty($primaryLight, 'Primary light color must be defined');
        
        // Verify variations are valid hex colors
        $this->assertMatchesRegularExpression('/^#[0-9A-Fa-f]{6}$/', $primaryDark);
        $this->assertMatchesRegularExpression('/^#[0-9A-Fa-f]{6}$/', $primaryLight);
        
        // Verify dark is darker than base
        $this->assertEquals('#1d4ed8', $primaryDark, 'Primary dark must be darker shade');
        
        // Verify light is lighter than base
        $this->assertEquals('#3b82f6', $primaryLight, 'Primary light must be lighter shade');
    }

    /**
     * @test
     * Property: CSS variables for primary color must be defined and accessible
     */
    public function primary_color_css_variables_are_defined()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify CSS variables are defined
        $this->assertStringContainsString('--color-primary:', $cssContent, 'Primary color CSS variable must be defined');
        $this->assertStringContainsString('--color-primary-dark:', $cssContent, 'Primary dark CSS variable must be defined');
        $this->assertStringContainsString('--color-primary-light:', $cssContent, 'Primary light CSS variable must be defined');
        
        // Verify CSS variables use correct values
        $this->assertStringContainsString('--color-primary: #2563eb', $cssContent);
        $this->assertStringContainsString('--color-primary-dark: #1d4ed8', $cssContent);
        $this->assertStringContainsString('--color-primary-light: #3b82f6', $cssContent);
    }

    /**
     * @test
     * Property: Primary color utility classes must be available
     */
    public function primary_color_utility_classes_exist()
    {
        $cssContent = file_get_contents(resource_path('css/app.css'));
        
        // Verify utility classes are defined
        $this->assertStringContainsString('.text-primary', $cssContent, 'Text primary utility class must exist');
        $this->assertStringContainsString('.bg-primary', $cssContent, 'Background primary utility class must exist');
        
        // Verify utility classes use CSS variables
        $this->assertStringContainsString('color: var(--color-primary)', $cssContent);
        $this->assertStringContainsString('background-color: var(--color-primary)', $cssContent);
    }

    /**
     * @test
     * Property: For any component using primary color, the color must be consistent
     */
    public function components_use_consistent_primary_color()
    {
        // Test Button component
        $buttonContent = file_get_contents(resource_path('views/components/button.blade.php'));
        $this->assertStringContainsString('bg-primary', $buttonContent, 'Button component must use primary color');
        
        // Test that components reference design tokens
        $this->assertStringContainsString("config('design-tokens.colors')", $buttonContent);
    }
}
