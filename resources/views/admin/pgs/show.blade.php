@extends('layouts.app')

@section('title', $pg->name . ' - Admin')

@section('content')
    <div class="page-container">
        <div class="max-w-6xl mx-auto space-y-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-brand-600">Admin Panel</p>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $pg->name }}</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.pgs.edit', $pg) }}" class="btn-secondary">Edit PG</a>
                    <a href="{{ route('admin.pgs.index') }}" class="btn-primary">Back to List</a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 card overflow-hidden">
                    <div class="h-80 bg-slate-200 relative overflow-hidden">
                        <img src="{{ $pg->primary_image_url }}" alt="{{ $pg->name }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('images/default-pg.jpg') }}';">
                        <div class="absolute bottom-3 right-3">
                            <a href="{{ route('admin.pgs.edit', $pg) }}" class="px-3 py-1.5 rounded-lg bg-black/60 hover:bg-black/80 text-white text-xs font-semibold backdrop-blur transition-colors flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Manage Photos ({{ $pg->images->count() }})
                            </a>
                        </div>
                    </div>

                    @if($pg->images->count() > 1)
                        <div class="p-4 border-b border-slate-100 bg-slate-50 flex gap-2 overflow-x-auto">
                            @foreach($pg->images as $img)
                                <div class="relative shrink-0 w-20 h-16 rounded-lg overflow-hidden border {{ $img->is_primary ? 'border-emerald-500 ring-2 ring-emerald-400' : 'border-slate-200' }}">
                                    <img src="{{ $img->image_url }}" alt="Gallery thumbnail" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('images/default-pg.jpg') }}';">
                                    @if($img->is_primary)
                                        <span class="absolute bottom-0.5 right-0.5 bg-emerald-600 text-white text-[9px] px-1 py-0.2 rounded font-bold">★</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="p-6 space-y-6">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 mb-2">Overview</h2>
                            <p class="text-slate-600 leading-relaxed">{{ $pg->description }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <p class="text-sm uppercase tracking-wide text-slate-500">Location</p>
                                <p class="text-slate-800 font-medium">{{ $pg->address }}, {{ $pg->city }}, {{ $pg->state }} - {{ $pg->pincode }}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm uppercase tracking-wide text-slate-500">Gender</p>
                                <p class="text-slate-800 font-medium">{{ ucfirst($pg->gender) }}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm uppercase tracking-wide text-slate-500">Monthly Rent</p>
                                <p class="text-slate-800 font-medium">₹{{ number_format($pg->monthly_rent) }}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm uppercase tracking-wide text-slate-500">Security Deposit</p>
                                <p class="text-slate-800 font-medium">₹{{ number_format($pg->security_deposit) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="card p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Status</h2>
                        <span class="badge {{ $pg->status === 'active' ? 'badge-approved' : 'badge-rejected' }}">
                            {{ ucfirst($pg->status) }}
                        </span>
                    </div>

                    <div class="card p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Amenities</h2>
                        <div class="flex flex-wrap gap-2">
                            @forelse($pg->amenities as $amenity)
                                <span class="bg-brand-50 text-brand-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $amenity->name }}</span>
                            @empty
                                <span class="text-slate-500 text-sm">No amenities listed</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="card p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Rooms</h2>
                        <div class="space-y-3">
                            @forelse($pg->rooms as $room)
                                <div class="border border-slate-200 rounded-xl p-3">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-semibold text-slate-800">{{ ucfirst($room->room_type) }}</span>
                                        <span class="text-sm text-slate-600">{{ $room->available_beds }}/{{ $room->total_beds }} beds</span>
                                    </div>
                                    <p class="text-sm text-slate-600">Room #{{ $room->room_number }} · ₹{{ number_format($room->monthly_rent) }}</p>
                                </div>
                            @empty
                                <p class="text-slate-500 text-sm">No rooms available</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
