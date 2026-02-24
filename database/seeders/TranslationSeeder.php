<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run()
    {
        // Translation::truncate(); // Commented out to prevent accidental data loss of admin-added translations

        $translations = [
            [
                'key' => 'home_badge',
                'id_value' => 'Travel Partner Terbaik 2026',
                'en_value' => 'The Best Travel Partner 2026',
                'ms_value' => 'Rakan Pelancongan Terbaik 2026',
                'group' => 'home'
            ],
            [
                'key' => 'home_hero_title',
                'id_value' => 'Jelajahi Keindahan Sumatera Utara Bersama Kami',
                'en_value' => 'Explore the Beauty of North Sumatra with Us',
                'ms_value' => 'Terokai Keindahan Sumatera Utara Bersama Kami',
                'group' => 'home'
            ],
            [
                'key' => 'home_hero_subtitle',
                'id_value' => 'Solusi perjalanan wisata profesional untuk Danau Toba, Berastagi, Bukit Lawang, dan sekitarnya.',
                'en_value' => 'Professional travel solutions for Lake Toba, Berastagi, Bukit Lawang, and surrounding areas.',
                'ms_value' => 'Penyelesaian pelancongan profesional untuk Tasik Toba, Berastagi, Bukit Lawang, dan kawasan sekitar.',
                'group' => 'home'
            ],
            [
                'key' => 'home_cta_booking',
                'id_value' => 'Pesan Sekarang',
                'en_value' => 'Book Now',
                'ms_value' => 'Tempah Sekarang',
                'group' => 'home'
            ],
            [
                'key' => 'nav_rental',
                'id_value' => 'Sewa Mobil',
                'en_value' => 'Car Rental',
                'ms_value' => 'Sewa Kereta',
                'group' => 'nav'
            ],
            [
                'key' => 'home_popular_tours',
                'id_value' => 'Paket Tour Terpopuler',
                'en_value' => 'Most Popular Tour Packages',
                'ms_value' => 'Pakej Pelancongan Paling Popular',
                'group' => 'home'
            ],
            [
                'key' => 'home_popular_tours_subtitle',
                'id_value' => 'Pilih dari berbagai paket wisata yang telah kami kurasi khusus untuk kenyamanan dan pengalaman tak terlupakan Anda.',
                'en_value' => 'Choose from various tour packages that we have curated specifically for your comfort and unforgettable experience.',
                'ms_value' => 'Pilih daripada pelbagai pakej pelancongan yang telah kami kurasi khas untuk keselesaan dan pengalaman yang tidak dapat dilupakan.',
                'group' => 'home'
            ],
            [
                'key' => 'home_link_all_packages',
                'id_value' => 'Lihat Semua Paket',
                'en_value' => 'View All Packages',
                'ms_value' => 'Lihat Semua Pakej',
                'group' => 'home'
            ],
            [
                'key' => 'home_gallery_title',
                'id_value' => 'Galeri Wisata',
                'en_value' => 'Travel Gallery',
                'ms_value' => 'Galeri Pelancongan',
                'group' => 'home'
            ],
            [
                'key' => 'home_gallery_subtitle',
                'id_value' => 'Kilasan keindahan alam dan momen berharga tamu selama menjelajahi Sumatera Utara.',
                'en_value' => 'A glimpse of natural beauty and precious moments of guests exploring North Sumatra.',
                'ms_value' => 'Sekilas keindahan semula jadi dan detik berharga tetamu menerokai Sumatera Utara.',
                'group' => 'home'
            ],
            [
                'key' => 'home_cta_title',
                'id_value' => 'Sudah Siap Menciptakan Momen Berharga?',
                'en_value' => 'Ready to Create Precious Moments?',
                'ms_value' => 'Sedia untuk Mencipta Detik Berharga?',
                'group' => 'home'
            ],
            [
                'key' => 'home_cta_subtitle',
                'id_value' => 'Konsultasikan rencana perjalanan Anda bersama tim profesional kami secara gratis via WhatsApp.',
                'en_value' => 'Consult your travel plans with our professional team for free via WhatsApp.',
                'ms_value' => 'Rujuk pelan pelancongan anda dengan pasukan profesional kami secara percuma melalui WhatsApp.',
                'group' => 'home'
            ],
            [
                'key' => 'home_cta_button',
                'id_value' => 'Konsultasi Gratis',
                'en_value' => 'Free Consultation',
                'ms_value' => 'Konsultasi Percuma',
                'group' => 'home'
            ],
            [
                'key' => 'nav_home',
                'id_value' => 'Utama',
                'en_value' => 'Home',
                'ms_value' => 'Utama',
                'group' => 'nav'
            ],
            [
                'key' => 'nav_packages',
                'id_value' => 'Paket Wisata',
                'en_value' => 'Packages',
                'ms_value' => 'Pakej',
                'group' => 'nav'
            ],
            [
                'key' => 'nav_gallery',
                'id_value' => 'Galeri',
                'en_value' => 'Gallery',
                'ms_value' => 'Galeri',
                'group' => 'nav'
            ],
            [
                'group' => 'nav'
            ],
            [
                'key' => 'nav_blog',
                'id_value' => 'Blog',
                'en_value' => 'Blog',
                'ms_value' => 'Blog',
                'group' => 'nav'
            ],
            [
                'key' => 'dashboard_welcome',
                'id_value' => 'Selamat Datang, :name',
                'en_value' => 'Welcome back, :name',
                'ms_value' => 'Selamat Datang, :name',
                'group' => 'dashboard'
            ],
            [
                'key' => 'dashboard_stat_total',
                'id_value' => 'Total Pesanan',
                'en_value' => 'Total Bookings',
                'ms_value' => 'Jumlah Tempahan',
                'group' => 'dashboard'
            ],
            [
                'key' => 'dashboard_stat_completed',
                'id_value' => 'Selesai Dibayar',
                'en_value' => 'Paid Bookings',
                'ms_value' => 'Telah Dibayar',
                'group' => 'dashboard'
            ],
            [
                'key' => 'dashboard_stat_pending',
                'id_value' => 'Menunggu Pembayaran',
                'en_value' => 'Pending Payment',
                'ms_value' => 'Menunggu Bayaran',
                'group' => 'dashboard'
            ],
            [
                'key' => 'dashboard_table_title_1',
                'id_value' => 'Riwayat',
                'en_value' => 'Booking',
                'ms_value' => 'Rekod',
                'group' => 'dashboard'
            ],
            [
                'key' => 'dashboard_table_title_2',
                'id_value' => 'Perjalanan',
                'en_value' => 'History',
                'ms_value' => 'Tempahan',
                'group' => 'dashboard'
            ],
            // Packages Page
            [
                'key' => 'packages_title_1',
                'id_value' => 'Paket',
                'en_value' => 'Tour',
                'ms_value' => 'Pakej',
                'group' => 'packages'
            ],
            [
                'key' => 'packages_title_2',
                'id_value' => 'Wisata',
                'en_value' => 'Packages',
                'ms_value' => 'Pelancongan',
                'group' => 'packages'
            ],
            [
                'key' => 'packages_subtitle',
                'id_value' => 'Pilih paket liburan impian Anda dengan layanan terbaik dan harga terjangkau.',
                'en_value' => 'Choose your dream holiday package with the best service and affordable prices.',
                'ms_value' => 'Pilih pakej percutian impian anda dengan perkhidmatan terbaik dan harga berpatutan.',
                'group' => 'packages'
            ],
            [
                'key' => 'packages_search_placeholder',
                'id_value' => 'Cari destinasi atau paket wisata...',
                'en_value' => 'Search destinations or tour packages...',
                'ms_value' => 'Cari destinasi atau pakej pelancongan...',
                'group' => 'packages'
            ],
            [
                'key' => 'packages_search_button',
                'id_value' => 'Cari',
                'en_value' => 'Search',
                'ms_value' => 'Cari',
                'group' => 'packages'
            ],
            [
                'key' => 'packages_label_starting_from',
                'id_value' => 'Mulai Dari',
                'en_value' => 'Starting From',
                'ms_value' => 'Bermula Dari',
                'group' => 'packages'
            ],
            [
                'key' => 'packages_empty_state',
                'id_value' => 'Tidak ada paket wisata ditemukan',
                'en_value' => 'No tour packages found',
                'ms_value' => 'Tiada pakej pelancongan ditemui',
                'group' => 'packages'
            ],
            // Rental Page
            [
                'key' => 'rental_badge',
                'id_value' => 'Armada Premium & Transportasi',
                'en_value' => 'Premium Fleet & Transport',
                'ms_value' => 'Armada Premium & Pengangkutan',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_title_1',
                'id_value' => 'Sewa',
                'en_value' => 'Car',
                'ms_value' => 'Sewa',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_title_2',
                'id_value' => 'Mobil',
                'en_value' => 'Rental',
                'ms_value' => 'Kereta',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_subtitle',
                'id_value' => 'Armada terbaru dengan kondisi prima dan supir profesional untuk kenyamanan perjalanan Anda di Sumatera Utara.',
                'en_value' => 'The latest fleet in prime condition and professional drivers for your travel comfort in North Sumatra.',
                'ms_value' => 'Armada terbaru dengan keadaan prima dan pemandu profesional untuk keselesaan perjalanan anda di Sumatera Utara.',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_label_capacity',
                'id_value' => 'Penumpang',
                'en_value' => 'Passengers',
                'ms_value' => 'Penumpang',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_feature_ac',
                'id_value' => 'Full AC',
                'en_value' => 'Full AC',
                'ms_value' => 'AC Penuh',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_feature_driver',
                'id_value' => 'Supir',
                'en_value' => 'Driver',
                'ms_value' => 'Pemandu',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_feature_fuel',
                'id_value' => 'BBM',
                'en_value' => 'Fuel',
                'ms_value' => 'BBM',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_label_price',
                'id_value' => 'Harga Sewa',
                'en_value' => 'Rental Price',
                'ms_value' => 'Harga Sewa',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_label_per_day',
                'id_value' => '/hari',
                'en_value' => '/day',
                'ms_value' => '/hari',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_info_title_1',
                'id_value' => 'Butuh Kapasitas',
                'en_value' => 'Need More',
                'ms_value' => 'Perlukan Kapasiti',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_info_title_2',
                'id_value' => 'Lebih Besar?',
                'en_value' => 'Capacity?',
                'ms_value' => 'Lebih Besar?',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_info_subtitle',
                'id_value' => 'Kami juga menyediakan Bus Pariwisata & Hiace Luxury untuk rombongan keluarga atau kantor. Hubungi kami untuk penawaran harga spesial.',
                'en_value' => 'We also provide Tourist Buses & Hiace Luxury for family or office groups. Contact us for special price offers.',
                'ms_value' => 'Kami juga menyediakan Bas Pelancongan & Hiace Luxury untuk rombongan keluarga atau pejabat. Hubungi kami untuk tawaran harga istimewa.',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_button_consultation',
                'id_value' => 'Konsultasi Gratis',
                'en_value' => 'Free Consultation',
                'ms_value' => 'Konsultasi Percuma',
                'group' => 'rental'
            ],
            [
                'key' => 'rental_button_whatsapp',
                'id_value' => 'Hubungi WhatsApp',
                'en_value' => 'Contact WhatsApp',
                'ms_value' => 'Hubungi WhatsApp',
                'group' => 'rental'
            ],
            // Gallery Page
            [
                'key' => 'gallery_title_1',
                'id_value' => 'Galeri',
                'en_value' => 'Travel',
                'ms_value' => 'Galeri',
                'group' => 'gallery'
            ],
            [
                'key' => 'gallery_title_2',
                'id_value' => 'Wisata',
                'en_value' => 'Gallery',
                'ms_value' => 'Pelancongan',
                'group' => 'gallery'
            ],
            [
                'key' => 'gallery_subtitle',
                'id_value' => 'Jelajahi keindahan alam dan budaya Sumatera Utara melalui lensa kamera kami.',
                'en_value' => 'Explore the natural beauty and culture of North Sumatra through our camera lens.',
                'ms_value' => 'Terokai keindahan semula jadi dan budaya Sumatera Utara melalui lensa kamera kami.',
                'group' => 'gallery'
            ],
            [
                'key' => 'gallery_all_categories',
                'id_value' => 'Semua Kategori',
                'en_value' => 'All Categories',
                'ms_value' => 'Semua Kategori',
                'group' => 'gallery'
            ],
            [
                'key' => 'gallery_empty_state',
                'id_value' => 'Tidak ada foto dalam kategori ini',
                'en_value' => 'No photos in this category',
                'ms_value' => 'Tiada foto dalam kategori ini',
                'group' => 'gallery'
            ],
            // Contact Page
            [
                'key' => 'contact_badge',
                'id_value' => 'Hubungi Kami',
                'en_value' => 'Get In Touch',
                'ms_value' => 'Hubungi Kami',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_title_1',
                'id_value' => 'Hubungi',
                'en_value' => 'Contact',
                'ms_value' => 'Hubungi',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_title_2',
                'id_value' => 'Kami',
                'en_value' => 'Us',
                'ms_value' => 'Kami',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_subtitle',
                'id_value' => 'Punya pertanyaan atau ingin kustomisasi paket? Tim kami siap membantu Anda 24/7.',
                'en_value' => 'Have questions or want to customize a package? Our team is ready to help you 24/7.',
                'ms_value' => 'Ada soalan atau ingin menyesuaikan pakej? Pasukan kami sedia membantu anda 24/7.',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_form_title',
                'id_value' => 'Kirim Pesan',
                'en_value' => 'Send Message',
                'ms_value' => 'Hantar Mesej',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_label_name',
                'id_value' => 'Nama Lengkap',
                'en_value' => 'Full Name',
                'ms_value' => 'Nama Penuh',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_placeholder_name',
                'id_value' => 'Nama Anda',
                'en_value' => 'Your Name',
                'ms_value' => 'Nama Anda',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_label_email',
                'id_value' => 'Alamat Email',
                'en_value' => 'Email Address',
                'ms_value' => 'Alamat Emel',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_placeholder_email',
                'id_value' => 'email@contoh.com',
                'en_value' => 'email@example.com',
                'ms_value' => 'emel@contoh.com',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_label_subject',
                'id_value' => 'Subjek',
                'en_value' => 'Subject',
                'ms_value' => 'Subjek',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_subject_option_1',
                'id_value' => 'Tanya Paket Wisata',
                'en_value' => 'Inquire Tour Package',
                'ms_value' => 'Tanya Pakej Pelancongan',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_subject_option_2',
                'id_value' => 'Sewa Mobil',
                'en_value' => 'Car Rental',
                'ms_value' => 'Sewa Kereta',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_subject_option_3',
                'id_value' => 'Kustom Perjalanan',
                'en_value' => 'Custom Trip',
                'ms_value' => 'Tersuai Perjalanan',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_subject_option_4',
                'id_value' => 'Kerjasama',
                'en_value' => 'Partnership',
                'ms_value' => 'Kerjasama',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_subject_option_5',
                'id_value' => 'Lainnya',
                'en_value' => 'Others',
                'ms_value' => 'Lain-lain',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_label_message',
                'id_value' => 'Pesan Anda',
                'en_value' => 'Your Message',
                'ms_value' => 'Mesej Anda',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_placeholder_message',
                'id_value' => 'Bagaimana kami bisa membantu Anda?',
                'en_value' => 'How can we help you?',
                'ms_value' => 'Bagaimana kami boleh membantu anda?',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_button_send',
                'id_value' => 'Kirim Pesan',
                'en_value' => 'Send Message',
                'ms_value' => 'Hantar Mesej',
                'group' => 'contact'
            ],
            // Wishlist Page
            [
                'key' => 'wishlist_title_1',
                'id_value' => 'Wishlist',
                'en_value' => 'My',
                'ms_value' => 'Wishlist',
                'group' => 'wishlist'
            ],
            [
                'key' => 'wishlist_title_2',
                'id_value' => 'Saya',
                'en_value' => 'Wishlist',
                'ms_value' => 'Saya',
                'group' => 'wishlist'
            ],
            [
                'key' => 'wishlist_subtitle',
                'id_value' => 'Simpan paket wisata impian Anda dan pesan kapan saja.',
                'en_value' => 'Save your dream tour packages and book anytime.',
                'ms_value' => 'Simpan pakej pelancongan impian anda dan tempah pada bila-bila masa.',
                'group' => 'wishlist'
            ],
            [
                'key' => 'wishlist_empty_title',
                'id_value' => 'Wishlist Anda Kosong',
                'en_value' => 'Your Wishlist is Empty',
                'ms_value' => 'Wishlist Anda Kosong',
                'group' => 'wishlist'
            ],
            [
                'key' => 'wishlist_empty_subtitle',
                'id_value' => 'Anda belum menyimpan paket wisata atau sewa mobil apapun. Jelajahi pilihan kami dan simpan yang Anda sukai!',
                'en_value' => "You haven't saved any tour packages or car rentals yet. Explore our options and save what you like!",
                'ms_value' => 'Anda belum menyimpan sebarang pakej pelancongan atau sewa kereta lagi. Terokai pilihan kami dan simpan yang anda suka!',
                'group' => 'wishlist'
            ],
            [
                'key' => 'wishlist_label_price',
                'id_value' => 'Mulai Dari',
                'en_value' => 'Starting From',
                'ms_value' => 'Bermula Dari',
                'group' => 'wishlist'
            ],
            [
                'key' => 'wishlist_label_tour',
                'id_value' => 'WISATA',
                'en_value' => 'TOUR',
                'ms_value' => 'PELANCONGAN',
                'group' => 'wishlist'
            ],
            [
                'key' => 'wishlist_label_rental',
                'id_value' => 'RENTAL',
                'en_value' => 'RENTAL',
                'ms_value' => 'SEWA',
                'group' => 'wishlist'
            ],
            // Footer
            [
                'key' => 'footer_description',
                'id_value' => 'Solusi perjalanan wisata profesional untuk menjelajahi keindahan Danau Toba, Berastagi, dan Bukit Lawang dengan layanan eksklusif dan terpercaya.',
                'en_value' => 'Professional travel solutions to explore the beauty of Lake Toba, Berastagi, and Bukit Lawang with exclusive and trusted services.',
                'ms_value' => 'Penyelesaian pelancongan profesional untuk meneroka keindahan Tasik Toba, Berastagi, dan Bukit Lawang dengan perkhidmatan eksklusif dan dipercayai.',
                'group' => 'footer'
            ],
            [
                'key' => 'footer_address_title',
                'id_value' => 'Alamat Kami',
                'en_value' => 'Our Address',
                'ms_value' => 'Alamat Kami',
                'group' => 'footer'
            ],
            [
                'key' => 'footer_legal_terms',
                'id_value' => 'Syarat & Ketentuan',
                'en_value' => 'Terms & Conditions',
                'ms_value' => 'Terma & Syarat',
                'group' => 'footer'
            ],
            [
                'key' => 'footer_legal_privacy',
                'id_value' => 'Kebijakan Privasi',
                'en_value' => 'Privacy Policy',
                'ms_value' => 'Dasar Privasi',
                'group' => 'footer'
            ],
        ];

        foreach ($translations as $translation) {
            Translation::updateOrCreate(
                ['key' => $translation['key']],
                $translation
            );
        }
    }
}
