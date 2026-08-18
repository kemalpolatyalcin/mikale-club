<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIKALE CLUB - Tüm Masaların QR Standları (Toplu Baskı)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body { background: #fff !important; color: #000 !important; }
            .no-print { display: none !important; }
            .print-card-item { 
                background: #14120F !important; 
                color: #E6E0D8 !important; 
                page-break-inside: avoid; 
                break-inside: avoid; 
                margin-bottom: 20px;
                border: 2px solid #C5A880 !important;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="bg-[#090807] text-[#E6E0D8] min-h-screen p-6">
    <div class="no-print max-w-5xl mx-auto mb-8 flex items-center justify-between border-b border-[#C5A880]/20 pb-4">
        <div>
            <h1 class="font-lux-title text-2xl text-[#F5EFE6] uppercase tracking-wider">Tüm Masalar İçin QR Standları</h1>
            <p class="text-xs text-[#A89C8F]">Masanıza koymak üzere {{ $tables->count() }} masanın standını tek tıkla yazdırabilirsiniz.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-2.5 rounded-full bg-[#C5A880] text-[#0D0C0A] font-lux-title text-xs tracking-wider uppercase font-bold hover:brightness-110 shadow-lg shadow-[#C5A880]/20">
                🖨️ Tümünü Yazdır (A4)
            </button>
            <a href="{{ route('reception.index', ['tab' => 'tables']) }}" class="px-4 py-2.5 rounded-full bg-[#181614] border border-[#C5A880]/30 text-xs text-[#E8D9C5] hover:text-white">
                ← Portala Dön
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($tables as $tbl)
            <div class="print-card-item bg-[#12100D] border-2 border-[#C5A880]/40 rounded-3xl p-6 text-center space-y-4 shadow-xl">
                <div class="space-y-0.5">
                    <div class="w-9 h-9 rounded-full border border-[#C5A880] flex items-center justify-center bg-[#1D1914] text-[#C5A880] font-lux-title text-sm mx-auto">
                        M
                    </div>
                    <h2 class="font-lux-title text-sm tracking-[0.2em] text-[#F5EFE6] uppercase pt-1">MIKALE CLUB</h2>
                </div>

                <div class="bg-[#1A1713] border border-[#C5A880]/30 rounded-xl py-2 px-3">
                    <span class="text-[8px] uppercase tracking-widest text-[#C5A880] font-semibold block">{{ $tbl->section }}</span>
                    <h3 class="font-lux-title text-xl font-bold text-[#F5EFE6]">{{ $tbl->table_number }}</h3>
                    <span class="text-[9px] text-[#A89C8F] block truncate">{{ $tbl->name }}</span>
                </div>

                <div class="bg-white p-3 rounded-xl inline-block shadow-md mx-auto border-2 border-[#C5A880]/30">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(url('/table/' . $tbl->qr_token)) }}&color=0D0C0A&bgcolor=FFFFFF&margin=1" 
                         alt="{{ $tbl->table_number }} QR" class="w-36 h-36 block mx-auto">
                </div>

                <div class="space-y-1 text-[10px] text-[#A89C8F]">
                    <p class="font-lux-title text-xs text-[#E8D9C5] uppercase">Sipariş İçin Kameranızı Açın</p>
                    <p class="text-[9px] text-[#8C8276]">Resepsiyon VIP Kodunuz ile Masaya Bağlanın</p>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
