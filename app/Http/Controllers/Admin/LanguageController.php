<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|in:en,hi'
        ]);

        if (session()->has('committee_member')) {
            $committee = session('committee_member');
            // Assuming committee member might not have a language column in DB right now, we store in session
            session(['language' => $request->language]);
        } elseif (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $admin->language = $request->language;
            $admin->save();
        }

        return back()->with('success', 'Language changed to ' . ($request->language === 'hi' ? 'Hindi' : 'English'));
    }
}
