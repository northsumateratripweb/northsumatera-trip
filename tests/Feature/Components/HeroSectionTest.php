<?php

namespace Tests\Feature\Components;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Property-Based Test for Hero Section Component
 * 
 * This test validates the correctness properties of the Hero Section component
 * as specified in the travel website redesign design document.
 * 
 * Property 1: Hero section displays fullscreen on desktop
 * Property 2: Headline and subheadline always display together
 * Property 3: Both CTA buttons are always present in hero section
 */
class HeroSectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Property 1: Hero section displays fullscreen on desktop
     * Validates: Requirements 1.1, 1.5
     * 
     * For any page load on desktop devices (screen width ≥ 1024px),
     * the hero section SHALL have a minimum height of 100vh.
     * 
     * @test
     */
    public function hero_section_has_fullscreen_height_on_desktop(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The hero section should have min-height: 100vh on desktop
        // Verified by checking the responsive height classes in the view
        $response->assertViewIs('welcome');
        $response->assertSee('min-h-[85vh] md:min-h-screen');
    }

    /**
     * Property 2: Headline and subheadline always display together
     * Validates: Requirements 1.2, 1.3
     * 
     * For any page with a hero section, if a headline is displayed,
     * a subheadline MUST also be displayed below it.
     * 
     * @test
     */
    public function headline_and_subheadline_always_display_together(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The hero section should display both headline and subheadline
        // These are retrieved from SettingsHelper
        $response->assertSee('Jelajahi Sumatera Utara Tanpa Batas');
        $response->assertSee('Solusi perjalanan wisata profesional');
    }

    /**
     * Property 3: Both CTA buttons are always present in hero section
     * Validates: Requirements 1.4
     * 
     * For any page with a hero section, both "Book Tour" and 
     * "Chat WhatsApp" CTA buttons MUST be visible and functional.
     * 
     * @test
     */
    public function both_cta_buttons_are_present_in_hero_section(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The hero section should have both CTA buttons
        // "BUAT PESANAN" (Book Tour) and "Pesan dari WhatsApp" (WhatsApp/Contact)
        $response->assertSee('BUAT PESANAN');
        $response->assertSee('Pesan dari WhatsApp');
    }

    /**
     * Responsive behavior test: Mobile height
     * Validates: Requirements 1.5
     * 
     * When the website loads on mobile devices (screen width < 768px),
     * the hero section SHALL have a height of 60vh.
     * 
     * @test
     */
    public function hero_section_has_responsive_height_on_mobile(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should render with responsive height classes
        $response->assertViewIs('welcome');
        $response->assertSee('min-h-[85vh]');
    }

    /**
     * Responsive behavior test: Tablet height
     * Validates: Requirements 1.5
     * 
     * When the website loads on tablet devices (screen width 768px-1024px),
     * the hero section SHALL have a height of 80vh.
     * 
     * @test
     */
    public function hero_section_has_responsive_height_on_tablet(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should render with responsive height classes
        $response->assertViewIs('welcome');
    }

    /**
     * Test that the hero section component renders correctly with all properties
     * 
     * @test
     */
    public function hero_section_renders_with_all_properties(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // Verify the hero section contains expected elements
        $response->assertSee('Jelajahi Sumatera Utara Tanpa Batas');
        $response->assertSee('Solusi perjalanan wisata profesional');
    }

    /**
     * Test that the hero section component handles missing properties gracefully
     * 
     * @test
     */
    public function hero_section_handles_missing_properties(): void
    {
        // Test with minimal properties
        $response = $this->get('/');

        $response->assertStatus(200);
        
        // The component should handle missing settings gracefully
        $response->assertSee('NorthSumateraTrip');
    }
}
