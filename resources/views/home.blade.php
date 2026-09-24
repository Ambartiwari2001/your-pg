@extends('layouts.app')

@section('title', 'Home - StayEase')

@section('content')
    <!-- Hero -->
    <section class="relative rounded-3xl overflow-hidden mb-16 animate-fade-in">
        <img src="{{ asset('images/home/hero-pg.jpg') }}"
             alt="Modern PG accommodation"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 hero-gradient opacity-90"></div>
        <div class="relative z-10 px-8 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="text-white animate-fade-in-up">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 backdrop-blur text-sm font-medium mb-6">
                    🏠 #1 PG Finder in Gujarat
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6 text-balance">
                    Find Your Perfect PG in Ahmedabad
                </h1>
                <p class="text-lg text-white/85 mb-8 max-w-lg leading-relaxed">
                    Verified, affordable, and secure accommodation for students and professionals. Browse 100+ listings with photos, amenities, and instant booking.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('pgs.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-brand-700 font-bold rounded-2xl hover:bg-brand-50 transition-all duration-300 shadow-lg hover:shadow-glow hover:-translate-y-0.5">
                        Explore PGs
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white/15 backdrop-blur text-white font-semibold rounded-2xl border border-white/30 hover:bg-white/25 transition-all duration-300">
                            Create Account
                        </a>
                    @endguest
                </div>
            </div>
            <div class="hidden lg:block animate-float">
                <div class="relative">
                    <img src="{{ asset('images/home/hero-pg.jpg') }}"
                         alt="Cozy PG room"
                         class="rounded-2xl shadow-2xl border-4 border-white/20 w-full max-w-md ml-auto">
                    <div class="absolute -bottom-6 -left-6 card p-4 shadow-card animate-fade-in-up stagger-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-2xl">✓</div>
                            <div>
                                <p class="font-bold text-slate-900">500+ Happy Tenants</p>
                                <p class="text-sm text-slate-500">Verified & trusted PGs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search -->
    <section class="mb-16 animate-on-scroll">
        <div class="card p-8 shadow-card -mt-8 relative z-20 mx-4 lg:mx-0">
            <h2 class="text-xl font-bold text-slate-900 mb-6">Quick Search</h2>
            <form action="{{ route('pgs.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Location</label>
                    <input type="text" name="location" placeholder="City or Area" class="input-modern">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Min Price</label>
                    <input type="number" name="min_price" placeholder="₹" class="input-modern">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Max Price</label>
                    <input type="number" name="max_price" placeholder="₹" class="input-modern">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-2">Gender</label>
                    <select name="gender" class="input-modern">
                        <option value="">Any</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="md:col-span-4">
                    <button type="submit" class="btn-primary w-full md:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Search PGs
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Featured PGs -->
    <section class="mb-20">
        <div class="flex items-end justify-between mb-8 animate-on-scroll">
            <div>
                <h2 class="section-title">Featured PGs</h2>
                <p class="section-subtitle">Hand-picked accommodations for you</p>
            </div>
            <a href="{{ route('pgs.index') }}" class="btn-ghost hidden sm:inline-flex">View all →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredPGs as $index => $pg)
                <article class="card card-hover overflow-hidden animate-on-scroll stagger-{{ min($index + 1, 6) }}">
                    <div class="relative h-52 overflow-hidden group">
                        <x-pg-image :pg="$pg" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                        <div class="absolute top-3 right-3 badge bg-white/90 text-brand-700 backdrop-blur">
                            ₹{{ number_format($pg->monthly_rent) }}/mo
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $pg->name }}</h3>
                        <p class="text-sm text-slate-500 mb-4 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $pg->city }}, {{ $pg->state }}
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($pg->amenities->take(3) as $amenity)
                                <span class="badge bg-brand-50 text-brand-700">{{ $amenity->name }}</span>
                            @endforeach
                        </div>
                        <div class="flex justify-between items-center text-sm text-slate-500 mb-5">
                            <span>{{ ucfirst($pg->gender) }}</span>
                            <span>{{ $pg->rooms->count() }} Rooms</span>
                        </div>
                        <a href="{{ route('pgs.show', $pg) }}" class="btn-primary w-full text-center text-sm py-2.5">View Details</a>
                    </div>
                </article>
            @empty
                <p class="text-slate-500 col-span-3 text-center py-12">No PGs available at the moment.</p>
            @endforelse
        </div>
    </section>

    <!-- Why Choose -->
    <section class="mb-20">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title">Why Choose StayEase?</h2>
            <p class="section-subtitle">Everything you need for a comfortable stay</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $features = [
                    ['img' => asset('images/pgs/stayease-premium-pg.jpg'), 'title' => 'Verified PGs', 'desc' => 'All properties are verified and authenticated'],
                    ['img' => asset('images/pgs/stayease-student-house.jpg'), 'title' => 'Affordable Pricing', 'desc' => 'Transparent pricing with no hidden charges'],
                    ['img' => asset('images/pgs/stayease-executive-stay.jpg'), 'title' => 'Easy Booking', 'desc' => 'Simple and hassle-free booking process'],
                    ['img' => asset('images/pgs/stayease-ladies-hostel.jpg'), 'title' => 'Safe & Secure', 'desc' => 'Your safety and privacy is our priority'],
                ];
            @endphp
            @foreach($features as $i => $feature)
                <div class="card card-hover p-6 text-center animate-on-scroll stagger-{{ $i + 1 }}">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-2xl overflow-hidden shadow-soft">
                        <img src="{{ $feature['img'] }}" alt="{{ $feature['title'] }}" class="w-full h-full object-cover" onerror="this.onerror=null;this.src='{{ asset('images/default-pg.jpg') }}';">
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-slate-500 text-sm">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- How It Works -->
    <section class="mb-12">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Four simple steps to your new home</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $steps = [
                    ['num' => '1', 'title' => 'Search PG', 'desc' => 'Browse available PGs in your area'],
                    ['num' => '2', 'title' => 'View Details', 'desc' => 'Check photos, amenities, and pricing'],
                    ['num' => '3', 'title' => 'Book Request', 'desc' => 'Submit your booking request easily'],
                    ['num' => '4', 'title' => 'Confirmation', 'desc' => 'Get instant confirmation from owner'],
                ];
            @endphp
            @foreach($steps as $i => $step)
                <div class="relative text-center animate-on-scroll stagger-{{ $i + 1 }}">
                    @if($i < 3)
                        <div class="hidden md:block absolute top-8 left-[60%] w-[80%] h-0.5 bg-gradient-to-r from-brand-300 to-brand-100"></div>
                    @endif
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl hero-gradient text-white flex items-center justify-center text-xl font-bold shadow-glow">
                        {{ $step['num'] }}
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-slate-500 text-sm">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection
