@extends('layouts.main')

@section('title', $car->name . ' - NorthSumateraTrip')
@section('meta_description', Str::limit(strip_tags($car->description ?? 'Sewa mobil ' . $car->name . ' di Medan Sumatera Utara harga murah dengan supir profesional.'), 160))
@section('meta_image', $car->image_url)

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@@type": "Product",
  "name": "Sewa Mobil {{ $car->brand }} {{ $car->name }}",
  "image": "{{ $car->image_url }}",
  "description": "{{ Str::limit(strip_tags($car->description ?? 'Sewa mobil ' . $car->name . ' di Medan Sumatera Utara harga murah.'), 200) }}",
  "brand": {
    "@@type": "Brand",
    "name": "{{ $car->brand }}"
  },
  "offers": {
    "@@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "IDR",
    "price": "{{ $car->price_with_driver }}",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "https://schema.org/InStock"
  }
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [{
    "@@type": "ListItem",
    "position": 1,
    "name": "Home",
    "item": "{{ route('home') }}"
  },{
    "@@type": "ListItem",
    "position": 2,
    "name": "Sewa Mobil",
    "item": "{{ route('rental') }}"
  },{
    "@@type": "ListItem",
    "position": 3,
    "name": "{{ $car->name }}",
    "item": "{{ url()->current() }}"
  }]
}
</script>
@endpush

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8 relative">
        <!-- Decorative Blobs -->
        <div class="absolute top-0 right-0 w-[60%] h-[60%] bg-blue-100/30 dark:bg-blue-900/10 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
        <div class="absolute bottom-1/4 left-0 w-[50%] h-[50%] bg-indigo-100/20 dark:bg-indigo-900/5 blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2 opacity-30"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
            <!-- Left Content -->
            <div class="lg:col-span-8">
                <div class="mb-14">
                    <div class="flex items-center gap-4 mb-10">
                        <span class="px-6 py-2.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-blue-100 dark:border-blue-800">
                            Sewa Mobil
                        </span>
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Medan & Sekitarnya</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-7xl font-black text-slate-900 dark:text-white leading-[1.05] tracking-tight mb-12 uppercase">{{ $car->name }}</h1>
                    
                    <div class="relative group rounded-[64px] overflow-hidden bg-white shadow-2xl shadow-blue-500/5 border border-slate-100 p-3">
                        <div class="aspect-video overflow-hidden rounded-[54px]">
                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-20">
                    <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-blue-500/5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Kapasitas</p>
                        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $car->capacity }} Kursi</p>
                    </div>
                    <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-blue-500/5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Harga / Hari</p>
                        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none">Rp {{ number_format($car->price_per_day / 1000, 0) }}k</p>
                    </div>
                    <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-blue-500/5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Transmisi</p>
                        <p class="text-2xl font-black text-slate-900 dark:text-white leading-none capitalize">{{ $car->transmission ?? 'Manual' }}</p>
                    </div>
                    <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-blue-500/5">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Status</p>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full {{ $car->is_available ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                            <span class="text-2xl font-black text-slate-900 dark:text-white leading-none">{{ $car->is_available ? 'Ready' : 'Booked' }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-20">
                    <section>
                        <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-widest mb-10 flex items-center gap-4">
                            <span class="w-12 h-1 bg-blue-700 rounded-full"></span>
                            Fasilitas Rental
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach(['Sopir Profesional Berpengalaman', 'Full AC & Audio System', 'Bahan Bakar Minyak (BBM)', 'Asuransi & Proteksi', 'Unit Mobil Terbaru', 'Kebersihan Terjamin'] as $service)
                                <div class="flex items-center gap-6 p-8 bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-500 hover:border-blue-100 dark:hover:border-blue-900/40">
                                    <div class="w-14 h-14 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-blue-700 dark:text-blue-400 transition-all duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="font-bold text-slate-600 dark:text-slate-400 text-lg">{{ $service }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-4">
                <div class="sticky top-44">
                    <div class="bg-white dark:bg-slate-900 rounded-[48px] p-12 border border-slate-100 dark:border-slate-800 shadow-xl shadow-blue-500/5">
                        
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Mulai Dari</p>
                                <p class="text-4xl font-black text-slate-900 dark:text-white tracking-tight">Rp {{ number_format($car->price_per_day / 1000, 0) }}k<span class="text-sm text-slate-400 font-bold ml-1">/hari</span></p>
                            </div>
                            <form action="{{ route('wishlist.toggle-car', $car->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 hover:text-rose-500 transition-all group">
                                    <svg class="w-6 h-6 transition-transform group-hover:scale-110 {{ \App\Models\Wishlist::where('car_id', $car->id)->where(function($q) { if(auth()->check()) { $q->where('user_id', auth()->id()); } else { $q->where('session_id', session()->getId()); } })->exists() ? 'fill-rose-500 text-rose-500' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="space-y-4 mb-10">
                            @foreach(['Sopir & BBM Include', 'Asuransi Perjalanan', 'Layanan 24 Jam'] as $item)
                                <div class="flex items-center gap-4 text-xs font-black text-slate-600 dark:text-slate-400 uppercase tracking-widest">
                                    <div class="w-6 h-6 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-700 dark:text-blue-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    {{ $item }}
                                </div>
                            @endforeach
                        </div>

                        <form action="{{ route('car.checkout', $car->id) }}" method="POST" id="car-booking-form" class="space-y-5" x-data="{ loading: false }" @submit="loading = true; handleCarBooking($event).finally(() => loading = false)">
                            @csrf
                            <div class="space-y-4">
                                <input type="text" name="customer_name" required placeholder="Nama Lengkap" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all">
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="tel" name="phone" id="phone" required placeholder="Telepon" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-sm font-bold focus:border-blue-700 outline-none transition-all">
                                    <input type="tel" name="customer_whatsapp" id="customer_whatsapp" required placeholder="WhatsApp" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-sm font-bold focus:border-blue-700 outline-none transition-all">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="date" name="travel_date" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-xs font-bold focus:border-blue-700 outline-none">
                                    <select name="duration" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-xs font-bold focus:border-blue-700 outline-none appearance-none">
                                        @for($i = 1; $i <= 14; $i++)
                                            <option value="{{ $i }}">{{ $i }} Hari</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Honeypot -->
                            <div class="hidden" aria-hidden="true">
                                <input type="text" name="hp_field" value="" tabindex="-1" autocomplete="off">
                            </div>

                            <!-- Terms & Conditions Checkbox -->
                            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 p-6 rounded-3xl flex items-start gap-4 mb-8">
                                <input type="checkbox" id="termsCheck" required class="w-6 h-6 mt-1 rounded-lg border-slate-200 dark:border-slate-700 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                                <label for="termsCheck" class="text-[11px] font-bold text-slate-500 dark:text-slate-400 leading-relaxed cursor-pointer">
                                    Saya menyetujui <a href="{{ route('legal.terms') }}" target="_blank" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> serta memberikan izin penggunaan data sesuai kebijakan <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 hover:underline">Privasi</a>.
                                </label>
                            </div>

                            <button type="submit" :disabled="loading"
                                    class="w-full py-6 bg-blue-700 hover:bg-blue-800 text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-500/20 flex items-center justify-center gap-3">
                                <span x-show="!loading" class="flex items-center gap-3">
                                    Sewa Sekarang
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                                <svg x-show="loading" class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </button>
                        </form>

                        <div class="mt-8 pt-8 border-t border-slate-50 dark:border-slate-800 text-center">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-6">Butuh Bantuan?</p>
                            <a href="{{ route('contact') }}" class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-widest hover:text-blue-700 transition-colors">Konsultasi Gratis</a>
                        </div>
                    </div>
                </div>
            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:hidden fixed bottom-10 left-6 right-6 z-[100]">
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl border border-slate-100 dark:border-slate-800 p-4 rounded-[32px] shadow-2xl flex gap-4 items-center">
                <a href="https://wa.me/{{ App\Helpers\SettingsHelper::whatsappNumber() }}?text=Tanya Sewa {{ $car->name }}" 
                   class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.038 3.284l-.569 2.1c-.123.446.251.846.684.733l2.047-.524c.974.51 2.013.788 3.087.77h.003c3.181 0 5.766-2.587 5.767-5.766 0-3.18-2.585-5.763-5.767-5.763zm3.845 8.167c-.12.336-.595.617-.912.658-.27.035-.624.062-1.01-.061-.24-.077-.549-.196-1.571-.621-1.422-.593-2.339-2.035-2.41-2.127-.071-.092-.571-.759-.571-1.44s.355-1.016.483-1.152c.127-.136.279-.17.372-.17.093 0 .186.001.267.005.085.004.2.034.303.28.106.253.364.887.395.952.032.065.053.14.01.226-.042.086-.064.14-.127.213-.064.073-.134.163-.191.219-.064.063-.131.131-.057.258.074.127.329.544.706.88.485.433.896.567 1.023.63.127.063.2.053.274-.034.074-.087.316-.371.4-.499.085-.128.17-.107.286-.064.117.043.742.349.87.414.127.065.213.097.245.151.033.054.033.31-.087.646z"/></svg>
                </a>
                <a href="#car-booking-form" class="flex-1 h-14 bg-blue-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest flex items-center justify-center shadow-lg shadow-blue-500/20">Sewa Sekarang</a>
            </div>
        </div>
    </div>
    <!-- Manual Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md" onclick="closePaymentModal()"></div>
        <div class="relative w-full max-w-xl bg-white dark:bg-slate-950 rounded-[64px] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-500 max-h-[95vh] overflow-y-auto border border-slate-100 dark:border-slate-800">
            <div class="p-12 md:p-16">
                <div class="flex items-center justify-between mb-12">
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Pembayaran</h3>
                    <button onclick="closePaymentModal()" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-10">
                    <!-- Order Info -->
                    <div class="bg-blue-700 rounded-[40px] p-10 text-white shadow-2xl shadow-blue-500/20 text-center relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 blur-2xl rounded-full -mr-16 -mt-16 transition-transform duration-1000 group-hover:scale-110"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-2">Total yang harus dibayar</p>
                        <p id="modalTotalAmount" class="text-4xl font-black tracking-tight leading-none mb-4">Rp 0</p>
                        <p class="text-[10px] font-black uppercase tracking-widest">Order ID: <span id="modalOrderId" class="opacity-60">#ORD-XXXXX</span></p>
                    </div>

                    <!-- Bank Accounts -->
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Silakan Transfer Ke:</p>
                        
                        @php $bankDetails = \App\Helpers\SettingsHelper::bankDetails(); @endphp
                        @foreach(['bank_1', 'bank_2'] as $bankKey)
                            @php $bank = $bankDetails[$bankKey] ?? null; @endphp
                            @if($bank && !empty($bank['name']) && !empty($bank['account']))
                                <div class="group p-8 rounded-[40px] border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between hover:border-blue-700 transition-all cursor-pointer" onclick="copyToClipboard('{{ $bank['account'] }}', '{{ $bank['name'] }}')">
                                    <div class="flex items-center gap-8">
                                        <div class="w-20 h-12 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-100 dark:border-slate-800 font-extrabold text-xs text-blue-900 dark:text-blue-400 uppercase">
                                            {{ $bank['name'] }}
                                        </div>
                                        <div>
                                            <p class="text-xl font-black text-slate-900 dark:text-white leading-tight mb-1">{{ $bank['account'] }}</p>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">a/n {{ $bank['holder'] }}</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 text-slate-300 group-hover:text-blue-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($bankDetails['qris'])
                    <div class="text-center pt-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Atau Scan QRIS Berikut:</p>
                        <div class="inline-block p-10 bg-white dark:bg-slate-800 rounded-[56px] shadow-sm border border-slate-100 dark:border-slate-700">
                            <img src="{{ asset('storage/' . $bankDetails['qris']) }}" alt="QRIS" class="w-64 h-64 mx-auto object-contain">
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-16">
                    <button onclick="redirectToWhatsappFromModal()" class="w-full py-6 bg-[#25D366] text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-2xl shadow-emerald-500/20 flex items-center justify-center gap-3">
                        Kirim Bukti via WhatsApp
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function handleCarBooking(e) {
        e.preventDefault();
        var form = e.target;
        var formData = new FormData(form);
        var data = {};
        formData.forEach(function(value, key) { data[key] = value; });

        if (!document.getElementById('termsCheck').checked) {
            showNotification('Silakan setujui Syarat & Ketentuan untuk melanjutkan.', 'error');
            return Promise.resolve();
        }

        data.action = 'payment'; 

        var csrfEl = document.querySelector('meta[name="csrf-token"]');
        var csrfToken = csrfEl ? csrfEl.content : '';

        return fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            if (response.status === 419) {
                throw new Error('Sesi telah berakhir (CSRF mismatch). Silakan segarkan halaman (refresh) dan coba lagi.');
            }
            return response.json().then(function(resData) {
                if (!response.ok) throw new Error(resData.message || 'Terjadi kesalahan sistem');
                return resData;
            });
        })
        .then(function(resData) {
            if (resData.success) {
                showManualPaymentModal(resData.order_id, resData.gross_amount);
            }
        })
        .catch(function(error) {
            showNotification(error.message, 'error');
            throw error;
        });
    }

    window.handleCarBooking = handleCarBooking;

    function showManualPaymentModal(orderId, amount) {
        document.getElementById('modalOrderId').textContent = orderId;
        document.getElementById('modalTotalAmount').textContent = 'Rp ' + amount.toLocaleString('id-ID');
        
        var modal = document.getElementById('paymentModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        var modal = document.getElementById('paymentModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    function copyToClipboard(text, bank) {
        navigator.clipboard.writeText(text).then(function() {
            showNotification('Nomor rekening ' + bank + ' berhasil disalin!', 'success');
        });
    }

    function showNotification(message, type) {
        if (type === undefined) type = 'success';
        var toast = document.createElement('div');
        toast.className = 'fixed bottom-8 left-1/2 -translate-x-1/2 px-8 py-4 rounded-2xl text-white font-bold text-sm shadow-2xl z-[300] transition-all duration-500 transform translate-y-20 opacity-0';
        toast.style.backgroundColor = type === 'success' ? '#10B981' : '#EF4444';
        toast.innerHTML = message;
        document.body.appendChild(toast);
        
        setTimeout(function() {
            toast.classList.remove('translate-y-20', 'opacity-0');
        }, 100);

        setTimeout(function() {
            toast.classList.add('translate-y-20', 'opacity-0');
            setTimeout(function() { toast.remove(); }, 500);
        }, 3000);
    }

    function redirectToWhatsappFromModal() {
        var orderId = document.getElementById('modalOrderId').textContent;
        var total = document.getElementById('modalTotalAmount').textContent;
        var name = document.querySelector('input[name="customer_name"]').value;
        var carName = "{{ $car->name }}";
        
        var message = 'Halo NorthSumateraTrip \u{1F44B}\n\nSaya ingin konfirmasi pembayaran sewa mobil.\n\n\u{1F9FE} ID Pesanan: ' + orderId + '\n\u{1F697} Unit: ' + carName + '\n\u{1F4B0} Total: ' + total + '\n\u{1F464} Nama: ' + name + '\n\nMohon bantuannya ya! Terima kasih \u{1F64F}';
        
        var waNumber = "{{ preg_replace('/\D/', '', \App\Helpers\SettingsHelper::whatsappNumber()) }}";
        window.open('https://wa.me/' + waNumber + '?text=' + encodeURIComponent(message), '_blank');
    }
</script>
@endpush

