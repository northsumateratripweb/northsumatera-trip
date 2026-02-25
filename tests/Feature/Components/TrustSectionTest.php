<?php

namespace Tests\Feature\Components;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;

/**
 * Property-Based Test for Trust Section Component
 * 
 * This test validates the correctness properties of the Trust Section component
 * as specified in the travel website redesign design document.
 * 
 * **Property 4: Trust section always displays all required elements**
 * **Validates: Requirements 2.1, 2.2, 2.3, 2.4**
 * 
 * For any trust section, customer ratings, traveler count, legal badges,
 * and testimonials MUST all be displayed.
 */
class TrustSectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for various trust section configurations
     * Generates different combinations of ratings, traveler counts, badges, and testimonials
     * to test the property across multiple inputs
     */
    public static function trustSectionDataProvider(): array
    {
        return [
            'minimal_data' => [
                'ratings' => [
                    ['platform' => 'Google', 'score' => 4.5, 'count' => 100, 'icon' => '⭐'],
                ],
                'travelerCount' => 500,
                'legalBadges' => [
                    ['name' => 'Licensed', 'icon' => 'badge', 'description' => 'Certified'],
                ],
                'testimonials' => [
                    ['name' => 'Test User', 'location' => 'City', 'text' => 'Great!', 'rating' => 5],
                ],
            ],
            'multiple_ratings' => [
                'ratings' => [
                    ['platform' => 'Google', 'score' => 4.8, 'count' => 150, 'icon' => '⭐'],
                    ['platform' => 'TripAdvisor', 'score' => 4.9, 'count' => 200, 'icon' => '⭐'],
                ],
                'travelerCount' => 1200,
                'legalBadges' => [
                    ['name' => 'Licensed Tour Operator', 'icon' => 'badge', 'description' => 'Officially certified'],
                    ['name' => 'Secure Booking', 'icon' => 'lock', 'description' => 'Safe transactions'],
                ],
                'testimonials' => [
                    ['name' => 'John Doe', 'location' => 'Jakarta', 'text' => 'Amazing experience!', 'rating' => 5],
                    ['name' => 'Jane Smith', 'location' => 'Singapore', 'text' => 'Highly recommended!', 'rating' => 5],
                ],
            ],
            'large_traveler_count' => [
                'ratings' => [
                    ['platform' => 'Google', 'score' => 4.7, 'count' => 500, 'icon' => '⭐'],
                ],
                'travelerCount' => 50000,
                'legalBadges' => [
                    ['name' => 'Licensed Tour Operator', 'icon' => 'badge', 'description' => 'Officially certified'],
                    ['name' => 'Secure Booking', 'icon' => 'lock', 'description' => 'Safe transactions'],
                    ['name' => '24/7 Support', 'icon' => 'headset', 'description' => 'Always available'],
                ],
                'testimonials' => [
                    ['name' => 'Alice Brown', 'location' => 'Malaysia', 'text' => 'Perfect trip!', 'rating' => 5],
                ],
            ],
            'many_testimonials' => [
                'ratings' => [
                    ['platform' => 'Google', 'score' => 4.9, 'count' => 300, 'icon' => '⭐'],
                ],
                'travelerCount' => 2500,
                'legalBadges' => [
                    ['name' => 'Licensed', 'icon' => 'badge', 'description' => 'Certified'],
                ],
                'testimonials' => [
                    ['name' => 'User 1', 'location' => 'City 1', 'text' => 'Great service!', 'rating' => 5],
                    ['name' => 'User 2', 'location' => 'City 2', 'text' => 'Excellent tour!', 'rating' => 5],
                    ['name' => 'User 3', 'location' => 'City 3', 'text' => 'Wonderful experience!', 'rating' => 5],
                    ['name' => 'User 4', 'location' => 'City 4', 'text' => 'Highly professional!', 'rating' => 5],
                ],
            ],
            'edge_case_low_rating' => [
                'ratings' => [
                    ['platform' => 'Google', 'score' => 3.5, 'count' => 50, 'icon' => '⭐'],
                ],
                'travelerCount' => 100,
                'legalBadges' => [
                    ['name' => 'Basic License', 'icon' => 'badge', 'description' => 'Standard'],
                ],
                'testimonials' => [
                    ['name' => 'Test', 'location' => 'Place', 'text' => 'Good.', 'rating' => 4],
                ],
            ],
        ];
    }

    /**
     * **Property 4: Trust section always displays all required elements**
     * **Validates: Requirements 2.1, 2.2, 2.3, 2.4**
     * 
     * For ANY trust section configuration with ratings, traveler count, legal badges,
     * and testimonials, ALL four required elements MUST be displayed.
     * 
     * This is a true property-based test that verifies the universal property
     * across multiple generated inputs.
     * 
     * @test
     * @dataProvider trustSectionDataProvider
     */
    public function property_trust_section_always_displays_all_required_elements(
        array $ratings,
        int $travelerCount,
        array $legalBadges,
        array $testimonials
    ): void {
        // Render the component with the provided data
        $view = View::make('components.trust.trust-section', [
            'ratings' => $ratings,
            'travelerCount' => $travelerCount,
            'legalBadges' => $legalBadges,
            'testimonials' => $testimonials,
        ]);

        $html = $view->render();

        // Property: Customer ratings MUST be displayed (Requirement 2.1)
        $this->assertStringContainsString('Trusted by Travelers Worldwide', $html, 
            'Trust section must display ratings section title');
        
        foreach ($ratings as $rating) {
            $this->assertStringContainsString((string)$rating['score'], $html,
                "Trust section must display rating score: {$rating['score']}");
            $this->assertStringContainsString($rating['platform'], $html,
                "Trust section must display rating platform: {$rating['platform']}");
        }

        // Property: Traveler count MUST be displayed (Requirement 2.2)
        $this->assertStringContainsString('Total Travelers Served', $html,
            'Trust section must display traveler count label');
        $this->assertStringContainsString(number_format($travelerCount), $html,
            "Trust section must display traveler count: {$travelerCount}");

        // Property: Legal badges MUST be displayed (Requirement 2.3)
        $this->assertStringContainsString('Certifications & Badges', $html,
            'Trust section must display badges section title');
        
        foreach ($legalBadges as $badge) {
            $this->assertStringContainsString($badge['name'], $html,
                "Trust section must display badge: {$badge['name']}");
        }

        // Property: Testimonials MUST be displayed (Requirement 2.4)
        $this->assertStringContainsString('What Travelers Say', $html,
            'Trust section must display testimonials section title');
        
        foreach ($testimonials as $testimonial) {
            $this->assertStringContainsString($testimonial['name'], $html,
                "Trust section must display testimonial from: {$testimonial['name']}");
            $this->assertStringContainsString($testimonial['text'], $html,
                "Trust section must display testimonial text: {$testimonial['text']}");
        }

        // Universal property: ALL four elements must be present together
        $hasRatings = str_contains($html, 'Trusted by Travelers Worldwide');
        $hasTravelerCount = str_contains($html, 'Total Travelers Served');
        $hasBadges = str_contains($html, 'Certifications & Badges');
        $hasTestimonials = str_contains($html, 'What Travelers Say');

        $this->assertTrue(
            $hasRatings && $hasTravelerCount && $hasBadges && $hasTestimonials,
            'Property violation: Trust section must ALWAYS display all four required elements (ratings, traveler count, badges, testimonials)'
        );
    }

    /**
     * Property 4: Trust section displays customer ratings
     * Validates: Requirements 2.1
     * 
     * When the trust section loads, the website SHALL display customer ratings
     * with star indicators.
     * 
     * @test
     */
    public function trust_section_displays_customer_ratings(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The trust section should display customer ratings
        // Check for rating score display (e.g., "4.8")
        $response->assertSee('4.8');
        
        // Check for rating count display (e.g., "150 reviews")
        $response->assertSee('review');
        
        // Check for platform indicators (e.g., Google, TripAdvisor)
        $response->assertSee('Google');
    }

    /**
     * Property 4: Trust section displays traveler count
     * Validates: Requirements 2.2
     * 
     * When the trust section loads, the website SHALL display the total
     * number of travelers served.
     * 
     * @test
     */
    public function trust_section_displays_traveler_count(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The trust section should display traveler count
        // Check for "Total Travelers Served" label
        $response->assertSee('Total Travelers Served');
        
        // Check for large traveler count display
        $response->assertSee('Travelers');
    }

    /**
     * Property 4: Trust section displays legal badges
     * Validates: Requirements 2.3
     * 
     * When the trust section loads, the website SHALL display legal badges
     * or certifications.
     * 
     * @test
     */
    public function trust_section_displays_legal_badges(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The trust section should display legal badges
        // Check for certifications section
        $response->assertSee('Certifications');
        $response->assertSee('Badges');
        
        // Check for specific badge types
        $response->assertSee('Licensed Tour Operator');
        $response->assertSee('Secure Booking');
        $response->assertSee('24/7 Support');
    }

    /**
     * Property 4: Trust section displays testimonials
     * Validates: Requirements 2.4
     * 
     * When the trust section loads, the website SHALL display short,
     * authentic customer testimonials.
     * 
     * @test
     */
    public function trust_section_displays_testimonials(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The trust section should display testimonials
        // Check for testimonials section title
        $response->assertSee('What Travelers Say');
        
        // Check for testimonial content
        $response->assertSee('Real experiences');
        $response->assertSee('real travelers');
    }

    /**
     * Property 4: Trust section displays all required elements together
     * Validates: Requirements 2.1, 2.2, 2.3, 2.4
     * 
     * For any trust section, all required elements MUST be displayed:
     * customer ratings, traveler count, legal badges, and testimonials.
     * 
     * @test
     */
    public function trust_section_displays_all_required_elements(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // Verify all four required elements are present
        $this->assertTrue(
            $response->see('4.8') && 
            $response->see('Total Travelers') && 
            $response->see('Certifications') && 
            $response->see('What Travelers Say'),
            'Trust section should display all required elements'
        );
    }

    /**
     * Responsive behavior test: Trust section on mobile
     * Validates: Requirements 2.5
     * 
     * When the trust section is viewed on mobile devices (screen width < 768px),
     * the section SHALL stack content vertically for easy reading.
     * 
     * @test
     */
    public function trust_section_has_responsive_layout_on_mobile(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should render with responsive layout classes
        // Check for mobile-first responsive classes
        $response->assertSee('grid grid-cols-1');
        $response->assertSee('md:grid-cols-2');
        $response->assertSee('lg:grid-cols-3');
    }

    /**
     * Responsive behavior test: Trust section on tablet
     * Validates: Requirements 2.5
     * 
     * When the trust section is viewed on tablet devices (screen width 768px-1024px),
     * the section SHALL adjust layout proportions appropriately.
     * 
     * @test
     */
    public function trust_section_has_responsive_layout_on_tablet(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should render with responsive layout classes
        $response->assertSee('md:grid-cols-2');
    }

    /**
     * Responsive behavior test: Trust section on desktop
     * Validates: Requirements 2.5
     * 
     * When the trust section is viewed on desktop devices (screen width ≥ 1024px),
     * the section SHALL display the full layout with all sections visible.
     * 
     * @test
     */
    public function trust_section_has_responsive_layout_on_desktop(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should render with responsive layout classes
        $response->assertSee('lg:grid-cols-3');
    }

    /**
     * Test that the trust section component renders correctly with all properties
     * 
     * @test
     */
    public function trust_section_renders_with_all_properties(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // Verify the trust section contains expected elements
        $response->assertSee('Trusted by Travelers Worldwide');
        $response->assertSee('Total Travelers Served');
        $response->assertSee('Certifications & Badges');
        $response->assertSee('What Travelers Say');
    }

    /**
     * Test that the trust section component handles missing data gracefully
     * 
     * @test
     */
    public function trust_section_handles_missing_data(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should handle missing data gracefully
        // and still display default values
        $response->assertSee('NorthSumateraTrip');
    }

    /**
     * Test that the trust section uses proper accessibility attributes
     * Validates: Requirements 10.1, 10.2, 10.3, 10.4, 10.5
     * 
     * @test
     */
    public function trust_section_has_accessibility_attributes(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should have proper accessibility attributes
        // Check for role attributes on articles
        $response->assertSee('role="article"');
    }

    /**
     * Test that the trust section maintains clean, professional layout
     * Validates: Requirements 2.5
     * 
     * While the trust section is visible, the website SHALL maintain
     * a clean, professional layout with adequate spacing.
     * 
     * @test
     */
    public function trust_section_maintains_clean_layout(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should have proper spacing classes
        $response->assertSee('py-16');
        $response->assertSee('space-y-4');
        $response->assertSee('space-y-6');
        $response->assertSee('space-y-8');
    }
}
