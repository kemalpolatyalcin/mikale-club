<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIKALE CLUB - {{ $table->table_number }} Masa QR Standı</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,400&family=Marcellus&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body { background: #000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .print-card { box-shadow: none !important; border: 2px solid #C5A880 !important; }
        }
    </style>
</head>
<body class="bg-[#090807] text-[#E6E0D8] min-h-screen flex flex-col items-center justify-center p-4">
    <div class="no-print mb-6 flex items-center gap-3">
        <button onclick="window.print()" class="px-5 py-2.5 rounded-full bg-[#C5A880] text-[#0D0C0A] font-lux-title text-xs tracking-wider uppercase font-bold hover:brightness-110 shadow-lg shadow-[#C5A880]/20">
            🖨️ Bu Standı Yazdır
        </button>
        <a href="{{ route('reception.index', ['tab' => 'tables']) }}" class="px-4 py-2.5 rounded-full bg-[#181614] border border-[#C5A880]/30 text-xs text-[#E8D9C5] hover:text-white">
            ← Portala Dön
        </a>
    </div>

    <div class="print-card w-full max-w-sm bg-[#12100D] border-2 border-[#C5A880]/50 rounded-3xl p-8 text-center space-y-6 shadow-2xl shadow-black relative overflow-hidden">
        <div class="space-y-1">
            <div class="w-12 h-12 rounded-full border border-[#C5A880] flex items-center justify-center bg-[#1D1914] text-[#C5A880] font-lux-title text-xl mx-auto shadow-md shadow-[#C5A880]/30">
                M
            </div>
            <h1 class="font-lux-title text-xl tracking-[0.25em] text-[#F5EFE6] uppercase pt-1">MIKALE</h1>
            <p class="text-[8px] tracking-[0.35em] uppercase text-[#A89C8F]">Club & VIP Lounge</p>
            <div class="h-[1px] w-16 mx-auto lux-divider my-2"></div>
        </div>

        <div class="bg-[#1A1713] border border-[#C5A880]/40 rounded-2xl py-3 px-4 space-y-0.5">
            <span class="text-[9px] uppercase tracking-[0.25em] text-[#C5A880] font-semibold block">{{ $table->section }}</span>
            <h2 class="font-lux-title text-2xl md:text-3xl font-bold text-[#F5EFE6] tracking-wider">{{ $table->table_number }}</h2>
            <span class="text-[10px] text-[#A89C8F] block">{{ $table->name }}</span>
        </div>

        <div class="bg-white p-4 rounded-2xl inline-block shadow-xl mx-auto border-4 border-[#C5A880]/40">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode(url('/table/' . $table->qr_token)) }}&color=0D0C0A&bgcolor=FFFFFF&margin=2" 
                 alt="Masa {{ $table->table_number }} QR Kodu" class="w-48 h-48 block mx-auto">
        </div>

        <div class="space-y-2 pt-1 text-xs text-[#A89C8F] font-light">
            <p class="font-lux-title text-sm text-[#E8D9C5] uppercase tracking-wider">Sipariş İçin Kameranızı Açın</p>
            <p class="text-[11px] leading-relaxed">
                QR kodu taratıp resepsiyondan aldığınız <strong class="text-[#C5A880]">VIP Giriş Kodu</strong> ile masaya anında bağlanıp sipariş verebilirsiniz.
            </p>
        </div>

        <div class="pt-2 border-t border-[#C5A880]/20">
            <span class="text-[8px] tracking-[0.3em] uppercase text-[#6E655A]">Exclusive Table Ordering System</span>
        </div>
    </div>
</body>
</html>
