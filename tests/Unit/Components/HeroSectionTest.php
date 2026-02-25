<?php

namespace Tests\Unit\Components;

use Tests\TestCase;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

/**
 * Unit tests for HeroSection Blade component
 * 
 * Tests the component in isolation without full HTTP requests.
 * Focuses on component rendering logic, edge cases, and responsive behavior.
 * 
 * Requirements: 1.2, 1.3, 1.4
 */
class HeroSectionTest extends TestCase
{
    /**
     * Test that headline is rendered correctly
     * 
     * @test
     */
    public function headline_is_rendered_correctly(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Test Headline', $rendered);
        $this->assertStringContainsString('<h1', $rendered);
        $this->assertStringContainsString('font-bold', $rendered);
        $this->assertStringContainsString('text-white', $rendered);
    }

    /**
     * Test that subheadline is rendered correctly
     * 
     * @test
     */
    public function subheadline_is_rendered_correctly(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
            'subheadline' => 'Test Subheadline',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Test Subheadline', $rendered);
        $this->assertStringContainsString('<p', $rendered);
        $this->assertStringContainsString('text-white/90', $rendered);
    }

    /**
     * Test that both headline and subheadline are rendered together
     * 
     * @test
     */
    public function headline_and_subheadline_render_together(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Main Headline',
            'subheadline' => 'Supporting Text',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Main Headline', $rendered);
        $this->assertStringContainsString('Supporting Text', $rendered);
        $this->assertStringContainsString('space-y-6', $rendered);
    }

    /**
     * Test that component handles missing headline gracefully
     * 
     * @test
     */
    public function component_handles_missing_headline_gracefully(): void
    {
        $view = View::make('components.hero.hero-section', [
            'subheadline' => 'Test Subheadline',
        ]);

        $rendered = $view->render();
        
        // Should not contain h1 tag since headline is missing
        $this->assertStringNotContainsString('<h1', $rendered);
        // Subheadline should still be rendered
        $this->assertStringContainsString('Test Subheadline', $rendered);
    }

    /**
     * Test that component handles missing subheadline gracefully
     * 
     * @test
     */
    public function component_handles_missing_subheadline_gracefully(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
        ]);

        $rendered = $view->render();
        
        // Headline should still be rendered
        $this->assertStringContainsString('Test Headline', $rendered);
        // Should not contain subheadline text
        $this->assertStringNotContainsString('Test Subheadline', $rendered);
    }

    /**
     * Test that component handles missing both headline and subheadline gracefully
     * 
     * @test
     */
    public function component_handles_missing_both_headline_and_subheadline_gracefully(): void
    {
        $view = View::make('components.hero.hero-section');

        $rendered = $view->render();
        
        // Neither headline nor subheadline should be rendered
        $this->assertStringNotContainsString('<h1', $rendered);
        $this->assertStringNotContainsString('<p', $rendered);
        // But the component structure should still be valid
        $this->assertStringContainsString('min-h-screen', $rendered);
    }

    /**
     * Test that responsive classes are applied correctly
     * 
     * @test
     */
    public function responsive_classes_are_applied_correctly(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
        ]);

        $rendered = $view->render();
        
        // Check for responsive text sizes
        $this->assertStringContainsString('text-4xl', $rendered);
        $this->assertStringContainsString('sm:text-5xl', $rendered);
        $this->assertStringContainsString('md:text-6xl', $rendered);
        $this->assertStringContainsString('lg:text-7xl', $rendered);
        
        // Check for responsive spacing
        $this->assertStringContainsString('sm:space-y-8', $rendered);
    }

    /**
     * Test that background image is rendered when provided
     * 
     * @test
     */
    public function background_image_is_rendered_when_provided(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
            'backgroundImage' => '/images/hero.jpg',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('hero.jpg', $rendered);
        $this->assertStringContainsString('object-cover', $rendered);
        $this->assertStringContainsString('loading="lazy"', $rendered);
    }

    /**
     * Test that video background is rendered when isVideo is true
     * 
     * @test
     */
    public function video_background_is_rendered_when_isVideo_is_true(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
            'backgroundImage' => '/videos/hero.mp4',
            'isVideo' => true,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('<video', $rendered);
        $this->assertStringContainsString('autoplay', $rendered);
        $this->assertStringContainsString('muted', $rendered);
        $this->assertStringContainsString('loop', $rendered);
    }

    /**
     * Test that overlay is applied for readability
     * 
     * @test
     */
    public function overlay_is_applied_for_readability(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('bg-black/30', $rendered);
        $this->assertStringContainsString('absolute inset-0', $rendered);
    }

    /**
     * Test that component uses correct typography from config
     * 
     * @test
     */
    public function component_uses_correct_typography_from_config(): void
    {
        $typography = Config::get('design-tokens.typography');
        
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
        ]);

        $rendered = $view->render();
        
        // Check that the font family from config is used
        $this->assertStringContainsString($typography['font-family']['sans'], $rendered);
        $this->assertStringContainsString('font-weight: 700', $rendered);
    }

    /**
     * Test that component has proper accessibility attributes
     * 
     * @test
     */
    public function component_has_proper_accessibility_attributes(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
            'backgroundImage' => '/images/hero.jpg',
        ]);

        $rendered = $view->render();
        
        // Check for alt text on image
        $this->assertStringContainsString('alt="Test Headline"', $rendered);
        $this->assertStringContainsString('loading="lazy"', $rendered);
    }

    /**
     * Test that component renders with empty headline string
     * 
     * @test
     */
    public function component_handles_empty_headline_string(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => '',
            'subheadline' => 'Test Subheadline',
        ]);

        $rendered = $view->render();
        
        // Empty headline should not render h1
        $this->assertStringNotContainsString('<h1', $rendered);
        $this->assertStringContainsString('Test Subheadline', $rendered);
    }

    /**
     * Test that component renders with empty subheadline string
     * 
     * @test
     */
    public function component_handles_empty_subheadline_string(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
            'subheadline' => '',
        ]);

        $rendered = $view->render();
        
        // Headline should still render
        $this->assertStringContainsString('Test Headline', $rendered);
        // Empty subheadline should not render p tag
        $this->assertStringNotContainsString('<p', $rendered);
    }

    /**
     * Test that component has proper z-index layering
     * 
     * @test
     */
    public function component_has_proper_z_index_layering(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
        ]);

        $rendered = $view->render();
        
        // Check for z-index layering
        $this->assertStringContainsString('z-10', $rendered);
        $this->assertStringContainsString('relative', $rendered);
    }

    /**
     * Test that component renders with CTA buttons slot content
     * 
     * @test
     */
    public function component_renders_with_cta_buttons_slot(): void
    {
        $view = View::make('components.hero.hero-section', [
            'headline' => 'Test Headline',
            'subheadline' => 'Test Subheadline',
        ]);

        // Add slot content using withSlot method
        $view->withSlot('<a href="/book" class="btn">Book Tour</a><a href="/whatsapp" class="btn">WhatsApp</a>');

        $rendered = $view->render();
        
        $this->assertStringContainsString('Book Tour', $rendered);
        $this->assertStringContainsString('WhatsApp', $rendered);
        $this->assertStringContainsString('flex-col sm:flex-row', $rendered);
    }
}
