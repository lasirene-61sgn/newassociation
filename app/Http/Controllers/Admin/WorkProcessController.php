<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WorkProcessController extends Controller
{
    private function getAdminId()
    {
        return Auth::guard('admin')->id();
    }

    public function index()
    {
        $workProcesses = WorkProcess::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.work_process.index', compact('workProcesses'));
    }

    public function create()
    {
        return view('admin.work_process.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'   => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,jpg,png,svg,webp,gif|max:5120',
            'videos'   => 'nullable|array',
            'videos.*' => 'file|mimes:mp4,mov,avi,wmv|max:51200', // Allow up to 50MB for videos
        ]);

        $imagePaths = [];
        $videoPaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('work_process_images', 'public');
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $file) {
                $videoPaths[] = $file->store('work_process_videos', 'public');
            }
        }

        WorkProcess::create([
            'admin_id' => $this->getAdminId(),
            'images' => !empty($imagePaths) ? $imagePaths : null,
            'videos' => !empty($videoPaths) ? $videoPaths : null,
        ]);

        return redirect()->route('admin.work_process.index')->with('success', 'Work Process Added');
    }

    public function edit(WorkProcess $work_process)
    {
        
        return view('admin.work_process.edit', compact('work_process'));
    }

    public function update(Request $request, WorkProcess $work_process)
    {
        

        $request->validate([
            'images'          => 'nullable|array',
            'images.*'        => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'videos'          => 'nullable|array',
            'videos.*'        => 'file|mimes:mp4,mov,avi,wmv|max:51200',
            'removed_images'  => 'nullable|array',
            'removed_images.*'=> 'string',
            'removed_videos'  => 'nullable|array',
            'removed_videos.*'=> 'string',
        ]);

        $currentImages = $work_process->images ?? [];
        $currentVideos = $work_process->videos ?? [];

        if ($request->filled('removed_images')) {
            foreach ($request->removed_images as $removedItem) {
                Storage::disk('public')->delete($removedItem);
                $currentImages = array_values(array_diff($currentImages, [$removedItem]));
            }
        }

        if ($request->filled('removed_videos')) {
            foreach ($request->removed_videos as $removedItem) {
                Storage::disk('public')->delete($removedItem);
                $currentVideos = array_values(array_diff($currentVideos, [$removedItem]));
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $currentImages[] = $file->store('work_process_images', 'public');
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $file) {
                $currentVideos[] = $file->store('work_process_videos', 'public');
            }
        }

        $work_process->update([
            'images' => !empty($currentImages) ? array_values($currentImages) : null,
            'videos' => !empty($currentVideos) ? array_values($currentVideos) : null,
        ]);

        return redirect()->route('admin.work_process.index')->with('success', 'Work Process updated successfully.');
    }

    public function destroy(WorkProcess $work_process)
    {
        

        if (!empty($work_process->images)) {
            foreach ($work_process->images as $item) {
                Storage::disk('public')->delete($item);
            }
        }
        if (!empty($work_process->videos)) {
            foreach ($work_process->videos as $item) {
                Storage::disk('public')->delete($item);
            }
        }
        $work_process->delete();
        return redirect()->route('admin.work_process.index')->with('success', 'Work Process Deleted');
    }
}
