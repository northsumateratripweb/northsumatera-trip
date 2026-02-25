<?php

namespace Tests\Unit\Components;

use Tests\TestCase;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

/**
 * Unit tests for Navigation Blade component
 * 
 * Tests the component in isolation without full HTTP requests.
 * Focuses on component rendering logic, edge cases, and responsive behavior.
 * 
 * Requirements: 4.1, 4.2, 4.3, 4.4, 4.5
 */
class NavigationTest extends TestCase
{
    /**
     * Test that navigation renders with sticky positioning
     * 
     * @test
     */
    public function navigation_renders_with_sticky_positioning(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('fixed', $rendered);
        $this->assertStringContainsString('w-full', $rendered);
        $this->assertStringContainsString('top-0', $rendered);
        $this->assertStringContainsString('z-[100]', $rendered);
    }

    /**
     * Test that navigation tracks scroll state
     * 
     * @test
     */
    public function navigation_tracks_scroll_state(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('isScrolled', $rendered);
        $this->assertStringContainsString('window.scrollY', $rendered);
    }

    /**
     * Test that navigation renders logo
     * 
     * @test
     */
    public function navigation_renders_logo(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => [
                'src' => '/images/logo.png',
                'alt' => 'Company Logo',
                'width' => 120,
                'height' => 40,
            ],
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('/images/logo.png', $rendered);
        $this->assertStringContainsString('Company Logo', $rendered);
    }

    /**
     * Test that navigation renders default logo when none provided
     * 
     * @test
     */
    public function navigation_renders_default_logo_when_none_provided(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('NorthSumateraTrip', $rendered);
        $this->assertStringContainsString('bg-blue-700', $rendered);
    }

    /**
     * Test that navigation renders menu items
     * 
     * @test
     */
    public function navigation_renders_menu_items(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
                ['label' => 'Packages', 'url' => '/packages', 'isActive' => false],
                ['label' => 'Gallery', 'url' => '/gallery', 'isActive' => false],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Home', $rendered);
        $this->assertStringContainsString('Packages', $rendered);
        $this->assertStringContainsString('Gallery', $rendered);
    }

    /**
     * Test that navigation highlights active menu item
     * 
     * @test
     */
    public function navigation_highlights_active_menu_item(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => false],
                ['label' => 'Packages', 'url' => '/packages', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('text-blue-600', $rendered);
        $this->assertStringContainsString('aria-current="page"', $rendered);
    }

    /**
     * Test that navigation limits menu items to 5
     * 
     * @test
     */
    public function navigation_limits_menu_items_to_five(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Item 1', 'url' => '/1', 'isActive' => false],
                ['label' => 'Item 2', 'url' => '/2', 'isActive' => false],
                ['label' => 'Item 3', 'url' => '/3', 'isActive' => false],
                ['label' => 'Item 4', 'url' => '/4', 'isActive' => false],
                ['label' => 'Item 5', 'url' => '/5', 'isActive' => false],
                ['label' => 'Item 6', 'url' => '/6', 'isActive' => false],
                ['label' => 'Item 7', 'url' => '/7', 'isActive' => false],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        // Should contain first 5 items
        $this->assertStringContainsString('Item 1', $rendered);
        $this->assertStringContainsString('Item 2', $rendered);
        $this->assertStringContainsString('Item 3', $rendered);
        $this->assertStringContainsString('Item 4', $rendered);
        $this->assertStringContainsString('Item 5', $rendered);
        
        // Should NOT contain items beyond 5
        $this->assertStringNotContainsString('Item 6', $rendered);
        $this->assertStringNotContainsString('Item 7', $rendered);
    }

    /**
     * Test that desktop menu is hidden on mobile
     * 
     * @test
     */
    public function desktop_menu_is_hidden_on_mobile(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('hidden md:flex', $rendered);
    }

    /**
     * Test that mobile menu toggle is hidden on desktop
     * 
     * @test
     */
    public function mobile_menu_toggle_is_hidden_on_desktop(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('md:hidden', $rendered);
    }

    /**
     * Test that mobile menu has hamburger icon
     * 
     * @test
     */
    public function mobile_menu_has_hamburger_icon(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('M4 6h16M4 12h16m-7 6h7', $rendered);
    }

    /**
     * Test that mobile menu has close icon
     * 
     * @test
     */
    public function mobile_menu_has_close_icon(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('M6 18L18 6M6 6l12 12', $rendered);
    }

    /**
     * Test that mobile menu has slide-in animation
     * 
     * @test
     */
    public function mobile_menu_has_slide_in_animation(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('x-transition:enter', $rendered);
        $this->assertStringContainsString('x-transition:leave', $rendered);
        $this->assertStringContainsString('opacity-0 -translate-y-4', $rendered);
    }

