@extends('layouts.app')

@section('title', 'MIKALE CLUB - Resepsiyon & Misafir Yönetimi')

@section('content')
<div class="max-w-5xl mx-auto px-4 pt-6 pb-20 space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#C5A880]/20 pb-4">
        <div>
            <span class="text-[10px] tracking-[0.3em] uppercase text-[#C5A880] font-medium block">Front Desk Management</span>
            <h2 class="font-lux-title text-2xl md:text-3xl font-normal tracking-wide text-[#F5EFE6] uppercase">Resepsiyon & Misafir Masası</h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-full bg-[#181614] border border-[#C5A880]/30 text-xs text-[#E8D9C5] hover:text-white transition-colors">
                ← Menüye Dön
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-[#1C1914] border border-[#C5A880]/40 text-[#E8D9C5] px-4 py-3 rounded-xl text-xs flex items-center justify-between shadow-lg shadow-black/40">
            <div class="flex items-center gap-2">
                <span class="text-[#C5A880]">✦</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="lux-card rounded-xl p-4">
            <span class="text-[9px] uppercase tracking-widest text-[#A89C8F] block mb-1">Aktif Misafirler</span>
            <div class="flex items-baseline gap-2">
                <span class="font-lux-title text-2xl text-[#F5EFE6]">{{ $activeGuests->count() }}</span>
                <span class="text-[10px] text-[#C5A880]">Kişi Kulüpte</span>
            </div>
        </div>
        <div class="lux-card rounded-xl p-4">
            <span class="text-[9px] uppercase tracking-widest text-[#A89C8F] block mb-1">Canlı Masadaki Harcama</span>
            <div class="flex items-baseline gap-2">
                <span class="font-lux-title text-2xl text-[#E8D9C5]">{{ number_format($totalActiveSpent, 0, ',', '.') }} ₺</span>
                <span class="text-[10px] text-[#A89C8F]">(+ %10 Servis)</span>
            </div>
        </div>
        <div class="lux-card rounded-xl p-4">
            <span class="text-[9px] uppercase tracking-widest text-[#A89C8F] block mb-1">Masa Kapasitesi</span>
            <div class="flex items-baseline gap-2">
                <span class="font-lux-title text-2xl text-[#F5EFE6]">{{ $tables->count() }}</span>
                <span class="text-[10px] text-[#8C8276]">Aktif Masa</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lux-card rounded-2xl p-5 space-y-4 h-fit">
            <div class="border-b border-[#C5A880]/15 pb-2">
                <span class="text-[9px] uppercase tracking-widest text-[#C5A880] font-medium block">Hızlı Kayıt</span>
                <h3 class="font-lux-title text-lg text-[#F5EFE6]">Yeni Misafir Karşılama</h3>
            </div>

            <form action="{{ route('reception.checkin') }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#A89C8F] mb-1">Misafir Adı Soyadı *</label>
                    <input type="text" name="name" required placeholder="Örn: Emirhan Kaya" 
                           class="w-full bg-[#141210] border border-[#C5A880]/20 rounded-xl px-3.5 py-2.5 text-xs text-[#E6E0D8] placeholder-[#6E655A] focus:outline-none focus:border-[#C5A880]/60">
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#A89C8F] mb-1">Telefon Numarası</label>
                    <input type="text" name="phone" placeholder="Örn: 0532 000 00 00" 
                           class="w-full bg-[#141210] border border-[#C5A880]/20 rounded-xl px-3.5 py-2.5 text-xs text-[#E6E0D8] placeholder-[#6E655A] focus:outline-none focus:border-[#C5A880]/60">
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-[#A89C8F] mb-1">Masa Ataması (İsteğe Bağlı)</label>
                    <select name="club_table_id" class="w-full bg-[#141210] border border-[#C5A880]/20 rounded-xl px-3.5 py-2.5 text-xs text-[#E6E0D8] focus:outline-none focus:border-[#C5A880]/60">
                        <option value="">Masaya sonradan QR ile bağlanacak</option>
                        @foreach($tables as $tbl)
                            <option value="{{ $tbl->id }}">{{ $tbl->table_number }} - {{ $tbl->name }} ({{ $tbl->section }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl bg-[#C5A880] text-[#0D0C0A] font-lux-title text-xs tracking-[0.2em] uppercase font-medium hover:brightness-110 active:scale-[0.99] transition-all shadow-md shadow-[#C5A880]/20">
                    Giriş Yap & VIP Kod Üret
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-[9px] uppercase tracking-widest text-[#C5A880] font-medium block">Live Floor</span>
                    <h3 class="font-lux-title text-lg text-[#F5EFE6]">Aktif Kulüp Misafirleri</h3>
                </div>
                <form action="{{ route('reception.index') }}" method="GET" class="relative max-w-xs">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Misafir veya kod ara..." 
                           class="w-full bg-[#141210] border border-[#C5A880]/20 rounded-full px-3.5 py-1.5 pl-8 text-xs text-[#E6E0D8] placeholder-[#6E655A] focus:outline-none focus:border-[#C5A880]/60">
                    <svg class="w-3.5 h-3.5 text-[#C5A880]/60 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
            </div>

            @if($activeGuests->isEmpty())
                <div class="lux-card rounded-2xl p-8 text-center text-[#8C8276] space-y-2">
                    <p class="font-lux-title text-sm">Şu an aktif misafir bulunmuyor.</p>
                    <p class="text-xs text-[#6E655A]">Girişteki misafirleri sol panelden sisteme kaydedebilirsiniz.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($activeGuests as $guest)
                        <div class="lux-card rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded text-[9px] font-mono tracking-widest uppercase bg-[#C5A880]/20 text-[#E8D9C5] border border-[#C5A880]/35 font-bold">
                                        {{ $guest->guest_code }}
                                    </span>
                                    <h4 class="font-lux-title text-base text-[#F5EFE6] font-normal">{{ $guest->name }}</h4>
                                </div>
                                <div class="flex items-center gap-3 text-[10px] text-[#A89C8F]">
                                    @if($guest->table)
                                        <span class="text-[#C5A880] font-medium">📍 {{ $guest->table->table_number }} ({{ $guest->table->section }})</span>
                                    @else
                                        <span class="text-[#8C8276] italic">Masa henüz seçilmedi</span>
                                    @endif
                                    <span>• Giriş: {{ $guest->check_in_at->format('H:i') }}</span>
                                    @if($guest->phone)
                                        <span>• {{ $guest->phone }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-4 pt-2 sm:pt-0 border-t sm:border-t-0 border-[#C5A880]/10">
                                <div class="text-left sm:text-right">
                                    <span class="text-[9px] uppercase tracking-wider text-[#8C8276] block">Harcama Tutarı</span>
                                    <span class="font-lux-title text-base text-[#E8D9C5]">{{ number_format($guest->totalSpent(), 0, ',', '.') }} ₺</span>
                                </div>

                                <form action="{{ route('reception.checkout', $guest->id) }}" method="POST" onsubmit="return confirm('{{ $guest->name }} misafirinin hesabı tahsil edilip oturumu kapatılsın mı?');">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-[#1F1B16] border border-[#C5A880]/40 text-[#E8D9C5] hover:bg-[#C5A880] hover:text-[#0D0C0A] text-[11px] uppercase tracking-wider transition-all font-medium whitespace-nowrap">
                                        Hesabı Kapat & Çıkış
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
