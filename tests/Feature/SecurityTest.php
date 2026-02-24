<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    /**
     * Test security headers are present
     */
    public function test_security_headers_are_present(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    /**
     * Test CSRF protection on forms
     */
    public function test_csrf_protection_on_contact_form(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Test message',
        ]);

        // Should fail without CSRF token
        $response->assertStatus(419);
    }

    /**
     * Test rate limiting on contact form
     */
    public function test_rate_limiting_on_contact_form(): void
    {
        // Make 4 requests (limit is 3 per minute)
        for ($i = 0; $i < 4; $i++) {
            $response = $this->post('/contact', [
                '_token' => csrf_token(),
                'name' => 'Test User',
                'email' => 'test@example.com',
                'message' => 'Test message',
            ]);
        }

        // 4th request should be rate limited
        $response->assertStatus(429);
    }

    /**
     * Test SQL injection protection
     */
    public function test_sql_injection_protection(): void
    {
        $response = $this->get('/tour/test\' OR 1=1--');

        // Should return 404, not expose database error
        $response->assertStatus(404);
    }

    /**
     * Test XSS protection
     */
    public function test_xss_protection(): void
    {
        $response = $this->get('/');

        $content = $response->getContent();
        
        // Should not contain unescaped script tags
        $this->assertStringNotContainsString('<script>alert', $content);
    }
}
