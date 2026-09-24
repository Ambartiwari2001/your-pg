@extends('layouts.app')

@section('title', 'My Dashboard - StayEase')

@section('content')
    <x-page-header :title="'Welcome back, ' . auth()->user()->name . '!'" subtitle="Manage your bookings and profile" />

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <x-stat-card label="Total Bookings" :value="$stats['total']" color="brand" icon="📋" />
        <x-stat-card label="Pending" :value="$stats['pending']" color="amber" icon="⏳" />
        <x-stat-card label="Approved" :value="$stats['approved']" color="green" icon="✓" />
        <x-stat-card label="Cancelled" :value="$stats['cancelled']" color="red" icon="✗" />
    </div>

    <div class="card overflow-hidden mb-10 animate-on-scroll">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">My Bookings</h2>
            <a href="{{ route('pgs.index') }}" class="btn-ghost text-sm">Browse PGs →</a>
        </div>

        @if($bookings->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($bookings as $booking)
                    <div class="p-6 hover:bg-brand-50/20 transition-colors duration-200">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                            <div class="md:col-span-2 flex gap-4">
                                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 shadow-soft">
                                    @if($booking->pg)
                                        <x-pg-image :pg="$booking->pg" class="w-full h-full object-cover" />
                                    @else
                                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-2xl">🏠</div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">{{ $booking->pg?->name ?? 'PG not found' }}</h3>
                                    <p class="text-slate-500 text-sm">{{ $booking->pg?->city ?? 'Location unavailable' }}</p>
                                    <p class="text-slate-500 text-sm">Room: {{ $booking->room?->room_type ? ucfirst($booking->room->room_type) : 'N/A' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wide">Move-in</p>
                                <p class="font-semibold text-slate-900">{{ $booking->move_in_date->format('d M, Y') }}</p>
                                <p class="text-slate-500 text-sm mt-1">{{ $booking->duration_months }} month(s)</p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs uppercase tracking-wide">Amount</p>
                                <p class="text-xl font-bold gradient-text">₹{{ number_format($booking->total_amount) }}</p>
                            </div>
                            <div class="text-right">
                                @if($booking->status === 'pending')
                                    <span class="badge-pending mb-2">Pending</span>
                                @elseif($booking->status === 'approved')
                                    <span class="badge-approved mb-2">Approved</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="badge-rejected mb-2">Rejected</span>
                                @else
                                    <span class="badge-cancelled mb-2">{{ ucfirst($booking->status) }}</span>
                                @endif
                                <br>
                                <a href="{{ route('bookings.show', $booking) }}" class="text-brand-600 hover:text-brand-700 font-semibold text-sm">View Details →</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center animate-on-scroll">
                <img src="{{ asset('images/home/hero-pg.jpg') }}" alt="No bookings" class="w-24 h-24 rounded-2xl object-cover mx-auto mb-4 opacity-80">
                <p class="text-slate-600 text-lg mb-4">No bookings yet</p>
                <a href="{{ route('pgs.index') }}" class="btn-primary">Browse PGs</a>
            </div>
        @endif
    </div>

    <div class="card p-6 lg:p-8 animate-on-scroll">
        <h2 class="text-xl font-bold text-slate-900 mb-6">My Profile</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-slate-500 text-sm">Full Name</p>
                <p class="font-semibold text-slate-900">{{ auth()->user()->name }}</p>
            </div>
            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-slate-500 text-sm">Email</p>
                <p class="font-semibold text-slate-900">{{ auth()->user()->email }}</p>
            </div>
            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-slate-500 text-sm">Phone</p>
                <p class="font-semibold text-slate-900">{{ auth()->user()->phone ?? 'Not provided' }}</p>
            </div>
            <div class="p-4 bg-slate-50 rounded-xl">
                <p class="text-slate-500 text-sm">Member Since</p>
                <p class="font-semibold text-slate-900">{{ auth()->user()->created_at->format('d M, Y') }}</p>
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ route('profile.edit') }}" class="btn-primary">Edit Profile</a>
        </div>
    </div>
@endsection
