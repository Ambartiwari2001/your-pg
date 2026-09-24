@extends('layouts.app')

@section('title', $user->name . ' - Admin')

@section('content')
    <x-page-header
        :title="$user->name"
        subtitle="User profile and booking history"
    />

    @if(session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-5 py-4 flex items-center gap-3 text-green-800 font-medium">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Profile card ── --}}
        <div class="space-y-6">
            <div class="card p-6 animate-on-scroll">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-brand-500 to-violet-500 flex items-center justify-center text-white font-bold text-3xl mb-4 shadow-soft">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <p class="text-slate-500 text-sm mt-1">Member since {{ $user->created_at->format('d M, Y') }}</p>
                </div>

                <dl class="space-y-4 text-sm">
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span class="text-lg shrink-0">✉</span>
                        <div>
                            <dt class="text-slate-500 font-medium text-xs uppercase tracking-wide">Email</dt>
                            <dd class="text-slate-900 font-semibold break-all mt-0.5">{{ $user->email }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span class="text-lg shrink-0">📞</span>
                        <div>
                            <dt class="text-slate-500 font-medium text-xs uppercase tracking-wide">Phone</dt>
                            <dd class="text-slate-900 font-semibold mt-0.5">{{ $user->phone ?? 'Not provided' }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50">
                        <span class="text-lg shrink-0">📋</span>
                        <div>
                            <dt class="text-slate-500 font-medium text-xs uppercase tracking-wide">Total Bookings</dt>
                            <dd class="text-slate-900 font-semibold mt-0.5">{{ $user->bookings->count() }}</dd>
                        </div>
                    </div>
                </dl>

                <div class="mt-6 flex flex-col gap-2">
                    <a href="mailto:{{ $user->email }}"
                       class="btn-primary text-center text-sm">
                        ✉ Contact via Email
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="btn-outline text-center text-sm">
                        ← Back to Users
                    </a>
                </div>
            </div>

            {{-- Quick stats --}}
            <div class="card p-6 animate-on-scroll stagger-1">
                <h3 class="font-bold text-slate-900 mb-4">Booking Summary</h3>
                @php
                    $pending   = $user->bookings->where('status', 'pending')->count();
                    $approved  = $user->bookings->where('status', 'approved')->count();
                    $rejected  = $user->bookings->where('status', 'rejected')->count();
                    $cancelled = $user->bookings->where('status', 'cancelled')->count();
                @endphp
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Pending</dt>
                        <dd class="font-semibold"><span class="badge-pending">{{ $pending }}</span></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Approved</dt>
                        <dd class="font-semibold"><span class="badge-approved">{{ $approved }}</span></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Rejected</dt>
                        <dd class="font-semibold"><span class="badge-rejected">{{ $rejected }}</span></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Cancelled</dt>
                        <dd class="font-semibold"><span class="badge-cancelled">{{ $cancelled }}</span></dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- ── Booking history ── --}}
        <div class="lg:col-span-2">
            <div class="card overflow-hidden animate-on-scroll">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-900">Booking History</h2>
                </div>

                @forelse($user->bookings->sortByDesc('created_at') as $booking)
                    <div class="p-5 border-b border-slate-100 last:border-0 hover:bg-slate-50/60 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <span class="font-bold text-slate-900 text-sm">{{ $booking->booking_number }}</span>
                                    @if($booking->status === 'pending')
                                        <span class="badge-pending">Pending</span>
                                    @elseif($booking->status === 'approved')
                                        <span class="badge-approved">Approved</span>
                                    @elseif($booking->status === 'rejected')
                                        <span class="badge-rejected">Rejected</span>
                                    @else
                                        <span class="badge-cancelled">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </div>
                                <p class="text-slate-700 font-semibold">{{ $booking->pg?->name ?? 'PG not found' }}</p>
                                <p class="text-slate-500 text-sm">
                                    Room: {{ $booking->room?->room_type ? ucfirst($booking->room->room_type) : 'N/A' }}
                                    · Move-in: {{ $booking->move_in_date?->format('d M, Y') ?? 'N/A' }}
                                    · {{ $booking->duration_months }} month(s)
                                </p>
                                @if($booking->rejection_note)
                                    <p class="mt-1 text-xs text-red-600 bg-red-50 rounded-lg px-2 py-1 inline-block">
                                        ❌ {{ $booking->rejection_note }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-bold text-brand-600">₹{{ number_format($booking->total_amount) }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $booking->created_at->diffForHumans() }}</p>
                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                   class="text-brand-600 text-sm font-semibold hover:underline mt-1 inline-block">
                                    View →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-slate-500">
                        <span class="text-4xl mb-3 block">📋</span>
                        No bookings found for this user.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
