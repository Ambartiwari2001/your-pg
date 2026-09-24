<?php

namespace App\Http\Controllers;

use App\Models\PG;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PGController extends Controller
{
    public function index(Request $request): View
    {
        $query = PG::where('status', 'active')
            ->with('images', 'amenities', 'rooms');

        // Apply filters
        if ($request->filled('location')) {
            $query->where('city', 'like', '%'.$request->location.'%');
        }

        if ($request->filled('min_price')) {
            $query->where('monthly_rent', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('monthly_rent', '<=', $request->max_price);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $pgs = $query->paginate(12);

        return view('pgs.index', compact('pgs'));
    }

    public function show(PG $pg): View
    {
        $pg->load('images', 'rooms', 'amenities', 'bookings');

        return view('pgs.show', compact('pg'));
    }
}
