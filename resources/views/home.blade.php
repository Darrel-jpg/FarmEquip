@extends('layouts.app')

@section('title', 'Solusi Tani Modern')

@section('content')
    {{-- 1. HERO SECTION --}}
    <section class="relative bg-slate-900 h-[650px] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=1740&auto=format&fit=crop"
                 alt="Pertanian Modern"
                 class="w-full h-full object-cover opacity-60 scale-105 animate-pulse-slow">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/80 to-transparent"></div>
        </div>

        <div class="container mx-auto px-6 z-10 relative mt-10">
            <div class="max-w-3xl animate-fade-in-up">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 backdrop-blur-md mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="text-emerald-300 text-sm font-semibold tracking-wide">Platform Sewa No. #1 Jember</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-extrabold text-white leading-tight mb-6 tracking-tight">
                    Panen Melimpah <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">
                        Tanpa Beli Alat
                    </span>
                </h1>

                <p class="text-lg text-slate-300 mb-10 leading-relaxed max-w-2xl border-l-4 border-emerald-500 pl-6">
                    Akses teknologi pertanian modern seperti Combine Harvester dan Drone Sprayer tanpa modal besar. Sewa harian, mingguan, atau bulanan.
                </p>

                <div class="flex flex-col sm:flex-row gap-5">
                    <a href="/tools" class="group relative px-8 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-900/20 overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            Lihat Katalog
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 2. STATISTIK (FLOATING) --}}
    {{-- Z-Index diset 20, pastikan Navbar kamu z-50 --}}
    <div class="relative z-20 -mt-20 container mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-xl border-t-4 border-emerald-500 p-8 grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-slate-100">
            <div class="text-center group">
                <div class="text-3xl font-bold text-slate-800 group-hover:text-emerald-600 transition">50+</div>
                <div class="text-sm text-slate-500 uppercase tracking-wider font-medium mt-1">Unit Ready</div>
            </div>
            <div class="text-center group px-4">
                <div class="text-3xl font-bold text-slate-800 group-hover:text-emerald-600 transition">24 Jam</div>
                <div class="text-sm text-slate-500 uppercase tracking-wider font-medium mt-1">Layanan Mekanik</div>
            </div>
            <div class="text-center group px-4">
                <div class="text-3xl font-bold text-slate-800 group-hover:text-emerald-600 transition">100%</div>
                <div class="text-sm text-slate-500 uppercase tracking-wider font-medium mt-1">Garansi Alat</div>
            </div>
            <div class="text-center group px-4">
                <div class="text-3xl font-bold text-slate-800 group-hover:text-emerald-600 transition">Rp 0</div>
                <div class="text-sm text-slate-500 uppercase tracking-wider font-medium mt-1">Biaya Konsultasi</div>
            </div>
        </div>
    </div>

    {{-- 3. KATEGORI PILIHAN (SMART ICON DARI API) --}}
    <section class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-emerald-600 font-bold tracking-wider uppercase text-sm">Kategori Favorit</span>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mt-2 mb-4">Apa yang Anda Butuhkan?</h2>
                <div class="w-20 h-1 bg-emerald-500 mx-auto rounded-full"></div>
            </div>

            <div id="kategori-container" class="grid md:grid-cols-3 gap-8">
                {{-- Loading Animation --}}
                <div class="col-span-3 text-center py-12">
                    <svg class="animate-spin h-10 w-10 mx-auto text-emerald-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-slate-500">Memuat kategori...</p>
                </div>
            </div>

            <div id="kategori-error" class="hidden text-center text-red-500">
                Gagal memuat kategori. Pastikan server Go berjalan.
            </div>
        </div>
    </section>

    {{-- SCRIPT: LOGIKA ICON CERDAS (Bukan Random Emoji) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriApiUrl = 'https://farmequip.up.railway.app/kategori';
            const container = document.getElementById('kategori-container');
            const errorDiv = document.getElementById('kategori-error');

            // FUNGSI PINTAR: Memilih SVG Icon & Warna berdasarkan kata kunci Slug
            function getCategoryStyle(slug) {
                const s = slug.toLowerCase();

                // 1. Air/Irigasi (Biru)
                if (s.includes('irigasi') || s.includes('air') || s.includes('pompa')) {
                    return { color: 'blue', icon: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>' };
                }
                // 2. Mesin/Traktor (Emerald)
                if (s.includes('mesin') || s.includes('traktor') || s.includes('berat')) {
                    return { color: 'emerald', icon: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>' };
                }
                // 3. Elektronik/IoT (Amber)
                if (s.includes('elektronik') || s.includes('iot') || s.includes('drone')) {
                    return { color: 'amber', icon: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>' };
                }
                // 4. Manual/Tangan (Rose)
                if (s.includes('manual') || s.includes('tangan') || s.includes('sabit')) {
                    return { color: 'rose', icon: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>' };
                }
                // Default (Violet)
                return { color: 'violet', icon: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>' };
            }

            fetch(kategoriApiUrl)
                .then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => {
                    container.innerHTML = '';

                    if (!data || data.length === 0) {
                        errorDiv.classList.remove('hidden');
                        errorDiv.innerText = "Belum ada kategori tersedia.";
                        return;
                    }

                    data.forEach(kategori => {
                        const style = getCategoryStyle(kategori.slug);
                        const c = style.color;

                        const cardHtml = `
                            <a href="/tools?category=${kategori.slug}" class="group bg-white rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 border border-slate-100 hover:border-${c}-100 relative overflow-hidden h-full flex flex-col">
                                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-${c}-50 rounded-full group-hover:scale-150 transition duration-500"></div>

                                <div class="relative z-10 flex flex-col h-full">
                                    <div class="w-16 h-16 bg-${c}-100 text-${c}-600 rounded-2xl flex items-center justify-center mb-6 text-2xl group-hover:bg-${c}-600 group-hover:text-white transition shadow-sm">
                                        ${style.icon}
                                    </div>

                                    <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-${c}-600 transition">
                                        ${kategori.nama_kategori}
                                    </h3>

                                    <p class="text-slate-500 leading-relaxed mb-6 flex-grow line-clamp-3">
                                        ${kategori.deskripsi || 'Deskripsi tidak tersedia.'}
                                    </p>

                                    <span class="inline-flex items-center text-${c}-600 font-bold hover:text-${c}-700 mt-auto">
                                        Lihat ${kategori.nama_kategori}
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </span>
                                </div>
                            </a>
                        `;
                        container.innerHTML += cardHtml;
                    });
                })
                .catch(err => {
                    container.innerHTML = '';
                    errorDiv.classList.remove('hidden');
                });
        });
    </script>

    {{-- 4. CTA FOOTER --}}
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-emerald-900">
             <img src="https://images.unsplash.com/photo-1595131838507-68196b0bd40e?q=80&w=1740&auto=format&fit=crop" class="w-full h-full object-cover opacity-10 mix-blend-overlay">
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Jangan Biarkan Lahan Menganggur</h2>
            <p class="text-emerald-100 text-lg mb-10 max-w-2xl mx-auto">Musim tanam sudah dekat. Pastikan Anda memiliki peralatan terbaik.</p>
            <a href="/tools" class="inline-block px-10 py-4 bg-white text-emerald-900 font-bold rounded-xl hover:bg-emerald-50 transition shadow-xl transform hover:-translate-y-1">
                Booking Alat Sekarang
            </a>
            <p class="mt-6 text-sm text-emerald-300 opacity-80">*Diskon khusus untuk penyewaan > 7 hari</p>
        </div>
    </section>

    {{-- DUMMY UNTUK TAILWIND (Agar warna dynamic tidak hilang) --}}
    <div class="hidden bg-blue-100 text-blue-600 bg-blue-50 border-blue-100 hover:border-blue-100 hover:text-blue-700
         bg-emerald-100 text-emerald-600 bg-emerald-50 border-emerald-100 hover:border-emerald-100 hover:text-emerald-700
         bg-amber-100 text-amber-600 bg-amber-50 border-amber-100 hover:border-amber-100 hover:text-amber-700
         bg-rose-100 text-rose-600 bg-rose-50 border-rose-100 hover:border-rose-100 hover:text-rose-700
         bg-violet-100 text-violet-600 bg-violet-50 border-violet-100 hover:border-violet-100 hover:text-violet-700">
    </div>
@endsection
