@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.temple.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Temple</h2>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg shadow-sm mb-6">
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.temple.update', $temple->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Hidden container to track removed images --}}
            <div id="removed-images-inputs"></div>

            {{-- Existing Images Section --}}
            @if (!empty($temple->images))
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Existing Images</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="existing-images-grid">
                        @foreach ($temple->images as $index => $img)
                            <div class="relative group rounded-lg overflow-hidden border border-gray-200 shadow-sm" id="image-box-{{ $index }}">
                                <img src="{{ asset('storage/' . $img) }}" alt="Temple Image" class="w-full h-28 object-cover">
                                
                                {{-- Remove button --}}
                                <button type="button" 
                                        onclick="markImageForRemoval('{{ $img }}', 'image-box-{{ $index }}')" 
                                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1.5 hover:bg-red-700 shadow focus:outline-none transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Add More Images --}}
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload More Images</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Select extra files</span>
                                <input id="images" name="images[]" type="file" multiple accept="image/*" class="sr-only" onchange="previewNewImages(event)">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500">You can add more images without losing old ones</p>
                    </div>
                </div>

                {{-- New Uploads Preview --}}
                <div id="new-preview-container" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mt-4"></div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="5" 
                          class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $temple->description) }}</textarea>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.temple.index') }}" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 shadow-md transition">
                    Update Temple
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Handles individual image deletion
    function markImageForRemoval(imagePath, boxId) {
        // 1. Hide the image box in UI
        document.getElementById(boxId).remove();

        // 2. Create a hidden input for the controller
        const inputContainer = document.getElementById('removed-images-inputs');
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'removed_images[]';
        hiddenInput.value = imagePath;
        inputContainer.appendChild(hiddenInput);
    }

    // Preview newly selected images
    function previewNewImages(event) {
        const container = document.getElementById('new-preview-container');
        container.innerHTML = '';
        const files = event.target.files;

        if (files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-20 object-cover rounded-md border border-blue-300 shadow-sm';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection