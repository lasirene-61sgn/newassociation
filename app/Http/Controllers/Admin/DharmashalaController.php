<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dharmashala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DharmashalaController extends Controller
{
    private function getAdminId()
    {
        return Auth::guard('admin')->id();
    }

    public function index()
    {
        $dharmas = Dharmashala::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.dharma.index', compact('dharmas'));
    }

    public function create()
    {
        return view('admin.dharma.create');
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
                $imagePaths[] = $file->store('dharma_images', 'public');
            }
        }

        Dharmashala::create([
            'admin_id' => $this->getAdminId(),
            'images' => $imagePaths,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dharma.index')->with('success', 'dharma Added');
    }

    public function edit(Dharmashala $dharma)
    {
        
        return view('admin.dharma.edit', compact('dharma'));
    }


    public function update(Request $request, Dharmashala $dharma)
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
        $currentImages = $dharma->images ?? [];

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
                $currentImages[] = $file->store('dharma_images', 'public');
            }
        }

        // 4. Update dharma record
        $dharma->update([
            'images'      => !empty($currentImages) ? array_values($currentImages) : null,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dharma.index')->with('success', 'dharma updated successfully.');
    }

    public function destroy(Dharmashala $dharma)
    {
        

        if (!empty($dharma->images)) {
            foreach ($dharma->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $dharma->delete();
        return redirect()->route('admin.dharma.index')->with('success', 'dharma Deleted');
    }
}
