<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Labh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabhController extends Controller
{
    private function getAdminId(){
        return Auth::guard('admin')->id();
    }

    public function index(){
        $labhs = Labh::where('admin_id', $this->getAdminId())->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.labh.index', compact('labhs'));
    }

    public function create(){
        return view('admin.labh.create');
    }

    public function store(Request $request){
        $request->validate([
            'heading' => 'nullable',
            'description' => 'nullable',
        ]);

        Labh::create([
            'admin_id' => $this->getAdminId(),
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.labh.index')->with('success', 'labh created');
    }

    public function edit(Labh $labh){
        if($labh->admin_id !== $this->getAdminId()){
            abort(403, 'unauthorized access');
        }
        return view('admin.labh.edit', compact('labh'));
    }

    public function update(Request $request, Labh $labh){
        if($labh->admin_id !== $this->getAdminId()){
            abort(403, 'unauthorized access');
        }

        $request->validate([
            'heading' => 'nullable',
            'description' => 'nullable',
        ]);

        $labh->update([
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.labh.index')->with('success', 'labh updated');
    }

    public function destroy(Labh $labh){
        if($labh->admin_id !== $this->getAdminId()){
            abort(403, 'unauthorized access');
        }
        $labh->delete();
        return redirect()->route('admin.labh.index')->with('success', 'Labh Deleted');
    }
}
