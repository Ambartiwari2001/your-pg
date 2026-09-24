<?php

namespace App\Http\Controllers;

use App\Models\PG;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredPGs = PG::where('status', 'active')
            ->with('images', 'amenities')
            ->limit(6)
            ->get();

        return view('home', compact('featuredPGs'));
    }
}
