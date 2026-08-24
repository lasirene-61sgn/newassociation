@extends('admin.layout.app')

@section('content')
<!-- Cropper.js CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<div class="container mt-5">
    <h2>Create Mobile Index Slides</h2>

    <form action="{{ route('admin.mobile_index.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div id="image-upload-wrapper">
            <div class="row align-items-center mb-3 image-row">
                <div class="col-md-6">
                    <label class="form-label">Select Image</label>
                    <input type="file" name="mobile_images[]" class="form-control mobile-image-input" accept="image/*" required>
                    <div class="image-preview-container mt-2 d-none">
                        <img class="img-thumbnail image-preview" src="" style="max-height: 150px;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Show Duration (Seconds)</label>
                    <input type="number" name="image_seconds[]" class="form-control" value="5" min="1" required>
                </div>
                <div class="col-md-2 mt-4">
                    <button type="button" class="btn btn-danger remove-row-btn d-none">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-more-btn" class="btn btn-secondary btn-sm mb-4">+ Add More Images</button>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Save Configurations</button>
            <a href="{{ route('admin.mobile_index.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-more-btn').addEventListener('click', function() {
        let wrapper = document.getElementById('image-upload-wrapper');
        let newRow = wrapper.querySelector('.image-row').cloneNode(true);
        
        // Reset dynamic values
        newRow.querySelector('input[type="file"]').value = '';
        newRow.querySelector('input[type="number"]').value = '5';
        
        // Hide preview for the cloned row
        newRow.querySelector('.image-preview-container').classList.add('d-none');
        newRow.querySelector('.image-preview').src = '';
        
        // Show row removal option if expanded
        let removeBtn = newRow.querySelector('.remove-row-btn');
        removeBtn.classList.remove('d-none');
        
        removeBtn.addEventListener('click', function() {
            newRow.remove();
        });

        wrapper.appendChild(newRow);
    });
</script>

<!-- Cropping Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cropperModalLabel">Crop Mobile Image</h5>
        <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-light d-flex justify-content-center align-items-center" style="height: 60vh;">
        <img id="cropperImage" src="" style="max-width: 100%; max-height: 100%; display: block;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancelCropBtn">Cancel</button>
        <button type="button" class="btn btn-primary" id="applyCropBtn">Apply Crop</button>
      </div>
    </div>
  </div>
</div>

<!-- Cropper.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentFileInput = null;
        let cropper = null;
        const cropperModalEl = document.getElementById('cropperModal');
        // Initialize Bootstrap Modal
        const cropperModal = new bootstrap.Modal(cropperModalEl);
        const cropperImage = document.getElementById('cropperImage');
        
        function hideModal() {
            cropperModal.hide();
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            if (currentFileInput) {
                const previewContainer = currentFileInput.closest('.col-md-6').querySelector('.image-preview-container');
                const previewImg = previewContainer.querySelector('.image-preview');
                // If user closed without applying, reset if no previous preview exists
                if (!previewImg.src || previewImg.src === window.location.href) {
                    currentFileInput.value = '';
                }
            }
            currentFileInput = null;
        }

        document.body.addEventListener('change', function(e) {
            if (e.target.classList.contains('mobile-image-input')) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    if (files[0].name === 'cropped.png') return;
                    
                    currentFileInput = e.target;
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        cropperImage.src = event.target.result;
                        cropperModal.show();
                        
                        if (cropper) cropper.destroy();
                        
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 9 / 16, // Mobile portrait aspect ratio
                            viewMode: 1,
                            autoCropArea: 1,
                        });
                    };
                    reader.readAsDataURL(files[0]);
                }
            }
        });

        document.getElementById('closeModalBtn').addEventListener('click', hideModal);
        document.getElementById('cancelCropBtn').addEventListener('click', hideModal);

        document.getElementById('applyCropBtn').addEventListener('click', function() {
            if (!cropper || !currentFileInput) return;
            
            const canvas = cropper.getCroppedCanvas({
                width: 1080,
                height: 1920,
            });
            
            canvas.toBlob(function(blob) {
                const file = new File([blob], 'cropped.png', { type: 'image/png', lastModified: new Date().getTime() });
                const container = new DataTransfer();
                container.items.add(file);
                currentFileInput.files = container.files;
                
                const previewContainer = currentFileInput.closest('.col-md-6').querySelector('.image-preview-container');
                const previewImg = previewContainer.querySelector('.image-preview');
                previewImg.src = URL.createObjectURL(blob);
                previewContainer.classList.remove('d-none');
                
                cropperModal.hide();
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            }, 'image/png');
        });
    });
</script>
@endsection