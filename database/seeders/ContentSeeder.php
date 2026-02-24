<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Banner;
use App\Models\Car;
use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run()
    {
        // Truncate existing data to avoid duplicates
        \Schema::disableForeignKeyConstraints();
        Tour::truncate();
        Post::truncate();
        Gallery::truncate();
        Banner::truncate();
        Car::truncate();
        Hotel::truncate();
        \Schema::enableForeignKeyConstraints();

        // ═══════════════════════════════════════════════════════════
        // 1. TOUR PACKAGES (12 UNIQUE PACKAGES)
        // ═══════════════════════════════════════════════════════════

        // #1 The Grand Sumatra Heritage
        Tour::create([
            'title' => 'The Grand Sumatra Heritage: Toba - Berastagi - Medan (5D4N)',
            'slug' => Str::slug('The Grand Sumatra Heritage Toba Berastagi Medan 5D4N'),
            'description' => '<p>Nikmati perjalanan epik melintasi jantung budaya Batak dan keindahan vulkanik Sumatera Utara. Paket ini dirancang untuk kenyamanan keluarga dengan akomodasi pilihan.</p>',
            'price' => 4850000,
            'itinerary' => '<ul><li>Day 1: Airport KNO - Parapat - Niagara Hotel.</li><li>Day 2: Samosir Island Discovery (Tomok & Ambarita).</li><li>Day 3: Simarjarunjung - Sipiso-piso Waterfall - Berastagi.</li><li>Day 4: Berastagi Fruit Market - Gundaling - Medan City Tour.</li><li>Day 5: Souvenir Shopping - Airport Transfer.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1536514072410-d09633e9bf0d?q=80&w=1200',
            'location' => 'Lake Toba',
            'duration_days' => 5,
            'trips' => ['Superior' => ['price' => 4850000], 'Deluxe' => ['price' => 5550000]]
        ]);

        // #2 Jungle Expedition
        Tour::create([
            'title' => 'Wild Jungle Expedition: Bukit Lawang Orangutan Trekking (3D2N)',
            'slug' => Str::slug('Wild Jungle Expedition Bukit Lawang Orangutan 3D2N'),
            'description' => '<p>Masuki hutan hujan tropis tertua di dunia. Jumpai Orangutan Sumatera yang cerdas di habitat alaminya dan rasakan sensasi petualangan river tubing.</p>',
            'price' => 2850000,
            'itinerary' => '<ul><li>Day 1: Medan - Bukit Lawang - Eco Lodge Check-in.</li><li>Day 2: Full Day Jungle Trekking & River Tubing.</li><li>Day 3: Village Tour - Return to Medan.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1544750040-4ea9b8a27d38?q=80&w=1200',
            'location' => 'Bukit Lawang',
            'duration_days' => 3,
            'trips' => ['Standard' => ['price' => 2850000], 'Private' => ['price' => 3450000]]
        ]);

        // #3 Luxury Toba Escape
        Tour::create([
            'title' => 'Lake Toba Luxury Getaway: Private Speedboat & Resort (3D2N)',
            'slug' => Str::slug('Lake Toba Luxury Getaway Private Speedboat 3D2N'),
            'description' => '<p>Privasi dan kenyamanan maksimal di tepi Kaldera. Transportasi Alphard dan akomodasi di resort bintang 5 terbaik.</p>',
            'price' => 6200000,
            'itinerary' => '<ul><li>Day 1: VIP Airport Service - Private Boat to Samosir.</li><li>Day 2: Exclusive Island Tour with Champagne Picnic.</li><li>Day 3: Spa Morning - Helicopter/VIP Car to Airport.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1200',
            'location' => 'Samosir Island',
            'duration_days' => 3,
            'trips' => ['Exclusive' => ['price' => 6200000]]
        ]);

        // #4 Tangkahan Elephant Sanctuary
        Tour::create([
            'title' => 'Tangkahan Hidden Oasis: Ethical Elephant Connection (2D1N)',
            'slug' => Str::slug('Tangkahan Hidden Oasis Ethical Elephant Experience 2D1N'),
            'description' => '<p>Interaksi yang etis dengan gajah, mandi di sungai yang jernih, dan ketenangan yang memulihkan jiwa di desa wisata terbaik.</p>',
            'price' => 2150000,
            'itinerary' => '<ul><li>Day 1: Journey through Palm Oil Plantations - Jungle Guest House.</li><li>Day 2: Morning Elephant Bathing - Hidden Waterfall Trek.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1544750040-4ea9b8a27d38?q=80&w=1200',
            'location' => 'Tangkahan',
            'duration_days' => 2,
            'trips' => ['Eco-Friendly' => ['price' => 2150000]]
        ]);

        // #5 Sibayak Sunrise Hike
        Tour::create([
            'title' => 'Sibayak Volcanic Sunrise: Hiking & Hot Springs (Day Trip)',
            'slug' => Str::slug('Sibayak Volcanic Sunrise Hiking Hot Springs 1D'),
            'description' => '<p>Saksikan matahari terbit dari puncak gunung berapi aktif dan relaksasi di kolam belerang alami Berastagi.</p>',
            'price' => 850000,
            'itinerary' => '<ul><li>02:00: Pick up Medan.</li><li>04:30: Start Trekking Sibayak.</li><li>06:00: Sunrise View.</li><li>09:00: Relax in Sidebuk-debuk Hot Springs.</li><li>13:00: Lunch - Fruit Market - Return.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1200',
            'location' => 'Berastagi',
            'duration_days' => 1,
            'trips' => ['Adventure' => ['price' => 850000]]
        ]);

        // #6 Medan Heritage & Street Food
        Tour::create([
            'title' => 'Medan City Heritage & Gastronomy Trail (Day Trip)',
            'slug' => Str::slug('Medan City Heritage Gastronomy Trail 1D'),
            'description' => '<p>Menelusuri sejarah kejayaan Deli dan mencicipi 10 kuliner ikonik Medan dalam satu hari penuh rasa.</p>',
            'price' => 650000,
            'itinerary' => '<ul><li>09:00: Maimoon Palace & Grand Mosque.</li><li>11:00: Tjong A Fie Mansion.</li><li>12:30: Mie Acheh / Sate Kerang Lunch.</li><li>15:00: Durian Ucok Experiencing.</li><li>19:00: Kesawan City Walk Dinner.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1597430302648-24d69b35a113?q=80&w=1200',
            'location' => 'Medan',
            'duration_days' => 1,
            'trips' => ['Foodie' => ['price' => 650000]]
        ]);

        // #7 Secret Samosir Trail
        Tour::create([
            'title' => 'Secret Samosir: Sidihoni (Lake inside Lake) & Holbung Hill (2D1N)',
            'slug' => Str::slug('Secret Samosir Sidihoni Holbung Hill 2D1N'),
            'description' => '<p>Cari tahu kenapa Samosir disebut sebagai jantung spiritual Batak dengan mengunjungi danau di atas danau dan savanna terindah.</p>',
            'price' => 1750000,
            'itinerary' => '<ul><li>Day 1: Parapat to Samosir - Sidihoni Lake Trek - Sunset at Tele.</li><li>Day 2: Sunrise at Holbung Hill - Efrata Waterfall - Return.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1200',
            'location' => 'Samosir',
            'duration_days' => 2,
            'trips' => ['Explorer' => ['price' => 1750000]]
        ]);

        // #8 Waterfall Wonder
        Tour::create([
            'title' => 'Waterfall Trail: Sipiso-piso & Bah Biak Waterfall (Day Trip)',
            'slug' => Str::slug('Waterfall Trail Sipiso-piso Bah Biak 1D'),
            'description' => '<p>Perpaduan pemandangan kebun teh Sidamanik yang hijau dan kemegahan air terjun tertinggi di Indonesia.</p>',
            'price' => 750000,
            'itinerary' => '<ul><li>07:00: Depart Medan.</li><li>10:00: Sidamanik Tea Plantation & Bah Biak Waterfall.</li><li>13:00: Sipiso-piso Waterfall Viewpoint.</li><li>15:00: Lake Toba Rim Drive.</li><li>20:00: Arrive Medan.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1533240332313-0db49b459ad6?q=80&w=1200',
            'location' => 'Simalungun',
            'duration_days' => 1,
            'trips' => ['Nature' => ['price' => 750000]]
        ]);

        // #9 Sumatra Coffee Tour
        Tour::create([
            'title' => 'The Aroma of Sumatra: Coffee & Agrotourism (2D1N)',
            'slug' => Str::slug('Aroma of Sumatra Coffee Agrotourism 2D1N'),
            'description' => '<p>Belajar langsung proses "Bean to Cup" kopi Arabika terbaik dunia di Sidikalang dan nikmati udara dingin pegunungan.</p>',
            'price' => 1950000,
            'itinerary' => '<ul><li>Day 1: Medan to Dairi - Coffee Farm Visit - Plantation Stay.</li><li>Day 2: Coffee Cupping Session - Taman Simalem Resort - Return.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1200',
            'location' => 'Sidikalang',
            'duration_days' => 2,
            'trips' => ['Coffee Lover' => ['price' => 1950000]]
        ]);

        // #10 Bakkara Cultural Heart
        Tour::create([
            'title' => 'Bakkara Cultural Heart: The Valley of Kings (2D1N)',
            'slug' => Str::slug('Bakkara Cultural Heart Valley of Kings 2D1N'),
            'description' => '<p>Situs sejarah kelahiran raja-raja Batak dengan lanskap lembah yang dikelilingi perbukitan hijau dan sungai jernih.</p>',
            'price' => 1850000,
            'itinerary' => '<ul><li>Day 1: Medan to Bakkara - King Sisingamangaraja Palace Site - Aek Sipangolu.</li><li>Day 2: Riverside Relax - Tipang Village - Return via Muara.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1200',
            'location' => 'Humbang Hasundutan',
            'duration_days' => 2,
            'trips' => ['History' => ['price' => 1850000]]
        ]);

        // #11 Two Colors Adventure
        Tour::create([
            'title' => 'Two Colors Canyon: Sibolangit Jungle Trekking (Day Trip)',
            'slug' => Str::slug('Two Colors Canyon Sibolangit Trekking 1D'),
            'description' => '<p>Hidden gem di Sibolangit dengan air terjun dua warna (biru dan putih) yang terbentuk secara alami dari kawah belerang.</p>',
            'price' => 550000,
            'itinerary' => '<ul><li>08:00: Meet up Sibolangit.</li><li>09:30: Jungle Trekking (2 hours).</li><li>12:00: Swimming at Two Colors Waterfall.</li><li>16:00: Return to Entrance.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?q=80&w=1200',
            'location' => 'Sibolangit',
            'duration_days' => 1,
            'trips' => ['Physical' => ['price' => 550000]]
        ]);

        // #12 Toba Fishing & Camping
        Tour::create([
            'title' => 'Paropo Lakeside: Fishing & Camping Adventure (3D2N)',
            'slug' => Str::slug('Paropo Lakeside Fishing Camping 3D2N'),
            'description' => '<p>Rasakan malam bertabur bintang di pinggir danau dengan api unggun, kegiatan memancing, dan memasak ikan bakar segar.</p>',
            'price' => 1450000,
            'itinerary' => '<ul><li>Day 1: Medan to Paropo - Tent Setup - Fishing Session.</li><li>Day 2: Morning Canoe - Hiking Siadtaratas - BBQ Night.</li><li>Day 3: Sunrise Relax - Packing - Return.</li></ul>',
            'thumbnail' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=1200',
            'location' => 'Paropo',
            'duration_days' => 3,
            'trips' => ['Camper' => ['price' => 1450000]]
        ]);

        // ═══════════════════════════════════════════════════════════
        // 2. BLOG POSTS (8 PROFESSIONAL ARTICLES)
        // ═══════════════════════════════════════════════════════════

        $blogs = [
            [
                'title' => '10 Spot Foto Paling Instagrammable di Danau Toba 2026',
                'category' => 'Destinasi',
                'thumb' => 'https://images.unsplash.com/photo-1536514072410-d09633e9bf0d?q=80&w=1200',
                'content' => '<h2>Mulai dari Bukit Holbung hingga Huta Siallagan</h2><p>Danau Toba menyajikan sejuta sudut pandang yang unik. Tahun ini, beberapa spot muncul sebagai favorit para fotografer profesional...</p>'
            ],
            [
                'title' => 'Panduan Lengkap Jungle Trekking di Bukit Lawang',
                'category' => 'Tips & Trick',
                'thumb' => 'https://images.unsplash.com/photo-1544750040-4ea9b8a27d38?q=80&w=1200',
                'content' => '<h2>Persiapan Mental dan Fisik Sebelum Bertemu Orangutan</h2><p>Mendaki di hutan hujan tropis memerlukan perlengkapan khusus. Pastikan Anda membawa sepatu trekking yang anti selip dan repellent anti nyamuk...</p>'
            ],
            [
                'title' => 'Rute Kuliner Medan: 24 Jam Non-Stop Mencari Rasa',
                'category' => 'Kuliner',
                'thumb' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200',
                'content' => '<h2>Daftar Wajib: Dari Durian Hingga Bihun Bebek</h2><p>Medan adalah surga gastromoni. Perjalanan Anda tidak akan lengkap tanpa mencicipi Sate Memeng legendaris atau Bolu Meranti...</p>'
            ],
            [
                'title' => 'Mengapa Tangkahan Disebut "The Hidden Paradise" Sumatera',
                'category' => 'Destinasi',
                'thumb' => 'https://images.unsplash.com/photo-1590424753858-3b6112ca92fd?q=80&w=1200',
                'content' => '<h2>Ketenangan yang Tidak Akan Anda Temukan di Kota</h2><p>Tangkahan menawarkan kedamaian yang otentik. Tidak ada sinyal kuat, hanya suara air sungai dan kicauan burung yang menemani tidur Anda...</p>'
            ],
            [
                'title' => '5 Alasan Memilih Sewa Mobil dengan Supir di Sumatera Utara',
                'category' => 'Panduan',
                'thumb' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1200',
                'content' => '<h2>Keamanan dan Kenyamanan Adalah Kunci Utama Traveling</h2><p>Medan dan sekitarnya memiliki topografi perbukitan. Memilih supir lokal yang berpengalaman akan membuat perjalanan Anda jauh lebih tenang...</p>'
            ],
            [
                'title' => 'Mengenal Budaya Batak Lewat Arsitektur Rumah Bolon',
                'category' => 'Budaya',
                'thumb' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=1200',
                'content' => '<h2>Filosofi di Balik Ukiran Gorga yang Rumit</h2><p>Setiap ukiran pada Rumah Bolon memiliki makna spiritual dan sosial yang mendalam bagi masyarakat etnis Batak Simalungun maupun Toba...</p>'
            ],
            [
                'title' => 'Misteri Batu Gantung: Legenda Cinta di Balik Parapat',
                'category' => 'Budaya',
                'thumb' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=1200',
                'content' => '<h2>Kisah Sedih Seruni dan Kesetian Sang Anjing</h2><p>Wisatawan yang menyeberang ke Samosir pasti akan melihat pahatan batu menyerupai manusia yang menggantung di dinding tebing...</p>'
            ],
            [
                'title' => 'Hiking Mount Sibayak: Cocok Bagi Pendaki Pemula',
                'category' => 'Tips & Trick',
                'thumb' => 'https://images.unsplash.com/photo-1533240332313-0db49b459ad6?q=80&w=1200',
                'content' => '<h2>Waktu Terbaik Mendaki Seberlum Fajar Menyingsing</h2><p>Hanya memerlukan waktu sekitar 1,5 hingga 2 jam, Sibayak menawarkan pemandangan sunset dan kawah yang sangat dramatis...</p>'
            ],
        ];

        foreach ($blogs as $blog) {
            Post::create([
                'title' => $blog['title'],
                'slug' => Str::slug($blog['title']),
                'thumbnail' => $blog['thumb'],
                'category' => $blog['category'],
                'content' => $blog['content'],
                'is_published' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════
        // 3. GALLERY (20 CURATED ITEMS)
        // ═══════════════════════════════════════════════════════════

        $galleries = [
            ['title' => 'Sunrise at Bukit Holbung', 'cat' => 'Destinasi', 'url' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=1200'],
            ['title' => 'Batak Traditional Dance', 'cat' => 'Budaya', 'url' => 'https://images.unsplash.com/photo-1588619623838-f1f3e0996841?q=80&w=1200'],
            ['title' => 'Orangutan Mother & Baby', 'cat' => 'Satwa', 'url' => 'https://images.unsplash.com/photo-1544750040-4ea9b8a27d38?q=80&w=1200'],
            ['title' => 'Sipiso-piso Waterfall', 'cat' => 'Alam', 'url' => 'https://images.unsplash.com/photo-1596402184320-417d7178b2cd?q=80&w=1200'],
            ['title' => 'Luxury Tent in Tangkahan', 'cat' => 'Aktivitas', 'url' => 'https://images.unsplash.com/photo-1501783063441-13e882ad2c8a?q=80&w=1200'],
            ['title' => 'Medan City Grand Mosque', 'cat' => 'Arsitektur', 'url' => 'https://images.unsplash.com/photo-1596402184320-417d7178b2cd?q=80&w=1200'],
            ['title' => 'Elephant Bathing Fun', 'cat' => 'Satwa', 'url' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?q=80&w=1200'],
            ['title' => 'Lake Toba Morning Mist', 'cat' => 'Pemandangan', 'url' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=1200'],
            ['title' => 'Canoeing in Parapat', 'cat' => 'Aktivitas', 'url' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=1200'],
            ['title' => 'Mie Aceh Spices', 'cat' => 'Kuliner', 'url' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200'],
            ['title' => 'Mount Sibayak Crater', 'cat' => 'Alam', 'url' => 'https://images.unsplash.com/photo-1533240332313-0db49b459ad6?q=80&w=1200'],
            ['title' => 'Jabu Bolon Details', 'cat' => 'Budaya', 'url' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?q=80&w=1200'],
            ['title' => 'Sidamanik Tea Garden', 'cat' => 'Destinasi', 'url' => 'https://images.unsplash.com/photo-1527689368864-3a821dbccc34?q=80&w=1200'],
            ['title' => 'Bakkara Valley View', 'cat' => 'Pemandangan', 'url' => 'https://images.unsplash.com/photo-1501783063441-13e882ad2c8a?q=80&w=1200'],
            ['title' => 'Tjong A Fie Interiors', 'cat' => 'Arsitektur', 'url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=1200'],
            ['title' => 'Durian Ucok Stall', 'cat' => 'Kuliner', 'url' => 'https://images.unsplash.com/photo-1505575967455-40e256f7377c?q=80&w=1200'],
            ['title' => 'Waterfall at Two Colors', 'cat' => 'Alam', 'url' => 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?q=80&w=1200'],
            ['title' => 'Samosir Sunset Reflection', 'cat' => 'Pemandangan', 'url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1200'],
            ['title' => 'Night Camping at Paropo', 'cat' => 'Aktivitas', 'url' => 'https://images.unsplash.com/photo-1510312305653-8ed496efbe75?q=80&w=1200'],
            ['title' => 'Sidihoni Sacred Lake', 'cat' => 'Destinasi', 'url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1200'],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create([
                'title' => $gallery['title'],
                'category' => $gallery['cat'],
                'image_url' => $gallery['url'],
                'is_active' => true,
            ]);
        }

        // ═══════════════════════════════════════════════════════════
        // 4. CAR FLEET (10 PREMIUM CARS)
        // ═══════════════════════════════════════════════════════════

        $cars = [
            ['name' => 'Toyota Innova Reborn', 'brand' => 'Toyota', 'cap' => 7, 'price' => 850000, 'img' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1200'],
            ['name' => 'Toyota Alphard VIP', 'brand' => 'Toyota', 'cap' => 6, 'price' => 2800000, 'img' => 'https://images.unsplash.com/photo-1619682817481-e994891cd1f5?q=80&w=1200'],
            ['name' => 'Toyota Fortuner GR Sport', 'brand' => 'Toyota', 'cap' => 7, 'price' => 1700000, 'img' => 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?q=80&w=1200'],
            ['name' => 'Toyota Hiace Premio', 'brand' => 'Toyota', 'cap' => 9, 'price' => 1850000, 'img' => 'https://images.unsplash.com/photo-1511704976822-4a0b25e11c6d?q=80&w=1200'],
            ['name' => 'Mitsubishi Xpander', 'brand' => 'Mitsubishi', 'cap' => 6, 'price' => 650000, 'img' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=1200'],
            ['name' => 'Toyota Avanza 2024', 'brand' => 'Toyota', 'cap' => 6, 'price' => 600000, 'img' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1200'],
            ['name' => 'Pajero Sport 4x4', 'brand' => 'Mitsubishi', 'cap' => 7, 'price' => 1750000, 'img' => 'https://images.unsplash.com/photo-1532581291347-9c39cf10a73c?q=80&w=1200'],
            ['name' => 'Toyota Camry VIP', 'brand' => 'Toyota', 'cap' => 4, 'price' => 2200000, 'img' => 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?q=80&w=1200'],
            ['name' => 'Luxury Bus 25-Seat', 'brand' => 'Mercedes', 'cap' => 25, 'price' => 3500000, 'img' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=1200'],
            ['name' => 'Big Bus 45-Seat', 'brand' => 'Hino', 'cap' => 45, 'price' => 4500000, 'img' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=1200'],
        ];

        foreach ($cars as $car) {
            Car::create([
                'name' => $car['name'],
                'slug' => Str::slug($car['name']),
                'brand' => $car['brand'],
                'capacity' => $car['cap'],
                'price_per_day' => $car['price'],
                'thumbnail' => $car['img'],
                'is_available' => true,
                'jenis_mobil' => 'Premium',
                'transmission' => 'Automatic',
            ]);
        }

        // ═══════════════════════════════════════════════════════════
        // 5. HOTELS (10 SELECTIONS)
        // ═══════════════════════════════════════════════════════════

        $hotels = [
            ['name' => 'JW Marriott Hotel Medan', 'loc' => 'Medan', 'cat' => 'Luxury 5*'],
            ['name' => 'Niagara Hotel Parapat', 'loc' => 'Parapat', 'cat' => 'Bintang 4'],
            ['name' => 'Samosir Villas Resort', 'loc' => 'Samosir', 'cat' => 'Luxury Resort'],
            ['name' => 'Taman Simalem Resort', 'loc' => 'Merek', 'cat' => 'Eco Luxury'],
            ['name' => 'Sinabung Hills Berastagi', 'loc' => 'Berastagi', 'cat' => 'Bintang 4'],
            ['name' => 'Marianna Resort Samosir', 'loc' => 'Samosir', 'cat' => 'Resort 5*'],
            ['name' => 'Santika Premiere Dyandra', 'loc' => 'Medan', 'cat' => 'Bintang 4'],
            ['name' => 'Mikie Holiday Resort', 'loc' => 'Berastagi', 'cat' => 'Family Resort'],
            ['name' => 'The Madani Hotel', 'loc' => 'Medan', 'cat' => 'Sharia Luxury'],
            ['name' => 'Debang Resort', 'loc' => 'Silalahi', 'cat' => 'Bintang 3'],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create([
                'name' => $hotel['name'],
                'location' => $hotel['loc'],
                'category' => $hotel['cat'],
                'is_active' => true,
            ]);
        }

        // Banner
        Banner::create([
            'title' => 'Eksplorasi Tak Terbatas Sumatera Utara',
            'subtitle' => 'Temukan keajaiban Kaldera Toba hingga liar-nya hutan Bukit Lawang bersama partner terpercaya.',
            'image' => 'https://images.unsplash.com/photo-1544750040-4ea9b8a27d38?q=80&w=1200',
            'button_text' => 'Pilih Paket Anda',
            'button_link' => '/#tours',
            'position' => 'hero',
            'is_active' => true,
        ]);
    }
}
