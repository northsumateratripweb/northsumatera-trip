<?php

namespace Tests\Unit\DesignSystem;

use Tests\TestCase;
use Illuminate\Support\Facades\View;

class DesignSystemTest extends TestCase
{
    /** @test */
    public function button_component_renders_with_primary_variant()
    {
        $view = View::make('components.button', [
            'variant' => 'primary',
            'slot' => 'Click Me'
        ]);
        
        $html = $view->render();
        
        $this->assertStringContainsString('bg-primary', $html);
        $this->assertStringContainsString('Click Me', $html);
    }

    /** @test */
    public function card_component_renders_with_default_variant()
    {
        $view = View::make('components.card', [
            'variant' => 'default',
            'slot' => 'Card Content'
        ]);
        
        $html = $view->render();
        
        $this->assertStringContainsString('rounded-3xl', $html);
        $this->assertStringContainsString('Card Content', $html);
    }

    /** @test */
    public function badge_component_uses_design_tokens()
    {
        $view = View::make('components.trust.badge', [
            'name' => 'SSL Secure',
            'description' => 'Secure connection',
            'type' => 'ssl'
        ]);
        
        $html = $view->render();
        
        $this->assertStringContainsString('SSL Secure', $html);
        $this->assertStringContainsString('Secure connection', $html);
    }

    /** @test */
    public function spacing_system_is_defined_in_config()
    {
        $spacing = config('design-tokens.spacing');
        
        $this->assertNotEmpty($spacing);
        $this->assertEquals(4, $spacing['base']);
        $this->assertArrayHasKey('scale', $spacing);
    }

    /** @test */
    public function color_palette_is_complete()
    {
        $colors = config('design-tokens.colors');
        
        $this->assertArrayHasKey('primary', $colors);
        $this->assertArrayHasKey('secondary', $colors);
        $this->assertArrayHasKey('accent', $colors);
    }

    /** @test */
    public function typography_configuration_is_complete()
    {
        $typography = config('design-tokens.typography');
        
        $this->assertArrayHasKey('font-family', $typography);
        $this->assertArrayHasKey('font-weight', $typography);
        $this->assertArrayHasKey('font-size', $typography);
        $this->assertArrayHasKey('line-height', $typography);
    }
}
