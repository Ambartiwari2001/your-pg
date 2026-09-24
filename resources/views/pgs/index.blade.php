@extends('layouts.app')

@section('title', 'Browse PGs - StayEase')

@section('content')
    <x-page-header title="Browse PGs" :subtitle="'Found ' . $pgs->total() . ' verified accommodations'" />

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Filters -->
        <aside class="lg:w-72 shrink-0 animate-on-scroll">
            <div class="card p-6 sticky top-24">
                <h3 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filters
                </h3>
                <form action="{{ route('pgs.index') }}" method="GET" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">Location</label>
                        <input type="text" name="location" value="{{ request('location') }}" placeholder="Search by city" class="input-modern">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">Price Range (₹)</label>
                        <div class="space-y-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="input-modern">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="input-modern">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">Gender</label>
                        <select name="gender" class="input-modern">
                            <option value="">All</option>
                            <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="any" {{ request('gender') === 'any' ? 'selected' : '' }}>Any</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-primary w-full">Apply Filters</button>
                </form>
            </div>
        </aside>

        <!-- Results -->
        <div class="flex-1 space-y-6">
            @forelse($pgs as $index => $pg)
                <article class="card card-hover overflow-hidden animate-on-scroll stagger-{{ min(($index % 6) + 1, 6) }}">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-0">
                        <div class="md:col-span-2 relative h-56 md:h-auto overflow-hidden group">
                            <x-pg-image :pg="$pg" class="w-full h-full object-cover min-h-[14rem] group-hover:scale-105 transition-transform duration-500" />
                            <div class="absolute top-3 left-3 badge bg-white/90 text-brand-700 backdrop-blur font-bold">
                                ₹{{ number_format($pg->monthly_rent) }}/mo
                            </div>
                        </div>
                        <div class="md:col-span-3 p-6 lg:p-8 flex flex-col justify-center">
                            <h2 class="text-2xl font-bold text-slate-900 mb-1">{{ $pg->name }}</h2>
                            <p class="text-slate-500 text-sm mb-3">{{ $pg->address }}, {{ $pg->city }}</p>
                            <p class="text-slate-600 mb-4 line-clamp-2">{{ $pg->description }}</p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($pg->amenities->take(5) as $amenity)
                                    <span class="badge bg-brand-50 text-brand-700">{{ $amenity->name }}</span>
                                @endforeach
                            </div>
                            <div class="flex flex-wrap gap-4 text-sm text-slate-500 mb-5">
                                <span>Deposit: ₹{{ number_format($pg->security_deposit) }}</span>
                                <span>{{ ucfirst($pg->gender) }}</span>
                                <span>{{ $pg->rooms->count() }} Rooms</span>
                                <span>{{ $pg->food_available ? 'Food Available' : 'No Food' }}</span>
                            </div>
                            <a href="{{ route('pgs.show', $pg) }}" class="btn-primary w-fit text-sm">View Details & Book</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="card p-12 text-center animate-on-scroll">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-2xl overflow-hidden opacity-60">
                        <img src="{{ asset('images/home/hero-pg.jpg') }}" alt="No results" class="w-full h-full object-cover">
                    </div>
                    <p class="text-slate-600 text-lg mb-4">No PGs found matching your criteria.</p>
                    <a href="{{ route('pgs.index') }}" class="btn-secondary">Clear Filters</a>
                </div>
            @endforelse

            <div class="mt-8">
                {{ $pgs->links() }}
            </div>
        </div>
    </div>
@endsection
