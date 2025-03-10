<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleFromUrlMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil prefix dari URL (misalnya 'en' atau 'id')
        $locale = $request->segment(1);

        // Pastikan prefix bahasa yang dipilih tersedia
        if (in_array($locale, ['en', 'id'])) {
            App::setLocale($locale);
        } else {
            // Jika tidak ada, gunakan bahasa default
            $locale = config('app.locale');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
