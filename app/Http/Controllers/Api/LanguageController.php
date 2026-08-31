<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|in:en,hi'
        ]);

        $user = $request->user();
        
        if ($user) {
            $user->language = $request->language;
            $user->save();
        }

        if ($request->expectsJson() || $request->is('api/*') && !$request->has('_token')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Language changed successfully to ' . ($request->language === 'hi' ? 'Hindi' : 'English'),
                'language' => $request->language
            ]);
        }

        return back()->with('success', 'Language changed to ' . ($request->language === 'hi' ? 'Hindi' : 'English'));
    }
}
