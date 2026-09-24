@extends('layouts.app')

@section('title', $pg->name . ' - StayEase')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <!-- Gallery -->
            <div class="animate-fade-in">
                <div class="rounded-2xl overflow-hidden mb-3 h-80 lg:h-96 shadow-card bg-slate-100 relative">
                    <img src="{{ $pg->primary_image_url }}" alt="{{ $pg->name }}" class="w-full h-full object-cover" id="mainImage" onerror="this.onerror=null;this.src='{{ asset('images/default-pg.jpg') }}';">
                </div>
                @if($pg->images->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($pg->images as $image)
                            <img src="{{ $image->image_url }}"
                                 alt="Gallery thumbnail"
                                 data-gallery-thumb="{{ $image->image_url }}"
                                 onerror="this.onerror=null;this.src='{{ asset('images/default-pg.jpg') }}';"
                                 class="w-full h-20 object-cover rounded-xl cursor-pointer hover:opacity-80 transition-all duration-200 ring-2 {{ $image->is_primary ? 'ring-brand-500' : 'ring-transparent' }}">
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="card p-6 lg:p-8 animate-on-scroll">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $pg->name }}</h1>
                <p class="text-slate-500 text-lg mb-6">{{ $pg->address }}, {{ $pg->city }}, {{ $pg->state }} - {{ $pg->pincode }}</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-6 border-y border-slate-100">
                    <div>
                        <p class="text-slate-500 text-sm">Monthly Rent</p>
                        <p class="text-2xl font-bold gradient-text">₹{{ number_format($pg->monthly_rent) }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Security Deposit</p>
                        <p class="text-2xl font-bold text-slate-900">₹{{ number_format($pg->security_deposit) }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Gender</p>
                        <p class="text-2xl font-bold text-slate-900">{{ ucfirst($pg->gender) }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm">Available Rooms</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $pg->rooms->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6 lg:p-8 animate-on-scroll">
                <h2 class="text-xl font-bold text-slate-900 mb-4">About This PG</h2>
                <p class="text-slate-600 leading-relaxed">{{ $pg->description }}</p>
            </div>

            <div class="card p-6 lg:p-8 animate-on-scroll">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Amenities & Facilities</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @forelse($pg->amenities as $amenity)
                        <div class="flex items-center gap-3 p-3 bg-brand-50/50 rounded-xl">
                            <span class="text-xl">{{ $amenity->icon ?? '✓' }}</span>
                            <span class="text-slate-800 font-medium">{{ $amenity->name }}</span>
                        </div>
                    @empty
                        <p class="text-slate-500 col-span-3">No amenities listed</p>
                    @endforelse
                </div>
            </div>

            <div class="card p-6 lg:p-8 animate-on-scroll">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Available Rooms</h2>
                <div class="space-y-4">
                    @forelse($pg->rooms as $room)
                        <div class="border border-slate-200 rounded-xl p-5 hover:border-brand-200 transition-colors">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-semibold text-slate-900">{{ ucfirst($room->room_type) }} - Room {{ $room->room_number }}</h3>
                                    <p class="text-slate-500 text-sm">{{ $room->total_beds }} beds | {{ $room->available_beds }} available</p>
                                </div>
                                <span class="text-lg font-bold gradient-text">₹{{ number_format($room->monthly_rent) }}/mo</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-gradient-to-r from-brand-500 to-violet-500 h-2 rounded-full transition-all duration-500" style="width: {{ ($room->available_beds / max($room->total_beds, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500">No rooms available</p>
                    @endforelse
                </div>
            </div>

            <div class="card p-6 lg:p-8 animate-on-scroll">
                <h2 class="text-xl font-bold text-slate-900 mb-4">House Rules</h2>
                <ul class="space-y-3 text-slate-600">
                    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm">✗</span> No smoking allowed</li>
                    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-sm">✗</span> No illegal activities</li>
                    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm">⏰</span> Visitor timing: 9 AM - 9 PM</li>
                    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm">⏰</span> Check-in: 12 PM | Check-out: 12 PM</li>
                    <li class="flex items-center gap-3"><span class="w-8 h-8 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center text-sm">ℹ</span> 30 days notice period for vacating</li>
                </ul>
            </div>

            <div class="rounded-2xl overflow-hidden animate-on-scroll">
                <div class="hero-gradient p-6 lg:p-8 text-white">
                    <h2 class="text-xl font-bold mb-4">Contact PG Owner</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <p class="text-white/70 text-sm">Phone</p>
                            <p class="font-semibold">+91 98765 43210</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <p class="text-white/70 text-sm">WhatsApp</p>
                            <p class="font-semibold">+91 98765 43210</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                            <p class="text-white/70 text-sm">Email</p>
                            <p class="font-semibold">owner@stayease.in</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Sidebar -->
        <div class="lg:col-span-1">
            <div class="card p-6 sticky top-24 shadow-card animate-slide-in-right">
                <h2 class="text-2xl font-bold text-slate-900 mb-6">Book This PG</h2>
                @auth
                    <form action="{{ route('bookings.create', $pg) }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Select Room</label>
                            <select name="room_id" required class="input-modern">
                                <option value="">Choose a room type</option>
                                @foreach($pg->rooms->where('status', 'active') as $room)
                                    <option value="{{ $room->id }}">{{ ucfirst($room->room_type) }} - ₹{{ number_format($room->monthly_rent) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Move-in Date</label>
                            <input type="date" name="move_in_date" required min="{{ date('Y-m-d') }}" class="input-modern">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Duration (Months)</label>
                            <select name="duration_months" required class="input-modern">
                                <option value="">Select duration</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }} Month{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-2 text-sm">
                            <div class="flex justify-between"><span class="text-slate-500">Monthly Rent</span><span class="font-semibold">₹{{ number_format($pg->monthly_rent) }}</span></div>
                            <div class="flex justify-between"><span class="text-slate-500">Deposit</span><span class="font-semibold">₹{{ number_format($pg->security_deposit) }}</span></div>
                            <div class="border-t border-slate-200 pt-2 flex justify-between font-bold">
                                <span>Total</span><span class="gradient-text">₹{{ number_format($pg->monthly_rent + $pg->security_deposit) }}</span>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary w-full text-lg">Book Now</button>
                    </form>
                    <p class="text-sm text-brand-600 text-center mt-4 font-medium">✓ Secure booking process</p>
                @else
                    <div class="space-y-3">
                        <p class="text-slate-500 text-center">Please log in to book this PG</p>
                        <a href="{{ route('login') }}" class="btn-primary w-full text-center">Login</a>
                        <a href="{{ route('register') }}" class="btn-secondary w-full text-center">Create Account</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
