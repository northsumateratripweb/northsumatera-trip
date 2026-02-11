<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>NorthSumateraTrip | Solusi Perjalanan Wisata Sumatera Utara</title>
    <meta name="description" content="Portal wisata profesional untuk menjelajahi keindahan Danau Toba, Berastagi, dan Bukit Lawang.">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          darkMode: 'class',
          theme: {
            extend: {
              colors: {
                clifford: '#da373d',
              }
            }
          }
        }
    </script>

    <style>
        /* Custom Animations & Styles */
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 0.8s ease-out forwards; }
        .glass { background: rgba(22, 22, 21, 0.8); backdrop-filter: blur(12px); }
        .text-gradient { background: linear-gradient(to right, #FF4433, #f53003); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #3E3E3A; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #FF4433; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-[#EDEDEC] antialiased font-['Instrument_Sans']">

    <nav class="fixed w-full z-[100] border-b border-[#3E3E3A] glass transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-extrabold tracking-tighter">
                        NorthSumatera<span class="text-[#FF4433]">Trip</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-sm font-medium hover:text-[#FF4433]">{{ __('common.home') }}</a>
                    <a href="#tours" class="text-sm font-medium hover:text-[#FF4433]">{{ __('common.tours') }}</a>
                    <a href="#rental" class="text-sm font-medium hover:text-[#FF4433]">{{ __('common.car_rental') }}</a>
                    <a href="#gallery" class="text-sm font-medium hover:text-[#FF4433]">{{ __('common.gallery') }}</a>
                    <a href="#contact" class="text-sm font-medium hover:text-[#FF4433]">{{ __('common.contact') }}</a>
                </div>
                
                <div class="flex items-center gap-4">
                    <x-language-switcher />
                    <a href="/admin" class="bg-[#FF4433] px-6 py-2 rounded-full text-sm font-bold">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-[#FF4433]/10 blur-[150px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-[#1D0002]/40 blur-[150px] rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#161615] border border-[#3E3E3A] mb-8 animate-fade-up">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF4433] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FF4433]"></span>
                </span>
                <span class="text-xs font-bold uppercase tracking-widest text-[#A1A09A]">Open Booking 2026</span>
            </div>
            
            <h1 class="text-6xl md:text-8xl font-black mb-8 leading-[1.1] animate-fade-up" style="animation-delay: 0.1s">
                Jelajahi <span class="text-gradient">Eksotisme</span> <br>Sumatera Utara
            </h1>
            
            <p class="max-w-2xl mx-auto text-lg md:text-xl text-[#A1A09A] mb-12 leading-relaxed animate-fade-up" style="animation-delay: 0.2s">
                Partner perjalanan terpercaya untuk mengeksplorasi destinasi ikonik di Sumatera Utara dengan layanan premium dan harga kompetitif.
            </p>

            <div class="flex flex-col md:flex-row items-center justify-center gap-4 animate-fade-up" style="animation-delay: 0.3s">
                <a href="#tours" class="w-full md:w-auto px-10 py-4 bg-white text-[#1C1C1A] rounded-xl font-bold text-lg hover:bg-[#eeeeec] transition transform hover:scale-105 shadow-2xl">
                    Pilih Paket Wisata
                </a>
                <a href="#about" class="w-full md:w-auto px-10 py-4 bg-transparent border-2 border-[#3E3E3A] text-white rounded-xl font-bold text-lg hover:border-[#FF4433] transition">
                    Pelajari Layanan
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 border-y border-[#3E3E3A] bg-[#161615]/30">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-12 text-center">
            <div>
                <div class="text-4xl font-black text-white mb-2">50+</div>
                <div class="text-sm text-[#A1A09A] uppercase tracking-widest font-bold">Destinasi</div>
            </div>
            <div>
                <div class="text-4xl font-black text-white mb-2">1k+</div>
                <div class="text-sm text-[#A1A09A] uppercase tracking-widest font-bold">Happy Travelers</div>
            </div>
            <div>
                <div class="text-4xl font-black text-white mb-2">4.9/5</div>
                <div class="text-sm text-[#A1A09A] uppercase tracking-widest font-bold">Rating</div>
            </div>
            <div>
                <div class="text-4xl font-black text-white mb-2">24/7</div>
                <div class="text-sm text-[#A1A09A] uppercase tracking-widest font-bold">Support</div>
            </div>
        </div>
    </section>

    <section id="tours" class="py-32 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-4xl font-black mb-4">Paket Wisata <span class="text-[#FF4433]">Unggulan</span></h2>
                    <p class="text-[#A1A09A]">Dipilih secara khusus untuk memberikan pengalaman terbaik di setiap sudut Sumatera Utara.</p>
                </div>
                <div class="h-1 w-24 bg-[#FF4433] hidden md:block"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($tours as $tour)
                    <a href="{{ route('tour.show', $tour->slug) }}" class="group bg-[#161615] rounded-3xl overflow-hidden border border-[#3E3E3A] hover:border-[#FF4433]/50 transition-all duration-500 hover:-translate-y-3">
                        <div class="relative overflow-hidden aspect-[4/3]">
                            <img src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent opacity-80"></div>
                        </div>

                        <div class="p-8">
                            <div class="flex items-center text-[#FF4433] text-xs font-bold uppercase tracking-widest mb-2">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $tour->location }}
                            </div>
                            
                            <h3 class="text-2xl font-bold mb-3 group-hover:text-[#FF4433] transition-colors line-clamp-2">{{ $tour->title }}</h3>
                            
                            <div class="flex items-center gap-2 text-[#A1A09A] text-sm font-semibold">
                                <svg class="w-4 h-4 text-[#FF4433]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $tour->duration_days }} Hari
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-24 text-center bg-[#161615] rounded-[40px] border-2 border-dashed border-[#3E3E3A]">
                        <p class="text-[#A1A09A] text-xl">Database paket masih kosong, silakan input via Admin Dashboard.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="rental" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-8">Rental Mobil Medan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($cars as $car)
                <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <a href="{{ route('car.show', $car->id) }}">
                        <img src="{{ $car->thumbnail ?? '/storage/default-car.jpg' }}" alt="{{ $car->name }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-5">
                        <h3 class="text-xl font-semibold"><a href="{{ route('car.show', $car->id) }}">{{ $car->name }}</a></h3>
                        <p class="text-sm text-gray-400 mt-1">Kapasitas: {{ $car->capacity }} orang</p>
                        <p class="text-sm text-gray-400">Transmisi: {{ $car->transmission ?? '-' }}</p>
                        <p class="mt-3 text-lg font-bold">Rp {{ number_format($car->price_per_day,0,',','.') }} / hari</p>
                        <div class="mt-4">
                            <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}?text={{ urlencode('Halo, saya mau sewa ' . $car->name) }}" class="inline-block w-full text-center bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 rounded">Pesan via WhatsApp</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-32 bg-[#161615]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-4xl font-black mb-6 uppercase tracking-tighter">Kenapa Memilih <span class="text-[#FF4433]">Kami?</span></h2>
                <p class="text-[#A1A09A]">Kami menjamin kualitas setiap aspek perjalanan Anda, didukung oleh tim berpengalaman dan teknologi manajemen terkini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="p-10 rounded-[32px] bg-[#0a0a0a] border border-[#3E3E3A] hover:border-[#FF4433] transition group">
                    <div class="w-14 h-14 bg-[#FF4433]/10 text-[#FF4433] rounded-2xl flex items-center justify-center mb-8 group-hover:bg-[#FF4433] group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Tepat Waktu</h4>
                    <p class="text-[#A1A09A] text-sm leading-relaxed">Itinerari yang terencana presisi memastikan Anda tidak melewatkan momen berharga di destinasi pilihan.</p>
                </div>
                
                <div class="p-10 rounded-[32px] bg-[#0a0a0a] border border-[#3E3E3A] hover:border-[#FF4433] transition group">
                    <div class="w-14 h-14 bg-[#FF4433]/10 text-[#FF4433] rounded-2xl flex items-center justify-center mb-8 group-hover:bg-[#FF4433] group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Aman & Terpercaya</h4>
                    <p class="text-[#A1A09A] text-sm leading-relaxed">Asuransi perjalanan dan armada yang selalu prima menjadi standar operasional wajib kami.</p>
                </div>

                <div class="p-10 rounded-[32px] bg-[#0a0a0a] border border-[#3E3E3A] hover:border-[#FF4433] transition group">
                    <div class="w-14 h-14 bg-[#FF4433]/10 text-[#FF4433] rounded-2xl flex items-center justify-center mb-8 group-hover:bg-[#FF4433] group-hover:text-white transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold mb-4">Layanan Cepat</h4>
                    <p class="text-[#A1A09A] text-sm leading-relaxed">Sistem booking berbasis web terintegrasi memudahkan Anda memesan tour dalam hitungan detik.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 border-t border-[#3E3E3A]">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-black mb-12 border-l-4 border-[#FF4433] pl-4">Tips & Berita Wisata</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <div class="bg-[#161615] rounded-2xl border border-[#3E3E3A] overflow-hidden">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <span class="text-xs font-bold text-[#FF4433] uppercase">{{ $post->category }}</span>
                            <h3 class="text-xl font-bold mt-2 mb-4">{{ $post->title }}</h3>
                            <a href="{{ route('post.show', $post->slug) }}" class="text-white font-bold text-sm underline underline-offset-4 hover:text-[#FF4433] transition">Baca Selengkapnya</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-footer />

    <!-- Tour Modal -->
    <div id="tourModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
        <div class="bg-[#161615] rounded-3xl border border-[#3E3E3A] max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="sticky top-0 bg-[#161615] border-b border-[#3E3E3A] p-6 flex justify-between items-center">
                <h2 id="modalTitle" class="text-2xl font-bold text-white"></h2>
                <button onclick="closeTourModal()" class="text-[#A1A09A] hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                <!-- Trips Selection -->
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-[#A1A09A] mb-3">Pilih Trip (A-H)</label>
                    <div id="tripsContainer" class="grid grid-cols-4 gap-2">
                        <!-- Dynamically populated -->
                    </div>
                </div>

                <!-- People Count -->
                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-[#A1A09A] mb-3">Jumlah Orang</label>
                    <select id="peopleCount" class="w-full bg-[#0a0a0a] border border-[#3E3E3A] rounded-xl px-4 py-3 text-white font-bold focus:border-[#1e88e5] transition">
                        <option value="1">1 Orang</option>
                        <option value="2">2 Orang</option>
                        <option value="3">3 Orang</option>
                        <option value="4">4 Orang</option>
                        <option value="5">5 Orang</option>
                        <option value="6">6 Orang</option>
                        <option value="7">7 Orang</option>
                        <option value="8">8 Orang</option>
                    </select>
                </div>

                <!-- Price Display -->
                <div class="bg-[#0a0a0a] border border-[#3E3E3A] rounded-xl p-4">
                    <div class="flex justify-between items-center">
                        <span class="text-[#A1A09A]">Total Harga:</span>
                        <span id="totalPrice" class="text-2xl font-black text-[#FF4433]">Rp 0</span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-3">Deskripsi</h3>
                    <div id="modalDescription" class="text-[#A1A09A] text-sm leading-relaxed prose prose-invert max-w-none"></div>
                </div>

                <!-- Itinerary -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-3">Itinerari</h3>
                    <div id="modalItinerary" class="text-[#A1A09A] text-sm leading-relaxed prose prose-invert max-w-none"></div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3 pt-6 border-t border-[#3E3E3A]">
                    <button id="bookNowBtn" class="w-full bg-[#1e88e5] hover:bg-[#1565c0] text-white font-black py-4 rounded-xl transition-all transform hover:scale-[1.03] shadow-xl shadow-blue-900/20">
                        BOOK NOW
                    </button>
                    <a id="whatsappBtn" href="#" target="_blank" class="w-full bg-[#43A047] hover:bg-[#2e7d32] text-white font-black py-4 rounded-xl transition-all transform hover:scale-[1.03] text-center shadow-xl shadow-green-900/20">
                        WHATSAPP
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script>
        let currentTour = null;
        let currentTrips = null;

        function openTourModal(slug, title, days, location, url, trips) {
            currentTour = { slug, title, days, location, url };
            currentTrips = trips || {};

            document.getElementById('tourModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = `${title} (${days} Hari)`;

            // Populate trips
            const container = document.getElementById('tripsContainer');
            container.innerHTML = '';
            
            if (trips && Object.keys(trips).length > 0) {
                Object.entries(trips).forEach(([key, tripData]) => {
                    const btn = document.createElement('button');
                    btn.className = 'bg-[#3E3E3A] hover:bg-[#1e88e5] text-white font-bold py-2 rounded-lg transition trip-btn';
                    btn.textContent = key.toUpperCase();
                    btn.dataset.tripId = key;
                    btn.dataset.tripPrice = tripData.price || 0;
                    btn.onclick = (e) => selectTrip(e);
                    container.appendChild(btn);
                });
            } else {
                container.innerHTML = '<p class="col-span-4 text-[#A1A09A] text-center py-4">Tidak ada pilihan trip</p>';
            }

            // Load description and itinerary
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    document.getElementById('modalDescription').innerHTML = (doc.querySelector('[data-description]')?.innerHTML || '').substring(0, 500);
                    document.getElementById('modalItinerary').innerHTML = (doc.querySelector('[data-itinerary]')?.innerHTML || '').substring(0, 500);
                })
                .catch(() => {
                    document.getElementById('modalDescription').textContent = 'Deskripsi tidak tersedia';
                    document.getElementById('modalItinerary').textContent = 'Itinerari tidak tersedia';
                });

            updatePrice();
        }

        function closeTourModal() {
            document.getElementById('tourModal').classList.add('hidden');
            currentTour = null;
        }

        function selectTrip(event) {
            document.querySelectorAll('.trip-btn').forEach(btn => btn.classList.remove('bg-[#1e88e5]'));
            event.target.classList.add('bg-[#1e88e5]');
            updatePrice();
        }

        function updatePrice() {
            const selectedTrip = document.querySelector('.trip-btn.bg-[#1e88e5]');
            const people = parseInt(document.getElementById('peopleCount').value) || 1;
            
            if (selectedTrip) {
                const price = parseInt(selectedTrip.dataset.tripPrice) || 0;
                const total = price * people;
                document.getElementById('totalPrice').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }
        }

        document.getElementById('peopleCount').addEventListener('change', updatePrice);

        document.getElementById('bookNowBtn').addEventListener('click', function() {
            const selectedTrip = document.querySelector('.trip-btn.bg-[#1e88e5]');
            if (!selectedTrip) {
                alert('Silakan pilih trip terlebih dahulu');
                return;
            }

            const people = document.getElementById('peopleCount').value;
            const tripId = selectedTrip.dataset.tripId;
            const price = parseInt(selectedTrip.dataset.tripPrice);
            const total = price * people;

            // Perform checkout via AJAX
            fetch('{{ route("checkout", ":id") }}'.replace(':id', currentTour.slug), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value || ''
                },
                body: JSON.stringify({
                    trip_id: tripId,
                    qty: people,
                    customer_name: 'Customer',
                    email: 'customer@test.com',
                    phone: '08000000000',
                    travel_date: new Date().toISOString().split('T')[0],
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            alert('Pembayaran Berhasil!');
                            closeTourModal();
                            window.location.href = '/';
                        },
                        onPending: function(result) {
                            alert('Pembayaran Menunggu Konfirmasi');
                        },
                        onError: function(result) {
                            alert('Pembayaran Gagal!');
                        }
                    });
                } else {
                    alert('Gagal membuat token pembayaran');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        });

        document.getElementById('whatsappBtn').addEventListener('click', function(e) {
            const selectedTrip = document.querySelector('.trip-btn.bg-[#1e88e5]');
            if (!selectedTrip) {
                e.preventDefault();
                alert('Silakan pilih trip terlebih dahulu');
                return;
            }

            const people = document.getElementById('peopleCount').value;
            const tripId = selectedTrip.dataset.tripId;
            const message = `Halo, saya tertarik dengan paket *${currentTour.title}* - Trip ${tripId.toUpperCase()} untuk ${people} orang. Silakan informasikan detailnya.`;
            
            this.href = `https://wa.me/{{ env('WHATSAPP_NUMBER') }}?text=${encodeURIComponent(message)}`;
        });

        // Close modal when clicking outside
        document.getElementById('tourModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTourModal();
            }
        });
    </script>

</body>
</html>

    <x-floating-whatsapp />