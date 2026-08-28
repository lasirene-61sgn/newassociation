@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8">
    
    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.586a2 2 0 012.828 0L20.5 5.5V9m-8-8v8m0 0h8"></path></svg>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Committee Member: {{ $committee->name }}</h2>
    </div>
    
    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Validation Errors:</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Main Form Container (Wide Layout) --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.committee.update', $committee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- NAME FIELD --}}
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" 
                           class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $committee->name) }}" 
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- PHONE FIELD --}}
                <div class="mb-5">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                    <input type="text" 
                           class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $committee->phone) }}" 
                           required>
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            {{-- PASSWORD FIELDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password (Optional)</label>
                    <input type="password" 
                           class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror" 
                           id="password" 
                           name="password">
                    <p class="mt-1 text-xs text-gray-500">Leave blank to keep the current password</p>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" 
                           class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                           id="password_confirmation" 
                           name="password_confirmation">
                </div>
            </div>
            
            {{-- POST NAME / ROLE FIELD --}}
            <div class="mb-5">
                <label for="post_name" class="block text-sm font-medium text-gray-700 mb-1">Committee Role/Designation <span class="text-red-500"></span></label>
                <input type="text" 
                       class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('post_name') border-red-500 @enderror" 
                       id="post_name" 
                       name="post_name" 
                       value="{{ old('post_name', $committee->post_name) }}" 
                       >
                @error('post_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- COMMITTEE CATEGORY FIELD --}}
            <div class="mb-5">
                <div class="flex justify-between items-center mb-1">
                    <label for="committee_category_id" class="block text-sm font-medium text-gray-700">Committee Category <span class="text-red-500"></span></label>
                    <button type="button" onclick="openCategoryModal()" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        + Add New Category
                    </button>
                </div>
                <select class="form-select w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('committee_category_id') border-red-500 @enderror" 
                        id="committee_category_id" 
                        name="committee_category_id">
                    <option value="">Select Category (Optional)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('committee_category_id', $committee->committee_category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('committee_category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- SORT ORDER FIELD --}}
            <div class="mb-5">
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Display Order <span class="text-red-500"></span></label>
                <input type="number" 
                       class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('sort_order') border-red-500 @enderror" 
                       id="sort_order" 
                       name="sort_order" 
                       value="{{ old('sort_order', $committee->sort_order) }}" 
                       min="0"
                       >
                <p class="mt-1 text-sm text-gray-500">Lower numbers appear first. Use 0 for President, 1 for Vice President, etc.</p>
                @error('sort_order')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6 border-gray-200">

            {{-- IMAGE FIELD (Shows Current Image & Upload) --}}
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                
                {{-- Current Image Preview --}}
                @if ($committee->image_path)
                    <div class="mb-4">
                        <span class="text-xs font-semibold text-gray-600">Current Image:</span>
                        {{-- NOTE: Using Storage::url() means this route must be accessible via a symbolic link/public disk. --}}
                        <img src="{{ Storage::url($committee->image_path) }}" 
                             alt="Current Member Image" 
                             class="w-36 h-36 object-cover rounded-lg shadow-md border border-gray-200 mt-2">
                    </div>
                @endif

                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload New Image (Optional):</label>
                <input class="block w-full text-sm text-gray-500
                             file:mr-4 file:py-2 file:px-4
                             file:rounded-lg file:border-0
                             file:text-sm file:font-semibold
                             file:bg-blue-50 file:text-blue-700
                             hover:file:bg-blue-100 cursor-pointer
                             @error('image') border-red-500 @enderror" 
                       type="file" 
                       id="image" 
                       name="image">
                <small class="mt-1 text-xs text-gray-500">Leave blank to keep the current image.</small>
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-6 border-gray-200">

            {{-- STATUS FIELD --}}
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select class="form-select w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror" 
                         id="status" 
                         name="status" 
                         required>
                    <option value="active" {{ old('status', $committee->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $committee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Buttons --}}
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 18h15.356M4 12v5h.582m15.356-2A8.001 8.001 0 0118.418 6h-15.356"></path></svg>
                    Update Member
                </button>
                <a href="{{ route('admin.committee.index') }}" class="inline-flex justify-center items-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
</div>

<!-- Add Category Modal -->
<div id="categoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeCategoryModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Add New Committee Category
                        </h3>
                        <div class="mt-4">
                            <label for="new_category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                            <input type="text" id="new_category_name" class="mt-1 form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Executive Board">
                            <p id="category_error" class="text-red-500 text-sm mt-1 hidden"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="saveCategory()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Save
                </button>
                <button type="button" onclick="closeCategoryModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openCategoryModal() {
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('new_category_name').value = '';
        document.getElementById('category_error').classList.add('hidden');
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    function saveCategory() {
        const name = document.getElementById('new_category_name').value;
        if (!name.trim()) {
            document.getElementById('category_error').innerText = 'Category name is required';
            document.getElementById('category_error').classList.remove('hidden');
            return;
        }

        // Disable button visually
        const saveBtn = document.querySelector('#categoryModal button.bg-blue-600');
        saveBtn.innerText = 'Saving...';
        saveBtn.disabled = true;

        fetch('{{ route("admin.committee_category.storeAjax") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => response.json())
        .then(data => {
            saveBtn.innerText = 'Save';
            saveBtn.disabled = false;

            if (data.status === 'success') {
                const select = document.getElementById('committee_category_id');
                const option = document.createElement('option');
                option.value = data.category.id;
                option.text = data.category.name;
                option.selected = true;
                select.appendChild(option);
                
                closeCategoryModal();
            } else {
                document.getElementById('category_error').innerText = data.message || 'An error occurred';
                document.getElementById('category_error').classList.remove('hidden');
            }
        })
        .catch(error => {
            saveBtn.innerText = 'Save';
            saveBtn.disabled = false;
            document.getElementById('category_error').innerText = 'An error occurred. Please try again.';
            document.getElementById('category_error').classList.remove('hidden');
        });
    }
</script>
@endsection