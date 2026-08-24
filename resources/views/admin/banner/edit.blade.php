@extends('admin.layout.app')

@section('content')
<!-- Cropper.js CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<div class="p-6 md:p-8">
    
    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Banner</h2>
    </div>
    
    {{-- Responsive styling applied: removed max-w-lg mx-auto for wider layout --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- Banner Image Upload Field --}}
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Banner Image Upload (Leave blank to keep existing)</label>
                <input class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100 cursor-pointer
                        @error('image') border-red-500 @enderror" 
                        type="file" 
                        id="image" 
                        name="image"
                        accept="image/*">
                
                <div id="image-preview-container" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">New Cropped Preview:</p>
                    <img id="image-preview" class="max-w-full h-auto rounded border border-gray-300" src="">
                </div>
                
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                {{-- Current Image Display --}}
                @if ($banner->image_path)
                    <p class="mt-4 text-sm font-medium text-gray-700">Current Image:</p>
                    <img src="{{ asset('storage/' . $banner->image_path) }}" 
                            alt="Current Banner" 
                            class="mt-2 w-full max-h-48 object-cover rounded-lg shadow-md border border-gray-200"
                            style="max-width: 300px;"> {{-- Kept max-width for image preview --}}
                @endif
                <p class="mt-2 text-xs text-gray-500">Only JPG, PNG, and GIF files are allowed. Recommended wide aspect ratio (e.g., 1920x600).</p>
            </div>

            {{-- Status Field --}}
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select class="form-select w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror" 
                         id="status" 
                         name="status" 
                         required>
                    <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Buttons --}}
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-3m-3-1l4-4m-4-4l-4 4m9-4l-4 4"></path></svg>
                    Update
                </button>
                <a href="{{ route('admin.banner.index') }}" class="inline-flex justify-center items-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Cropping Modal -->
<div id="cropperModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-bold">Crop Banner Image</h3>
            <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-4 flex-grow overflow-hidden flex justify-center items-center bg-gray-100">
            <div style="max-height: 60vh; width: 100%;">
                <img id="cropperImage" src="" style="max-width: 100%; display: block;">
            </div>
        </div>
        <div class="p-4 border-t flex justify-end gap-3">
            <button type="button" id="cancelCrop" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">Cancel</button>
            <button type="button" id="applyCrop" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Apply Crop</button>
        </div>
    </div>
</div>

<!-- Cropper.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const cropperModal = document.getElementById('cropperModal');
        const cropperImage = document.getElementById('cropperImage');
        const closeModal = document.getElementById('closeModal');
        const cancelCrop = document.getElementById('cancelCrop');
        const applyCrop = document.getElementById('applyCrop');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const imagePreview = document.getElementById('image-preview');
        
        let cropper = null;
        
        function hideModal() {
            cropperModal.classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            if (imagePreview.src === '' || imagePreview.src === window.location.href) {
                imageInput.value = ''; 
            }
        }
        
        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                if (files[0].name === 'cropped.png') return;
                
                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    cropperModal.classList.remove('hidden');
                    
                    if (cropper) {
                        cropper.destroy();
                    }
                    
                    cropper = new Cropper(cropperImage, {
                        aspectRatio: 1920 / 600,
                        viewMode: 1,
                        autoCropArea: 1,
                    });
                };
                reader.readAsDataURL(files[0]);
            }
        });
        
        closeModal.addEventListener('click', hideModal);
        cancelCrop.addEventListener('click', hideModal);
        
        applyCrop.addEventListener('click', function() {
            if (!cropper) return;
            
            const canvas = cropper.getCroppedCanvas({
                width: 1920,
                height: 600,
            });
            
            canvas.toBlob(function(blob) {
                const file = new File([blob], 'cropped.png', { type: 'image/png', lastModified: new Date().getTime() });
                const container = new DataTransfer();
                container.items.add(file);
                imageInput.files = container.files;
                
                imagePreview.src = URL.createObjectURL(blob);
                imagePreviewContainer.classList.remove('hidden');
                
                hideModal();
            }, 'image/png');
        });
    });
</script>
@endsection