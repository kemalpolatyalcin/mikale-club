@extends('layouts.app')

@section('title', 'MIKALE CLUB - Resepsiyon Girişi')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="lux-card rounded-3xl p-7 md:p-9 max-w-md w-full border border-[#C5A880]/35 shadow-2xl shadow-black relative overflow-hidden space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-full border border-[#C5A880]/50 flex items-center justify-center bg-[#181614] text-[#C5A880] font-lux-title text-xl mx-auto shadow-lg shadow-[#C5A880]/20">
                M
            </div>
            <span class="text-[9px] tracking-[0.3em] uppercase text-[#C5A880] font-medium block">Yalnızca Yetkili Personel Erişimi</span>
            <h2 class="font-lux-title text-xl md:text-2xl text-[#F5EFE6] tracking-wider uppercase">Resepsiyon Portalı</h2>
            <p class="font-lux-serif italic text-xs text-[#A89C8F]">Kulüp yönetimi, misafir check-in ve canlı sipariş masası</p>
            <div class="h-[1px] w-14 mx-auto lux-divider pt-1"></div>
        </div>

        @if($errors->any())
            <div class="bg-[#241414] border border-red-500/40 text-red-200 px-4 py-3 rounded-xl text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <span>⚠</span>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('reception.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-wider text-[#A89C8F] mb-1">E-Posta Adresi</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full bg-[#141210] border border-[#C5A880]/30 rounded-xl px-4 py-3 text-xs text-[#E6E0D8] focus:outline-none focus:border-[#C5A880] font-mono">
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-wider text-[#A89C8F] mb-1">Şifre</label>
                <input type="password" name="password" required 
                       class="w-full bg-[#141210] border border-[#C5A880]/30 rounded-xl px-4 py-3 text-xs text-[#E6E0D8] focus:outline-none focus:border-[#C5A880] font-mono">
            </div>

            <div class="flex items-center justify-between text-[11px] text-[#8C8276]">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" checked class="rounded bg-[#141210] border-[#C5A880]/30 text-[#C5A880] focus:ring-0">
                    <span>Oturumu açık tut</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-[#8F7655] via-[#C5A880] to-[#8F7655] text-[#0D0C0A] font-lux-title text-xs tracking-[0.2em] uppercase font-bold hover:brightness-110 active:scale-[0.99] transition-all shadow-lg shadow-[#C5A880]/20">
                Portala Giriş Yap
            </button>
        </form>

        <div class="pt-2 text-center border-t border-[#C5A880]/15">
            <a href="{{ route('home') }}" class="text-[11px] text-[#8C8276] hover:text-[#C5A880] transition-colors">
                ← Canlı Müşteri Menüsüne Dön
            </a>
        </div>
    </div>
</div>
@endsection
