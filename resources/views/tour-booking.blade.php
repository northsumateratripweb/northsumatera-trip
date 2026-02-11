<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $tour->title }} | NorthSumateraTrip</title>
    <meta name="description" content="{{ strip_tags($tour->description) }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    
    <style>
        @keyframes fade-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fade-up 0.8s ease-out forwards; }
        .glass { background: rgba(22, 22, 21, 0.8); backdrop-filter: blur(12px); }
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #3E3E3A; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #FF4433; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-[#EDEDEC] antialiased font-['Instrument_Sans']">

    <!-- Navigation -->
    <nav class="fixed w-full z-[100] border-b border-[#3E3E3A] glass transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="/" class="text-xl font-extrabold tracking-tighter">
                    NorthSumatera<span class="text-[#FF4433]">Trip</span>
                </a>
                <a href="/" class="px-6 py-2 rounded-full text-sm font-bold border border-[#3E3E3A] hover:border-[#FF4433] transition">Kembali</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-32 pb-20 px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-8">
            
            <!-- Left Content -->
            <div class="lg:col-span-2">
                
                <!-- Hero Image -->
                <div class="rounded-2xl overflow-hidden mb-8 bg-[#161615] h-96 flex items-center justify-center border border-[#3E3E3A]">
                    <img src="{{ $tour->thumbnail }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
                </div>

                <!-- Title & Location -->
                <div class="mb-8 animate-fade-up">
                    <h1 class="text-4xl md:text-5xl font-black mb-4">{{ $tour->title }}</h1>
                    <div class="flex items-center gap-2 text-[#A1A09A]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                        <span>{{ $tour->location }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-[#A1A09A] mt-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                        <span>{{ $tour->duration_days }} Hari</span>
                    </div>
                </div>

                <!-- Trip Image (Deskripsi Gambar) -->
                @if($tour->trip_image)
                <div class="rounded-2xl overflow-hidden mb-8 bg-[#161615] border border-[#3E3E3A]">
                    <img src="{{ asset('storage/' . $tour->trip_image) }}" alt="Trip Image" class="w-full h-64 object-cover">
                </div>
                @endif

                <!-- Description -->
                <div class="mb-8 animate-fade-up">
                    <h2 class="text-2xl font-bold mb-4">Deskripsi Paket</h2>
                    <div class="text-[#A1A09A] leading-relaxed prose prose-invert max-w-none">
                        {!! $tour->description !!}
                    </div>
                </div>

                <!-- Itinerary -->
                <div class="mb-8 animate-fade-up">
                    <h2 class="text-2xl font-bold mb-4">Itinerary</h2>
                    <div class="text-[#A1A09A] leading-relaxed prose prose-invert max-w-none">
                        {!! $tour->itinerary !!}
                    </div>
                </div>

                <!-- PDF & Request Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mb-8 animate-fade-up">
                    <a href="" class="flex-1 px-6 py-3 bg-[#3E3E3A] hover:bg-[#4E4E4A] rounded-xl font-bold text-center transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                        </svg>
                        Download PDF Itinerary
                    </a>
                    <a href="https://wa.me/{{ env('WHATSAPP_NUMBER', '6281234567890') }}?text=Halo%2C%20saya%20ingin%20request%20paket%20trip%20custom%20untuk%20{{ urlencode($tour->title) }}" class="flex-1 px-6 py-3 bg-[#3E3E3A] hover:bg-[#4E4E4A] rounded-xl font-bold text-center transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.411-2.296-1.414-.848-.757-1.422-1.694-1.594-1.992-.172-.299-.018-.461.13-.611.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-3.055 2.036-5.029 5.33-5.029 8.917 0 3.665 1.999 6.823 5.213 8.94l.9-.563c3.026-1.896 4.918-4.501 4.918-8.377 0-3.782-1.975-7.055-5.066-8.995z"/>
                        </svg>
                        Request Paket Custom
                    </a>
                </div>

            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-[#161615] border border-[#3E3E3A] rounded-2xl p-6 sticky top-32">
                    
                    <!-- Trip Selection -->
                    <h3 class="text-lg font-bold mb-4">Pilih Tipe Trip</h3>
                    <div class="grid grid-cols-2 gap-3 mb-6" id="tripsContainer">
                        @forelse($tour->trips as $key => $trip)
                            <button 
                                class="trip-btn bg-[#3E3E3A] hover:bg-[#1e88e5] text-white font-bold py-2 rounded-lg transition"
                                data-trip-id="{{ $key }}"
                                data-trip-price="{{ $trip['price'] ?? 0 }}"
                                onclick="selectTrip(this)">
                                {{ strtoupper($key) }}
                            </button>
                        @empty
                            <p class="col-span-2 text-sm text-[#A1A09A]">Belum ada pilihan trip</p>
                        @endforelse
                    </div>

                    <!-- Trip Details -->
                    <div id="tripDetails" class="mb-6 p-4 bg-[#3E3E3A] rounded-lg text-sm text-[#A1A09A]">
                        <p>Pilih tipe trip untuk melihat detail</p>
                    </div>

                    <!-- People Count -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold mb-2">Jumlah Orang</label>
                        <select id="peopleCount" onchange="updatePrice()" class="w-full bg-[#3E3E3A] border border-[#4E4E4A] rounded-lg px-4 py-2 text-white">
                            <option value="">Pilih jumlah orang</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }} Orang</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="mb-6 p-4 bg-[#3E3E3A] rounded-lg">
                        <p class="text-sm text-[#A1A09A] mb-1">Total Harga</p>
                        <p id="totalPrice" class="text-2xl font-bold text-[#FF4433]">Rp 0</p>
                    </div>

                    <!-- Booking Form -->
                    <div class="space-y-3 mb-6">
                        <input type="text" id="customerName" placeholder="Nama Lengkap" class="w-full bg-[#3E3E3A] border border-[#4E4E4A] rounded-lg px-4 py-2 text-white placeholder-[#A1A09A]">
                        <input type="email" id="customerEmail" placeholder="Email" class="w-full bg-[#3E3E3A] border border-[#4E4E4A] rounded-lg px-4 py-2 text-white placeholder-[#A1A09A]">
                        <input type="tel" id="customerPhone" placeholder="No. Telepon" class="w-full bg-[#3E3E3A] border border-[#4E4E4A] rounded-lg px-4 py-2 text-white placeholder-[#A1A09A]">
                        <input type="date" id="travelDate" class="w-full bg-[#3E3E3A] border border-[#4E4E4A] rounded-lg px-4 py-2 text-white">
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button id="bookNowBtn" 
                            class="w-full px-6 py-3 bg-[#1e88e5] hover:bg-blue-700 text-white rounded-xl font-bold transition disabled:opacity-50 disabled:cursor-not-allowed"
                            onclick="bookNow()">
                            📍 BOOK NOW
                        </button>
                        <a id="whatsappBtn" 
                            href="#"
                            class="w-full px-6 py-3 bg-[#43A047] hover:bg-green-700 text-white rounded-xl font-bold transition text-center block">
                            💬 WHATSAPP
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        let currentTrip = null;
        const csrf_token = document.querySelector('meta[name="csrf-token"]').content;

        function selectTrip(button) {
            document.querySelectorAll('.trip-btn').forEach(btn => {
                btn.classList.remove('bg-[#1e88e5]');
                btn.classList.add('bg-[#3E3E3A]');
            });
            
            button.classList.add('bg-[#1e88e5]');
            button.classList.remove('bg-[#3E3E3A]');
            
            const tripId = button.dataset.tripId;
            const price = parseInt(button.dataset.tripPrice);
            
            // Get trip details from tour data
            const tripData = @json($tour->trips);
            const trip = tripData[tripId];
            
            currentTrip = { id: tripId, price: price, data: trip };
            
            // Show trip details
            const detailsHtml = `
                <strong>${trip.name || 'Tipe ' + tripId.toUpperCase()}</strong>
                <p class="text-xs mt-1">${trip.includes || ''}</p>
            `;
            document.getElementById('tripDetails').innerHTML = detailsHtml;
            
            updatePrice();
            updateWhatsappLink();
        }

        function updatePrice() {
            if (!currentTrip) return;
            
            const people = parseInt(document.getElementById('peopleCount').value) || 1;
            const total = currentTrip.price * people;
            document.getElementById('totalPrice').textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function updateWhatsappLink() {
            if (!currentTrip) {
                document.getElementById('whatsappBtn').href = '#';
                return;
            }
            
            const name = document.getElementById('customerName').value || 'Pengunjung';
            const people = document.getElementById('peopleCount').value || '1';
            const date = document.getElementById('travelDate').value || 'belum ditentukan';
            const tripName = currentTrip.data.name || currentTrip.id.toUpperCase();
            
            const message = `Halo, saya ingin booking paket wisata:\n\nPaket: {{ $tour->title }}\nTipe Trip: ${tripName}\nNama: ${name}\nJumlah Orang: ${people}\nTanggal: ${date}`;
            
            const whatsappNumber = '{{ env("WHATSAPP_NUMBER", "6281234567890") }}';
            document.getElementById('whatsappBtn').href = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
        }

        function bookNow() {
            if (!currentTrip) {
                alert('Silakan pilih tipe trip terlebih dahulu');
                return;
            }

            const name = document.getElementById('customerName').value.trim();
            const email = document.getElementById('customerEmail').value.trim();
            const phone = document.getElementById('customerPhone').value.trim();
            const people = parseInt(document.getElementById('peopleCount').value);
            const date = document.getElementById('travelDate').value;

            if (!name || !email || !phone || !people || !date) {
                alert('Silakan isi semua data dengan lengkap');
                return;
            }

            const total = currentTrip.price * people;

            fetch('{{ route("checkout", $tour->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf_token,
                },
                body: JSON.stringify({
                    trip_id: currentTrip.id,
                    qty: people,
                    customer_name: name,
                    email: email,
                    phone: phone,
                    travel_date: date,
                    gross_amount: total
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result){
                            alert('Pembayaran berhasil!');
                            console.log(result);
                        },
                        onPending: function(result){
                            alert('Menunggu pembayaran');
                            console.log(result);
                        },
                        onError: function(result){
                            alert('Pembayaran gagal');
                            console.log(result);
                        },
                        onClose: function(){
                            alert('Anda menutup popup pembayaran');
                        }
                    });
                } else {
                    alert('Error: ' + (data.message || 'Gagal membuat transaksi'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
        }

        // Update WhatsApp link when input changes
        document.getElementById('customerName').addEventListener('change', updateWhatsappLink);
        document.getElementById('customerPhone').addEventListener('change', updateWhatsappLink);
        document.getElementById('peopleCount').addEventListener('change', updateWhatsappLink);
        document.getElementById('travelDate').addEventListener('change', updateWhatsappLink);
    </script>

</body>
</html>
