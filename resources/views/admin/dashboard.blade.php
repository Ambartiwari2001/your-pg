@extends('layouts.app')

@section('title', 'Admin Dashboard - StayEase')

@section('content')
    <x-page-header title="Admin Dashboard" subtitle="Manage PGs, bookings, and users" />

    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-10">
        <x-stat-card label="Total PGs" :value="$stats['total_pgs']" color="brand" />
        <x-stat-card label="Active PGs" :value="$stats['active_pgs']" color="green" />
        <x-stat-card label="Total Users" :value="$stats['total_users']" color="purple" />
        <x-stat-card label="Pending" :value="$stats['pending_bookings']" color="amber" />
        <x-stat-card label="Approved" :value="$stats['approved_bookings']" color="green" />
        <x-stat-card label="Revenue" :value="'₹' . number_format($stats['total_revenue'])" color="red" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        @php
            $links = [
                ['route' => 'admin.pgs.index', 'gradient' => 'from-brand-600 to-violet-600', 'icon' => '🏠', 'title' => 'Manage PGs', 'desc' => 'Add, edit, or delete PGs'],
                ['route' => 'admin.bookings.index', 'gradient' => 'from-purple-600 to-pink-600', 'icon' => '📅', 'title' => 'Manage Bookings', 'desc' => 'Approve or reject bookings'],
                ['route' => 'admin.users.index', 'gradient' => 'from-emerald-600 to-teal-600', 'icon' => '👥', 'title' => 'Manage Users', 'desc' => 'View user information'],
                ['route' => 'admin.pgs.create', 'gradient' => 'from-orange-500 to-amber-500', 'icon' => '➕', 'title' => 'Add New PG', 'desc' => 'Create a new PG listing'],
            ];
        @endphp
        @foreach($links as $i => $link)
            <a href="{{ route($link['route']) }}"
               class="group relative overflow-hidden rounded-2xl p-6 text-white bg-gradient-to-br {{ $link['gradient'] }} shadow-soft hover:shadow-glow hover:-translate-y-1 transition-all duration-300 animate-on-scroll stagger-{{ $i + 1 }}">
                <div class="text-3xl mb-3">{{ $link['icon'] }}</div>
                <h3 class="font-bold text-lg">{{ $link['title'] }}</h3>
                <p class="text-sm text-white/80 mt-1">{{ $link['desc'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="card overflow-hidden animate-on-scroll">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-xl font-bold text-slate-900">Recent Bookings</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="table-modern w-full">
                <thead>
                    <tr>
                        <th>Booking No.</th>
                        <th>User</th>
                        <th>PG</th>
                        <th>Room</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentBookings as $booking)
                        <tr>
                            <td class="font-medium">{{ $booking->booking_number }}</td>
                            <td>{{ $booking->user?->name ?? 'Unknown' }}</td>
                            <td>{{ $booking->pg?->name ?? 'N/A' }}</td>
                            <td>{{ $booking->room?->room_type ? ucfirst($booking->room->room_type) : 'N/A' }}</td>
                            <td class="font-semibold">₹{{ number_format($booking->total_amount) }}</td>
                            <td>
                                @if($booking->status === 'pending')
                                    <span class="badge-pending">Pending</span>
                                @elseif($booking->status === 'approved')
                                    <span class="badge-approved">Approved</span>
                                @else
                                    <span class="badge-rejected">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-brand-600 hover:text-brand-700 font-semibold">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