    /**
     * Test that mobile menu closes on item click
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

        $rendered = $view->render();
        
        $this->assertStringContainsString('@click="mobileMenu = false"', $rendered);
    }

    /**
     * Test that navigation has smooth scroll script
     * 
     * @test
     */
    public function navigation_has_smooth_scroll_script(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('scrollIntoView', $rendered);
        $this->assertStringContainsString('behavior: \'smooth\'', $rendered);
    }

    /**
     * Test that navigation handles empty menu items
     * 
     * @test
     */
    public function navigation_handles_empty_menu_items(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        // Should still render navigation structure
        $this->assertStringContainsString('role="navigation"', $rendered);
        $this->assertStringContainsString('fixed', $rendered);
    }

    /**
     * Test that navigation has proper accessibility attributes
     * 
     * @test
     */
    public function navigation_has_proper_accessibility_attributes(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('role="navigation"', $rendered);
        $this->assertStringContainsString('aria-label', $rendered);
        $this->assertStringContainsString('aria-expanded', $rendered);
        $this->assertStringContainsString('aria-controls', $rendered);
    }

    /**
     * Test that navigation uses responsive container
     * 
     * @test
     */
    public function navigation_uses_responsive_container(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('max-w-7xl', $rendered);
        $this->assertStringContainsString('mx-auto', $rendered);
        $this->assertStringContainsString('px-4', $rendered);
    }

    /**
     * Test that navigation logo is clickable
     * 
     * @test
     */
    public function navigation_logo_is_clickable(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('href="/"', $rendered);
    }

    /**
     * Test that navigation menu items have correct links
     * 
     * @test
     */
    public function navigation_menu_items_have_correct_links(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
                ['label' => 'Packages', 'url' => '/packages', 'isActive' => false],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('href="/"', $rendered);
        $this->assertStringContainsString('href="/packages"', $rendered);
    }

    /**
     * Test that mobile menu has backdrop blur
     * 
     * @test
     */
    public function mobile_menu_has_backdrop_blur(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('backdrop-blur-xl', $rendered);
        $this->assertStringContainsString('bg-white/95', $rendered);
    }

    /**
     * Test that mobile menu has proper z-index
     * 
     * @test
     */
    public function mobile_menu_has_proper_z_index(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('z-[90]', $rendered);
    }

    /**
     * Test that navigation handles single menu item
     * 
     * @test
     */
    public function navigation_handles_single_menu_item(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('Home', $rendered);
    }

    /**
     * Test that navigation handles exactly 5 menu items
     * 
     * @test
     */
    public function navigation_handles_exactly_five_menu_items(): void
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

        $rendered = $view->render();
        
        $this->assertStringContainsString('Item 1', $rendered);
        $this->assertStringContainsString('Item 5', $rendered);
    }

    /**
     * Test that navigation uses correct transition duration
     * 
     * @test
     */
    public function navigation_uses_correct_transition_duration(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('duration-500', $rendered);
        $this->assertStringContainsString('duration-300', $rendered);
    }

    /**
     * Test that mobile menu items are vertically stacked
     * 
     * @test
     */
    public function mobile_menu_items_are_vertically_stacked(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('space-y-1', $rendered);
    }

    /**
     * Test that mobile menu items have adequate padding
     * 
     * @test
     */
    public function mobile_menu_items_have_adequate_padding(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('p-4', $rendered);
    }

    /**
     * Test that navigation handles missing isActive property
     * 
     * @test
     */
    public function navigation_handles_missing_is_active_property(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/'],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        // Should still render without errors
        $this->assertStringContainsString('Home', $rendered);
    }

    /**
     * Test that navigation uses Alpine.js for interactivity
     * 
     * @test
     */
    public function navigation_uses_alpine_js_for_interactivity(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('x-data', $rendered);
        $this->assertStringContainsString('x-init', $rendered);
        $this->assertStringContainsString('x-show', $rendered);
    }

    /**
     * Test that navigation has proper role attributes
     * 
     * @test
     */
    public function navigation_has_proper_role_attributes(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('role="navigation"', $rendered);
        $this->assertStringContainsString('role="menu"', $rendered);
        $this->assertStringContainsString('role="menuitem"', $rendered);
    }

    /**
     * Test that desktop menu uses horizontal layout
     * 
     * @test
     */
    public function desktop_menu_uses_horizontal_layout(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'Home', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('items-center', $rendered);
        $this->assertStringContainsString('gap-6', $rendered);
    }

    /**
     * Test that navigation handles long menu item labels
     * 
     * @test
     */
    public function navigation_handles_long_menu_item_labels(): void
    {
        $view = View::make('components.navigation.navigation', [
            'menuItems' => [
                ['label' => 'This is a very long menu item label', 'url' => '/', 'isActive' => true],
            ],
            'logo' => null,
        ]);

        $rendered = $view->render();
        
        $this->assertStringContainsString('This is a very long menu item label', $rendered);
    }
}

