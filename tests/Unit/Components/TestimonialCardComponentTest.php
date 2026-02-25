<?php

namespace Tests\Unit\Components;

use Tests\TestCase;
use Illuminate\Support\Facades\View;

/**
 * Unit tests for TestimonialCard Blade component
 * 
 * Tests the testimonial card component in isolation.
 * Focuses on testimonial display, rating stars, and edge cases.
 * 
 * Requirements: 2.4
 */
class TestimonialCardComponentTest extends TestCase
{
    /**
     * Test that testimonial name is displayed correctly
     * 
     * @test
     */
    public function testimonial_name_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('John Doe', $rendered);
    }

    /**
     * Test that testimonial location is displayed correctly
     * 
     * @test
     */
    public function testimonial_location_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Jakarta', $rendered);
    }

    /**
     * Test that testimonial text is displayed correctly
     * 
     * @test
     */
    public function testimonial_text_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Amazing experience!', $rendered);
        $this->assertStringContainsString('"', $rendered); // Should have quotes
    }

    /**
     * Test that rating stars are displayed correctly
     * 
     * @test
     */
    public function rating_stars_are_displayed_correctly(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        // Should contain 5 stars
        $this->assertStringContainsString('★', $rendered);
        $this->assertStringContainsString('testimonial-rating', $rendered);
    }

    /**
     * Test that partial rating is displayed correctly
     * 
     * @test
     */
    public function partial_rating_is_displayed_correctly(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Good experience!',
            'rating' => 3,
        ]);

        $rendered = $view->render();
        
        // Should contain stars with different colors
        $this->assertStringContainsString('★', $rendered);
        $this->assertStringContainsString('#FBBF24', $rendered); // Yellow for filled stars
        $this->assertStringContainsString('#D1D5DB', $rendered); // Gray for empty stars
    }

    /**
     * Test that avatar initial is displayed
     * 
     * @test
     */
    public function avatar_initial_is_displayed(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
            'avatarInitial' => 'J',
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('J', $rendered);
        $this->assertStringContainsString('author-avatar', $rendered);
    }

    /**
     * Test that component can hide avatar
     * 
     * @test
     */
    public function component_can_hide_avatar(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
            'avatarInitial' => 'J',
            'showAvatar' => false,
        ]);

        $rendered = $view->render();
        
        $this->assertStringNotContainsString('author-avatar', $rendered);
    }

    /**
     * Test that component handles zero rating
     * 
     * @test
     */
    public function component_handles_zero_rating(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Experience',
            'rating' => 0,
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('John Doe', $rendered);
        $this->assertStringContainsString('★', $rendered);
    }

    /**
     * Test that component handles missing name
     * 
     * @test
     */
    public function component_handles_missing_name(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('testimonial-card', $rendered);
    }

    /**
     * Test that component handles missing location
     * 
     * @test
     */
    public function component_handles_missing_location(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('John Doe', $rendered);
    }

    /**
     * Test that component handles empty text
     * 
     * @test
     */
    public function component_handles_empty_text(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => '',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        // Should still render structure
        $this->assertStringContainsString('testimonial-text', $rendered);
    }

    /**
     * Test that component has proper accessibility attributes
     * 
     * @test
     */
    public function component_has_proper_accessibility_attributes(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('role="article"', $rendered);
        $this->assertStringContainsString('aria-label="Customer testimonial from John Doe"', $rendered);
    }

    /**
     * Test that component has proper styling
     * 
     * @test
     */
    public function component_has_proper_styling(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('testimonial-card', $rendered);
        $this->assertStringContainsString('rounded-xl', $rendered);
        $this->assertStringContainsString('shadow-sm', $rendered);
    }

    /**
     * Test that component has hover effect
     * 
     * @test
     */
    public function component_has_hover_effect(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('hover:shadow-md', $rendered);
        $this->assertStringContainsString('transition-shadow', $rendered);
    }

    /**
     * Test that component has proper structure
     * 
     * @test
     */
    public function component_has_proper_structure(): void
    {
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => 'Amazing experience!',
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('testimonial-rating', $rendered);
        $this->assertStringContainsString('testimonial-text', $rendered);
        $this->assertStringContainsString('testimonial-author', $rendered);
        $this->assertStringContainsString('author-info', $rendered);
    }

    /**
     * Test that component handles long testimonial text
     * 
     * @test
     */
    public function component_handles_long_testimonial_text(): void
    {
        $longText = str_repeat('This is a long testimonial text. ', 20);
        
        $view = View::make('components.trust.testimonial-card', [
            'name' => 'John Doe',
            'location' => 'Jakarta',
            'text' => $longText,
            'rating' => 5,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString($longText, $rendered);
    }
}
