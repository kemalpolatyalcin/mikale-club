<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0D0C0A">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MIKALE CLUB - VIP Bar & Lounge Menu')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Marcellus&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit" async defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0D0C0A] text-[#E6E0D8] antialiased min-h-screen selection:bg-[#C5A880] selection:text-black {{ !request()->routeIs('reception.*', 'portal.*') ? 'pb-28' : '' }}">
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden {{ request()->routeIs('reception.*', 'portal.*') ? 'hidden' : '' }}">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[550px] h-[550px] bg-[#C5A880]/5 rounded-full blur-[130px]"></div>
        <div class="absolute top-[50%] -left-32 w-[450px] h-[450px] bg-[#8F7655]/5 rounded-full blur-[140px]"></div>
        <div class="absolute top-[80%] -right-32 w-[500px] h-[500px] bg-[#C5A880]/4 rounded-full blur-[130px]"></div>
    </div>

    @if(!request()->routeIs('reception.*', 'portal.*'))
        <header class="header-slide-down sticky top-0 z-30 bg-[#0D0C0A]/90 backdrop-blur-xl border-b border-[#C5A880]/15 transition-all duration-300">
            <div class="max-w-4xl mx-auto px-4 py-3 relative flex items-center justify-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-full border border-[#C5A880]/40 flex items-center justify-center bg-[#181614] text-[#C5A880] font-lux-title text-sm shadow-md shadow-[#C5A880]/10">
                        M
                    </div>
                    <div class="text-left">
                        <h1 class="font-lux-title tracking-[0.25em] text-sm md:text-base font-normal text-[#F5EFE6]">MIKALE</h1>
                        <p class="text-[8px] tracking-[0.35em] uppercase text-[#A89C8F] font-medium -mt-0.5">Club & Lounge</p>
                    </div>
                </a>

                @if(session('guest_id'))
                    <div class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 flex items-center gap-1.5 sm:gap-2 bg-[#181614] border border-[#C5A880]/40 px-2 sm:px-2.5 py-1 rounded-full text-xs shadow-inner">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse flex-shrink-0"></span>
                        <span class="text-[#E8D9C5] truncate max-w-[60px] sm:max-w-[120px] font-medium text-[10px] sm:text-[11px]">{{ session('guest_name') }}</span>
                        <span class="text-[9px] font-mono text-[#C5A880] font-bold">[{{ session('guest_code') }}]</span>
                        <form action="{{ route('table.leave') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Masa oturumunu kapat" class="text-[#8C8276] hover:text-red-400 ml-0.5 text-xs">✕</button>
                        </form>
                    </div>
                @endif
            </div>
        </header>
    @endif

    <main class="relative z-10">
        @yield('content')
    </main>

    <div id="order-toast" class="fixed bottom-24 sm:bottom-28 left-1/2 -translate-x-1/2 z-50 bg-[#1A1713] border border-[#C5A880]/50 text-[#F5EFE6] px-4 py-2.5 rounded-full shadow-2xl shadow-black text-xs flex items-center gap-2 translate-y-32 opacity-0 pointer-events-none transition-all duration-300">
        <span class="text-[#C5A880]">✦</span>
        <span id="toast-msg">Ürün sepete eklendi</span>
    </div>

    @if(!request()->routeIs('reception.*', 'portal.*'))
        <div class="fixed bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 z-40 w-[94%] max-w-md pb-[env(safe-area-inset-bottom,0px)]">
            <nav class="bg-[#14120F]/90 backdrop-blur-2xl border border-[#C5A880]/30 rounded-full p-1.5 shadow-[0_15px_45px_rgba(0,0,0,0.85)] ring-1 ring-white/5 flex items-center justify-between transition-all">
                <a href="{{ route('home') }}" id="toolbar-tab-menu" 
                   class="toolbar-item flex flex-col items-center justify-center flex-1 py-1.5 px-1 rounded-full transition-all duration-300 active:scale-90 {{ (request()->routeIs('home', 'menu')) ? 'bg-[#C5A880]/20 border border-[#C5A880]/40 text-[#F5EFE6] shadow-inner font-semibold' : 'text-[#A89C8F] hover:text-[#E8D9C5] border border-transparent' }}">
                    <svg class="w-5 h-5 {{ (request()->routeIs('home', 'menu')) ? 'text-[#C5A880]' : 'text-current' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-[9px] tracking-wider font-medium mt-0.5">Menü</span>
                </a>

                <button type="button" id="toolbar-tab-search" 
                        class="toolbar-item flex flex-col items-center justify-center flex-1 py-1.5 px-1 rounded-full text-[#A89C8F] hover:text-[#E8D9C5] border border-transparent transition-all duration-300 active:scale-90">
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="text-[9px] tracking-wider font-medium mt-0.5">Arama</span>
                </button>

                <button type="button" id="toolbar-tab-join" 
                        class="toolbar-item open-companion-modal-btn flex flex-col items-center justify-center flex-1 py-1.5 px-1 rounded-full text-[#A89C8F] hover:text-[#E8D9C5] border border-transparent transition-all duration-300 active:scale-90">
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-[9px] tracking-wider font-medium mt-0.5 whitespace-nowrap">Masaya Katıl</span>
                </button>

                <button type="button" id="toolbar-tab-waiter" 
                        class="toolbar-item open-waiter-modal-btn-trigger flex flex-col items-center justify-center flex-1 py-1.5 px-1 rounded-full text-[#A89C8F] hover:text-[#E8D9C5] border border-transparent transition-all duration-300 active:scale-90">
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="text-[9px] tracking-wider font-medium mt-0.5 whitespace-nowrap">Garson Çağır</span>
                </button>

                <button type="button" id="toolbar-tab-cart" 
                        class="toolbar-item open-cart-btn-trigger flex flex-col items-center justify-center flex-1 py-1.5 px-1 rounded-full text-[#A89C8F] hover:text-[#E8D9C5] border border-transparent transition-all duration-300 active:scale-90">
                    <div class="relative">
                        <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span id="toolbar-cart-badge" class="absolute -top-1.5 -right-2.5 bg-[#C5A880] text-[#0D0C0A] text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center font-mono scale-0 transition-transform shadow-md">0</span>
                    </div>
                    <span class="text-[9px] tracking-wider font-medium mt-0.5">Sepetim</span>
                </button>

                <a href="{{ route('reception.index') }}" id="toolbar-tab-reception" 
                   class="toolbar-item flex flex-col items-center justify-center flex-1 py-1.5 px-1 rounded-full text-[#A89C8F] hover:text-[#E8D9C5] border border-transparent transition-all duration-300 active:scale-90">
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-[9px] tracking-wider font-medium mt-0.5">Resepsiyon</span>
                </a>
            </nav>
        </div>

        <div id="waiter-call-modal" class="fixed inset-0 z-[60] flex items-center justify-center p-3 sm:p-4 hidden">
            <div id="waiter-modal-backdrop" class="fixed inset-0 bg-black/85 modal-backdrop transition-opacity"></div>
            <div class="relative bg-[#14120F] border border-[#C5A880]/40 rounded-3xl max-w-lg w-full p-5 sm:p-6 shadow-2xl shadow-black z-10 modal-content-in space-y-4 max-h-[92vh] overflow-y-auto hide-scrollbar">
                <button id="close-waiter-modal-btn" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-[#1F1B16] border border-[#C5A880]/30 text-[#C5A880] flex items-center justify-center active:scale-90 hover:text-white transition-all">
                    ✕
                </button>

                <div class="text-center space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-[#1F1B16] border border-[#C5A880]/30 text-[9px] font-medium text-[#C5A880] uppercase tracking-[0.2em]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#C5A880] animate-ping"></span>
                        <span>Direct Service Alert</span>
                    </div>
                    <h3 class="font-lux-title text-xl text-[#F5EFE6]">Garson & Servis Çağır</h3>
                    <p class="font-lux-serif italic text-xs text-[#A89C8F]">Talebinizi seçin, servis ekibimiz anında masanıza yönlendirilsin.</p>
                </div>

                @if(session('guest_id'))
                    <div class="space-y-3 pt-2">
                        <div class="p-3 rounded-2xl bg-[#1B1814] border border-[#C5A880]/30 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <div>
                                    <span class="text-[9px] uppercase tracking-wider text-[#A89C8F] block">Masa Numarası</span>
                                    <span class="font-mono text-sm font-bold text-[#F5EFE6]">{{ session('current_table_number') ?? 'Masa' }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] uppercase tracking-wider text-[#A89C8F] block">Aktif Misafir</span>
                                <span class="text-xs font-semibold text-[#E8D9C5]">{{ session('guest_name') }} <span class="font-mono text-[#C5A880]">[{{ session('guest_code') }}]</span></span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-wider text-[#A89C8F] mb-1.5">Çağrı Talebi Türü</label>
                            <div class="grid grid-cols-2 gap-2" id="waiter-call-type-options">
                                <button type="button" data-call-type="waiter" class="waiter-type-pill active bg-[#C5A880] text-[#0D0C0A] border-[#C5A880] font-semibold p-2.5 rounded-xl border text-xs flex items-center gap-2 transition-all">
                                    <span>🛎️</span>
                                    <span class="text-[11px]">Garson Masaya</span>
                                </button>
                                <button type="button" data-call-type="bill" class="waiter-type-pill bg-[#1B1814] text-[#A89C8F] border-[#C5A880]/20 hover:border-[#C5A880]/40 p-2.5 rounded-xl border text-xs flex items-center gap-2 transition-all">
                                    <span>💳</span>
                                    <span class="text-[11px]">Hesap & Adisyon</span>
                                </button>
                                <button type="button" data-call-type="ice" class="waiter-type-pill bg-[#1B1814] text-[#A89C8F] border-[#C5A880]/20 hover:border-[#C5A880]/40 p-2.5 rounded-xl border text-xs flex items-center gap-2 transition-all">
                                    <span>🧊</span>
                                    <span class="text-[11px]">Buz & Bardak</span>
                                </button>
                                <button type="button" data-call-type="ashtray" class="waiter-type-pill bg-[#1B1814] text-[#A89C8F] border-[#C5A880]/20 hover:border-[#C5A880]/40 p-2.5 rounded-xl border text-xs flex items-center gap-2 transition-all">
                                    <span>🚬</span>
                                    <span class="text-[11px]">Kül Tablası</span>
                                </button>
                                <button type="button" data-call-type="hookah" class="waiter-type-pill bg-[#1B1814] text-[#A89C8F] border-[#C5A880]/20 hover:border-[#C5A880]/40 p-2.5 rounded-xl border text-xs flex items-center gap-2 transition-all">
                                    <span>💨</span>
                                    <span class="text-[11px]">Köz Yenileme</span>
                                </button>
                                <button type="button" data-call-type="custom" class="waiter-type-pill bg-[#1B1814] text-[#A89C8F] border-[#C5A880]/20 hover:border-[#C5A880]/40 p-2.5 rounded-xl border text-xs flex items-center gap-2 transition-all">
                                    <span>✍️</span>
                                    <span class="text-[11px]">Özel İstek</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-wider text-[#A89C8F] mb-1">Ekstra Not (Opsiyonel)</label>
                            <input type="text" id="waiter-call-note" 
                                   class="w-full bg-[#1B1814] border border-[#C5A880]/30 rounded-xl px-4 py-2.5 text-base sm:text-xs text-[#E6E0D8] focus:outline-none focus:border-[#C5A880]">
                        </div>

                        <button type="button" id="submit-waiter-call-btn" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-[#8F7655] via-[#C5A880] to-[#8F7655] text-[#0D0C0A] font-lux-title text-xs tracking-[0.2em] uppercase font-bold hover:brightness-110 active:scale-[0.98] touch-manipulation transition-all shadow-lg shadow-[#C5A880]/25 flex items-center justify-center gap-2">
                            <span>🛎️</span>
                            <span>Çağrıyı Personele İlet</span>
                        </button>
                    </div>
                @else
                    <div class="space-y-4 pt-4 text-center">
                        <div class="w-14 h-14 rounded-full bg-[#1B1814] border border-[#C5A880]/40 text-[#C5A880] flex items-center justify-center mx-auto text-2xl shadow-inner">
                            🔒
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-lux-title text-base text-[#F5EFE6]">Masa Oturumu Gerekli</h4>
                            <p class="font-lux-serif italic text-xs text-[#A89C8F] max-w-xs mx-auto">
                                Garson çağırabilmek ve servis talebinde bulunabilmek için lütfen resepsiyondan verilen VIP Misafir Kodunuz ile masaya giriş yapınız.
                            </p>
                        </div>
                        <button type="button" id="waiter-need-login-btn" class="w-full py-3.5 rounded-xl bg-[#C5A880] text-[#0D0C0A] font-lux-title text-xs tracking-[0.2em] uppercase font-bold hover:brightness-110 active:scale-[0.98] touch-manipulation transition-all shadow-md shadow-[#C5A880]/20 flex items-center justify-center gap-2">
                            <span>🔑</span>
                            <span>VIP Kodunuzla Masaya Giriş Yapın</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if(!request()->routeIs('reception.*', 'portal.*'))
        <footer class="relative z-10 border-t border-[#C5A880]/15 bg-[#090807] mt-20 py-12 text-center text-xs text-[#A89C8F]">
            <div class="max-w-md mx-auto px-4 space-y-3">
                <p class="font-lux-title tracking-[0.3em] text-[#C5A880] text-sm font-normal">MIKALE VIP LOUNGE</p>
                <p class="text-[#8C8276] text-[11px] font-light leading-relaxed">Özel miksoloji sunumları, şef tabakları ve şişe seremonileri için lütfen servis ekibimize danışınız.</p>
                <div class="h-[1px] w-14 mx-auto lux-divider my-4"></div>
                <p class="text-[9px] tracking-[0.25em] text-[#6E655A] uppercase">© 2026 MIKALE CLUB. ALL RIGHTS RESERVED.</p>
            </div>
        </footer>
    @endif
</body>
</html>
