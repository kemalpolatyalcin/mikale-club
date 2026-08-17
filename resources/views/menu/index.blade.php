@extends('layouts.app')

@section('title', 'MIKALE CLUB - VIP Bar & Lounge Menu')

@section('content')
@if(isset($dailySpecials) && $dailySpecials->count() > 0)
    <div id="specials-welcome-overlay" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div id="welcome-backdrop" class="fixed inset-0 bg-[#070605]/90 modal-backdrop transition-opacity"></div>
        <div class="relative bg-[#14120F] border border-[#C5A880]/40 rounded-2xl max-w-xl w-full p-6 md:p-8 shadow-2xl shadow-black z-10 overlay-content-in space-y-5">
            <button id="welcome-close-btn" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-[#1F1B16] border border-[#C5A880]/30 text-[#C5A880] hover:text-white flex items-center justify-center transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="text-center space-y-1.5 pt-1">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#1F1B16] border border-[#C5A880]/30 text-[9px] font-medium text-[#C5A880] uppercase tracking-[0.25em]">
                    <span class="w-1 h-1 rounded-full bg-[#C5A880] animate-ping"></span>
                    <span>Tonight's Selection</span>
                </div>
                <h3 class="font-lux-title text-xl md:text-2xl font-normal tracking-[0.18em] text-[#F5EFE6] uppercase">Günün Spesiyalleri</h3>
                <p class="font-lux-serif italic text-xs md:text-sm text-[#A89C8F]">Miksolojistimizin bu geceye özel öne çıkardığı imza lezzetler</p>
                <div class="h-[1px] w-12 mx-auto lux-divider pt-1"></div>
            </div>

            <div class="space-y-3">
                @foreach($dailySpecials as $special)
                    <div class="specials-card rounded-xl p-4 flex flex-col justify-between open-product-modal"
                         data-name="{{ $special->name }}"
                         data-subtitle="{{ $special->sub_title }}"
                         data-desc="{{ $special->description }}"
                         data-notes="{{ $special->taste_notes }}"
                         data-price="{{ $special->formatted_price }}"
                         data-orig-price="{{ $special->original_price ? number_format($special->original_price, 0, ',', '.') . ' ₺' : '' }}"
                         data-badge="{{ $special->badge ?? 'SPECIAL' }}"
                         data-abv="{{ $special->alcohol_percentage }}"
                         data-vol="{{ $special->volume_ml }}">
                        
                        <div class="flex items-start justify-between gap-3 mb-1.5">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[8px] tracking-[0.2em] uppercase font-bold bg-[#C5A880] text-[#0D0C0A]">
                                        {{ $special->badge ?? 'SPESİYAL' }}
                                    </span>
                                    @if($special->alcohol_percentage > 0)
                                        <span class="text-[9px] text-[#A89C8F] tracking-wider">%{{ $special->alcohol_percentage }} ABV</span>
                                    @endif
                                </div>
                                <h4 class="font-lux-title text-sm md:text-base text-[#F5EFE6] tracking-wide font-normal">
                                    {{ $special->name }}
                                </h4>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="font-lux-title text-sm md:text-base text-[#E8D9C5] tracking-wider block">
                                    {{ $special->formatted_price }}
                                </span>
                            </div>
                        </div>

                        @if($special->description)
                            <p class="text-[11px] text-[#A89C8F] font-light leading-relaxed mb-2 line-clamp-2">
                                {{ $special->description }}
                            </p>
                        @endif

                        @if($special->taste_notes)
                            <div class="pt-2 border-t border-[#C5A880]/15 flex items-center justify-between text-[10px]">
                                <div class="flex items-center gap-1.5 text-[#C5A880] truncate">
                                    <span class="text-[9px]">✦</span>
                                    <span class="font-lux-serif italic truncate text-[#E8D9C5]">{{ $special->taste_notes }}</span>
                                </div>
                                <span class="text-[9px] text-[#C5A880]/80 uppercase tracking-wider flex-shrink-0 ml-2">Detayları İncele →</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="pt-2">
                <button id="welcome-dismiss-btn" class="w-full py-3 rounded-full bg-gradient-to-r from-[#8F7655] via-[#C5A880] to-[#8F7655] text-[#0D0C0A] font-lux-title text-xs tracking-[0.25em] uppercase font-medium hover:brightness-110 active:scale-[0.99] transition-all shadow-lg shadow-[#C5A880]/20">
                    Menüyü Keşfet
                </button>
            </div>
        </div>
    </div>
@endif

<div class="max-w-4xl mx-auto px-4 pt-8 pb-20">
    <div class="text-center space-y-3 mb-10 hero-fade-down">
        <span class="text-[10px] tracking-[0.3em] uppercase text-[#C5A880] font-medium block">
            Exclusive Mixology & Prestige Cellar
        </span>
        <h2 class="font-lux-title text-2xl md:text-4xl font-normal tracking-[0.2em] text-[#F5EFE6]">
            BAR MENU
        </h2>
        <p class="font-lux-serif italic text-sm md:text-base text-[#A89C8F] max-w-md mx-auto leading-relaxed">
            Seçkin miksoloji tarifleri, vintage şampanyalar ve gece ritüelleri.
        </p>
        <div class="h-[1px] w-16 mx-auto lux-divider pt-1"></div>
    </div>

    @if(isset($dailySpecials) && $dailySpecials->count() > 0)
        <div class="mb-12 specials-fade-in">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-[#C5A880]/20">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#C5A880] animate-ping"></span>
                    <h3 class="font-lux-title text-sm md:text-base uppercase tracking-[0.2em] text-[#F5EFE6]">Günün Spesiyalleri</h3>
                </div>
                <span class="text-[9px] tracking-[0.2em] uppercase text-[#C5A880] px-2.5 py-0.5 rounded-full bg-[#181614] border border-[#C5A880]/30 font-medium">Chef & Mixologist Choice</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($dailySpecials as $special)
                    <div class="specials-card rounded-xl p-5 relative flex flex-col justify-between open-product-modal"
                         data-name="{{ $special->name }}"
                         data-subtitle="{{ $special->sub_title }}"
                         data-desc="{{ $special->description }}"
                         data-notes="{{ $special->taste_notes }}"
                         data-price="{{ $special->formatted_price }}"
                         data-orig-price="{{ $special->original_price ? number_format($special->original_price, 0, ',', '.') . ' ₺' : '' }}"
                         data-badge="{{ $special->badge ?? 'SPECIAL' }}"
                         data-abv="{{ $special->alcohol_percentage }}"
                         data-vol="{{ $special->volume_ml }}">
                        
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded text-[8px] tracking-[0.2em] uppercase font-bold bg-[#C5A880] text-[#0D0C0A]">
                                            {{ $special->badge ?? 'SPESİYAL' }}
                                        </span>
                                        @if($special->alcohol_percentage > 0)
                                            <span class="text-[9px] text-[#A89C8F] tracking-wider">%{{ $special->alcohol_percentage }} ABV</span>
                                        @endif
                                        @if($special->volume_ml)
                                            <span class="text-[9px] text-[#A89C8F] tracking-wider">{{ $special->volume_ml }} ml</span>
                                        @endif
                                    </div>
                                    <h4 class="font-lux-title text-base md:text-lg text-[#F5EFE6] tracking-wide font-normal">
                                        {{ $special->name }}
                                    </h4>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <span class="font-lux-title text-base md:text-lg text-[#E8D9C5] tracking-wider block">
                                        {{ $special->formatted_price }}
                                    </span>
                                    @if($special->original_price)
                                        <span class="text-[10px] text-[#7A7166] line-through block">
                                            {{ number_format($special->original_price, 0, ',', '.') }} ₺
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($special->sub_title)
                                <p class="text-[11px] text-[#C5A880] font-medium mb-2 tracking-wide">{{ $special->sub_title }}</p>
                            @endif

                            @if($special->description)
                                <p class="text-xs text-[#A89C8F] font-light leading-relaxed mb-3">
                                    {{ $special->description }}
                                </p>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-[#C5A880]/15 flex items-center justify-between text-[10px]">
                            <div class="flex items-center gap-1.5 text-[#C5A880] truncate">
                                <span class="text-[9px]">✦</span>
                                <span class="font-lux-serif italic truncate text-[#E8D9C5]">{{ $special->taste_notes }}</span>
                            </div>
                            <span class="text-[9px] uppercase tracking-wider text-[#A89C8F] flex-shrink-0 ml-2">Detayları Gör →</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mb-8 reveal-up">
        <div class="relative max-w-md mx-auto">
            <input type="text" id="menu-search" placeholder="İçerik, kokteyl veya tat notası ara..." 
                   class="w-full bg-[#161412]/90 border border-[#C5A880]/20 rounded-full px-5 py-2.5 pl-10 text-xs md:text-sm text-[#E6E0D8] placeholder-[#7A7166] focus:outline-none focus:border-[#C5A880]/60 focus:ring-1 focus:ring-[#C5A880]/30 transition-all shadow-inner">
            <svg class="w-4 h-4 text-[#C5A880]/60 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    <div class="sticky top-[57px] z-30 -mx-4 px-4 py-3 bg-[#0D0C0A]/95 backdrop-blur-xl border-y border-[#C5A880]/15 mb-10 overflow-x-auto hide-scrollbar">
        <div class="flex items-center gap-2 min-w-max mx-auto max-w-4xl justify-start md:justify-center">
            @foreach($categories as $idx => $cat)
                <a href="#cat-{{ $cat->slug }}" 
                   data-target="cat-{{ $cat->slug }}"
                   class="category-nav-btn px-4 py-1.5 rounded-full text-[11px] uppercase tracking-wider transition-all duration-300 whitespace-nowrap border {{ $idx === 0 ? 'bg-[#C5A880] text-[#0D0C0A] border-[#C5A880] font-medium shadow-md shadow-[#C5A880]/20' : 'bg-[#181614] text-[#A89C8F] border-[#C5A880]/20 hover:text-[#F5EFE6] hover:border-[#C5A880]/40' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="space-y-16">
        @foreach($categories as $catIndex => $category)
            <section id="cat-{{ $category->slug }}" class="category-section scroll-mt-28 space-y-5">
                <div class="border-b border-[#C5A880]/20 pb-3 reveal-up flex items-end justify-between">
                    <div>
                        <span class="text-[9px] tracking-[0.3em] uppercase text-[#C5A880] font-medium block mb-1">0{{ $catIndex + 1 }}</span>
                        <h3 class="font-lux-title text-xl md:text-2xl font-normal tracking-[0.15em] text-[#F5EFE6] uppercase">{{ $category->name }}</h3>
                    </div>
                    <span class="text-[10px] tracking-widest uppercase text-[#8C8276]">{{ $category->activeProducts->count() }} Seçenek</span>
                </div>

                @if($category->description)
                    <p class="font-lux-serif italic text-xs md:text-sm text-[#A89C8F] -mt-2 reveal-up">{{ $category->description }}</p>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 md:gap-4">
                    @foreach($category->activeProducts as $pIndex => $product)
                        <div class="product-card lux-card rounded-xl p-4 relative flex flex-col justify-between open-product-modal {{ $pIndex % 2 == 0 ? 'reveal-left' : 'reveal-right' }}"
                             data-name="{{ $product->name }}"
                             data-subtitle="{{ $product->sub_title }}"
                             data-desc="{{ $product->description }}"
                             data-notes="{{ $product->taste_notes }}"
                             data-price="{{ $product->formatted_price }}"
                             data-orig-price="{{ $product->original_price ? number_format($product->original_price, 0, ',', '.') . ' ₺' : '' }}"
                             data-badge="{{ $product->badge }}"
                             data-abv="{{ $product->alcohol_percentage }}"
                             data-vol="{{ $product->volume_ml }}">
                            
                            <div>
                                <div class="flex items-baseline justify-between gap-3 mb-1.5">
                                    <h4 class="font-lux-title text-sm md:text-base text-[#F5EFE6] tracking-wide font-normal">
                                        {{ $product->name }}
                                    </h4>
                                    <span class="font-lux-title text-sm md:text-base text-[#E8D9C5] tracking-wider flex-shrink-0">
                                        {{ $product->formatted_price }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 flex-wrap mb-2">
                                    @if($product->badge)
                                        <span class="px-2 py-0.5 rounded text-[8px] tracking-[0.15em] uppercase font-semibold bg-[#C5A880]/15 text-[#E8D9C5] border border-[#C5A880]/30">
                                            {{ $product->badge }}
                                        </span>
                                    @endif
                                    @if($product->alcohol_percentage > 0)
                                        <span class="text-[9px] text-[#8C8276] tracking-wider">%{{ $product->alcohol_percentage }} ABV</span>
                                    @endif
                                    @if($product->volume_ml)
                                        <span class="text-[9px] text-[#8C8276] tracking-wider">{{ $product->volume_ml }} ml</span>
                                    @endif
                                </div>

                                @if($product->description)
                                    <p class="text-[11px] text-[#A89C8F] font-light leading-relaxed mb-2">
                                        {{ $product->description }}
                                    </p>
                                @endif
                            </div>

                            @if($product->taste_notes)
                                <div class="pt-2.5 mt-2 border-t border-[#C5A880]/10 flex items-center justify-between text-[10px] text-[#8C8276]">
                                    <div class="flex items-center gap-1.5 truncate">
                                        <span class="text-[#C5A880] text-[9px]">✦</span>
                                        <span class="font-lux-serif italic truncate text-[#A89C8F]">{{ $product->taste_notes }}</span>
                                    </div>
                                    <span class="text-[8px] text-[#C5A880]/70 flex-shrink-0 ml-1">İncele ↗</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</div>

<div id="product-detail-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div id="modal-backdrop" class="fixed inset-0 bg-black/80 modal-backdrop transition-opacity"></div>
    <div class="relative bg-[#161411] border border-[#C5A880]/35 rounded-2xl max-w-lg w-full p-6 md:p-7 shadow-2xl shadow-black/80 z-10 modal-content-in space-y-4">
        <button id="modal-close-btn" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-[#201C18] border border-[#C5A880]/30 text-[#C5A880] hover:text-white flex items-center justify-center transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div>
            <div class="flex items-center gap-2 mb-2">
                <span id="modal-badge" class="px-2 py-0.5 rounded text-[8px] tracking-[0.2em] uppercase font-bold bg-[#C5A880] text-[#0D0C0A]"></span>
                <span id="modal-abv" class="text-[9px] text-[#A89C8F] tracking-wider"></span>
                <span id="modal-vol" class="text-[9px] text-[#A89C8F] tracking-wider"></span>
            </div>
            <h3 id="modal-title" class="font-lux-title text-xl md:text-2xl text-[#F5EFE6] tracking-wide font-normal"></h3>
            <p id="modal-subtitle" class="text-xs text-[#C5A880] font-medium tracking-wide mt-1"></p>
        </div>

        <div class="py-3 border-y border-[#C5A880]/15 flex items-baseline justify-between">
            <span class="text-xs uppercase tracking-widest text-[#8C8276]">Fiyat</span>
            <div class="text-right">
                <span id="modal-price" class="font-lux-title text-xl font-normal text-[#E8D9C5]"></span>
                <span id="modal-orig-price" class="text-xs text-[#7A7166] line-through block"></span>
            </div>
        </div>

        <div class="space-y-2">
            <span class="text-[10px] uppercase tracking-widest text-[#C5A880] font-medium block">İçerik & Hikaye</span>
            <p id="modal-desc" class="text-xs md:text-sm text-[#D5CDC3] font-light leading-relaxed"></p>
        </div>

        <div id="modal-notes-container" class="bg-[#1D1A16] border border-[#C5A880]/20 rounded-xl p-3.5 flex items-start gap-2.5">
            <span class="text-[#C5A880] text-xs mt-0.5">✦</span>
            <div>
                <span class="text-[9px] uppercase tracking-wider text-[#A89C8F] block font-medium">Tat Profili & Notalar</span>
                <p id="modal-notes" class="font-lux-serif italic text-xs md:text-sm text-[#F5EFE6]"></p>
            </div>
        </div>

        <div class="pt-2 text-center">
            <span class="text-[10px] text-[#8C8276] tracking-wider uppercase block">VIP Masanıza Özel Servis Edilir</span>
        </div>
    </div>
</div>
@endsection
