<?php

namespace App\Services;

class AnimationService
{
    /**
     * Get fade-in animation configuration
     *
     * @param string $variant Animation variant (default, slow, fast)
     * @return array Animation configuration
     */
    public function getFadeInConfig(string $variant = 'default'): array
    {
        $animations = config('design-tokens.animations');
        
        $configKey = match($variant) {
            'slow' => 'fade-in-slow',
            'fast' => 'fade-in-fast',
            default => 'fade-in',
        };
        
        return [
            'duration' => $animations[$configKey]['duration'] ?? 800,
            'easing' => $animations[$configKey]['easing'] ?? 'ease-out',
            'delay' => 0,
            'threshold' => 0.1,
            'opacityStart' => 0,
            'opacityEnd' => 1,
        ];
    }

    /**
     * Get hover effect configuration
     *
     * @return array Hover effect configuration
     */
    public function getHoverConfig(): array
    {
        return [
            'duration' => 300,
            'easing' => 'ease-in-out',
            'transform' => 'translateY(-2px)',
            'scale' => 1.02,
        ];
    }

    /**
     * Get scroll behavior configuration
     *
     * @return array Scroll configuration
     */
    public function getScrollConfig(): array
    {
        return [
            'behavior' => 'smooth',
            'duration' => 800,
            'easing' => 'cubic-bezier(0.4, 0, 0.2, 1)',
            'offset' => 80,
        ];
    }

    /**
     * Generate CSS classes for fade-in animation
     *
     * @param string $variant Animation variant
     * @return string CSS classes
     */
    public function getFadeInClasses(string $variant = 'default'): string
    {
        return match($variant) {
            'slow' => 'animate-fade-in-slow',
            'fast' => 'animate-fade-in-fast',
            default => 'animate-fade-in',
        };
    }

    /**
     * Generate inline styles for fade-in animation
     *
     * @param string $variant Animation variant
     * @return string Inline CSS styles
     */
    public function getFadeInStyles(string $variant = 'default'): string
    {
        $config = $this->getFadeInConfig($variant);
        
        return sprintf(
            'opacity: 0; transition: opacity %dms %s;',
            $config['duration'],
            $config['easing']
        );
    }

    /**
     * Generate inline styles for hover effect
     *
     * @return string Inline CSS styles
     */
    public function getHoverStyles(): string
    {
        $config = $this->getHoverConfig();
        
        return sprintf(
            'transition: transform %dms %s, box-shadow %dms %s;',
            $config['duration'],
            $config['easing'],
            $config['duration'],
            $config['easing']
        );
    }
}
