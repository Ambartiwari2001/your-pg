@extends('layouts.app')

@section('title', 'Booking Details - StayEase')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 animate-fade-in-down">
            <x-page-header title="Booking Details" :subtitle="'Booking #' . $booking->booking_number" class="mb-0" />
            <div>
                @if($booking->status === 'pending')
                    <span class="badge-pending text-sm px-4 py-2">Pending</span>
                @elseif($booking->status === 'approved')
                    <span class="badge-approved text-sm px-4 py-2">Approved</span>
                @elseif($booking->status === 'rejected')
                    <span class="badge-rejected text-sm px-4 py-2">Rejected</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6 animate-on-scroll">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">PG Information</h2>
                    <div class="flex gap-5">
                        <div class="w-28 h-28 rounded-xl overflow-hidden shrink-0 shadow-soft">
                            @if($booking->pg)
                                <x-pg-image :pg="$booking->pg" class="w-full h-full object-cover" />
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-3xl">🏠</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">{{ $booking->pg?->name ?? 'PG not found' }}</h3>
                            <p class="text-slate-500 mt-1">{{ $booking->pg?->address ?? 'Address unavailable' }}</p>
                            <p class="text-slate-500">{{ $booking->pg?->city ?? '' }}, {{ $booking->pg?->state ?? '' }}</p>
                            <div class="mt-3 flex gap-4 text-sm">
                                <span><strong>Rent:</strong> ₹{{ number_format($booking->pg?->monthly_rent ?? 0) }}</span>
                                <span><strong>Gender:</strong> {{ $booking->pg?->gender ? ucfirst($booking->pg->gender) : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-6 animate-on-scroll">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Booking Details</h2>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach([
                            ['Room Type', $booking->room?->room_type ? ucfirst($booking->room->room_type) : 'N/A'],
                            ['Room Number', $booking->room?->room_number ?? 'N/A'],
                            ['Move-in Date', $booking->move_in_date->format('d M, Y')],
                            ['Duration', $booking->duration_months . ' Month(s)'],
                            ['Occupants', $booking->occupants],
                            ['Booked On', $booking->created_at->format('d M, Y')],
                        ] as [$label, $value])
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <p class="text-slate-500 text-xs uppercase tracking-wide">{{ $label }}</p>
                                <p class="font-semibold text-slate-900">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card p-6 animate-on-scroll">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Pricing Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between"><span class="text-slate-500">Rent × {{ $booking->duration_months }} months</span><span class="font-semibold">₹{{ number_format($booking->monthly_rent * $booking->duration_months) }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Security Deposit</span><span class="font-semibold">₹{{ number_format($booking->security_deposit) }}</span></div>
                        <div class="border-t border-slate-200 pt-3 flex justify-between text-lg font-bold">
                            <span>Total</span><span class="gradient-text">₹{{ number_format($booking->total_amount) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6 animate-on-scroll">
                    <h3 class="font-bold text-slate-900 mb-4">Status</h3>
                    @if($booking->status === 'pending')
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-sm">
                            <strong>Pending Approval</strong><br>The PG owner will contact you within 24 hours.
                        </div>
                    @elseif($booking->status === 'approved')
                        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm">
                            <strong>Approved!</strong><br>Contact the owner for payment and move-in details.
                        </div>
                    @elseif($booking->status === 'rejected')
                        <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm">
                            <strong>Rejected</strong><br>Try booking another PG from our listings.
                        </div>
                    @endif
                </div>

                <div class="card p-6 animate-on-scroll">
                    <h3 class="font-bold text-slate-900 mb-4">Contact Owner</h3>
                    <div class="space-y-3">
                        <a href="tel:+919876543210" class="btn-primary w-full">📞 Call Owner</a>
                        <a href="https://wa.me/919876543210" target="_blank" class="block w-full text-center py-3 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors">💬 WhatsApp</a>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" class="btn-secondary w-full text-center">← Back to Dashboard</a>
            </div>
        </div>
    </div>
@endsection
