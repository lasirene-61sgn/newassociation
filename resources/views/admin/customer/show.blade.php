@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8 space-y-6">

    {{-- Top Action Bar --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ session('customer_index_url', route('admin.customer.index')) }}" 
               class="p-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 tracking-tight">{{ $customer->name }}</h2>
                <p class="text-sm text-gray-500">Member ID: #{{ $customer->id }} &bull; Registered on {{ $customer->created_at->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.customer.edit', $customer->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Member
            </a>
        </div>
    </div>

    {{-- Hero Profile Banner --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        {{-- Background Image / Cover --}}
        <div class="h-44 w-full bg-slate-200 relative overflow-hidden">
            @if($customer->background_image)
                <img src="{{ asset('storage/' . $customer->background_image) }}" alt="Cover" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-blue-600 to-indigo-700 opacity-90"></div>
            @endif
        </div>

        {{-- Profile Header Details --}}
        <div class="px-6 md:px-8 pb-6 relative">
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between -mt-16 sm:-mt-20 gap-4 mb-4">
                <div class="flex items-end space-x-5">
                    <div class="relative">
                        @if($customer->image)
                            <img src="{{ asset('storage/' . $customer->image) }}" alt="{{ $customer->name }}" 
                                 class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border-4 border-white shadow-md object-cover bg-white">
                        @else
                            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl border-4 border-white shadow-md bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-3xl">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($customer->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            @if($customer->gotra) <span><strong>Gotra:</strong> {{ $customer->gotra }}</span> &bull; @endif
                            @if($customer->father_name) <span>S/o / D/o {{ $customer->father_name }}</span> @endif
                        </p>
                    </div>
                </div>

                {{-- Working Board Tag --}}
                @if($customer->is_trust_working_board)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                        </svg>
                        Trust Working Board Member
                    </span>
                @endif
            </div>

            {{-- Identity & Quick Information Bar --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-100 text-sm">
                <div>
                    <span class="text-gray-500 block text-xs uppercase font-semibold">PAN Card</span>
                    <span class="font-medium text-gray-800 uppercase">{{ $customer->pan_card_no ?: '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block text-xs uppercase font-semibold">Aadhaar Card</span>
                    <span class="font-medium text-gray-800">{{ $customer->aadhar_no ?: '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block text-xs uppercase font-semibold">Mobile</span>
                    <span class="font-medium text-gray-800">{{ $customer->mobile ?: '—' }}</span>
                </div>
                <div>
                    <span class="text-gray-500 block text-xs uppercase font-semibold">Website</span>
                    @if($customer->website)
                        <a href="{{ $customer->website }}" target="_blank" class="text-indigo-600 hover:underline truncate block">
                            {{ $customer->website }}
                        </a>
                    @else
                        <span class="text-gray-400">—</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Lineage, Parents, & Address --}}
        <div class="space-y-6 lg:col-span-1">

            {{-- Family Lineage & Parents Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Lineage & Parents
                </h4>

                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Mother Name</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->mother_name ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Grandfather Name</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->grand_father_name ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Grandmother Name</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->grand_mother_name ?: '—' }}</dd>
                    </div>
                </dl>

                {{-- Parent Photos --}}
                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 mb-2 font-medium">Father Photo</span>
                        @if($customer->father_photo_path)
                            <img src="{{ asset('storage/' . $customer->father_photo_path) }}" alt="Father" 
                                 class="w-20 h-20 mx-auto rounded-lg object-cover border shadow-sm">
                        @else
                            <div class="w-20 h-20 mx-auto rounded-lg bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                                No Photo
                            </div>
                        @endif
                    </div>
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 mb-2 font-medium">Mother Photo</span>
                        @if($customer->mother_photo_path)
                            <img src="{{ asset('storage/' . $customer->mother_photo_path) }}" alt="Mother" 
                                 class="w-20 h-20 mx-auto rounded-lg object-cover border shadow-sm">
                        @else
                            <div class="w-20 h-20 mx-auto rounded-lg bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                                No Photo
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Location & Contact Information Card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Contact & Address
                </h4>

                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">WhatsApp</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->whatsapp ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Email</dt>
                        <dd class="font-medium text-gray-900 truncate max-w-[180px]">{{ $customer->email ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">M/S Firm Name</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->ms_firm_name ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Door / House No</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->dno ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Street / Road</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->street_road ?: '—' }}</dd>
                    </div>
                    @if($customer->address2)
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Address Line 2</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->address2 }}</dd>
                    </div>
                    @endif
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">Village</dt>
                        <dd class="font-medium text-gray-900">{{ optional($customer->village)->name ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">City / District</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->city ?: '—' }} / {{ $customer->district ?: '—' }}</dd>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <dt class="text-gray-500">State / Pincode</dt>
                        <dd class="font-medium text-gray-900">{{ $customer->state ?: '—' }} - {{ $customer->pincode ?: '—' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Right Column: Personal/Work Details + Payments Table + Family Members --}}
        <div class="space-y-6 lg:col-span-2">

            {{-- Personal & Professional Overview --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile & Professional Details
                </h4>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs">Date of Birth</span>
                        <span class="font-medium text-gray-900">{{ $customer->date_of_birth ? \Carbon\Carbon::parse($customer->date_of_birth)->format('d M, Y') : '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Anniversary Date</span>
                        <span class="font-medium text-gray-900">{{ $customer->anniversary_date ? \Carbon\Carbon::parse($customer->anniversary_date)->format('d M, Y') : '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Age / Gender</span>
                        <span class="font-medium text-gray-900">{{ $customer->age ? $customer->age . ' yrs' : '—' }} / {{ ucfirst($customer->gender ?: '—') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Blood Group</span>
                        <span class="font-medium text-gray-900">{{ $customer->blood_group ?: '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Education</span>
                        <span class="font-medium text-gray-900">{{ $customer->education ?: '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Occupation</span>
                        <span class="font-medium text-gray-900">{{ $customer->occupation ?: '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Business Type / Name</span>
                        <span class="font-medium text-gray-900">{{ $customer->business_type ?: '—' }} ({{ $customer->business_name ?: '—' }})</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Product / Service</span>
                        <span class="font-medium text-gray-900">{{ $customer->product_service ?: '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Native Place</span>
                        <span class="font-medium text-gray-900">{{ $customer->native_place ?: '—' }}</span>
                    </div>
                </div>

                @if($customer->hobbies)
                <div class="mt-4 pt-4 border-t border-gray-100 text-sm">
                    <span class="text-gray-500 block text-xs">Hobbies</span>
                    <p class="text-gray-800 mt-0.5">{{ $customer->hobbies }}</p>
                </div>
                @endif

                @if($customer->office_address)
                <div class="mt-3 text-sm">
                    <span class="text-gray-500 block text-xs">Office Address</span>
                    <p class="text-gray-800 mt-0.5">{{ $customer->office_address }}</p>
                </div>
                @endif
            </div>

            {{-- Payment Details / Labh Entries (Stored in JSON) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-100">
                    <h4 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Donation & Payment Details (Labh)
                    </h4>
                    @php
                        $payments = $customer->payment_details ?? [];
                        $totalAmount = is_array($payments) ? collect($payments)->sum('amount') : 0;
                    @endphp
                    <span class="text-xs font-semibold px-2.5 py-1 rounded bg-indigo-50 text-indigo-700">
                        Total: ₹{{ number_format((float)$totalAmount, 2) }}
                    </span>
                </div>

                @if(!empty($payments) && is_array($payments) && count($payments) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="px-3 py-2.5">#</th>
                                    <th class="px-3 py-2.5">Labh / Purpose</th>
                                    <th class="px-3 py-2.5">Cheque No</th>
                                    <th class="px-3 py-2.5">Bank & Branch</th>
                                    <th class="px-3 py-2.5">Date</th>
                                    <th class="px-3 py-2.5 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($payments as $idx => $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2.5 text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-3 py-2.5 font-medium text-gray-900">{{ $payment['labh_type'] ?? '—' }}</td>
                                        <td class="px-3 py-2.5 text-gray-600">{{ $payment['cheque_no'] ?? '—' }}</td>
                                        <td class="px-3 py-2.5 text-gray-600">
                                            {{ $payment['bank_name'] ?? '—' }}
                                            @if(!empty($payment['bank_branch']))
                                                <span class="text-xs text-gray-400">({{ $payment['bank_branch'] }})</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2.5 text-gray-600">
                                            {{ !empty($payment['date']) ? \Carbon\Carbon::parse($payment['date'])->format('d M, Y') : '—' }}
                                        </td>
                                        <td class="px-3 py-2.5 text-right font-semibold text-emerald-700">
                                            ₹{{ number_format((float)($payment['amount'] ?? 0), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-6 text-center text-sm text-gray-500">
                        No payment or donation entries recorded for this customer.
                    </div>
                @endif
            </div>

            {{-- Family Members List --}}
            @if(method_exists($customer, 'familyMembers') && $customer->familyMembers->isNotEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="text-base font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Registered Family Members ({{ $customer->familyMembers->count() }})
                </h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($customer->familyMembers as $member)
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200 flex items-center gap-3">
                            @if($member->image)
                                <img src="{{ asset($member->image) }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-full object-cover border">
                            @else
                                <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h5 class="text-sm font-semibold text-gray-900 truncate">{{ $member->name }}</h5>
                                <p class="text-xs text-gray-500">{{ $member->relationship ?: 'Member' }} &bull; {{ ucfirst($member->gender ?: 'N/A') }}</p>
                                @if($member->mobile)
                                    <p class="text-xs text-gray-500">{{ $member->mobile }}</p>
                                @endif
                            </div>
                            @if($member->pdf)
                                <a href="{{ asset($member->pdf) }}" target="_blank" class="p-1.5 text-red-600 hover:bg-red-50 rounded" title="View Document">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection