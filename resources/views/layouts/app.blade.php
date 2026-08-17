<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#0D0C0A">
    <title>@yield('title', 'MIKALE CLUB - VIP Bar & Lounge Menu')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Marcellus&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0D0C0A] text-[#E6E0D8] antialiased min-h-screen selection:bg-[#C5A880] selection:text-black">
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[550px] h-[550px] bg-[#C5A880]/5 rounded-full blur-[130px]"></div>
        <div class="absolute top-[50%] -left-32 w-[450px] h-[450px] bg-[#8F7655]/5 rounded-full blur-[140px]"></div>
        <div class="absolute top-[80%] -right-32 w-[500px] h-[500px] bg-[#C5A880]/4 rounded-full blur-[130px]"></div>
    </div>

    <header class="header-slide-down sticky top-0 z-40 bg-[#0D0C0A]/90 backdrop-blur-xl border-b border-[#C5A880]/15 transition-all duration-300">
        <div class="max-w-4xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-8 h-8 rounded-full border border-[#C5A880]/40 flex items-center justify-center bg-[#181614] text-[#C5A880] font-lux-title text-sm shadow-md shadow-[#C5A880]/10">
                    M
                </div>
                <div>
                    <h1 class="font-lux-title tracking-[0.25em] text-sm md:text-base font-normal text-[#F5EFE6]">MIKALE</h1>
                    <p class="text-[8px] tracking-[0.35em] uppercase text-[#A89C8F] font-medium -mt-0.5">Club & Lounge</p>
                </div>
            </a>

            @if(isset($activeTable))
                <div class="flex items-center gap-2 bg-[#181614] border border-[#C5A880]/30 px-3.5 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C5A880] animate-pulse"></span>
                    <span class="text-xs text-[#E8D9C5] tracking-wider">{{ $activeTable->table_number }}</span>
                    <span class="text-[10px] text-[#A89C8F]">({{ $activeTable->section }})</span>
                </div>
            @else
                <div class="text-right">
                    <span class="text-[10px] tracking-[0.2em] uppercase text-[#C5A880] font-medium px-3 py-1 rounded-full bg-[#181614] border border-[#C5A880]/20">VIP Night Menu</span>
                </div>
            @endif
        </div>
    </header>

    <main class="relative z-10">
        @yield('content')
    </main>

    <footer class="relative z-10 border-t border-[#C5A880]/15 bg-[#090807] mt-20 py-12 text-center text-xs text-[#A89C8F]">
        <div class="max-w-md mx-auto px-4 space-y-3">
            <p class="font-lux-title tracking-[0.3em] text-[#C5A880] text-sm font-normal">MIKALE VIP LOUNGE</p>
            <p class="text-[#8C8276] text-[11px] font-light leading-relaxed">Özel miksoloji sunumları, şef tabakları ve şişe seremonileri için lütfen servis ekibimize danışınız.</p>
            <div class="h-[1px] w-14 mx-auto lux-divider my-4"></div>
            <p class="text-[9px] tracking-[0.25em] text-[#6E655A] uppercase">© 2026 MIKALE CLUB. ALL RIGHTS RESERVED.</p>
        </div>
    </footer>
</body>
</html>
