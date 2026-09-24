<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PG;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(PG $pg): View|RedirectResponse
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admins cannot book PGs.');
        }

        $pg->load('rooms', 'amenities');

        return view('bookings.create', compact('pg'));
    }

    public function store(Request $request, PG $pg): RedirectResponse
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admins cannot book PGs.');
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date|after:today',
            'duration_months' => 'required|integer|min:1|max:12',
            'occupants' => 'required|integer|min:1',
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'current_address' => 'required|string',
            'emergency_contact' => 'required|string',
            'emergency_phone' => 'required|string',
        ]);

        $room = $pg->rooms()->findOrFail($validated['room_id']);

        $totalAmount = ($room->monthly_rent * $validated['duration_months']) + $pg->security_deposit;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'pg_id' => $pg->id,
            'room_id' => $room->id,
            'booking_number' => 'BK'.Str::random(10),
            'move_in_date' => $validated['move_in_date'],
            'duration_months' => $validated['duration_months'],
            'occupants' => $validated['occupants'],
            'monthly_rent' => $room->monthly_rent,
            'security_deposit' => $pg->security_deposit,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'notes' => 'Contact: '.$validated['phone'].' | Email: '.$validated['email'],
        ]);

        // Update user info
        auth()->user()->update([
            'phone' => $validated['phone'],
            'name' => $validated['full_name'],
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking request submitted successfully!');
    }

    public function show(Booking $booking): View
    {
        $this->authorize('view', $booking);

        $booking->load('pg', 'room', 'user');

        return view('bookings.show', compact('booking'));
    }
}
