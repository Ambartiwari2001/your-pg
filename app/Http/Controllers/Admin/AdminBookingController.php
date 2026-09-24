<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(): View
    {
        $bookings = Booking::with('user', 'pg', 'room')
            ->latest()
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking): View
    {
        $booking->load('user', 'pg', 'room', 'documents');

        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => 'approved', 'rejection_note' => null]);

        return back()->with('success', 'Booking approved successfully!');
    }

    public function reject(Booking $booking, Request $request): RedirectResponse
    {
        $request->validate([
            'rejection_note' => ['required', 'string', 'max:1000'],
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', 'Booking rejected with note saved.');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled!');
    }
}
