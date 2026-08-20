@extends('layouts.app')

@section('title', 'MIKALE CLUB - VIP Yönetim Portalı & Gösterge Paneli')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] text-[#1E293B] flex flex-col md:flex-row font-sans selection:bg-[#B38E5D] selection:text-white relative">
    <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <aside id="portal-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-[#FFFFFF] border-r border-[#E2E8F0] flex flex-col justify-between -translate-x-full md:translate-x-0 md:static md:w-64 transition-transform duration-300 shadow-xl md:shadow-sm flex-shrink-0">
        <div class="overflow-y-auto flex-1">
            <div class="p-5 border-b border-[#F1F5F9] flex items-center justify-between">
                <a href="{{ route('reception.index') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full border border-[#B38E5D]/40 flex items-center justify-center bg-[#FDFBF7] text-[#B38E5D] font-lux-title text-base shadow-sm">
                        M
                    </div>
                    <div>
                        <h2 class="font-lux-title text-sm tracking-[0.2em] font-normal text-[#0F172A]">MIKALE</h2>
                        <span class="text-[8px] uppercase tracking-[0.3em] text-[#B38E5D] font-bold block -mt-0.5">VIP Management</span>
                    </div>
                </a>

                <button type="button" id="mobile-sidebar-close" class="md:hidden w-8 h-8 rounded-xl bg-[#F8F9FA] border border-[#CBD5E1] text-[#64748B] hover:text-[#0F172A] flex items-center justify-center">
                    ✕
                </button>
            </div>

            <div class="p-3">
                <a href="{{ route('home') }}" target="_blank" class="w-full mb-3 py-2.5 px-3.5 rounded-xl bg-[#FDFBF7] border border-[#B38E5D]/30 hover:border-[#B38E5D]/80 text-[#8F6E40] hover:text-[#5C4524] text-xs flex items-center justify-between transition-all group shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-[#B38E5D]">✦</span>
                        <span class="font-semibold tracking-wide">Menüyü Gör</span>
                    </div>
                    <svg class="w-4 h-4 text-[#8F6E40] group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <nav class="space-y-1">
                    <button type="button" data-tab="dashboard" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? 'dashboard') === 'dashboard' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Gösterge Paneli</span>
                    </button>

                    <button type="button" data-tab="categories" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'categories' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Kategoriler ({{ $totalCategoriesCount }})</span>
                    </button>

                    <button type="button" data-tab="products" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'products' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Ürünler ({{ $totalProductsCount }})</span>
                    </button>

                    <button type="button" data-tab="guests" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'guests' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Misafirler & Giriş</span>
                    </button>

                    <button type="button" data-tab="tables" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'tables' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span>Masalar ve QR</span>
                    </button>

                    <button type="button" data-tab="notifications" class="portal-nav-btn w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'notifications' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span>Garson Bildirimleri</span>
                        </div>
                        <span id="nav-waiter-badge" class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold {{ $pendingWaiterCallsCount > 0 ? 'bg-red-500 text-white animate-bounce' : 'bg-[#E2E8F0] text-[#64748B]' }}">{{ $pendingWaiterCallsCount }}</span>
                    </button>

                    <button type="button" data-tab="orders" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'orders' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Canlı Siparişler ({{ $pendingOrdersCount }})</span>
                    </button>

                    <button type="button" data-tab="bills" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'bills' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Kasa ve Hesaplar</span>
                    </button>

                    <button type="button" data-tab="settings" class="portal-nav-btn w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs transition-all font-semibold {{ ($tab ?? '') === 'settings' ? 'bg-[#8F6E40] text-white shadow-md' : 'text-[#64748B] hover:bg-[#F1F5F9] hover:text-[#0F172A]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Ayarlar & Hesap</span>
                    </button>
                </nav>
            </div>
        </div>

        <div class="p-4 border-t border-[#F1F5F9] bg-[#FFFFFF]">
            <div class="flex items-center justify-between mb-3 px-1">
                <div>
                    <span class="text-[10px] text-[#94A3B8] block font-medium">Giriş Yapan Yetkili</span>
                    <span class="text-xs font-mono text-[#0F172A] font-semibold truncate max-w-[140px] block">{{ Auth::user()->email ?? 'club@gmail.com' }}</span>
                </div>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>
            <form action="{{ route('reception.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2.5 px-3 rounded-xl bg-[#FEF2F2] hover:bg-[#FEE2E2] border border-[#FCA5A5]/40 text-[#DC2626] text-xs font-semibold transition-all flex items-center justify-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Çıkış Yap</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-y-auto max-h-screen">
        <header class="bg-[#FFFFFF] border-b border-[#E2E8F0] px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-2.5">
                <button type="button" id="mobile-sidebar-toggle" class="md:hidden p-2 rounded-xl bg-[#F8F9FA] border border-[#CBD5E1] text-[#0F172A] hover:bg-[#E2E8F0] transition-colors flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div>
                    <h1 id="portal-current-tab-title" class="font-lux-title text-base md:text-xl text-[#0F172A] font-bold">Gösterge Paneli</h1>
                    <span class="text-[10px] md:text-xs text-[#64748B] hidden sm:block">MIKALE Club & Lounge Yönetim Sistemi</span>
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-3">
                <button type="button" onclick="switchPortalTab('notifications')" class="relative p-2 rounded-xl bg-[#F8F9FA] hover:bg-[#E2E8F0] border border-[#CBD5E1] text-[#0F172A] transition-all flex items-center justify-center shadow-sm" title="Garson & Sipariş Bildirimleri">
                    <svg class="w-4 h-4 text-[#8F6E40]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="header-waiter-badge" class="absolute -top-1 -right-1 px-1.5 py-0.2 rounded-full text-[9px] font-mono font-bold {{ $pendingWaiterCallsCount > 0 ? 'bg-red-500 text-white animate-pulse' : 'hidden' }}">{{ $pendingWaiterCallsCount }}</span>
                </button>

                <div class="relative hidden sm:block">
                    <input type="text" id="portal-live-search" 
                           class="bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-3 py-1.5 text-xs text-[#0F172A] focus:outline-none focus:border-[#8F6E40] w-36 md:w-48 transition-all">
                </div>
                <span class="px-2.5 py-1 rounded-full bg-[#F0FDF4] border border-[#BBF7D0] text-[10px] text-[#16A34A] font-semibold font-mono whitespace-nowrap">
                    ● Canlı Panel
                </span>
            </div>
        </header>

        <main class="p-4 md:p-6 space-y-6">
            @if(session('success'))
                <div class="bg-[#F0FDF4] border border-[#BBF7D0] text-[#16A34A] px-4 py-3 rounded-2xl text-xs font-medium flex items-center gap-2 shadow-sm">
                    <span class="text-base">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-[#FEF2F2] border border-[#FCA5A5] text-[#DC2626] px-4 py-3 rounded-2xl text-xs font-medium flex items-center gap-2">
                    <span>⚠</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <section id="section-dashboard" class="portal-tab-content {{ ($tab ?? 'dashboard') === 'dashboard' ? '' : 'hidden' }} space-y-6">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 md:p-5 shadow-sm hover:shadow-md transition-shadow flex items-center gap-3.5">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#FFFBEB] border border-[#FDE68A] flex items-center justify-center text-base md:text-xl text-[#D97706] flex-shrink-0">
                            🗂️
                        </div>
                        <div>
                            <span class="text-[10px] md:text-[11px] uppercase tracking-wider text-[#64748B] font-semibold block">Toplam Kategori</span>
                            <span class="font-lux-title text-xl md:text-2xl font-bold text-[#0F172A]">{{ $totalCategoriesCount }}</span>
                        </div>
                    </div>

                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 md:p-5 shadow-sm hover:shadow-md transition-shadow flex items-center gap-3.5">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#EFF6FF] border border-[#BFDBFE] flex items-center justify-center text-base md:text-xl text-[#2563EB] flex-shrink-0">
                            🍸
                        </div>
                        <div>
                            <span class="text-[10px] md:text-[11px] uppercase tracking-wider text-[#64748B] font-semibold block">Toplam Ürün</span>
                            <span class="font-lux-title text-xl md:text-2xl font-bold text-[#0F172A]">{{ $totalProductsCount }}</span>
                        </div>
                    </div>

                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 md:p-5 shadow-sm hover:shadow-md transition-shadow flex items-center gap-3.5">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#F0FDF4] border border-[#BBF7D0] flex items-center justify-center text-base md:text-xl text-[#16A34A] flex-shrink-0">
                            🪑
                        </div>
                        <div>
                            <span class="text-[10px] md:text-[11px] uppercase tracking-wider text-[#64748B] font-semibold block">Aktif Masalar</span>
                            <span class="font-lux-title text-xl md:text-2xl font-bold text-[#0F172A]">{{ $activeTablesCount }} / {{ $tables->count() }}</span>
                        </div>
                    </div>

                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 md:p-5 shadow-sm hover:shadow-md transition-shadow flex items-center gap-3.5">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-[#FAF5FF] border border-[#E9D5FF] flex items-center justify-center text-base md:text-xl text-[#9333EA] flex-shrink-0">
                            👥
                        </div>
                        <div>
                            <span class="text-[10px] md:text-[11px] uppercase tracking-wider text-[#64748B] font-semibold block">Aktif Misafirler</span>
                            <span class="font-lux-title text-xl md:text-2xl font-bold text-[#0F172A]">{{ $activeGuests->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-5 md:p-6 shadow-sm space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="text-[#8F6E40] text-lg">✦</span>
                        <h3 class="font-lux-title text-base md:text-lg font-bold text-[#0F172A]">Yönetim Portalı Kullanıma Hazır</h3>
                    </div>
                    <p class="text-xs text-[#64748B] max-w-2xl leading-relaxed">
                        Tüm kategorileri, kokteylleri, masaları ve misafir kayıtlarını anlık olarak ekleyebilir, sırasını değiştirebilir, düzenleyebilir ve silebilirsiniz.
                    </p>
                    <div class="flex items-center gap-2.5 flex-wrap pt-2">
                        <button type="button" onclick="switchPortalTab('guests')" class="px-4 py-2.5 rounded-xl bg-[#8F6E40] text-white font-semibold text-xs tracking-wider uppercase hover:bg-[#725732] transition-all shadow-sm">
                            + Yeni Misafir Kaydı
                        </button>
                        <button type="button" onclick="switchPortalTab('categories')" class="px-4 py-2.5 rounded-xl bg-[#FFFFFF] border border-[#CBD5E1] text-[#334155] text-xs font-semibold hover:bg-[#F8F9FA] transition-all">
                            Kategorileri & Sıralamayı Düzenle
                        </button>
                        <button type="button" onclick="switchPortalTab('products')" class="px-4 py-2.5 rounded-xl bg-[#FFFFFF] border border-[#CBD5E1] text-[#334155] text-xs font-semibold hover:bg-[#F8F9FA] transition-all">
                            Ürünleri Yönet ({{ $totalProductsCount }})
                        </button>
                        <button type="button" onclick="switchPortalTab('tables')" class="px-4 py-2.5 rounded-xl bg-[#FFFFFF] border border-[#CBD5E1] text-[#334155] text-xs font-semibold hover:bg-[#F8F9FA] transition-all">
                            Masa ve QR Yönetimi
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-5 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                            <h4 class="font-lux-title text-sm uppercase tracking-wider text-[#0F172A] font-bold">Masadaki Aktif Misafirler</h4>
                            <button type="button" onclick="switchPortalTab('guests')" class="text-xs text-[#8F6E40] font-semibold hover:underline">Tümünü Gör →</button>
                        </div>
                        <div class="space-y-2.5">
                            @forelse($activeGuests->take(4) as $guest)
                                <div class="bg-[#F8F9FA] border border-[#E2E8F0] rounded-2xl p-3.5 flex items-center justify-between">
                                    <div>
                                        <h5 class="text-xs font-bold text-[#0F172A]">{{ $guest->name }}</h5>
                                        <span class="text-[11px] font-mono text-[#8F6E40] font-semibold">{{ $guest->guest_code }} • {{ $guest->table->table_number ?? 'Masa Belirtilmedi' }}</span>
                                    </div>
                                    <span class="font-lux-title text-sm text-[#0F172A] font-bold">{{ number_format($guest->totalSpent(), 0, ',', '.') }} ₺</span>
                                </div>
                            @empty
                                <div class="text-center py-8 text-[#94A3B8] text-xs">Henüz aktif misafir bulunmuyor.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-5 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                            <h4 class="font-lux-title text-sm uppercase tracking-wider text-[#0F172A] font-bold">Son Gelen Siparişler</h4>
                            <button type="button" onclick="switchPortalTab('orders')" class="text-xs text-[#8F6E40] font-semibold hover:underline">Tümünü Gör →</button>
                        </div>
                        <div class="space-y-2.5">
                            @forelse($liveOrders->take(4) as $order)
                                <div class="bg-[#F8F9FA] border border-[#E2E8F0] rounded-2xl p-3.5 flex items-center justify-between">
                                    <div>
                                        <h5 class="text-xs font-bold text-[#0F172A]">#{{ $order->order_number }} • {{ $order->table->table_number ?? 'Masa' }}</h5>
                                        <span class="text-[11px] text-[#64748B]">{{ $order->guest->name ?? 'Misafir' }} ({{ $order->items->count() }} Kalem)</span>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold uppercase bg-[#FEF3C7] text-[#D97706] border border-[#FDE68A]">
                                        {{ $order->status }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center py-8 text-[#94A3B8] text-xs">Henüz sipariş bulunmuyor.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-categories" class="portal-tab-content {{ ($tab ?? '') === 'categories' ? '' : 'hidden' }} space-y-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm">
                    <div>
                        <h3 class="font-lux-title text-base font-bold text-[#0F172A]">Kategori Yönetimi & Sıralama</h3>
                        <span class="text-xs text-[#64748B]">Kategorileri ekleyin, düzenleyin, sıralamasını oklarla yönetin veya aktif/pasif yapın</span>
                    </div>
                    <button type="button" onclick="document.getElementById('add-category-modal').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-[#8F6E40] text-white font-semibold text-xs tracking-wider uppercase hover:bg-[#725732] transition-all shadow-sm">
                        + Yeni Kategori Ekle
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categories as $index => $category)
                        <div class="category-card-item bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between space-y-4" data-search="{{ strtolower($category->name . ' ' . $category->description) }}">
                            <div class="space-y-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col items-center justify-center bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-1 shadow-inner flex-shrink-0">
                                            <form action="{{ route('reception.category.reorder', $category) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="direction" value="up">
                                                <button type="submit" title="Kategoriyi Yukarı Taşı" class="p-1 hover:text-[#8F6E40] text-xs leading-none font-bold">▲</button>
                                            </form>
                                            <span class="text-[10px] font-mono font-bold text-[#64748B] px-1">{{ $index + 1 }}</span>
                                            <form action="{{ route('reception.category.reorder', $category) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="direction" value="down">
                                                <button type="submit" title="Kategoriyi Aşağı Taşı" class="p-1 hover:text-[#8F6E40] text-xs leading-none font-bold">▼</button>
                                            </form>
                                        </div>

                                        <div>
                                            <h4 class="font-lux-title text-lg font-bold text-[#0F172A]">{{ $category->name }}</h4>
                                            <span class="text-[11px] text-[#64748B] block font-mono">Slug: {{ $category->slug }}</span>
                                        </div>
                                    </div>

                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $category->is_active ? 'bg-[#DCFCE7] text-[#16A34A]' : 'bg-[#F1F5F9] text-[#64748B]' }}">
                                        {{ $category->is_active ? 'Aktif' : 'Pasif' }}
                                    </span>
                                </div>

                                @if($category->description)
                                    <p class="text-xs text-[#64748B] line-clamp-2">{{ $category->description }}</p>
                                @endif

                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-xl bg-[#F8F9FA] border border-[#CBD5E1] text-xs font-semibold text-[#475569]">
                                        📦 {{ $category->products->count() }} Ürün Kayıtlı
                                    </span>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-[#F1F5F9] flex items-center justify-between gap-2">
                                <button type="button" 
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        data-desc="{{ $category->description }}"
                                        data-order="{{ $category->sort_order }}"
                                        onclick="openEditCategoryModalFromBtn(this)" 
                                        class="px-3 py-1.5 rounded-xl bg-[#EFF6FF] border border-[#BFDBFE] text-xs font-semibold text-[#2563EB] hover:bg-[#DBEAFE] transition-all">
                                    Düzenle
                                </button>

                                <div class="flex items-center gap-2">
                                    <form action="{{ route('reception.category.toggle', $category) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl bg-[#F1F5F9] text-xs font-semibold text-[#475569] hover:bg-[#E2E8F0] transition-all">
                                            {{ $category->is_active ? 'Gizle' : 'Aç' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('reception.category.delete', $category) }}" method="POST" onsubmit="return confirm('{{ $category->name }} kategorisini ve içindeki ürünleri silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-[#FEF2F2] border border-[#FCA5A5] text-xs font-bold text-[#DC2626] hover:bg-[#FEE2E2] transition-all">
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="section-products" class="portal-tab-content {{ ($tab ?? '') === 'products' ? '' : 'hidden' }} space-y-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm">
                    <div>
                        <h3 class="font-lux-title text-base font-bold text-[#0F172A]">Tüm Ürünler & Sıralama Yönetimi</h3>
                        <span class="text-xs text-[#64748B]">Ürünün kategorisini, fiyatını veya kategori içi gösterim sırasını değiştirin</span>
                    </div>
                    <button type="button" onclick="document.getElementById('add-product-modal').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-[#8F6E40] text-white font-semibold text-xs tracking-wider uppercase hover:bg-[#725732] transition-all shadow-sm">
                        + Yeni Ürün Ekle
                    </button>
                </div>

                <div class="flex items-center gap-2 overflow-x-auto pb-1">
                    <button type="button" onclick="filterPortalProducts('all', this)" class="prod-filter-btn px-3.5 py-1.5 rounded-xl bg-[#8F6E40] text-white text-xs font-semibold whitespace-nowrap shadow-sm">
                        Tümü ({{ $products->count() }})
                    </button>
                    @foreach($categories as $c)
                        <button type="button" onclick="filterPortalProducts('cat-{{ $c->id }}', this)" class="prod-filter-btn px-3.5 py-1.5 rounded-xl bg-[#FFFFFF] border border-[#CBD5E1] text-[#475569] hover:bg-[#F1F5F9] text-xs font-semibold whitespace-nowrap">
                            {{ $c->name }} ({{ $c->products_count }})
                        </button>
                    @endforeach
                </div>

                <div class="space-y-3" id="products-list-container">
                    @foreach($products as $product)
                        <div class="product-item-row bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col md:flex-row items-start md:items-center justify-between gap-4"
                             data-cat="cat-{{ $product->category_id }}"
                             data-search="{{ strtolower($product->name . ' ' . $product->description . ' ' . ($product->category->name ?? '') . ' ' . $product->taste_notes) }}">
                            <div class="flex items-start gap-3 flex-1 min-w-0">
                                <div class="flex flex-col items-center justify-center bg-[#F8F9FA] border border-[#CBD5E1] rounded-lg p-1 shadow-inner flex-shrink-0">
                                    <form action="{{ route('reception.product.reorder', $product) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="direction" value="up">
                                        <input type="hidden" name="tab" value="products">
                                        <button type="submit" title="Ürünü Yukarı Taşı" class="p-0.5 hover:text-[#8F6E40] text-xs leading-none font-bold">▲</button>
                                    </form>
                                    <span class="text-[10px] font-mono font-bold text-[#64748B]">{{ $product->sort_order }}</span>
                                    <form action="{{ route('reception.product.reorder', $product) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="direction" value="down">
                                        <input type="hidden" name="tab" value="products">
                                        <button type="submit" title="Ürünü Aşağı Taşı" class="p-0.5 hover:text-[#8F6E40] text-xs leading-none font-bold">▼</button>
                                    </form>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold bg-[#EFF6FF] text-[#2563EB] border border-[#BFDBFE] flex items-center gap-1">
                                            <span>🗂️ Kategori:</span>
                                            <strong>{{ $product->category->name ?? 'Kategorisiz' }}</strong>
                                        </span>
                                        @if($product->badge)
                                            <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-[#FEF3C7] text-[#D97706]">
                                                {{ $product->badge }}
                                            </span>
                                        @endif
                                        @if($product->is_featured)
                                            <span class="text-xs text-[#D97706] font-bold">★ Günün Spesiyali</span>
                                        @endif
                                    </div>
                                    <h4 class="font-lux-title text-base font-bold text-[#0F172A]">{{ $product->name }}</h4>
                                    <p class="text-xs text-[#64748B] truncate max-w-xl">{{ $product->description }}</p>
                                    @if($product->taste_notes)
                                        <span class="text-[11px] text-[#8F6E40] font-medium block mt-0.5">✦ Tat Profili: {{ $product->taste_notes }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-4 flex-shrink-0">
                                <div class="text-right">
                                    <span class="font-lux-title text-lg font-bold text-[#0F172A] block">{{ $product->formatted_price }}</span>
                                    <span class="text-[10px] uppercase font-semibold {{ $product->is_available ? 'text-[#16A34A]' : 'text-[#94A3B8]' }}">
                                        {{ $product->is_available ? 'Satışta' : 'Kapalı' }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            data-id="{{ $product->id }}"
                                            data-cat-id="{{ $product->category_id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}"
                                            data-badge="{{ $product->badge }}"
                                            data-notes="{{ $product->taste_notes }}"
                                            data-desc="{{ $product->description }}"
                                            data-order="{{ $product->sort_order }}"
                                            data-special="{{ ($product->is_featured || $product->is_special) ? '1' : '0' }}"
                                            onclick="openEditProductModalFromBtn(this)" 
                                            class="px-3.5 py-2 rounded-xl bg-[#EFF6FF] border border-[#BFDBFE] text-xs font-bold text-[#2563EB] hover:bg-[#DBEAFE] transition-all">
                                        Düzenle
                                    </button>
                                    <form action="{{ route('reception.product.toggle', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 rounded-xl bg-[#F1F5F9] border border-[#E2E8F0] text-xs font-semibold text-[#475569] hover:bg-[#E2E8F0]">
                                            {{ $product->is_available ? 'Kapat' : 'Aç' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('reception.product.delete', $product) }}" method="POST" onsubmit="return confirm('{{ $product->name }} ürününü silmek istediğinize emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 rounded-xl bg-[#FEF2F2] border border-[#FCA5A5] text-xs font-bold text-[#DC2626] hover:bg-[#FEE2E2]">
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="section-guests" class="portal-tab-content {{ ($tab ?? '') === 'guests' ? '' : 'hidden' }} space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-5 shadow-sm space-y-4">
                        <div class="border-b border-[#F1F5F9] pb-3">
                            <span class="text-[10px] uppercase tracking-widest text-[#8F6E40] font-bold block">Resepsiyon Deski</span>
                            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Yeni Misafir Kaydı</h3>
                        </div>

                        <form action="{{ route('reception.checkin') }}" method="POST" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold text-[#475569] mb-1">Misafir Adı Soyadı *</label>
                                <input type="text" name="name" required
                                       class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#475569] mb-1">VIP Kodu (Opsiyonel / Boşsa Otomatik Üretilir)</label>
                                <input type="text" name="guest_code"
                                       class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] font-mono uppercase font-medium focus:outline-none focus:border-[#8F6E40]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#475569] mb-1">Telefon Numarası</label>
                                <input type="text" name="phone"
                                       class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#475569] mb-1">Atanacak Masa</label>
                                <select name="club_table_id" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-3.5 py-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
                                    <option value="">-- Masasız / Bar Ayakta --</option>
                                    @foreach($tables as $table)
                                        <option value="{{ $table->id }}">{{ $table->table_number }} - {{ $table->name }} ({{ $table->section }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs tracking-wider uppercase hover:bg-[#725732] transition-all shadow-md">
                                Misafiri Kaydet & VIP Kod Oluştur
                            </button>
                        </form>
                    </div>

                    <div class="lg:col-span-2 space-y-4">
                        <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-5 shadow-sm space-y-3">
                            <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
                                <div>
                                    <h4 class="font-lux-title text-base font-bold text-[#0F172A]">İçerideki Aktif Misafirler</h4>
                                    <span class="text-xs text-[#64748B]">Düzenleyin, masa değiştirin veya hesabı kapatın</span>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-[#FDFBF7] border border-[#B38E5D]/40 text-xs font-bold text-[#8F6E40]">
                                    Toplam: {{ number_format($totalActiveSpent, 0, ',', '.') }} ₺
                                </span>
                            </div>

                            <div class="space-y-2.5 max-h-[500px] overflow-y-auto pr-1">
                                @forelse($activeGuests as $guest)
                                    <div class="guest-card-item bg-[#F8F9FA] border border-[#E2E8F0] rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3"
                                         data-search="{{ strtolower($guest->name . ' ' . $guest->guest_code . ' ' . ($guest->phone ?? '') . ' ' . ($guest->table->table_number ?? '')) }}">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h5 class="text-sm font-bold text-[#0F172A]">{{ $guest->name }}</h5>
                                                <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold bg-[#8F6E40] text-white">
                                                    {{ $guest->guest_code }}
                                                </span>
                                            </div>
                                            <span class="text-xs text-[#64748B] block">
                                                Masa: <strong class="text-[#0F172A]">{{ $guest->table->table_number ?? 'Belirtilmedi' }}</strong> • Giriş: {{ $guest->check_in_at ? $guest->check_in_at->format('H:i') : '-' }} • Tel: {{ $guest->phone }}
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                                            <div class="text-right mr-2">
                                                <span class="text-[10px] text-[#64748B] block uppercase font-semibold">Harcama</span>
                                                <span class="font-lux-title text-sm font-bold text-[#0F172A]">{{ number_format($guest->totalSpent(), 0, ',', '.') }} ₺</span>
                                            </div>

                                            <button type="button" 
                                                    data-id="{{ $guest->id }}"
                                                    data-name="{{ $guest->name }}"
                                                    data-code="{{ $guest->guest_code }}"
                                                    data-phone="{{ $guest->phone }}"
                                                    data-table-id="{{ $guest->club_table_id }}"
                                                    data-status="{{ $guest->status }}"
                                                    onclick="openEditGuestModalFromBtn(this)" 
                                                    class="px-3 py-2 rounded-xl bg-[#EFF6FF] border border-[#BFDBFE] text-xs font-semibold text-[#2563EB] hover:bg-[#DBEAFE]">
                                                Düzenle
                                            </button>

                                            <form action="{{ route('reception.checkout', $guest) }}" method="POST" onsubmit="return confirm('{{ $guest->name }} misafirinin hesabını kapatıp çıkış yapmak istiyor musunuz?')">
                                                @csrf
                                                <button type="submit" class="px-3 py-2 rounded-xl bg-[#DCFCE7] border border-[#BBF7D0] text-[#16A34A] hover:bg-[#BBF7D0] text-xs font-bold transition-all shadow-sm">
                                                    Hesabı Kapat
                                                </button>
                                            </form>

                                            <form action="{{ route('reception.guest.delete', $guest) }}" method="POST" onsubmit="return confirm('Misafir kaydını silmek istediğinize emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-2 rounded-xl bg-[#FEF2F2] border border-[#FCA5A5] text-[#DC2626] text-xs font-bold hover:bg-[#FEE2E2]">
                                                    Sil
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 text-[#94A3B8] text-xs">Aktif kayıtlı misafir bulunmuyor.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-tables" class="portal-tab-content {{ ($tab ?? '') === 'tables' ? '' : 'hidden' }} space-y-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm">
                    <div>
                        <h3 class="font-lux-title text-base font-bold text-[#0F172A]">Masa Haritası ve Özel QR Motoru</h3>
                        <span class="text-xs text-[#64748B]">Masaları ekleyin, düzenleyin, QR kodları yenileyin veya yazdırın</span>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('reception.tables.print_all') }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-[#F8F9FA] border border-[#CBD5E1] text-xs text-[#334155] font-semibold hover:bg-[#E2E8F0] transition-all">
                            🖨️ Toplu A4 QR Yazdır
                        </a>
                        <button type="button" onclick="document.getElementById('add-table-modal').classList.remove('hidden')" class="px-4 py-2 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-sm">
                            + Yeni Masa Ekle
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($tables as $table)
                        <div class="table-card-item bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between space-y-3"
                             data-search="{{ strtolower($table->table_number . ' ' . $table->name . ' ' . $table->section) }}">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-mono text-sm font-bold text-[#0F172A]">{{ $table->table_number }}</span>
                                    <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $table->activeGuests->count() > 0 ? 'bg-[#DCFCE7] text-[#16A34A] border border-[#BBF7D0]' : 'bg-[#F1F5F9] text-[#64748B]' }}">
                                        {{ $table->activeGuests->count() > 0 ? $table->activeGuests->count() . ' Misafir' : 'Boş' }}
                                    </span>
                                </div>
                                <h5 class="text-xs font-bold text-[#334155]">{{ $table->name }}</h5>
                                <span class="text-[11px] text-[#64748B] block">{{ $table->section }} • Kapasite: {{ $table->capacity }} Kişi</span>
                            </div>

                            <div class="bg-[#F8F9FA] border border-[#E2E8F0] rounded-xl p-2.5 flex items-center gap-3">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data={{ urlencode(url('/table/' . $table->qr_token)) }}&bgcolor=FFFFFF&color=1E293B" 
                                     alt="QR {{ $table->table_number }}" class="w-12 h-12 rounded border border-[#CBD5E1] bg-white flex-shrink-0 shadow-sm">
                                <div class="flex-1 min-w-0 text-[11px]">
                                    <span class="text-[#64748B] block truncate">Token: {{ $table->qr_token }}</span>
                                    <a href="{{ route('reception.table.print_qr', $table) }}" target="_blank" class="text-[#8F6E40] font-bold hover:underline block mt-0.5">
                                        Pleksi Stant Önizle ↗
                                    </a>
                                </div>
                            </div>

                            <a href="{{ route('table.show', $table->qr_token) }}" target="_blank" class="w-full py-2 px-3 rounded-xl bg-[#FDFBF7] hover:bg-[#8F6E40] border border-[#B38E5D]/40 text-[#8F6E40] hover:text-white font-bold text-xs flex items-center justify-center gap-1.5 transition-all shadow-sm group">
                                <span>🍸 Menüyü Görüntüle</span>
                                <span class="group-hover:translate-x-0.5 transition-transform">↗</span>
                            </a>

                            <div class="pt-2 border-t border-[#F1F5F9] flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            data-id="{{ $table->id }}"
                                            data-name="{{ $table->name }}"
                                            data-section="{{ $table->section }}"
                                            data-capacity="{{ $table->capacity }}"
                                            onclick="openEditTableModalFromBtn(this)" 
                                            class="font-semibold text-[#2563EB] hover:underline">
                                        Düzenle
                                    </button>
                                    <span class="text-[#CBD5E1]">•</span>
                                    <form action="{{ route('reception.table.regenerate_qr', $table) }}" method="POST" onsubmit="return confirm('QR kodu yenilensin mi?')">
                                        @csrf
                                        <button type="submit" class="font-semibold text-[#64748B] hover:text-[#0F172A]">QR Yenile</button>
                                    </form>
                                </div>
                                <form action="{{ route('reception.table.delete', $table) }}" method="POST" onsubmit="return confirm('{{ $table->table_number }} masasını silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold text-[#DC2626] hover:underline">Sil</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="section-notifications" class="portal-tab-content {{ ($tab ?? '') === 'notifications' ? '' : 'hidden' }} space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                            <h3 class="font-lux-title text-base font-bold text-[#0F172A]">Garson & Sipariş Bildirimleri (Canlı)</h3>
                        </div>
                        <span class="text-xs text-[#64748B]">Masalardan gelen anlık servis çağrıları ve yeni siparişler tüm detaylarıyla burada listelenir</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full bg-[#F0FDF4] border border-[#BBF7D0] text-[10px] text-[#16A34A] font-semibold font-mono whitespace-nowrap flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Otomatik Canlı Takip: Açık</span>
                        </span>
                        <form action="{{ route('reception.waiter_call.clear_all') }}" method="POST" onsubmit="return confirm('Tüm bekleyen bildirimler tamamlandı olarak işaretlensin mi?')">
                            @csrf
                            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-[#F8F9FA] hover:bg-[#E2E8F0] border border-[#CBD5E1] text-[#0F172A] text-xs font-semibold transition-all">
                                Tümünü Tamamla
                            </button>
                        </form>
                    </div>
                </div>

                <div id="portal-notifications-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($waiterCalls as $call)
                        <div class="waiter-call-card bg-[#FFFFFF] border {{ $call->status === 'pending' ? 'border-[#8F6E40]/60 ring-2 ring-[#8F6E40]/20' : 'border-[#E2E8F0]' }} rounded-2xl p-4 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-3"
                             data-id="{{ $call->id }}"
                             data-search="{{ strtolower($call->table_number . ' ' . ($call->guest_name ?? '') . ' ' . $call->title . ' ' . ($call->message ?? '')) }}">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-1.5">
                                        @if($call->type === 'order')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#FEF3C7] text-[#B45309] border border-[#FDE68A]">🛒 SİPARİŞ</span>
                                        @elseif($call->type === 'bill')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#EFF6FF] text-[#1D4ED8] border border-[#BFDBFE]">💳 HESAP İSTEĞİ</span>
                                        @elseif($call->type === 'ice')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#F0FDF4] text-[#15803D] border border-[#BBF7D0]">🧊 BUZ & BARDAK</span>
                                        @elseif($call->type === 'ashtray')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#F8FAFC] text-[#475569] border border-[#E2E8F0]">🚬 KÜL TABLASI</span>
                                        @elseif($call->type === 'hookah')
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#FAF5FF] text-[#7E22CE] border border-[#E9D5FF]">💨 KÖZ YENİLEME</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#FEF2F2] text-[#B91C1C] border border-[#FECACA]">🛎️ GARSON ÇAĞRISI</span>
                                        @endif
                                        <span class="font-mono text-xs font-bold text-[#0F172A]">{{ $call->table_number }}</span>
                                    </div>
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold font-mono {{ $call->status === 'pending' ? 'bg-red-50 text-red-600 border border-red-200 animate-pulse' : 'bg-emerald-50 text-emerald-600 border border-emerald-200' }}">
                                        {{ $call->status === 'pending' ? 'BEKLİYOR' : 'TAMAMLANDI' }}
                                    </span>
                                </div>

                                <h4 class="font-lux-title text-sm font-bold text-[#0F172A]">{{ $call->title }}</h4>
                                <div class="flex items-center gap-2 text-[11px] text-[#64748B] mb-2">
                                    @if($call->guest_name)
                                        <span class="font-medium text-[#334155]">👤 {{ $call->guest_name }}</span>
                                    @endif
                                    @if($call->guest_code)
                                        <span class="font-mono font-bold text-[#8F6E40]">[{{ $call->guest_code }}]</span>
                                    @endif
                                    <span>• {{ $call->created_at ? $call->created_at->diffForHumans() : '' }}</span>
                                </div>

                                @if($call->message)
                                    <div class="p-2.5 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] text-xs text-[#334155] mb-2">
                                        <span class="text-[10px] uppercase font-bold text-[#64748B] block mb-0.5">Misafir Notu:</span>
                                        {{ $call->message }}
                                    </div>
                                @endif

                                @if(!empty($call->order_items))
                                    <div class="border border-[#F1F5F9] rounded-xl p-2.5 bg-[#FAFBFD] space-y-1.5 mb-2">
                                        <span class="text-[10px] uppercase font-bold text-[#64748B] block mb-1">Sipariş İçeriği:</span>
                                        @foreach($call->order_items as $item)
                                            <div class="flex items-center justify-between text-xs py-0.5 border-b border-[#F1F5F9] last:border-0">
                                                <div class="flex items-center gap-1.5 truncate">
                                                    <span class="font-bold text-[#8F6E40]">{{ $item['quantity'] ?? 1 }}x</span>
                                                    <span class="text-[#1E293B] truncate">{{ $item['name'] ?? '' }}</span>
                                                </div>
                                                <span class="font-mono font-semibold text-[#0F172A] text-xs flex-shrink-0 ml-2">
                                                    {{ number_format($item['total'] ?? ($item['price'] ?? 0), 0, ',', '.') }} ₺
                                                </span>
                                            </div>
                                        @endforeach
                                        @if($call->total_amount)
                                            <div class="pt-1.5 mt-1 border-t border-[#E2E8F0] flex items-center justify-between font-bold text-xs">
                                                <span class="text-[#0F172A]">Toplam Tutar:</span>
                                                <span class="font-mono text-[#8F6E40]">{{ number_format($call->total_amount, 0, ',', '.') }} ₺</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="pt-2 border-t border-[#F1F5F9] flex items-center gap-2">
                                <form action="{{ route('reception.waiter_call.status', $call) }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $call->status === 'pending' ? 'completed' : 'pending' }}">
                                    <button type="submit" class="w-full py-1.5 px-2 rounded-lg {{ $call->status === 'pending' ? 'bg-[#DCFCE7] hover:bg-[#BBF7D0] border border-[#BBF7D0] text-[#16A34A]' : 'bg-[#F1F5F9] hover:bg-[#E2E8F0] border border-[#CBD5E1] text-[#475569]' }} text-xs font-bold transition-all">
                                        {{ $call->status === 'pending' ? '✓ Tamamlandı' : '↺ Beklet' }}
                                    </button>
                                </form>
                                <form action="{{ route('reception.waiter_call.delete', $call) }}" method="POST" onsubmit="return confirm('Bildirimi silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-[#FEF2F2] hover:bg-[#FEE2E2] border border-[#FECACA] text-[#DC2626] text-xs font-bold transition-all" title="Sil">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-[#94A3B8] text-xs bg-[#FFFFFF] rounded-2xl border border-[#E2E8F0]">Henüz bekleyen garson çağrısı veya sipariş bildirimi bulunmuyor.</div>
                    @endforelse
                </div>
            </section>

            <section id="section-orders" class="portal-tab-content {{ ($tab ?? '') === 'orders' ? '' : 'hidden' }} space-y-6">
                <div class="flex items-center justify-between bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm">
                    <div>
                        <h3 class="font-lux-title text-base font-bold text-[#0F172A]">Canlı Sipariş Akışı (KDS)</h3>
                        <span class="text-xs text-[#64748B]">Sipariş durumunu Hazırla, Servis Et veya Tamamla olarak güncelleyin</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($liveOrders as $order)
                        <div class="order-card-item bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between space-y-3"
                             data-search="{{ strtolower($order->order_number . ' ' . ($order->guest->name ?? '') . ' ' . ($order->table->table_number ?? '')) }}">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="font-mono text-xs font-bold text-[#8F6E40]">#{{ $order->order_number }}</span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase bg-[#FEF3C7] text-[#D97706]">
                                        {{ $order->status }}
                                    </span>
                                </div>
                                <h4 class="font-lux-title text-sm font-bold text-[#0F172A]">{{ $order->table->table_number ?? 'Masa' }} - {{ $order->guest->name ?? 'Misafir' }}</h4>
                                <span class="text-[11px] text-[#64748B] block mb-2">{{ $order->created_at->diffForHumans() }}</span>

                                <div class="space-y-1.5 border-t border-b border-[#F1F5F9] py-2">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-[#334155] font-medium">{{ $item->quantity }}x {{ $item->product->name ?? 'Ürün' }}</span>
                                            <span class="font-mono font-semibold text-[#0F172A] text-xs">{{ number_format($item->subtotal, 0, ',', '.') }} ₺</span>
                                        </div>
                                    @endforeach
                                </div>

                                @if($order->note)
                                    <div class="mt-2 text-[11px] text-[#B45309] bg-[#FFFBEB] p-2 rounded-lg border border-[#FDE68A]">
                                        Not: {{ $order->note }}
                                    </div>
                                @endif
                            </div>

                            <div class="pt-2 border-t border-[#F1F5F9] space-y-2">
                                <form action="{{ route('reception.order.status', $order) }}" method="POST" class="grid grid-cols-3 gap-1.5">
                                    @csrf
                                    <button type="submit" name="status" value="preparing" class="py-1.5 rounded-lg bg-[#FEF3C7] border border-[#FDE68A] text-[10px] font-bold text-[#D97706] hover:bg-[#FDE68A]">
                                        Hazırla
                                    </button>
                                    <button type="submit" name="status" value="served" class="py-1.5 rounded-lg bg-[#DCFCE7] border border-[#BBF7D0] text-[10px] font-bold text-[#16A34A] hover:bg-[#BBF7D0]">
                                        Servis Et
                                    </button>
                                    <button type="submit" name="status" value="completed" class="py-1.5 rounded-lg bg-[#EFF6FF] border border-[#BFDBFE] text-[10px] font-bold text-[#2563EB] hover:bg-[#DBEAFE]">
                                        Tamamla
                                    </button>
                                </form>
                                <form action="{{ route('reception.order.delete', $order) }}" method="POST" onsubmit="return confirm('Siparişi silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full text-center text-[10px] text-[#DC2626] hover:underline font-semibold">
                                        Siparişi İptal Et & Sil
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-[#94A3B8] text-xs">Aktif sipariş bulunmuyor.</div>
                    @endforelse
                </div>
            </section>

            <section id="section-bills" class="portal-tab-content {{ ($tab ?? '') === 'bills' ? '' : 'hidden' }} space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-5 shadow-sm">
                        <span class="text-xs uppercase tracking-wider text-[#64748B] font-semibold block">Toplam Ciro</span>
                        <span class="font-lux-title text-2xl font-bold text-[#16A34A]">{{ number_format($totalBillsRevenue, 0, ',', '.') }} ₺</span>
                    </div>
                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-5 shadow-sm">
                        <span class="text-xs uppercase tracking-wider text-[#64748B] font-semibold block">Kapanan Hesap Sayısı</span>
                        <span class="font-lux-title text-2xl font-bold text-[#0F172A]">{{ $bills->count() }}</span>
                    </div>
                    <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-5 shadow-sm">
                        <span class="text-xs uppercase tracking-wider text-[#64748B] font-semibold block">Açık Masa Bakiyesi</span>
                        <span class="font-lux-title text-2xl font-bold text-[#8F6E40]">{{ number_format($totalActiveSpent, 0, ',', '.') }} ₺</span>
                    </div>
                </div>

                <div class="bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-5 shadow-sm space-y-3">
                    <h4 class="font-lux-title text-base font-bold text-[#0F172A] border-b border-[#F1F5F9] pb-3">Kapanan Hesap Geçmişi & Faturalar</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs whitespace-nowrap">
                            <thead>
                                <tr class="border-b border-[#E2E8F0] text-[#64748B] font-semibold">
                                    <th class="py-3 px-2">Fatura No</th>
                                    <th class="px-2">Misafir</th>
                                    <th class="px-2">Masa</th>
                                    <th class="px-2">Ara Toplam</th>
                                    <th class="px-2">Hizmet Bedeli</th>
                                    <th class="px-2">Toplam</th>
                                    <th class="px-2">Tarih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#F1F5F9]">
                                @forelse($bills as $bill)
                                    <tr class="bill-row-item hover:bg-[#F8F9FA]" data-search="{{ strtolower($bill->bill_number . ' ' . ($bill->guest->name ?? '') . ' ' . ($bill->table->table_number ?? '')) }}">
                                        <td class="py-3 px-2 font-mono font-bold text-[#8F6E40]">{{ $bill->bill_number }}</td>
                                        <td class="px-2 text-[#0F172A] font-semibold">{{ $bill->guest->name ?? 'Misafir' }}</td>
                                        <td class="px-2 font-medium text-[#475569]">{{ $bill->table->table_number ?? '-' }}</td>
                                        <td class="px-2">{{ number_format($bill->subtotal, 0, ',', '.') }} ₺</td>
                                        <td class="px-2">{{ number_format($bill->service_fee, 0, ',', '.') }} ₺</td>
                                        <td class="px-2 font-bold text-[#0F172A]">{{ number_format($bill->total_amount, 0, ',', '.') }} ₺</td>
                                        <td class="px-2 text-[#64748B] text-[11px]">{{ $bill->paid_at ? $bill->paid_at->format('d.m.Y H:i') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-[#94A3B8]">Kapanan hesap kaydı bulunamadı.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="section-settings" class="portal-tab-content {{ ($tab ?? '') === 'settings' ? '' : 'hidden' }} space-y-6">
                <div class="flex items-center justify-between bg-[#FFFFFF] border border-[#E2E8F0] rounded-2xl p-4 shadow-sm">
                    <div>
                        <h3 class="font-lux-title text-base font-bold text-[#0F172A]">Yönetici Hesap ve Güvenlik Ayarları</h3>
                        <span class="text-xs text-[#64748B]">Portal giriş e-posta adresinizi ve şifrenizi buradan güncelleyebilirsiniz</span>
                    </div>
                </div>

                <div class="max-w-2xl bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                    <form action="{{ route('reception.settings.update') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="flex items-center gap-3 p-4 rounded-2xl bg-[#F8FAFC] border border-[#E2E8F0]">
                            <div class="w-12 h-12 rounded-2xl bg-[#8F6E40]/10 border border-[#8F6E40]/20 flex items-center justify-center text-xl font-bold text-[#8F6E40]">
                                👤
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-[#64748B] block tracking-wider">Aktif Giriş E-posta</span>
                                <span class="font-mono text-sm font-bold text-[#0F172A]">{{ Auth::user()->email ?? 'club@gmail.com' }}</span>
                            </div>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-semibold text-[#475569] mb-1.5">Giriş E-posta Adresi *</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? 'club@gmail.com') }}" required 
                                       class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-4 py-3 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40] transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#475569] mb-1.5">Görünen Yönetici Adı</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name ?? 'Resepsiyon Yönetici') }}" 
                                       class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-4 py-3 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40] transition-all">
                            </div>

                            <div class="h-[1px] bg-[#F1F5F9] my-4"></div>

                            <div>
                                <h4 class="font-lux-title text-sm font-bold text-[#0F172A] mb-1">Şifre Değiştirme (Opsiyonel)</h4>
                                <p class="text-[11px] text-[#64748B] mb-3">Şifrenizi değiştirmek istemiyorsanız bu alanları boş bırakabilirsiniz.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#475569] mb-1.5">Mevcut Şifre</label>
                                <input type="password" name="current_password" 
                                       class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-4 py-3 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40] transition-all">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-[#475569] mb-1.5">Yeni Şifre</label>
                                    <input type="password" name="password" 
                                           class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-4 py-3 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40] transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-[#475569] mb-1.5">Yeni Şifre Tekrarı</label>
                                    <input type="password" name="password_confirmation" 
                                           class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl px-4 py-3 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40] transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-[#8F6E40] hover:bg-[#725732] text-white font-lux-title text-xs font-bold uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                                <span>💾</span>
                                <span>Değişiklikleri Kaydet</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</div>

<div id="add-category-modal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('add-category-modal').classList.add('hidden')"></div>
    <div class="relative bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl max-w-md w-full p-6 shadow-2xl z-10 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Yeni Kategori Ekle</h3>
            <button type="button" onclick="document.getElementById('add-category-modal').classList.add('hidden')" class="text-[#64748B] hover:text-[#0F172A] text-lg font-bold">✕</button>
        </div>
        <form action="{{ route('reception.category.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Kategori Adı *</label>
                <input type="text" name="name" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Açıklama</label>
                <input type="text" name="description" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-md">
                Kategoriyi Kaydet
            </button>
        </form>
    </div>
</div>

<div id="edit-category-modal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('edit-category-modal').classList.add('hidden')"></div>
    <div class="relative bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl max-w-md w-full p-6 shadow-2xl z-10 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Kategoriyi Düzenle</h3>
            <button type="button" onclick="document.getElementById('edit-category-modal').classList.add('hidden')" class="text-[#64748B] hover:text-[#0F172A] text-lg font-bold">✕</button>
        </div>
        <form id="edit-category-form" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Kategori Adı *</label>
                <input type="text" name="name" id="edit-cat-name" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Açıklama</label>
                <input type="text" name="description" id="edit-cat-desc" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Sıra No</label>
                <input type="number" name="sort_order" id="edit-cat-order" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium focus:outline-none focus:border-[#8F6E40]">
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-md">
                Değişiklikleri Güncelle
            </button>
        </form>
    </div>
</div>

<div id="add-product-modal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('add-product-modal').classList.add('hidden')"></div>
    <div class="relative bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl max-w-lg w-full p-6 shadow-2xl z-10 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Yeni Ürün Ekle</h3>
            <button type="button" onclick="document.getElementById('add-product-modal').classList.add('hidden')" class="text-[#64748B] hover:text-[#0F172A] text-lg font-bold">✕</button>
        </div>
        <form action="{{ route('reception.product.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Kategori *</label>
                <select name="category_id" id="add-prod-category-select" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Ürün Adı *</label>
                <input type="text" name="name" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Fiyat (₺) *</label>
                    <input type="number" step="0.01" name="price" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Rozet / Badge</label>
                    <input type="text" name="badge" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Tat Notları</label>
                <input type="text" name="taste_notes" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Açıklama</label>
                <textarea name="description" rows="2" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium"></textarea>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_special" id="is_special_check" value="1" class="rounded border-[#CBD5E1] text-[#8F6E40]">
                <label for="is_special_check" class="text-xs font-medium text-[#334155]">Günün Spesiyallerinde Göster</label>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-md">
                Ürünü Kaydet
            </button>
        </form>
    </div>
</div>

<div id="edit-product-modal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('edit-product-modal').classList.add('hidden')"></div>
    <div class="relative bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl max-w-lg w-full p-6 shadow-2xl z-10 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Ürünü & Kategorisini Düzenle</h3>
            <button type="button" onclick="document.getElementById('edit-product-modal').classList.add('hidden')" class="text-[#64748B] hover:text-[#0F172A] text-lg font-bold">✕</button>
        </div>
        <form id="edit-product-form" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Bağlı Olduğu Kategori *</label>
                <select name="category_id" id="edit-prod-category" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-bold">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Ürün Adı *</label>
                <input type="text" name="name" id="edit-prod-name" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Fiyat (₺) *</label>
                    <input type="number" step="0.01" name="price" id="edit-prod-price" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Rozet / Badge</label>
                    <input type="text" name="badge" id="edit-prod-badge" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Tat Notları</label>
                    <input type="text" name="taste_notes" id="edit-prod-notes" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Sıra No</label>
                    <input type="number" name="sort_order" id="edit-prod-order" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Açıklama</label>
                <textarea name="description" id="edit-prod-desc" rows="2" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium"></textarea>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <input type="checkbox" name="is_special" id="edit-prod-special" value="1" class="rounded border-[#CBD5E1] text-[#8F6E40]">
                <label for="edit-prod-special" class="text-xs font-medium text-[#334155]">Günün Spesiyallerinde Göster</label>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-md">
                Değişiklikleri Güncelle
            </button>
        </form>
    </div>
</div>

<div id="add-table-modal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('add-table-modal').classList.add('hidden')"></div>
    <div class="relative bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl max-w-md w-full p-6 shadow-2xl z-10 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Yeni Masa & QR Üret</h3>
            <button type="button" onclick="document.getElementById('add-table-modal').classList.add('hidden')" class="text-[#64748B] hover:text-[#0F172A] text-lg font-bold">✕</button>
        </div>
        <form action="{{ route('reception.table.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Masa No *</label>
                <input type="text" name="table_number" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Masa Adı *</label>
                <input type="text" name="name" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Bölüm *</label>
                    <input type="text" name="section" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Kapasite *</label>
                    <input type="number" name="capacity" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-md">
                Masayı ve QR'ı Oluştur
            </button>
        </form>
    </div>
</div>

<div id="edit-table-modal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('edit-table-modal').classList.add('hidden')"></div>
    <div class="relative bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl max-w-md w-full p-6 shadow-2xl z-10 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Masayı Düzenle</h3>
            <button type="button" onclick="document.getElementById('edit-table-modal').classList.add('hidden')" class="text-[#64748B] hover:text-[#0F172A] text-lg font-bold">✕</button>
        </div>
        <form id="edit-table-form" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Masa Adı *</label>
                <input type="text" name="name" id="edit-table-name" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Bölüm *</label>
                    <input type="text" name="section" id="edit-table-section" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-[#475569] mb-1">Kapasite *</label>
                    <input type="number" name="capacity" id="edit-table-capacity" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                </div>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-md">
                Değişiklikleri Güncelle
            </button>
        </form>
    </div>
</div>

<div id="edit-guest-modal" class="fixed inset-0 z-[70] flex items-center justify-center p-4 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('edit-guest-modal').classList.add('hidden')"></div>
    <div class="relative bg-[#FFFFFF] border border-[#E2E8F0] rounded-3xl max-w-md w-full p-6 shadow-2xl z-10 space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-[#F1F5F9] pb-3">
            <h3 class="font-lux-title text-lg font-bold text-[#0F172A]">Misafir Bilgilerini Düzenle</h3>
            <button type="button" onclick="document.getElementById('edit-guest-modal').classList.add('hidden')" class="text-[#64748B] hover:text-[#0F172A] text-lg font-bold">✕</button>
        </div>
        <form id="edit-guest-form" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Misafir Adı Soyadı *</label>
                <input type="text" name="name" id="edit-guest-name" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">VIP Kodu *</label>
                <input type="text" name="guest_code" id="edit-guest-code" required class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-mono uppercase font-bold focus:outline-none focus:border-[#8F6E40]">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Telefon Numarası</label>
                <input type="text" name="phone" id="edit-guest-phone" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Masa</label>
                <select name="club_table_id" id="edit-guest-table" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                    <option value="">-- Masasız / Bar --</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->table_number }} - {{ $table->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-[#475569] mb-1">Durum</label>
                <select name="status" id="edit-guest-status" class="w-full bg-[#F8F9FA] border border-[#CBD5E1] rounded-xl p-2.5 text-xs text-[#0F172A] font-medium">
                    <option value="active">İçeride (Aktif)</option>
                    <option value="checked_out">Çıkış Yapıldı</option>
                </select>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-[#8F6E40] text-white font-bold text-xs uppercase tracking-wider hover:bg-[#725732] transition-all shadow-md">
                Misafir Bilgilerini Güncelle
            </button>
        </form>
    </div>
</div>

<audio id="notification-sound-element" src="{{ asset('sounds/bell.wav') }}" preload="auto"></audio>

<script>
    const portalSidebar = document.getElementById('portal-sidebar');
    const mobileBackdrop = document.getElementById('mobile-sidebar-backdrop');
    const mobileToggleBtn = document.getElementById('mobile-sidebar-toggle');
    const mobileCloseBtn = document.getElementById('mobile-sidebar-close');

    function openMobileNav() {
        if (portalSidebar) portalSidebar.classList.remove('-translate-x-full');
        if (mobileBackdrop) mobileBackdrop.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileNav() {
        if (portalSidebar) portalSidebar.classList.add('-translate-x-full');
        if (mobileBackdrop) mobileBackdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if (mobileToggleBtn) mobileToggleBtn.addEventListener('click', openMobileNav);
    if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeMobileNav);
    if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileNav);

    function switchPortalTab(tabName) {
        document.querySelectorAll('.portal-tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.portal-nav-btn').forEach(btn => {
            if (btn.getAttribute('data-tab') === tabName) {
                btn.classList.add('bg-[#8F6E40]', 'text-white', 'shadow-md');
                btn.classList.remove('text-[#64748B]', 'hover:bg-[#F1F5F9]');
            } else {
                btn.classList.remove('bg-[#8F6E40]', 'text-white', 'shadow-md');
                btn.classList.add('text-[#64748B]', 'hover:bg-[#F1F5F9]');
            }
        });

        const targetSection = document.getElementById('section-' + tabName);
        if (targetSection) targetSection.classList.remove('hidden');

        const titleMap = {
            'dashboard': 'Gösterge Paneli',
            'categories': 'Kategoriler ve Sıralama Yönetimi',
            'products': 'Tüm Ürünler & Kategori Yönetimi',
            'guests': 'Misafirler ve Check-In Deski',
            'tables': 'Masa Haritası ve Özel QR Motoru',
            'notifications': 'Garson & Sipariş Bildirimleri (Canlı Takip)',
            'orders': 'Canlı Sipariş Akışı (KDS)',
            'bills': 'Kasa ve Kapanan Hesaplar',
            'settings': 'Yönetici Hesap ve Güvenlik Ayarları'
        };
        const titleEl = document.getElementById('portal-current-tab-title');
        if (titleEl && titleMap[tabName]) {
            titleEl.textContent = titleMap[tabName];
        }

        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);

        if (window.innerWidth < 768) {
            closeMobileNav();
        }
    }

    document.querySelectorAll('.portal-nav-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const tab = btn.getAttribute('data-tab');
            if (tab) switchPortalTab(tab);
        });
    });

    function filterPortalProducts(categoryKey, btnElement) {
        document.querySelectorAll('.prod-filter-btn').forEach(b => {
            b.classList.remove('bg-[#8F6E40]', 'text-white', 'shadow-sm');
            b.classList.add('bg-[#FFFFFF]', 'text-[#475569]', 'border', 'border-[#CBD5E1]');
        });
        if (btnElement) {
            btnElement.classList.add('bg-[#8F6E40]', 'text-white', 'shadow-sm');
            btnElement.classList.remove('bg-[#FFFFFF]', 'text-[#475569]');
        }

        const rows = document.querySelectorAll('.product-item-row');
        rows.forEach(row => {
            if (categoryKey === 'all' || row.getAttribute('data-cat') === categoryKey) {
                row.style.display = 'flex';
            } else {
                row.style.display = 'none';
            }
        });
    }

    const liveSearchInput = document.getElementById('portal-live-search');
    if (liveSearchInput) {
        liveSearchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            const searchTargets = document.querySelectorAll('.product-item-row, .guest-card-item, .category-card-item, .table-card-item, .order-card-item, .bill-row-item');
            
            searchTargets.forEach(el => {
                const searchStr = el.getAttribute('data-search') || '';
                if (!query || searchStr.includes(query)) {
                    if (el.classList.contains('product-item-row') || el.classList.contains('guest-card-item')) {
                        el.style.display = 'flex';
                    } else if (el.classList.contains('bill-row-item')) {
                        el.style.display = 'table-row';
                    } else {
                        el.style.display = 'block';
                    }
                } else {
                    el.style.display = 'none';
                }
            });
        });
    }

    function openEditCategoryModalFromBtn(button) {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const desc = button.getAttribute('data-desc');
        const order = button.getAttribute('data-order');

        document.getElementById('edit-cat-name').value = name || '';
        document.getElementById('edit-cat-desc').value = desc || '';
        document.getElementById('edit-cat-order').value = order || 0;
        document.getElementById('edit-category-form').action = '/reception/categories/' + id + '/update';
        document.getElementById('edit-category-modal').classList.remove('hidden');
    }

    function openAddProductModalForCategory(categoryId, categoryName) {
        const select = document.getElementById('add-prod-category-select');
        if (select) select.value = categoryId;
        document.getElementById('add-product-modal').classList.remove('hidden');
    }

    function openEditProductModalFromBtn(button) {
        const id = button.getAttribute('data-id');
        const catId = button.getAttribute('data-cat-id');
        const name = button.getAttribute('data-name');
        const price = button.getAttribute('data-price');
        const badge = button.getAttribute('data-badge');
        const notes = button.getAttribute('data-notes');
        const desc = button.getAttribute('data-desc');
        const order = button.getAttribute('data-order');
        const special = button.getAttribute('data-special');

        document.getElementById('edit-prod-category').value = catId || '';
        document.getElementById('edit-prod-name').value = name || '';
        document.getElementById('edit-prod-price').value = price || '';
        document.getElementById('edit-prod-badge').value = badge || '';
        document.getElementById('edit-prod-notes').value = notes || '';
        document.getElementById('edit-prod-desc').value = desc || '';
        document.getElementById('edit-prod-order').value = order || 0;
        document.getElementById('edit-prod-special').checked = (special === '1');
        document.getElementById('edit-product-form').action = '/reception/products/' + id + '/update';
        document.getElementById('edit-product-modal').classList.remove('hidden');
    }

    function openEditTableModalFromBtn(button) {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const section = button.getAttribute('data-section');
        const capacity = button.getAttribute('data-capacity');

        document.getElementById('edit-table-name').value = name || '';
        document.getElementById('edit-table-section').value = section || '';
        document.getElementById('edit-table-capacity').value = capacity || 4;
        document.getElementById('edit-table-form').action = '/reception/tables/' + id + '/update';
        document.getElementById('edit-table-modal').classList.remove('hidden');
    }

    function openEditGuestModalFromBtn(button) {
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const code = button.getAttribute('data-code');
        const phone = button.getAttribute('data-phone');
        const tableId = button.getAttribute('data-table-id');
        const status = button.getAttribute('data-status');

        document.getElementById('edit-guest-name').value = name || '';
        document.getElementById('edit-guest-code').value = code || '';
        document.getElementById('edit-guest-phone').value = phone || '';
        document.getElementById('edit-guest-table').value = tableId || '';
        document.getElementById('edit-guest-status').value = status || 'active';
        document.getElementById('edit-guest-form').action = '/reception/guests/' + id + '/update';
        document.getElementById('edit-guest-modal').classList.remove('hidden');
    }

    let lastKnownNotificationId = {{ $waiterCalls->first() ? $waiterCalls->first()->id : 0 }};
    let previousPendingCount = {{ $pendingWaiterCallsCount }};
    let initialPollDone = false;
    let portalAudioContext = null;

    function unlockPortalAudio() {
        try {
            const audioEl = document.getElementById('notification-sound-element');
            if (audioEl && !audioEl.dataset.unlocked) {
                audioEl.volume = 1.0;
                audioEl.play().then(() => {
                    audioEl.pause();
                    audioEl.currentTime = 0;
                    audioEl.dataset.unlocked = '1';
                }).catch(() => {});
            }

            if (!portalAudioContext) {
                const AudioCtx = window.AudioContext || window.webkitAudioContext;
                if (AudioCtx) {
                    portalAudioContext = new AudioCtx();
                }
            }
            if (portalAudioContext && portalAudioContext.state === 'suspended') {
                portalAudioContext.resume();
            }

            const statusEl = document.getElementById('audio-status-indicator');
            if (statusEl) {
                statusEl.innerHTML = '<span>🔊</span><span>Ses Açık</span>';
                statusEl.className = 'px-2.5 py-1 rounded-full bg-[#F0FDF4] border border-[#BBF7D0] text-[10px] text-[#16A34A] font-semibold flex items-center gap-1.5 shadow-sm cursor-pointer';
            }
        } catch(e) {}
    }

    document.addEventListener('click', unlockPortalAudio);
    document.addEventListener('keydown', unlockPortalAudio);
    document.addEventListener('touchstart', unlockPortalAudio);

    function playNotificationSound() {
        try {
            const audioEl = document.getElementById('notification-sound-element');
            if (audioEl) {
                audioEl.currentTime = 0;
                audioEl.volume = 1.0;
                const p = audioEl.play();
                if (p !== undefined) {
                    p.catch(() => {});
                }
            }
        } catch(e) {}

        try {
            unlockPortalAudio();
            if (!portalAudioContext) return;

            const ctx = portalAudioContext;
            if (ctx.state === 'suspended') {
                ctx.resume();
            }

            const baseTime = ctx.currentTime;
            const ringIntervals = [0, 0.8, 1.6, 2.4, 3.2];

            ringIntervals.forEach(offset => {
                const now = baseTime + offset;

                const osc1 = ctx.createOscillator();
                const gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(880, now);
                osc1.frequency.exponentialRampToValueAtTime(1174.66, now + 0.15);
                gain1.gain.setValueAtTime(0.6, now);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.6);
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(now);
                osc1.stop(now + 0.6);

                const osc2 = ctx.createOscillator();
                const gain2 = ctx.createGain();
                osc2.type = 'triangle';
                osc2.frequency.setValueAtTime(1479.98, now + 0.1);
                gain2.gain.setValueAtTime(0.4, now + 0.1);
                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.75);
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(now + 0.1);
                osc2.stop(now + 0.75);
            });
        } catch(e) {}
    }

    async function pollLiveNotifications() {
        try {
            const res = await fetch('/reception/live-notifications?since_id=' + lastKnownNotificationId);
            if (!res.ok) return;
            const data = await res.json();
            if (!data.success) return;

            const navBadge = document.getElementById('nav-waiter-badge');
            const headerBadge = document.getElementById('header-waiter-badge');

            if (navBadge) {
                navBadge.textContent = data.pending_count;
                if (data.pending_count > 0) {
                    navBadge.classList.add('bg-red-500', 'text-white', 'animate-bounce');
                    navBadge.classList.remove('bg-[#E2E8F0]', 'text-[#64748B]');
                } else {
                    navBadge.classList.remove('bg-red-500', 'text-white', 'animate-bounce');
                    navBadge.classList.add('bg-[#E2E8F0]', 'text-[#64748B]');
                }
            }

            if (headerBadge) {
                headerBadge.textContent = data.pending_count;
                if (data.pending_count > 0) {
                    headerBadge.classList.remove('hidden');
                } else {
                    headerBadge.classList.add('hidden');
                }
            }

            if (initialPollDone && (data.new_count > 0 || data.pending_count > previousPendingCount)) {
                playNotificationSound();
            }

            previousPendingCount = data.pending_count;

            if (data.latest_id > lastKnownNotificationId) {
                lastKnownNotificationId = data.latest_id;
            }

            initialPollDone = true;

            const container = document.getElementById('portal-notifications-container');
            if (container && data.notifications && data.notifications.length > 0) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                container.innerHTML = data.notifications.map(call => {
                    let typeBadge = '';
                    if (call.type === 'order') {
                        typeBadge = '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#FEF3C7] text-[#B45309] border border-[#FDE68A]">🛒 SİPARİŞ</span>';
                    } else if (call.type === 'bill') {
                        typeBadge = '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#EFF6FF] text-[#1D4ED8] border border-[#BFDBFE]">💳 HESAP İSTEĞİ</span>';
                    } else if (call.type === 'ice') {
                        typeBadge = '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#F0FDF4] text-[#15803D] border border-[#BBF7D0]">🧊 BUZ & BARDAK</span>';
                    } else if (call.type === 'ashtray') {
                        typeBadge = '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#F8FAFC] text-[#475569] border border-[#E2E8F0]">🚬 KÜL TABLASI</span>';
                    } else if (call.type === 'hookah') {
                        typeBadge = '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#FAF5FF] text-[#7E22CE] border border-[#E9D5FF]">💨 KÖZ YENİLEME</span>';
                    } else {
                        typeBadge = '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase bg-[#FEF2F2] text-[#B91C1C] border border-[#FECACA]">🛎️ GARSON ÇAĞRISI</span>';
                    }

                    const isPending = (call.status === 'pending');
                    const statusBadge = isPending 
                        ? '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold font-mono bg-red-50 text-red-600 border border-red-200 animate-pulse">BEKLİYOR</span>'
                        : '<span class="px-2 py-0.5 rounded-full text-[9px] font-bold font-mono bg-emerald-50 text-emerald-600 border border-emerald-200">TAMAMLANDI</span>';

                    let itemsHtml = '';
                    if (call.order_items && call.order_items.length > 0) {
                        itemsHtml = `
                            <div class="border border-[#F1F5F9] rounded-xl p-2.5 bg-[#FAFBFD] space-y-1.5 mb-2">
                                <span class="text-[10px] uppercase font-bold text-[#64748B] block mb-1">Sipariş İçeriği:</span>
                                ${call.order_items.map(item => `
                                    <div class="flex items-center justify-between text-xs py-0.5 border-b border-[#F1F5F9] last:border-0">
                                        <div class="flex items-center gap-1.5 truncate">
                                            <span class="font-bold text-[#8F6E40]">${item.quantity || 1}x</span>
                                            <span class="text-[#1E293B] truncate">${item.name || ''}</span>
                                        </div>
                                        <span class="font-mono font-semibold text-[#0F172A] text-xs flex-shrink-0 ml-2">
                                            ${(item.total || item.price || 0).toLocaleString('tr-TR')} ₺
                                        </span>
                                    </div>
                                `).join('')}
                                ${call.total_amount ? `
                                    <div class="pt-1.5 mt-1 border-t border-[#E2E8F0] flex items-center justify-between font-bold text-xs">
                                        <span class="text-[#0F172A]">Toplam Tutar:</span>
                                        <span class="font-mono text-[#8F6E40]">${call.total_amount}</span>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                    }

                    return `
                        <div class="waiter-call-card bg-[#FFFFFF] border ${isPending ? 'border-[#8F6E40]/60 ring-2 ring-[#8F6E40]/20' : 'border-[#E2E8F0]'} rounded-2xl p-4 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-3"
                             data-id="${call.id}"
                             data-search="${(call.table_number + ' ' + (call.guest_name || '') + ' ' + call.title + ' ' + (call.message || '')).toLowerCase()}">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-1.5">
                                        ${typeBadge}
                                        <span class="font-mono text-xs font-bold text-[#0F172A]">${call.table_number}</span>
                                    </div>
                                    ${statusBadge}
                                </div>

                                <h4 class="font-lux-title text-sm font-bold text-[#0F172A]">${call.title}</h4>
                                <div class="flex items-center gap-2 text-[11px] text-[#64748B] mb-2">
                                    ${call.guest_name ? `<span class="font-medium text-[#334155]">👤 ${call.guest_name}</span>` : ''}
                                    ${call.guest_code ? `<span class="font-mono font-bold text-[#8F6E40]">[${call.guest_code}]</span>` : ''}
                                    <span>• ${call.time_ago || call.created_at_fmt}</span>
                                </div>

                                ${call.message ? `
                                    <div class="p-2.5 rounded-xl bg-[#F8FAFC] border border-[#E2E8F0] text-xs text-[#334155] mb-2">
                                        <span class="text-[10px] uppercase font-bold text-[#64748B] block mb-0.5">Misafir Notu:</span>
                                        ${call.message}
                                    </div>
                                ` : ''}

                                ${itemsHtml}
                            </div>

                            <div class="pt-2 border-t border-[#F1F5F9] flex items-center gap-2">
                                <form action="/reception/waiter-calls/${call.id}/status" method="POST" class="flex-1">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="status" value="${isPending ? 'completed' : 'pending'}">
                                    <button type="submit" class="w-full py-1.5 px-2 rounded-lg ${isPending ? 'bg-[#DCFCE7] hover:bg-[#BBF7D0] border border-[#BBF7D0] text-[#16A34A]' : 'bg-[#F1F5F9] hover:bg-[#E2E8F0] border border-[#CBD5E1] text-[#475569]'} text-xs font-bold transition-all">
                                        ${isPending ? '✓ Tamamlandı' : '↺ Beklet'}
                                    </button>
                                </form>
                                <form action="/reception/waiter-calls/${call.id}" method="POST" onsubmit="return confirm('Bildirimi silmek istediğinize emin misiniz?')">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="p-1.5 rounded-lg bg-[#FEF2F2] hover:bg-[#FEE2E2] border border-[#FECACA] text-[#DC2626] text-xs font-bold transition-all" title="Sil">
                                        ✕
                                    </button>
                                </form>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        } catch(e) {}
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        if (tab) {
            switchPortalTab(tab);
        }
        pollLiveNotifications();
        setInterval(pollLiveNotifications, 4000);
    });
</script>
@endsection
