<?php

namespace Tests\Unit\Components;

use Tests\TestCase;
use Illuminate\Support\Facades\View;

/**
 * Unit tests for Badge Blade component
 * 
 * Tests the badge component in isolation.
 * Focuses on badge display, icon rendering, and edge cases.
 * 
 * Requirements: 2.3
 */
class BadgeComponentTest extends TestCase
{
    /**
     * Test that badge name is displayed correctly
     * 
     * @test
     */
    public function badge_name_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Licensed Tour Operator',
            'icon' => 'badge',
            'description' => 'Officially certified',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Licensed Tour Operator', $rendered);
    }

    /**
     * Test that badge description is displayed correctly
     * 
     * @test
     */
    public function badge_description_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Licensed Tour Operator',
            'icon' => 'badge',
            'description' => 'Officially certified',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Officially certified', $rendered);
    }

    /**
     * Test that badge icon is rendered
     * 
     * @test
     */
    public function badge_icon_is_rendered(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Secure Booking',
            'icon' => 'lock',
            'description' => 'Safe transactions',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('badge-icon', $rendered);
        $this->assertStringContainsString('<svg', $rendered);
    }

    /**
     * Test that component handles missing icon
     * 
     * @test
     */
    public function component_handles_missing_icon(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Test Badge',
            'description' => 'Test description',
        ]);

        $rendered = $view->render();
        
        // Should still render with default icon
        $this->assertStringContainsString('Test Badge', $rendered);
        $this->assertStringContainsString('<svg', $rendered);
    }

    /**
     * Test that component handles missing description
     * 
     * @test
     */
    public function component_handles_missing_description(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Test Badge',
            'icon' => 'badge',
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('Test Badge', $rendered);
    }

    /**
     * Test that component handles empty name
     * 
     * @test
     */
    public function component_handles_empty_name(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => '',
            'icon' => 'badge',
            'description' => 'Test description',
        ]);

        $rendered = $view->render();
        
        // Should still render structure
        $this->assertStringContainsString('trust-badge', $rendered);
    }

    /**
     * Test that component uses correct icon for SSL type
     * 
     * @test
     */
    public function component_uses_correct_icon_for_ssl_type(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'SSL Certified',
            'type' => 'ssl',
            'description' => 'Secure connection',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('SSL Certified', $rendered);
        $this->assertStringContainsString('<svg', $rendered);
    }

    /**
     * Test that component uses correct icon for payment type
     * 
     * @test
     */
    public function component_uses_correct_icon_for_payment_type(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Secure Payment',
            'type' => 'payment',
            'description' => 'Safe transactions',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Secure Payment', $rendered);
        $this->assertStringContainsString('<svg', $rendered);
    }

    /**
     * Test that component uses correct icon for support type
     * 
     * @test
     */
    public function component_uses_correct_icon_for_support_type(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => '24/7 Support',
            'type' => 'support',
            'description' => 'Always available',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('24/7 Support', $rendered);
        $this->assertStringContainsString('<svg', $rendered);
    }

    /**
     * Test that component has proper styling
     * 
     * @test
     */
    public function component_has_proper_styling(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Test Badge',
            'icon' => 'badge',
            'description' => 'Test description',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('trust-badge', $rendered);
        $this->assertStringContainsString('flex items-start', $rendered);
        $this->assertStringContainsString('rounded-lg', $rendered);
    }

    /**
     * Test that component has icon container
     * 
     * @test
     */
    public function component_has_icon_container(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Test Badge',
            'icon' => 'badge',
            'description' => 'Test description',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('badge-icon', $rendered);
        $this->assertStringContainsString('flex-shrink-0', $rendered);
    }

    /**
     * Test that component has content section
     * 
     * @test
     */
    public function component_has_content_section(): void
    {
        $view = View::make('components.trust.badge', [
            'name' => 'Test Badge',
            'icon' => 'badge',
            'description' => 'Test description',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('badge-content', $rendered);
        $this->assertStringContainsString('badge-name', $rendered);
        $this->assertStringContainsString('badge-description', $rendered);
    }
}
