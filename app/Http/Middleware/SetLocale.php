<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'en';

        // Check for committee member (web)
        if (session()->has('committee_member') && session()->has('language')) {
            $locale = session('language');
        } 
        // Check for admin (web/api)
        elseif (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
            $locale = \Illuminate\Support\Facades\Auth::guard('admin')->user()->language ?? 'en';
        }
        // Fallback for API
        elseif ($request->user() && isset($request->user()->language)) {
            $locale = $request->user()->language;
        } elseif ($request->hasHeader('Accept-Language')) {
            $locale = $request->header('Accept-Language');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
