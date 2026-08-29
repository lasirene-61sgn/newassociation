<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VisionController extends Controller
{
    private function getAdminId()
    {
        return Auth::guard('admin')->id();
    }

    public function index()
    {
        $visions = Vision::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vision.index', compact('visions'));
    }

    public function create()
    {
        return view('admin.vision.create');
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
                $imagePaths[] = $file->store('vision_images', 'public');
            }
        }

        Vision::create([
            'admin_id' => $this->getAdminId(),
            'images' => $imagePaths,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.vision.index')->with('success', 'Vision Added');
    }

    public function edit(Vision $vision)
    {
        
        return view('admin.vision.edit', compact('vision'));
    }


    public function update(Request $request, Vision $vision)
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
        $currentImages = $vision->images ?? [];

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
                $currentImages[] = $file->store('vision_images', 'public');
            }
        }

        // 4. Update Vision record
        $vision->update([
            'images'      => !empty($currentImages) ? array_values($currentImages) : null,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.vision.index')->with('success', 'Vision updated successfully.');
    }

    public function destroy(Vision $vision)
    {
        

        if (!empty($vision->images)) {
            foreach ($vision->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $vision->delete();
        return redirect()->route('admin.vision.index')->with('success', 'Vision Deleted');
    }
}
