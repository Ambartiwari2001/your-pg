<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PG;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(): View
    {
        $stats = [
            'total_pgs' => PG::count(),
            'active_pgs' => PG::where('status', 'active')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'approved_bookings' => Booking::where('status', 'approved')->count(),
            'total_revenue' => Booking::where('status', 'approved')->sum('total_amount'),
        ];

        $recentBookings = Booking::with('user', 'pg', 'room')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}
