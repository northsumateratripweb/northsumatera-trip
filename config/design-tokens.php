<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Color Palette
    |--------------------------------------------------------------------------
    |
    | The primary, secondary, and accent colors for the travel website.
    | These colors are used throughout the application for consistent styling.
    |
    */

    'colors' => [
        'primary' => [
            'default' => '#2563eb',
            'dark' => '#1d4ed8',
            'light' => '#3b82f6',
        ],
        'secondary' => [
            'default' => '#ffffff',
        ],
        'accent' => [
            'light-gray' => [
                '50' => '#f8fafc',
                '100' => '#f1f5f9',
                '200' => '#e2e8f0',
                '300' => '#cbd5e1',
                '400' => '#94a3b8',
                '500' => '#64748b',
                '600' => '#475569',
                '700' => '#334155',
                '800' => '#1e293b',
                '900' => '#0f172a',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Typography
    |--------------------------------------------------------------------------
    |
    | Font families, weights, and sizes for the website.
    | Headlines use bold weight, body text uses light weight.
    |
    */

    'typography' => [
        'font-family' => [
            'sans' => 'Figtree, system-ui, -apple-system, sans-serif',
        ],
        'font-weight' => [
            'headline' => 700,
            'body' => 300,
            'semibold' => 600,
        ],
        'font-size' => [
            'xs' => '0.75rem',
            'sm' => '0.875rem',
            'base' => '1rem',
            'lg' => '1.125rem',
            'xl' => '1.25rem',
            '2xl' => '1.5rem',
            '3xl' => '1.875rem',
            '4xl' => '2.25rem',
            '5xl' => '3rem',
            '6xl' => '3.75rem',
            '7xl' => '4.5rem',
            '8xl' => '6rem',
            '9xl' => '8rem',
        ],
        'line-height' => [
            'tight' => '1.25',
            'normal' => '1.5',
            'relaxed' => '1.75',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Spacing System
    |--------------------------------------------------------------------------
    |
    | Proportional spacing scale based on Tailwind's spacing system.
    | Uses a 4px base unit for consistent spacing throughout the application.
    |
    */

    'spacing' => [
        'base' => 4, // 4px base unit
        'scale' => [
            'xs' => '0.25rem',   // 4px
            'sm' => '0.5rem',    // 8px
            'md' => '1rem',      // 16px
            'lg' => '1.5rem',    // 24px
            'xl' => '2rem',      // 32px
            '2xl' => '3rem',     // 48px
            '3xl' => '4rem',     // 64px
            '4xl' => '5rem',     // 80px
            '5xl' => '6rem',     // 96px
            '6xl' => '8rem',     // 128px
            '7xl' => '10rem',    // 160px
            '8xl' => '12rem',    // 192px
            '9xl' => '16rem',    // 256px
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Animation
    |--------------------------------------------------------------------------
    |
    | Animation configurations for smooth transitions and effects.
    |
    */

    'animations' => [
        'fade-in' => [
            'duration' => 800,
            'easing' => 'ease-out',
        ],
        'fade-in-slow' => [
            'duration' => 1200,
            'easing' => 'ease-out',
        ],
        'fade-in-fast' => [
            'duration' => 500,
            'easing' => 'ease-out',
        ],
        'scale-in' => [
            'duration' => 500,
            'easing' => 'cubic-bezier(0.16, 1, 0.3, 1)',
        ],
        'float' => [
            'duration' => 6000,
            'easing' => 'ease-in-out',
        ],
        'shimmer' => [
            'duration' => 1500,
            'easing' => 'linear',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Breakpoints
    |--------------------------------------------------------------------------
    |
    | Responsive breakpoints for mobile-first design.
    |
    */

    'breakpoints' => [
        'mobile' => '640px',
        'tablet' => '768px',
        'desktop' => '1024px',
        'large' => '1280px',
        'xlarge' => '1536px',
    ],

    /*
    |--------------------------------------------------------------------------
    | Grid System
    |--------------------------------------------------------------------------
    |
    | Grid configuration for consistent layout structure.
    |
    */

    'grid' => [
        'columns' => [
            'mobile' => 1,
            'tablet' => 2,
            'desktop' => 3,
        ],
        'gap' => [
            'sm' => '1rem',
            'md' => '1.5rem',
            'lg' => '2rem',
        ],
    ],
];
