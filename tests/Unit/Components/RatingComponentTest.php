<?php

namespace Tests\Unit\Components;

use Tests\TestCase;
use Illuminate\Support\Facades\View;

/**
 * Unit tests for Rating Blade component
 * 
 * Tests the rating component in isolation.
 * Focuses on score display, platform styling, and edge cases.
 * 
 * Requirements: 2.1
 */
class RatingComponentTest extends TestCase
{
    /**
     * Test that rating score is displayed correctly
     * 
     * @test
     */
    public function rating_score_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.8,
            'count' => 150,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('4.8', $rendered);
        $this->assertStringContainsString('/5', $rendered);
    }

    /**
     * Test that rating count is displayed correctly
     * 
     * @test
     */
    public function rating_count_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.5,
            'count' => 150,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('150', $rendered);
        $this->assertStringContainsString('review', $rendered);
    }

    /**
     * Test that platform name is displayed
     * 
     * @test
     */
    public function platform_name_is_displayed(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.8,
            'count' => 150,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Google', $rendered);
    }

    /**
     * Test that star icon is displayed
     * 
     * @test
     */
    public function star_icon_is_displayed(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.8,
            'count' => 150,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('⭐', $rendered);
    }

    /**
     * Test that component handles zero score
     * 
     * @test
     */
    public function component_handles_zero_score(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 0,
            'count' => 0,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('0.0', $rendered);
    }

    /**
     * Test that component handles large count
     * 
     * @test
     */
    public function component_handles_large_count(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.9,
            'count' => 10000,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('10,000', $rendered);
    }

    /**
     * Test that component handles missing platform
     * 
     * @test
     */
    public function component_handles_missing_platform(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.8,
            'count' => 150,
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('4.8', $rendered);
    }

    /**
     * Test that component handles custom max score
     * 
     * @test
     */
    public function component_handles_custom_max_score(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 8.5,
            'count' => 150,
            'platform' => 'Custom',
            'maxScore' => 10,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('8.5', $rendered);
        $this->assertStringContainsString('/10', $rendered);
    }

    /**
     * Test that component can hide platform
     * 
     * @test
     */
    public function component_can_hide_platform(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.8,
            'count' => 150,
            'platform' => 'Google',
            'showPlatform' => false,
        ]);

        $rendered = $view->render();
        
        $this->assertStringNotContainsString('Google', $rendered);
    }

    /**
     * Test that component can hide count
     * 
     * @test
     */
    public function component_can_hide_count(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.8,
            'count' => 150,
            'platform' => 'Google',
            'showCount' => false,
        ]);

        $rendered = $view->render();
        
        $this->assertStringNotContainsString('150', $rendered);
        $this->assertStringNotContainsString('review', $rendered);
    }

    /**
     * Test that component handles decimal scores correctly
     * 
     * @test
     */
    public function component_handles_decimal_scores_correctly(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.75,
            'count' => 150,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('4.8', $rendered); // Should round to 1 decimal
    }

    /**
     * Test that component uses correct styling
     * 
     * @test
     */
    public function component_uses_correct_styling(): void
    {
        $view = View::make('components.trust.rating', [
            'score' => 4.8,
            'count' => 150,
            'platform' => 'Google',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('rating', $rendered);
        $this->assertStringContainsString('display: flex', $rendered);
    }
}
