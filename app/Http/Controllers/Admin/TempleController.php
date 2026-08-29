<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temple;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TempleController extends Controller
{
    private function getAdminId()
    {
        return Auth::guard('admin')->id();
    }

    public function index()
    {
        $temples = Temple::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.temple.index', compact('temples'));
    }

    public function create()
    {
        return view('admin.temple.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'  => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,jpg,png,svg,webp,gif,|max:5120',
            'description' => 'nullable',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('temple_images', 'public');
            }
        }

        Temple::create([
            'admin_id' => $this->getAdminId(),
            'images' => $imagePaths,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.temple.index')->with('success', 'Temple Added');
    }

    public function edit(Temple $temple)
    {
        
        return view('admin.temple.edit', compact('temple'));
    }


    public function update(Request $request, Temple $temple)
    {
        // Authorization check
        

        $request->validate([
            'images'           => 'nullable|array',
            'images.*'         => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'removed_images'   => 'nullable|array',
            'removed_images.*' => 'string',
            'description'      => 'nullable|string',
        ]);

        // 1. Get current images
        $currentImages = $temple->images ?? [];

        // 2. Remove selected images from disk and from array
        if ($request->filled('removed_images')) {
            foreach ($request->removed_images as $removedImage) {
                // Delete from storage
                Storage::disk('public')->delete($removedImage);
                // Remove from array
                $currentImages = array_values(array_diff($currentImages, [$removedImage]));
            }
        }

        // 3. Append newly uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $currentImages[] = $file->store('temple_images', 'public');
            }
        }

        // 4. Update temple record
        $temple->update([
            'images'      => !empty($currentImages) ? array_values($currentImages) : null,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.temple.index')->with('success', 'Temple updated successfully.');
    }

    public function destroy(Temple $temple)
    {
        

        if (!empty($temple->images)) {
            foreach ($temple->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $temple->delete();
        return redirect()->route('admin.temple.index')->with('success', 'Temple Deleted');
    }
}
