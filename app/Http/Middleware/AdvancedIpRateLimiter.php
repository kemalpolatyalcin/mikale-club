<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AdvancedIpRateLimiter
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $banKey = 'ip_banned_' . md5($ip);
        $windowKey = 'ip_req_count_' . md5($ip);

        if (Cache::has($banKey)) {
            $remainingSeconds = Cache::get('ip_ban_expiry_' . md5($ip), now()->addMinutes(60)->timestamp) - now()->timestamp;
            $remainingMinutes = max(1, ceil($remainingSeconds / 60));

            if ($request->expectsJson() || $request->is('api/*') || $request->is('orders/*')) {
                return response()->json([
                    'success' => false,
                    'message' => "Aşırı istek nedeniyle IP adresiniz geçici olarak engellenmiştir. Kalan süre: {$remainingMinutes} dakika.",
                ], 429);
            }

            return response("Aşırı istek nedeniyle IP adresiniz geçici olarak engellenmiştir. Kalan süre: {$remainingMinutes} dakika.", 429);
        }

        $currentCount = (int) Cache::get($windowKey, 0);

        if ($currentCount === 0) {
            Cache::put($windowKey, 1, 60);
        } else {
            Cache::increment($windowKey);
        }

        if ($currentCount + 1 > 100) {
            Cache::put($banKey, true, now()->addMinutes(60));
            Cache::put('ip_ban_expiry_' . md5($ip), now()->addMinutes(60)->timestamp, now()->addMinutes(60));
            Cache::forget($windowKey);

            if ($request->expectsJson() || $request->is('api/*') || $request->is('orders/*')) {
                return response()->json([
                    'success' => false,
                    'message' => '1 dakika içerisinde 100 istek sınırını aştığınız için IP adresiniz 60 dakika boyunca tamamen engellenmiştir.',
                ], 429);
            }

            return response('1 dakika içerisinde 100 istek sınırını aştığınız için IP adresiniz 60 dakika boyunca tamamen engellenmiştir.', 429);
        }

        return $next($request);
    }
}
