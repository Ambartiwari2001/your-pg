@extends('layouts.app')

@section('title', 'Add New PG - Admin')

@section('content')
    <div class="page-container">
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-brand-600">Admin Panel</p>
                    <h1 class="text-3xl font-bold text-slate-900">Add New PG</h1>
                </div>
                <a href="{{ route('admin.pgs.index') }}" class="btn-secondary">Back to PGs</a>
            </div>

            @if($errors->any())
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 space-y-1 text-sm">
                    <p class="font-semibold">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pgs.store') }}" method="POST" enctype="multipart/form-data" class="card p-6 md:p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">PG Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="input-modern" required>
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-medium text-slate-700 mb-2">City</label>
                        <input id="city" name="city" type="text" value="{{ old('city') }}" class="input-modern" required>
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-slate-700 mb-2">State</label>
                        <input id="state" name="state" type="text" value="{{ old('state') }}" class="input-modern" required>
                    </div>

                    <div>
                        <label for="pincode" class="block text-sm font-medium text-slate-700 mb-2">Pincode</label>
                        <input id="pincode" name="pincode" type="text" value="{{ old('pincode') }}" class="input-modern" required>
                    </div>

                    <div>
                        <label for="monthly_rent" class="block text-sm font-medium text-slate-700 mb-2">Monthly Rent (₹)</label>
                        <input id="monthly_rent" name="monthly_rent" type="number" min="0" step="0.01" value="{{ old('monthly_rent') }}" class="input-modern" required>
                    </div>

                    <div>
                        <label for="security_deposit" class="block text-sm font-medium text-slate-700 mb-2">Security Deposit (₹)</label>
                        <input id="security_deposit" name="security_deposit" type="number" min="0" step="0.01" value="{{ old('security_deposit') }}" class="input-modern" required>
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-slate-700 mb-2">Gender</label>
                        <select id="gender" name="gender" class="input-modern" required>
                            <option value="">Select</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="any" {{ old('gender') == 'any' ? 'selected' : '' }}>Any</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <label class="inline-flex items-center gap-3 p-3 border border-slate-200 rounded-xl bg-slate-50 w-full cursor-pointer hover:bg-slate-100 transition-colors">
                            <input type="checkbox" name="food_available" value="1" {{ old('food_available') ? 'checked' : '' }} class="h-4 w-4 text-brand-600 rounded border-slate-300">
                            <span class="text-sm font-medium text-slate-700">Food Available</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-2">Address</label>
                    <textarea id="address" name="address" rows="3" class="input-modern" required>{{ old('address') }}</textarea>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4" class="input-modern" required>{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-3">Amenities</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($amenities as $amenity)
                            <label class="inline-flex items-center gap-3 p-3 border border-slate-200 rounded-xl bg-slate-50 cursor-pointer hover:bg-slate-100 transition-colors">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" class="h-4 w-4 text-brand-600 rounded border-slate-300">
                                <span class="text-sm text-slate-700">{{ $amenity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Photos Upload Section -->
                <div class="border-t border-slate-200 pt-6">
                    <label class="block text-lg font-bold text-slate-900 mb-1">PG Photos</label>
                    <p class="text-sm text-slate-500 mb-4">Select multiple photos. The first image will be set as the main cover photo (JPG, PNG, WebP up to 5MB).</p>

                    <div class="border-2 border-dashed border-slate-300 hover:border-brand-500 rounded-2xl p-6 text-center transition-colors bg-slate-50/50">
                        <svg class="mx-auto h-12 w-12 text-slate-400 mb-3" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <input id="create_pg_images_input" type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:bg-brand-600 file:text-white file:font-semibold hover:file:bg-brand-700 file:cursor-pointer cursor-pointer">
                        <p class="text-xs text-slate-400 mt-2">You can select multiple photos</p>
                    </div>

                    <div id="create_image_preview_container" class="hidden mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Selected photos preview:</p>
                        <div id="create_image_previews" class="grid grid-cols-2 sm:grid-cols-4 gap-3"></div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.pgs.index') }}" class="btn-ghost">Cancel</a>
                    <button type="submit" class="btn-primary">Save PG</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('create_pg_images_input');
        const container = document.getElementById('create_image_preview_container');
        const previews = document.getElementById('create_image_previews');

        if (input && container && previews) {
            input.addEventListener('change', function () {
                previews.innerHTML = '';
                const files = this.files;

                if (files && files.length > 0) {
                    container.classList.remove('hidden');
                    Array.from(files).forEach((file, idx) => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const card = document.createElement('div');
                                card.className = 'relative rounded-xl overflow-hidden border border-slate-200 aspect-video bg-slate-100';
                                card.innerHTML = `
                                    <img src="${e.target.result}" class="w-full h-full object-cover">
                                    <span class="absolute bottom-1 right-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded backdrop-blur">${idx === 0 ? 'Cover ★' : '#' + (idx + 1)}</span>
                                `;
                                previews.appendChild(card);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                } else {
                    container.classList.add('hidden');
                }
            });
        }
    });
</script>
@endpush

