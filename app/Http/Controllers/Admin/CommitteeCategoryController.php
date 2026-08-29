<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeCategoryController extends Controller
{
    private function getAdminId(){
        return Auth::guard('admin')->id();
    }

    public function index(){
        $categories = CommitteeCategory::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.committee_category.index', compact('categories'));
    }

    public function create(){
        return view('admin.committee_category.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        CommitteeCategory::create([
            'admin_id' => $this->getAdminId(),
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.committee_category.index')->with('success', 'Category Created');
    }

    public function storeAjax(Request $request){
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category = CommitteeCategory::create([
            'admin_id' => $this->getAdminId(),
            'name' => $request->name,
            'status' => 'active',
        ]);

        return response()->json([
            'status' => 'success',
            'category' => $category
        ]);
    }

    public function edit(CommitteeCategory $committee_category){
        
        return view('admin.committee_category.edit', compact('committee_category'));
    }

    public function update(Request $request, CommitteeCategory $committee_category){
        

        $request->validate([
            'name' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $committee_category->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.committee_category.index')->with('success', 'Category Updated');
    }

    public function destroy(CommitteeCategory $committee_category){
        
        $committee_category->delete();
        return redirect()->route('admin.committee_category.index')->with('success', 'Category Deleted');
    }
}
