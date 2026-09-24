<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $bookings = $user->bookings()->with('pg', 'room')->latest()->get();

        $stats = [
            'total' => $bookings->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        return view('dashboard.index', compact('bookings', 'stats'));
    }
}
