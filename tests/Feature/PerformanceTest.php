<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PerformanceTest extends TestCase
{
    /**
     * Test homepage loads within acceptable time
     */
    public function test_homepage_loads_quickly(): void
    {
        $startTime = microtime(true);
        
        $response = $this->get('/');
        
        $executionTime = (microtime(true) - $startTime) * 1000;

        $response->assertStatus(200);
        
        // Should load within 2 seconds
        $this->assertLessThan(2000, $executionTime, 'Homepage took too long to load');
    }

    /**
     * Test database queries are optimized (no N+1)
     */
    public function test_homepage_has_optimized_queries(): void
    {
        DB::enableQueryLog();
        
        $this->get('/');
        
        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        // Homepage should not exceed 50 queries
        $this->assertLessThan(50, $queryCount, "Too many database queries: {$queryCount}");
    }

    /**
     * Test tour listing page performance
     */
    public function test_packages_page_loads_quickly(): void
    {
        $startTime = microtime(true);
        
        $response = $this->get('/packages');
        
        $executionTime = (microtime(true) - $startTime) * 1000;

        $response->assertStatus(200);
        
        // Should load within 2 seconds
        $this->assertLessThan(2000, $executionTime);
    }

    /**
     * Test memory usage is reasonable
     */
    public function test_memory_usage_is_reasonable(): void
    {
        $startMemory = memory_get_usage();
        
        $this->get('/');
        
        $memoryUsed = (memory_get_usage() - $startMemory) / 1024 / 1024; // MB

        // Should not use more than 50MB for a single request
        $this->assertLessThan(50, $memoryUsed, "Memory usage too high: {$memoryUsed}MB");
    }
}
