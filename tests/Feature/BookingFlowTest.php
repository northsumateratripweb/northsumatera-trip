<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test tour detail page loads
     */
    public function test_tour_detail_page_loads(): void
    {
        $tour = Tour::factory()->create([
            'slug' => 'test-tour',
            'is_active' => true,
        ]);

        $response = $this->get("/tour/{$tour->slug}");

        $response->assertStatus(200);
        $response->assertSee($tour->title);
    }

    /**
     * Test checkout page requires authentication
     */
    public function test_checkout_requires_valid_data(): void
    {
        $tour = Tour::factory()->create();

        $response = $this->post("/checkout/{$tour->id}", []);

        // Should fail validation
        $response->assertSessionHasErrors();
    }

    /**
     * Test booking creation with valid data
     */
    public function test_booking_can_be_created_with_valid_data(): void
    {
        $tour = Tour::factory()->create([
            'price' => 1000000,
        ]);

        $bookingData = [
            'customer_name' => 'John Doe',
            'phone' => '081234567890',
            'email' => 'john@example.com',
            'travel_date' => now()->addDays(7)->format('Y-m-d'),
            'qty' => 2,
        ];

        $response = $this->post("/checkout/{$tour->id}", $bookingData);

        // Should create booking
        $this->assertDatabaseHas('bookings', [
            'customer_name' => 'John Doe',
            'tour_id' => $tour->id,
        ]);
    }

    /**
     * Test booking status can be checked
     */
    public function test_booking_status_can_be_checked(): void
    {
        $response = $this->get('/booking-status');

        $response->assertStatus(200);
        $response->assertSee('Cek Status Booking');
    }

    /**
     * Test wishlist functionality
     */
    public function test_tour_can_be_added_to_wishlist(): void
    {
        $user = User::factory()->create();
        $tour = Tour::factory()->create();

        $response = $this->actingAs($user)
            ->post("/wishlist/toggle/{$tour->id}");

        $response->assertRedirect();
        
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'tour_id' => $tour->id,
        ]);
    }

    /**
     * Test review can be submitted
     */
    public function test_review_can_be_submitted(): void
    {
        $tour = Tour::factory()->create();

        $reviewData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'rating' => 5,
            'comment' => 'Great tour!',
        ];

        $response = $this->post("/tour/{$tour->id}/review", $reviewData);

        $this->assertDatabaseHas('reviews', [
            'tour_id' => $tour->id,
            'name' => 'Jane Doe',
            'rating' => 5,
        ]);
    }
}
