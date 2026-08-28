@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8">
    
    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Temple Management</h2>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg shadow-sm mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        
        {{-- Controls Header --}}
        <div class="p-4 md:p-5 border-b border-gray-100 flex items-center justify-between">
            <a href="{{ route('admin.temple.create') }}" 
               class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span>Add New Temple</span>
            </a>
        </div>
        
        {{-- Table Content --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden md:table-header-group">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">Images</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-4/12">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12 hidden lg:table-cell">Created At</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-2/12">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($temples as $temple)
                    
                    {{-- Mobile View: Stacked Card --}}
                    <tr class="md:hidden block border-b border-gray-200 last:border-b-0">
                        <td class="p-4 block">
                            <div class="space-y-3">
                                {{-- Images Grid --}}
                                <div class="flex flex-wrap gap-2">
                                    @if (!empty($temple->images))
                                        @foreach (array_slice($temple->images, 0, 3) as $img)
                                            <img src="{{ asset('storage/' . $img) }}" 
                                                 alt="Temple Image" 
                                                 class="w-16 h-16 object-cover rounded-md border border-gray-200 shadow-sm">
                                        @endforeach
                                        @if (count($temple->images) > 3)
                                            <div class="w-16 h-16 rounded-md bg-gray-100 border border-gray-200 flex items-center justify-center text-xs font-semibold text-gray-600">
                                                +{{ count($temple->images) - 3 }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400">No images</span>
                                    @endif
                                </div>
                                
                                {{-- Description --}}
                                <p class="text-sm text-gray-700">
                                    {{ Str::limit($temple->description ?? 'No description provided.', 80) }}
                                </p>

                                {{-- Actions --}}
                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    <span class="text-xs text-gray-400">{{ $temple->created_at->format('Y-m-d H:i') }}</span>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.temple.edit', $temple->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</a>
                                        <form action="{{ route('admin.temple.destroy', $temple->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this temple?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    {{-- Desktop View: Table Row --}}
                    <tr class="hover:bg-gray-50 hidden md:table-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                @if (!empty($temple->images))
                                    @foreach (array_slice($temple->images, 0, 3) as $img)
                                        <img src="{{ asset('storage/' . $img) }}" 
                                             alt="Temple Image" 
                                             class="w-14 h-14 object-cover rounded-md border border-gray-200 shadow-sm">
                                    @endforeach
                                    @if (count($temple->images) > 3)
                                        <span class="inline-flex items-center justify-center w-14 h-14 rounded-md bg-gray-100 border border-gray-200 text-xs font-bold text-gray-600">
                                            +{{ count($temple->images) - 3 }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-sm text-gray-400">No images</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($temple->description ?? 'No description provided.', 70) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                            {{ $temple->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                            <div class="flex space-x-2 justify-center">
                                <a href="{{ route('admin.temple.edit', $temple->id) }}" class="text-blue-600 hover:text-blue-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.temple.destroy', $temple->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this temple?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Temples Found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new temple entry.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.temple.create') }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                    Add New Temple
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination --}}
    <div class="mt-4">
        {{ $temples->links() }}
    </div>
</div>
@endsection