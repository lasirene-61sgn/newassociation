@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Add New Member</h2>
    </div>

    @php
        $fieldPermissions = Auth::guard('admin')->user()->customer_field_permissions ?? [];
    @endphp

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.customer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Row 1: Primary Personal Details --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('name', $fieldPermissions))
                <div class="mb-3 md:mb-0">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('image', $fieldPermissions))
                <div class="mb-3 md:mb-0">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                    <input type="file"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer @error('image') border-red-500 @enderror"
                        id="image" name="image">
                    @error('image')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('father_name', $fieldPermissions))
                <div class="mb-3 md:mb-0">
                    <label for="father_name" class="block text-sm font-medium text-gray-700 mb-1">Father Name</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('father_name') border-red-500 @enderror"
                        id="father_name" name="father_name" value="{{ old('father_name') }}">
                    @error('father_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('gotra', $fieldPermissions))
                <div class="mb-3 md:mb-0">
                    <label for="gotra" class="block text-sm font-medium text-gray-700 mb-1">Gotra</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('gotra') border-red-500 @enderror"
                        id="gotra" name="gotra" value="{{ old('gotra') }}">
                    @error('gotra')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            <hr class="my-6 border-gray-200">

            {{-- Family Lineage & Document Photos --}}
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Family Lineage & Parents Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="mother_name" class="block text-sm font-medium text-gray-700 mb-1">Mother Name</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('mother_name') border-red-500 @enderror"
                        id="mother_name" name="mother_name" value="{{ old('mother_name') }}">
                    @error('mother_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="grand_father_name" class="block text-sm font-medium text-gray-700 mb-1">Grandfather Name</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('grand_father_name') border-red-500 @enderror"
                        id="grand_father_name" name="grand_father_name" value="{{ old('grand_father_name') }}">
                    @error('grand_father_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="grand_mother_name" class="block text-sm font-medium text-gray-700 mb-1">Grandmother Name</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('grand_mother_name') border-red-500 @enderror"
                        id="grand_mother_name" name="grand_mother_name" value="{{ old('grand_mother_name') }}">
                    @error('grand_mother_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="father_photo" class="block text-sm font-medium text-gray-700 mb-1">Father Photo</label>
                    <input type="file"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer @error('father_photo') border-red-500 @enderror"
                        id="father_photo" name="father_photo">
                    @error('father_photo')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="mother_photo" class="block text-sm font-medium text-gray-700 mb-1">Mother Photo</label>
                    <input type="file"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer @error('mother_photo') border-red-500 @enderror"
                        id="mother_photo" name="mother_photo">
                    @error('mother_photo')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            {{-- Identity & Association Details --}}
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Identity & Association Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="pan_card_no" class="block text-sm font-medium text-gray-700 mb-1">PAN Card No</label>
                    <input type="text" maxlength="10"
                        class="form-input w-full uppercase px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('pan_card_no') border-red-500 @enderror"
                        id="pan_card_no" name="pan_card_no" value="{{ old('pan_card_no') }}" placeholder="ABCDE1234F">
                    @error('pan_card_no')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="aadhar_no" class="block text-sm font-medium text-gray-700 mb-1">Aadhaar Card No</label>
                    <input type="text" maxlength="12"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('aadhar_no') border-red-500 @enderror"
                        id="aadhar_no" name="aadhar_no" value="{{ old('aadhar_no') }}" placeholder="12-digit Aadhaar Number">
                    @error('aadhar_no')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="url"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('website') border-red-500 @enderror"
                        id="website" name="website" value="{{ old('website') }}" placeholder="https://example.com">
                    @error('website')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-6 flex items-center">
                <input type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-4 w-4"
                    id="is_trust_working_board" name="is_trust_working_board" value="1" {{ old('is_trust_working_board') ? 'checked' : '' }}>
                <label for="is_trust_working_board" class="ml-2 block text-sm font-medium text-gray-700">
                    Trust Working Board Member
                </label>
            </div>

            <hr class="my-6 border-gray-200">

            {{-- Location/Address Details --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('label_name', $fieldPermissions))
                <div>
                    <label for="label_name" class="block text-sm font-medium text-gray-700 mb-1">Label Name</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('label_name') border-red-500 @enderror"
                        id="label_name" name="label_name" value="{{ old('label_name') }}">
                    @error('label_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                <div>
                    <label for="village_id" class="block text-sm font-medium text-gray-700 mb-1">Village</label>
                    <select class="form-select w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('village_id') border-red-500 @enderror"
                        id="village_id" name="village_id">
                        <option value="">Select Village...</option>
                        @foreach($villages as $id => $name)
                        <option value="{{ $id }}" {{ old('village_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('village_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                @if(empty($fieldPermissions) || in_array('district', $fieldPermissions))
                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-1">District</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('district') border-red-500 @enderror"
                        id="district" name="district" value="{{ old('district') }}">
                    @error('district')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('ms_firm_name', $fieldPermissions))
                <div>
                    <label for="ms_firm_name" class="block text-sm font-medium text-gray-700 mb-1">M/S Firm Name</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('ms_firm_name') border-red-500 @enderror"
                        id="ms_firm_name" name="ms_firm_name" value="{{ old('ms_firm_name') }}">
                    @error('ms_firm_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('dno', $fieldPermissions))
                <div>
                    <label for="dno" class="block text-sm font-medium text-gray-700 mb-1">Door No. / H. No.</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('dno') border-red-500 @enderror"
                        id="dno" name="dno" value="{{ old('dno') }}">
                    @error('dno')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            @if(empty($fieldPermissions) || in_array('street_road', $fieldPermissions))
            <div class="mb-6">
                <label for="street_road" class="block text-sm font-medium text-gray-700 mb-1">Street / Road</label>
                <input type="text"
                    class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('street_road') border-red-500 @enderror"
                    id="street_road" name="street_road" value="{{ old('street_road') }}">
                @error('street_road')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            @endif

            @if(empty($fieldPermissions) || in_array('address2', $fieldPermissions))
            <div class="mb-6">
                <label for="address2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2 (Optional)</label>
                <input type="text"
                    class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('address2') border-red-500 @enderror"
                    id="address2" name="address2" value="{{ old('address2') }}">
                @error('address2')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('city', $fieldPermissions))
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('city') border-red-500 @enderror"
                        id="city" name="city" value="{{ old('city') }}">
                    @error('city')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('state') border-red-500 @enderror"
                        id="state" name="state" value="{{ old('state') }}">
                    @error('state')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                @if(empty($fieldPermissions) || in_array('pincode', $fieldPermissions))
                <div>
                    <label for="pincode" class="block text-sm font-medium text-gray-700 mb-1">Pincode</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('pincode') border-red-500 @enderror"
                        id="pincode" name="pincode" value="{{ old('pincode') }}">
                    @error('pincode')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            <hr class="my-6 border-gray-200">

            {{-- Contact Information --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('mobile', $fieldPermissions))
                <div>
                    <label for="mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('mobile') border-red-500 @enderror"
                        id="mobile" name="mobile" value="{{ old('mobile') }}">
                    @error('mobile')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('whatsapp', $fieldPermissions))
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('whatsapp') border-red-500 @enderror"
                        id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}">
                    @error('whatsapp')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('email', $fieldPermissions))
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                        id="email" name="email" value="{{ old('email') }}">
                    @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('status', $fieldPermissions))
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <select class="form-select w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror"
                        id="status" name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            {{-- Demographic & Profile --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('age', $fieldPermissions))
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                    <input type="number"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('age') border-red-500 @enderror"
                        id="age" name="age" value="{{ old('age') }}">
                    @error('age')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('gender', $fieldPermissions))
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('gender') border-red-500 @enderror"
                        id="gender" name="gender">
                        <option value="">Select Gender...</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('date_of_birth', $fieldPermissions))
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('date_of_birth') border-red-500 @enderror"
                        id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('anniversary_date', $fieldPermissions))
                <div>
                    <label for="anniversary_date" class="block text-sm font-medium text-gray-700 mb-1">Anniversary Date</label>
                    <input type="date"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('anniversary_date') border-red-500 @enderror"
                        id="anniversary_date" name="anniversary_date" value="{{ old('anniversary_date') }}">
                    @error('anniversary_date')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            {{-- Professional & Background Details --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('business_type', $fieldPermissions))
                <div>
                    <label for="business_type" class="block text-sm font-medium text-gray-700 mb-1">Business Type</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('business_type') border-red-500 @enderror"
                        id="business_type" name="business_type" value="{{ old('business_type') }}">
                    @error('business_type')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('business_name', $fieldPermissions))
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('business_name') border-red-500 @enderror"
                        id="business_name" name="business_name" value="{{ old('business_name') }}">
                    @error('business_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('product_service', $fieldPermissions))
                <div>
                    <label for="product_service" class="block text-sm font-medium text-gray-700 mb-1">Product/Service</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('product_service') border-red-500 @enderror"
                        id="product_service" name="product_service" value="{{ old('product_service') }}">
                    @error('product_service')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('education', $fieldPermissions))
                <div>
                    <label for="education" class="block text-sm font-medium text-gray-700 mb-1">Education</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('education') border-red-500 @enderror"
                        id="education" name="education" value="{{ old('education') }}">
                    @error('education')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('occupation', $fieldPermissions))
                <div>
                    <label for="occupation" class="block text-sm font-medium text-gray-700 mb-1">Occupation</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('occupation') border-red-500 @enderror"
                        id="occupation" name="occupation" value="{{ old('occupation') }}">
                    @error('occupation')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('blood_group', $fieldPermissions))
                <div>
                    <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('blood_group') border-red-500 @enderror"
                        id="blood_group" name="blood_group" value="{{ old('blood_group') }}">
                    @error('blood_group')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                @if(empty($fieldPermissions) || in_array('hobbies', $fieldPermissions))
                <div>
                    <label for="hobbies" class="block text-sm font-medium text-gray-700 mb-1">Hobbies</label>
                    <textarea class="form-textarea w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('hobbies') border-red-500 @enderror"
                        id="hobbies" name="hobbies" rows="2">{{ old('hobbies') }}</textarea>
                    @error('hobbies')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif

                @if(empty($fieldPermissions) || in_array('native_place', $fieldPermissions))
                <div>
                    <label for="native_place" class="block text-sm font-medium text-gray-700 mb-1">Native Place</label>
                    <input type="text"
                        class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('native_place') border-red-500 @enderror"
                        id="native_place" name="native_place" value="{{ old('native_place') }}">
                    @error('native_place')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                @endif
            </div>

            <div class="mb-6">
                <label for="background_image" class="block text-sm font-medium text-gray-700 mb-1">Background Image</label>
                <input type="file"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer @error('background_image') border-red-500 @enderror"
                    id="background_image" name="background_image">
                @error('background_image')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <hr class="my-6 border-gray-200">

            {{-- Multiple Payment Details / Labh Entries --}}
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Payment Details / Labh Entries</h3>
                        <p class="text-sm text-gray-500">Add multiple payments like Temple Donations, Cheques, etc.</p>
                    </div>
                    <button type="button" id="addPaymentBtn" class="px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        + Add Payment
                    </button>
                </div>

                <div id="paymentRowsContainer" class="space-y-4">
                    {{-- Dynamically populated --}}
                </div>
            </div>

            {{-- Submission Buttons --}}
            <div class="pt-4 border-t border-gray-100 flex gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Customer
                </button>
                <a href="{{ route('admin.customer.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    let paymentIndex = 0;

    function renderPaymentRow(data = {}) {
        const container = document.getElementById('paymentRowsContainer');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-1 md:grid-cols-6 gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 items-end payment-item';
        row.innerHTML = `
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Labh / Purpose</label>
                <input type="text" name="payment_details[${paymentIndex}][labh_type]" value="${data.labh_type || ''}" placeholder="Temple Donation" class="w-full text-sm px-3 py-2 border rounded-md">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Cheque No</label>
                <input type="text" name="payment_details[${paymentIndex}][cheque_no]" value="${data.cheque_no || ''}" placeholder="CHQ-00123" class="w-full text-sm px-3 py-2 border rounded-md">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Bank Name</label>
                <input type="text" name="payment_details[${paymentIndex}][bank_name]" value="${data.bank_name || ''}" placeholder="State Bank" class="w-full text-sm px-3 py-2 border rounded-md">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Bank Branch</label>
                <input type="text" name="payment_details[${paymentIndex}][bank_branch]" value="${data.bank_branch || ''}" placeholder="Main Branch" class="w-full text-sm px-3 py-2 border rounded-md">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Date</label>
                <input type="date" name="payment_details[${paymentIndex}][date]" value="${data.date || ''}" class="w-full text-sm px-3 py-2 border rounded-md">
            </div>
            <div class="flex gap-2">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Amount</label>
                    <input type="number" step="0.01" name="payment_details[${paymentIndex}][amount]" value="${data.amount || ''}" placeholder="0.00" class="w-full text-sm px-3 py-2 border rounded-md">
                </div>
                <button type="button" class="removePaymentBtn self-end mb-1 p-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        `;

        row.querySelector('.removePaymentBtn').addEventListener('click', () => row.remove());
        container.appendChild(row);
        paymentIndex++;
    }

    document.getElementById('addPaymentBtn').addEventListener('click', () => renderPaymentRow());

    // Prepopulate old input if validation failed
    @if(old('payment_details'))
        const oldPayments = @json(old('payment_details'));
        Object.values(oldPayments).forEach(item => renderPaymentRow(item));
    @endif
</script>
@endsection