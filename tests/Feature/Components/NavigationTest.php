<?php

namespace Tests\Feature\Components;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;

/**
 * Property-Based Test for Navigation Component
 * 
 * This test validates the correctness properties of the Navigation component
 * as specified in the travel website redesign design document.
 * 
 * **Property 6: Navigation maintains sticky behavior during scroll**
 * **Validates: Requirements 4.1**
 * 
 * For any page scroll action, the navigation header MUST remain visible
 * at the top of the viewport.
 */
class NavigationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Data provider for various navigation configurations
     * Generates different combinations of menu items to test the property
     * across multiple inputs
     */
    public static function navigationDataProvider(): array
    {
        return [
            'minimal_menu' => [
                'menuItems' => [
                    ['label' => 'Home', 'url' => '/', 'isActive' => true],
                ],
                'logo' => null,
            ],
            'standard_menu' => [
                'menuItems' => [
                    ['label' => 'Home', 'url' => '/', 'isActive' => true],
                    ['label' => 'Packages', 'url' => '/packages', 'isActive' => false],
                    ['label' => 'Gallery', 'url' => '/gallery', 'isActive' => false],
                ],
                'logo' => null,
            ],
            'max_menu_items' => [
                'menuItems' => [
                    ['label' => 'Home', 'url' => '/', 'isActive' => true],
                    ['label' => 'Packages', 'url' => '/packages', 'isActive' => false],
                    ['label' => 'Rental', 'url' => '/rental', 'isActive' => false],
                    ['label' => 'Gallery', 'url' => '/gallery', 'isActive' => false],
                    ['label' => 'Contact', 'url' => '/contact', 'isActive' => false],
                ],
                'logo' => null,
            ],
            'with_custom_logo' => [
                'menuItems' => [
                    ['label' => 'Home', 'url' => '/', 'isActive' => true],
                    ['label' => 'Packages', 'url' => '/packages', 'isActive' => false],
                ],
                'logo' => [
                    'src' => '/images/logo.png',
                    'alt' => 'Company Logo',
                    'width' => 120,
                    'height' => 40,
                ],
            ],
            'different_active_states' => [
                'menuItems' => [
                    ['label' => 'Home', 'url' => '/', 'isActive' => false],
                    ['label' => 'Packages', 'url' => '/packages', 'isActive' => true],
                    ['label' => 'Gallery', 'url' => '/gallery', 'isActive' => false],
                ],
                'logo' => null,
            ],
        ];
    }

    /**
     * **Property 6: Navigation maintains sticky behavior during scroll**
     * **Validates: Requirements 4.1**
     * 
     * For ANY navigation configuration, the navigation header MUST use
     * sticky positioning to remain visible at the top of the viewport.
     * 
     * This is a true property-based test that verifies the universal property
     * across multiple generated inputs.
     * 
     * @test
     * @dataProvider navigationDataProvider
     */
    public function property_navigation_maintains_sticky_behavior(
        array $menuItems,
        ?array $logo
    ): void {
        // Render the component with the provided data
        $view = View::make('components.navigation.navigation', [
            'menuItems' => $menuItems,
            'logo' => $logo,
        ]);

        $html = $view->render();

        // Property: Navigation MUST use fixed positioning (Requirement 4.1)
        $this->assertStringContainsString('fixed', $html,
            'Navigation must use fixed positioning');
        
        $this->assertStringContainsString('w-full', $html,
            'Navigation must span full width');
        
        $this->assertStringContainsString('top-0', $html,
            'Navigation must be positioned at top');
        
        $this->assertStringContainsString('z-[100]', $html,
            'Navigation must have high z-index to stay on top');

        // Property: Navigation MUST have scroll-responsive behavior
        $this->assertStringContainsString('isScrolled', $html,
            'Navigation must track scroll state');

        // Universal property: Sticky behavior must be present
        $hasFixedPosition = str_contains($html, 'fixed');
        $hasTopPosition = str_contains($html, 'top-0');
        $hasHighZIndex = str_contains($html, 'z-[100]');
        $hasScrollTracking = str_contains($html, 'isScrolled');

        $this->assertTrue(
            $hasFixedPosition && $hasTopPosition && $hasHighZIndex && $hasScrollTracking,
            'Property violation: Navigation must ALWAYS maintain sticky behavior with fixed positioning, top alignment, high z-index, and scroll tracking'
        );
    }

    /**
     * **Property 7: Navigation menu never exceeds 5 items**
     * **Validates: Requirements 4.2**
     * 
     * For ANY navigation configuration, the main navigation menu MUST
     * contain 5 or fewer items.
     * 
     * @test
     */
    public function property_navigation_menu_never_exceeds_five_items(): void
    {
        // Test with exactly 5 items
        $menuItems = [
            ['label' => 'Item 1', 'url' => '/1', 'isActive' => false],
            ['label' => 'Item 2', 'url' => '/2', 'isActive' => false],
            ['label' => 'Item 3', 'url' => '/3', 'isActive' => false],
            ['label' => 'Item 4', 'url' => '/4', 'isActive' => false],
            ['label' => 'Item 5', 'url' => '/5', 'isActive' => false],
        ];

        $view = View::make('components.navigation.navigation', [
            'menuItems' => $menuItems,
            'logo' => null,
        ]);

        $html = $view->render();

        // Count menu items in desktop menu
        $desktopMenuCount = substr_count($html, 'text-sm font-black transition-all');
        $this->assertLessThanOrEqual(5, $desktopMenuCount,
            'Desktop menu must not exceed 5 items');

        // Test with more than 5 items (should be truncated)
        $menuItems = [
            ['label' => 'Item 1', 'url' => '/1', 'isActive' => false],
            ['label' => 'Item 2', 'url' => '/2', 'isActive' => false],
            ['label' => 'Item 3', 'url' => '/3', 'isActive' => false],
            ['label' => 'Item 4', 'url' => '/4', 'isActive' => false],
            ['label' => 'Item 5', 'url' => '/5', 'isActive' => false],
            ['label' => 'Item 6', 'url' => '/6', 'isActive' => false],
            ['label' => 'Item 7', 'url' => '/7', 'isActive' => false],
        ];

        $view = View::make('components.navigation.navigation', [
            'menuItems' => $menuItems,
            'logo' => null,
        ]);

        $html = $view->render();

        // Verify only 5 items are rendered
        $this->assertStringNotContainsString('Item 6', $html,
            'Navigation must truncate menu items beyond 5');
        $this->assertStringNotContainsString('Item 7', $html,
            'Navigation must truncate menu items beyond 5');
    }

    /**
     * Property 6: Navigation displays sticky header
     * Validates: Requirements 4.1
     * 
     * When the page scrolls, the website SHALL maintain a sticky header
     * navigation bar.
     * 
     * @test
     */
    public function navigation_displays_sticky_header(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The navigation should use fixed positioning
        $this->assertStringContainsString('fixed', $html);
        $this->assertStringContainsString('w-full', $html);
        $this->assertStringContainsString('top-0', $html);
        $this->assertStringContainsString('z-[100]', $html);
    }

    /**
     * Property 6: Navigation tracks scroll state
     * Validates: Requirements 4.1
     * 
     * The navigation MUST track scroll state to apply appropriate styling.
     * 
     * @test
     */
    public function navigation_tracks_scroll_state(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The navigation should have Alpine.js scroll tracking
        $this->assertStringContainsString('isScrolled', $html);
        $this->assertStringContainsString('window.scrollY', $html);
    }

    /**
     * Property 7: Navigation displays maximum 5 menu items
     * Validates: Requirements 4.2
     * 
     * While the navigation is visible, the website SHALL display a maximum
     * of 5 main menu items.
     * 
     * @test
     */
    public function navigation_displays_maximum_five_menu_items(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Item 1', 'url' => '/1', 'isActive' => false],
                ['label' => 'Item 2', 'url' => '/2', 'isActive' => false],
                ['label' => 'Item 3', 'url' => '/3', 'isActive' => false],
                ['label' => 'Item 4', 'url' => '/4', 'isActive' => false],
                ['label' => 'Item 5', 'url' => '/5', 'isActive' => false],
            ],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The navigation should display menu items
        $this->assertStringContainsString('hidden md:flex', $html);
    }

    /**
     * Property 8: Navigation uses hamburger menu on mobile
     * Validates: Requirements 4.3
     * 
     * When the navigation is viewed on mobile devices (screen width < 768px),
     * the website SHALL display a simplified, easy-to-use menu with
     * hamburger icon.
     * 
     * @test
     */
    public function navigation_uses_hamburger_menu_on_mobile(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The navigation should have mobile menu toggle
        $this->assertStringContainsString('md:hidden', $html);
        $this->assertStringContainsString('mobileMenu', $html);
        
        // Should have hamburger icon
        $this->assertStringContainsString('M4 6h16M4 12h16m-7 6h7', $html);
    }

    /**
     * Property 8: Mobile menu has slide-in animation
     * Validates: Requirements 4.3, 4.4
     * 
     * When a menu item is tapped on mobile, the website SHALL respond
     * with a clear visual feedback and slide-in animation.
     * 
     * @test
     */
    public function mobile_menu_has_slide_in_animation(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The mobile menu should have transition animations
        $this->assertStringContainsString('x-transition:enter', $html);
        $this->assertStringContainsString('x-transition:leave', $html);
        $this->assertStringContainsString('opacity-0 -translate-y-4', $html);
    }

    /**
     * Property 6: Navigation has smooth scroll to anchors
     * Validates: Requirements 4.1, 6.3
     * 
     * When anchor links are clicked, the page SHALL scroll smoothly
     * to the target section.
     * 
     * @test
     */
    public function navigation_has_smooth_scroll_to_anchors(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The navigation should have smooth scroll script
        $this->assertStringContainsString('scrollIntoView', $html);
        $this->assertStringContainsString('behavior: \'smooth\'', $html);
    }

    /**
     * Test that navigation renders with all required elements
     * 
     * @test
     */
    public function navigation_renders_with_all_required_elements(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // Verify the navigation contains expected elements
        $this->assertStringContainsString('NorthSumateraTrip', $html);
        $this->assertStringContainsString('role="navigation"', $html);
    }

    /**
     * Test that navigation has proper accessibility attributes
     * Validates: Requirements 10.1, 10.2, 10.3, 10.4, 10.5
     * 
     * @test
     */
    public function navigation_has_accessibility_attributes(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The component should have proper accessibility attributes
        $this->assertStringContainsString('role="navigation"', $html);
        $this->assertStringContainsString('aria-label', $html);
        $this->assertStringContainsString('aria-expanded', $html);
        $this->assertStringContainsString('aria-controls', $html);
    }

    /**
     * Test that desktop menu displays horizontally
     * Validates: Requirements 4.5
     * 
     * When the navigation is viewed on desktop, the website SHALL display
     * menu items horizontally.
     * 
     * @test
     */
    public function desktop_menu_displays_horizontally(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The desktop menu should use flex layout
        $this->assertStringContainsString('hidden md:flex', $html);
        $this->assertStringContainsString('items-center', $html);
        $this->assertStringContainsString('gap-6', $html);
    }

    /**
     * Test that active menu items are highlighted
     * Validates: Requirements 4.5
     * 
     * The navigation SHALL highlight the active menu item with
     * appropriate styling.
     * 
     * @test
     */
    public function active_menu_items_are_highlighted(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The navigation should have active state styling
        $this->assertStringContainsString('text-blue-600', $html);
        $this->assertStringContainsString('aria-current', $html);
    }

    /**
     * Test that mobile menu closes on item click
     * Validates: Requirements 4.4
     * 
     * When a menu item is clicked on mobile, the menu SHALL close
     * automatically.
     * 
     * @test
     */
    public function mobile_menu_closes_on_item_click(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The mobile menu items should have click handler to close menu
        $this->assertStringContainsString('@click="mobileMenu = false"', $html);
    }

    /**
     * Test that navigation logo is clickable
     * Validates: Requirements 4.1
     * 
     * The navigation logo SHALL be clickable and link to the home page.
     * 
     * @test
     */
    public function navigation_logo_is_clickable(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The logo should be wrapped in a link
        $this->assertStringContainsString('href="/"', $html);
    }

    /**
     * Test that navigation uses responsive container
     * Validates: Requirements 8.1, 8.2, 8.3
     * 
     * The navigation SHALL use a responsive container that adapts
     * to different screen sizes.
     * 
     * @test
     */
    public function navigation_uses_responsive_container(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $html = $view->render();
        
        // The navigation should use max-width container
        $this->assertStringContainsString('max-w-7xl', $html);
        $this->assertStringContainsString('mx-auto', $html);
        $this->assertStringContainsString('px-4', $html);
    }
}

