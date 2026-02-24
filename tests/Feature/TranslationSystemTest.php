<?php

namespace Tests\Feature;

use App\Models\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class TranslationSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    /** @test */
    public function it_can_translate_from_database()
    {
        Cache::flush();
        Translation::create([
            'key' => 'home_hero_title',
            'id_value' => 'Jelajahi Keindahan',
            'en_value' => 'Explore Beauty',
            'ms_value' => 'Terokai Keindahan',
            'group' => 'home',
        ]);

        App::setLocale('id');
        $this->assertEquals('Jelajahi Keindahan', __t('home_hero_title'));

        App::setLocale('en');
        $this->assertEquals('Explore Beauty', __t('home_hero_title'));
    }

    /** @test */
    public function it_falls_back_to_laravel_default_if_key_missing_in_db()
    {
        // No translation in DB
        App::setLocale('en');
        // Assuming 'pagination.next' exists in default Laravel lang files
        $this->assertEquals(__('pagination.next'), __t('pagination.next'));
    }

    /** @test */
    public function it_replaces_placeholders()
    {
        Translation::create([
            'key' => 'welcome_user',
            'en_value' => 'Welcome, :name!',
            'id_value' => 'Selamat datang, :name!',
            'ms_value' => 'Selamat datang, :name!',
        ]);

        $this->assertEquals('Welcome, John!', __t('welcome_user', ['name' => 'John'], 'en'));
        $this->assertEquals('Selamat datang, Budi!', __t('welcome_user', ['name' => 'Budi'], 'id'));
    }

    /** @test */
    public function it_can_switch_language_via_route()
    {
        $response = $this->get('/lang/id');

        $response->assertRedirect();
        $this->assertEquals('id', session('locale'));

        Translation::create([
            'key' => 'home_hero_title',
            'id_value' => 'Jelajahi Keindahan',
            'en_value' => 'Explore Beauty',
            'ms_value' => 'Terokai Keindahan',
            'group' => 'home',
        ]);

        $response = $this->get('/');
        $this->assertEquals('id', App::getLocale());
        $this->assertStringContainsString('Jelajahi Keindahan', $response->getContent());
    }

    /** @test */
    public function it_validates_supported_locales()
    {
        // Try to set unsupported locale
        $response = $this->get('/lang/fr');

        $response->assertRedirect();
        // Should not change to 'fr', might stay default or previous
        $this->assertNotEquals('fr', session('locale'));
    }
}
