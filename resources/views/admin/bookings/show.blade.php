@extends('layouts.app')

@section('title', 'Booking #' . $booking->booking_number . ' - Admin')

@section('content')
    <x-page-header
        title="Booking #{{ $booking->booking_number }}"
        subtitle="Submitted {{ $booking->created_at->diffForHumans() }}"
    />

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-200 px-5 py-4 flex items-center gap-3 text-green-800 font-medium">
            <span class="text-xl">✅</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 flex items-center gap-3 text-red-800 font-medium">
            <span class="text-xl">❌</span> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Left column: booking details ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Status banner --}}
            <div class="card p-6 flex items-center justify-between gap-4 animate-on-scroll">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Current Status</p>
                    @if($booking->status === 'pending')
                        <span class="badge-pending text-base px-4 py-1.5">⏳ Pending Review</span>
                    @elseif($booking->status === 'approved')
                        <span class="badge-approved text-base px-4 py-1.5">✅ Approved</span>
                    @elseif($booking->status === 'rejected')
                        <span class="badge-rejected text-base px-4 py-1.5">❌ Rejected</span>
                    @elseif($booking->status === 'cancelled')
                        <span class="badge-cancelled text-base px-4 py-1.5">🚫 Cancelled</span>
                    @else
                        <span class="badge-approved text-base px-4 py-1.5">✔ {{ ucfirst($booking->status) }}</span>
                    @endif
                </div>
                <a href="{{ route('admin.bookings.index') }}" class="btn-outline text-sm">← Back to Bookings</a>
            </div>

            {{-- Booking details --}}
            <div class="card p-6 animate-on-scroll stagger-1">
                <h2 class="text-lg font-bold text-slate-900 mb-5">Booking Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    <div>
                        <dt class="text-slate-500 font-medium">Booking Number</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">{{ $booking->booking_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Move-in Date</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">{{ $booking->move_in_date?->format('d M, Y') ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Duration</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">{{ $booking->duration_months }} month(s)</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Occupants</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">{{ $booking->occupants }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Monthly Rent</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">₹{{ number_format($booking->monthly_rent) }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Security Deposit</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">₹{{ number_format($booking->security_deposit) }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Total Amount</dt>
                        <dd class="font-bold text-brand-600 text-base mt-0.5">₹{{ number_format($booking->total_amount) }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Booked On</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">{{ $booking->created_at->format('d M, Y h:i A') }}</dd>
                    </div>
                </dl>

                @if($booking->notes)
                    <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">User Notes</p>
                        <p class="text-slate-700 text-sm">{{ $booking->notes }}</p>
                    </div>
                @endif

                @if($booking->rejection_note)
                    <div class="mt-4 p-4 rounded-xl bg-red-50 border border-red-200">
                        <p class="text-xs font-semibold text-red-600 uppercase tracking-wide mb-1">❌ Rejection Reason</p>
                        <p class="text-red-800 text-sm">{{ $booking->rejection_note }}</p>
                    </div>
                @endif
            </div>

            {{-- PG Details --}}
            <div class="card p-6 animate-on-scroll stagger-2">
                <h2 class="text-lg font-bold text-slate-900 mb-5">PG Information</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                    <div>
                        <dt class="text-slate-500 font-medium">PG Name</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">
                            <a href="{{ route('admin.pgs.show', $booking->pg) }}" class="text-brand-600 hover:underline">
                                {{ $booking->pg?->name ?? 'N/A' }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium">Room Type</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">
                            {{ $booking->room?->room_type ? ucfirst($booking->room->room_type) : 'N/A' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-slate-500 font-medium">Address</dt>
                        <dd class="font-semibold text-slate-900 mt-0.5">
                            {{ $booking->pg?->address ?? 'N/A' }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Documents --}}
            @if($booking->documents && $booking->documents->count())
                <div class="card p-6 animate-on-scroll stagger-3">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Submitted Documents</h2>
                    <ul class="space-y-2">
                        @foreach($booking->documents as $doc)
                            <li class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-200">
                                <span class="text-xl">📄</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-800 truncate">{{ $doc->document_type ?? 'Document' }}</p>
                                    <p class="text-xs text-slate-500">Uploaded {{ $doc->created_at->diffForHumans() }}</p>
                                </div>
                                @if($doc->file_path)
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                       class="text-brand-600 text-sm font-semibold hover:underline shrink-0">View</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- ── Right column: user card + actions ── --}}
        <div class="space-y-6">

            {{-- User card --}}
            <div class="card p-6 animate-on-scroll">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Applicant</h2>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brand-500 to-violet-500 flex items-center justify-center text-white font-bold text-lg shrink-0">
                        {{ strtoupper(substr($booking->user?->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $booking->user?->name ?? 'Unknown User' }}</p>
                        <p class="text-sm text-slate-500">{{ $booking->user?->email ?? '' }}</p>
                    </div>
                </div>
                @if($booking->user?->phone)
                    <p class="text-sm text-slate-600 mb-1">📞 {{ $booking->user->phone }}</p>
                @endif
                @if($booking->user)
                    <div class="mt-4 flex flex-col gap-2">
                        <a href="{{ route('admin.users.show', $booking->user) }}"
                           class="btn-outline text-sm text-center">View Profile</a>
                        <a href="mailto:{{ $booking->user->email }}"
                           class="btn-outline text-sm text-center">✉ Contact via Email</a>
                    </div>
                @endif
            </div>

            {{-- Admin Actions --}}
            @if(in_array($booking->status, ['pending', 'approved']))
                <div class="card p-6 animate-on-scroll stagger-1">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Admin Actions</h2>

                    @if($booking->status === 'pending')
                        {{-- Approve --}}
                        <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 px-4 rounded-xl font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                ✅ Approve Booking
                            </button>
                        </form>

                        {{-- Decline with note --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="w-full py-2.5 px-4 rounded-xl font-semibold text-white bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 transition-all duration-200 shadow-sm hover:shadow-md">
                                ❌ Decline Booking
                            </button>

                            <div x-show="open" x-transition class="mt-3">
                                <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rejection_note" class="block text-sm font-semibold text-slate-700 mb-1">
                                            Reason for Declining <span class="text-red-500">*</span>
                                        </label>
                                        <textarea id="rejection_note" name="rejection_note" rows="4"
                                                  placeholder="Explain why this booking is being declined..."
                                                  class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-300 focus:border-red-400 resize-none"
                                                  required>{{ old('rejection_note') }}</textarea>
                                        @error('rejection_note')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                            class="w-full py-2.5 px-4 rounded-xl font-semibold text-white bg-red-600 hover:bg-red-700 transition-colors">
                                        Confirm Decline
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($booking->status === 'approved')
                        <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST"
                              onsubmit="return confirm('Cancel this approved booking?')">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 px-4 rounded-xl font-semibold text-white bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 transition-all duration-200">
                                🚫 Cancel Booking
                            </button>
                        </form>
                    @endif
                </div>
            @endif

        </div>
    </div>
@endsection
