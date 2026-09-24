@extends('layouts.app')

@section('title', 'Manage Bookings - Admin')

@section('content')
    <x-page-header title="Manage Bookings" :subtitle="'Total Bookings: ' . $bookings->total()" />

    <div class="card overflow-hidden animate-on-scroll">
        <div class="overflow-x-auto">
            <table class="table-modern w-full">
                <thead>
                    <tr>
                        <th>Booking No.</th>
                        <th>User</th>
                        <th>PG</th>
                        <th>Move-in</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td class="font-semibold">{{ $booking->booking_number }}</td>
                            <td>{{ $booking->user?->name ?? 'Unknown' }}</td>
                            <td>{{ $booking->pg?->name ?? 'N/A' }}</td>
                            <td>{{ $booking->move_in_date?->format('d M, Y') ?? 'N/A' }}</td>
                            <td class="font-semibold">₹{{ number_format($booking->total_amount) }}</td>
                            <td>
                                @if($booking->status === 'pending')
                                    <span class="badge-pending">Pending</span>
                                @elseif($booking->status === 'approved')
                                    <span class="badge-approved">Approved</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="badge-rejected">Rejected</span>
                                @else
                                    <span class="badge-cancelled">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-brand-600 font-semibold hover:text-brand-700">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-slate-100">{{ $bookings->links() }}</div>
    </div>
@endsection
