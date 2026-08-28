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
        $workProcesses = WorkProcess::where('admin_id', $this->getAdminId())->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.work_process.index', compact('workProcesses'));
    }

    public function create()
    {
        return view('admin.work_process.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'media'  => 'nullable|array',
            'media.*' => 'file|mimes:jpeg,jpg,png,svg,webp,gif,mp4,mov,avi,wmv|max:51200', // Allow up to 50MB for videos
        ]);

        $mediaPaths = [];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('work_process_media', 'public');
            }
        }

        WorkProcess::create([
            'admin_id' => $this->getAdminId(),
            'media' => $mediaPaths,
        ]);

        return redirect()->route('admin.work_process.index')->with('success', 'Work Process Added');
    }

    public function edit(WorkProcess $work_process)
    {
        if ($work_process->admin_id !== $this->getAdminId()) {
            abort(403, 'unauthorized access');
        }
        return view('admin.work_process.edit', compact('work_process'));
    }

    public function update(Request $request, WorkProcess $work_process)
    {
        if ($work_process->admin_id !== $this->getAdminId()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'media'           => 'nullable|array',
            'media.*'         => 'file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,wmv|max:51200',
            'removed_media'   => 'nullable|array',
            'removed_media.*' => 'string',
        ]);

        $currentMedia = $work_process->media ?? [];

        if ($request->filled('removed_media')) {
            foreach ($request->removed_media as $removedItem) {
                Storage::disk('public')->delete($removedItem);
                $currentMedia = array_values(array_diff($currentMedia, [$removedItem]));
            }
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $currentMedia[] = $file->store('work_process_media', 'public');
            }
        }

        $work_process->update([
            'media' => !empty($currentMedia) ? array_values($currentMedia) : null,
        ]);

        return redirect()->route('admin.work_process.index')->with('success', 'Work Process updated successfully.');
    }

    public function destroy(WorkProcess $work_process)
    {
        if ($work_process->admin_id !== $this->getAdminId()) {
            abort(403, 'unauthorized access');
        }

        if (!empty($work_process->media)) {
            foreach ($work_process->media as $item) {
                Storage::disk('public')->delete($item);
            }
        }
        $work_process->delete();
        return redirect()->route('admin.work_process.index')->with('success', 'Work Process Deleted');
    }
}
