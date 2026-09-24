@extends('layouts.app')

@section('title', 'Book ' . $pg->name . ' - StayEase')

@section('content')
    <x-page-header title="Complete Your Booking" :subtitle="'PG: ' . $pg->name . ' · ' . $pg->city" />

    <form action="{{ route('bookings.store', $pg) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="space-y-6">
                <div class="card p-6 animate-on-scroll">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-8 h-8 rounded-lg hero-gradient text-white flex items-center justify-center text-sm font-bold">1</span>
                        <h2 class="text-lg font-bold text-slate-900">Select Room</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach($pg->rooms->where('status', 'active') as $room)
                            <label class="flex items-center p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-brand-300 hover:bg-brand-50/30 transition-all has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                                <input type="radio" name="room_id" value="{{ $room->id }}" required class="mr-3 text-brand-600 focus:ring-brand-500">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900">{{ ucfirst($room->room_type) }} - Room {{ $room->room_number }}</p>
                                    <p class="text-sm text-slate-500">₹{{ number_format($room->monthly_rent) }}/month · {{ $room->available_beds }} beds available</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('room_id')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                </div>

                <div class="card p-6 animate-on-scroll stagger-2">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-8 h-8 rounded-lg hero-gradient text-white flex items-center justify-center text-sm font-bold">2</span>
                        <h2 class="text-lg font-bold text-slate-900">Move-in Details</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Move-in Date *</label>
                            <input type="date" name="move_in_date" required min="{{ date('Y-m-d') }}" class="input-modern" value="{{ old('move_in_date') }}">
                            @error('move_in_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Duration (Months) *</label>
                            <select name="duration_months" required class="input-modern">
                                <option value="">Select duration</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('duration_months') == $i ? 'selected' : '' }}>{{ $i }} Month{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            @error('duration_months')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Number of Occupants *</label>
                            <input type="number" name="occupants" required min="1" max="4" class="input-modern" value="{{ old('occupants', 1) }}">
                            @error('occupants')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6 animate-on-scroll stagger-3">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-8 h-8 rounded-lg hero-gradient text-white flex items-center justify-center text-sm font-bold">3</span>
                        <h2 class="text-lg font-bold text-slate-900">Personal Details</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Full Name *</label>
                            <input type="text" name="full_name" required class="input-modern" value="{{ old('full_name', auth()->user()->name) }}">
                            @error('full_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Email *</label>
                            <input type="email" name="email" required class="input-modern" value="{{ old('email', auth()->user()->email) }}">
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Phone *</label>
                            <input type="tel" name="phone" required class="input-modern" value="{{ old('phone', auth()->user()->phone) }}">
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Current Address *</label>
                            <input type="text" name="current_address" required class="input-modern" value="{{ old('current_address') }}">
                            @error('current_address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="card p-6 animate-on-scroll stagger-4">
                    <div class="flex items-center gap-3 mb-5">
                        <span class="w-8 h-8 rounded-lg hero-gradient text-white flex items-center justify-center text-sm font-bold">4</span>
                        <h2 class="text-lg font-bold text-slate-900">Emergency Contact</h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Contact Name *</label>
                            <input type="text" name="emergency_contact" required class="input-modern" value="{{ old('emergency_contact') }}">
                            @error('emergency_contact')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">Contact Phone *</label>
                            <input type="tel" name="emergency_phone" required class="input-modern" value="{{ old('emergency_phone') }}">
                            @error('emergency_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6 lg:p-8 animate-on-scroll">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-8 h-8 rounded-lg hero-gradient text-white flex items-center justify-center text-sm font-bold">5</span>
                <h2 class="text-lg font-bold text-slate-900">Booking Summary</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <div class="flex justify-between"><span class="text-slate-500">PG Name</span><span class="font-semibold">{{ $pg->name }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Monthly Rent</span><span class="font-semibold gradient-text">₹{{ number_format($pg->monthly_rent) }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Security Deposit</span><span class="font-semibold">₹{{ number_format($pg->security_deposit) }}</span></div>
                    <div class="border-t border-slate-200 pt-3 flex justify-between text-lg font-bold">
                        <span>Total Amount</span><span class="gradient-text">₹{{ number_format($pg->monthly_rent + $pg->security_deposit) }}</span>
                    </div>
                </div>
                <div>
                    <label class="flex items-start gap-3 p-4 bg-brand-50 rounded-xl cursor-pointer">
                        <input type="checkbox" required class="mt-1 text-brand-600 focus:ring-brand-500 rounded">
                        <span class="text-sm text-slate-700">I agree to the house rules and terms & conditions. Security deposit will be refunded within 30 days after vacating.</span>
                    </label>
                    <button type="submit" class="btn-primary w-full mt-4 text-lg">Submit Booking Request</button>
                    <p class="text-sm text-slate-500 text-center mt-3">Owner will review your request within 24 hours.</p>
                </div>
            </div>
        </div>
    </form>
@endsection
