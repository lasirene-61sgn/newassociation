@extends('admin.layout.app')

@section('content')
<div class="container-fluid p-6 lg:p-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-3 md:space-y-0">
        <h2 class="text-3xl font-bold text-gray-800">📝 About Us</h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.about-us.edit') }}" class="flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition duration-150 ease-in-out">
                Edit About Us
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
            <h5 class="text-xl font-semibold text-gray-800">Current Information</h5>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6">
                
                <div>
                    <h6 class="text-lg font-medium text-gray-700 mb-2">Description</h6>
                    <div class="p-4 bg-gray-50 rounded-md border border-gray-100">
                        {{ $aboutUs->description ?: 'Not provided.' }}
                    </div>
                </div>

                <div>
                    <h6 class="text-lg font-medium text-gray-700 mb-2">Vision</h6>
                    <div class="p-4 bg-gray-50 rounded-md border border-gray-100">
                        {{ $aboutUs->vision ?: 'Not provided.' }}
                    </div>
                </div>

                <div>
                    <h6 class="text-lg font-medium text-gray-700 mb-2">Mission</h6>
                    <div class="p-4 bg-gray-50 rounded-md border border-gray-100">
                        {{ $aboutUs->mission ?: 'Not provided.' }}
                    </div>
                </div>

                <div>
                    <h6 class="text-lg font-medium text-gray-700 mb-2">Image</h6>
                    <div class="p-4 bg-gray-50 rounded-md border border-gray-100">
                        @if($aboutUs->image_path)
                            <img src="{{ asset('storage/' . $aboutUs->image_path) }}" alt="About Us Image" class="w-64 h-auto rounded border border-gray-200 shadow-sm">
                        @else
                            <p class="text-gray-500">No image uploaded.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
