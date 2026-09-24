<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\PG;
use App\Models\PGImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPGController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(): View
    {
        $pgs = PG::with('images', 'rooms')->paginate(10);

        return view('admin.pgs.index', compact('pgs'));
    }

    public function create(): View
    {
        $amenities = Amenity::all();

        return view('admin.pgs.create', compact('amenities'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
            'gender' => 'required|in:male,female,any',
            'monthly_rent' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'food_available' => 'boolean',
            'amenities' => 'array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $pg = PG::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'gender' => $validated['gender'],
            'monthly_rent' => $validated['monthly_rent'],
            'security_deposit' => $validated['security_deposit'],
            'food_available' => $request->has('food_available'),
            'status' => 'active',
        ]);

        if ($request->has('amenities')) {
            $pg->amenities()->attach($validated['amenities']);
        }

        if ($request->hasFile('images')) {
            $this->storePgImages($pg, $request->file('images'), true);
        }

        return redirect()->route('admin.pgs.show', $pg)->with('success', 'PG created successfully!');
    }

    public function show(PG $pg): View
    {
        $pg->load('images', 'rooms', 'amenities');

        return view('admin.pgs.show', compact('pg'));
    }

    public function edit(PG $pg): View
    {
        $amenities = Amenity::all();
        $pg->load(['amenities', 'images']);

        return view('admin.pgs.edit', compact('pg', 'amenities'));
    }

    public function update(Request $request, PG $pg): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:20',
            'gender' => 'required|in:male,female,any',
            'monthly_rent' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'food_available' => 'boolean',
            'amenities' => 'array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'make_new_image_primary' => 'nullable|boolean',
        ]);

        $pg->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
            'gender' => $validated['gender'],
            'monthly_rent' => $validated['monthly_rent'],
            'security_deposit' => $validated['security_deposit'],
            'food_available' => $request->has('food_available'),
        ]);

        if ($request->has('amenities')) {
            $pg->amenities()->sync($validated['amenities']);
        } else {
            $pg->amenities()->detach();
        }

        if ($request->hasFile('images')) {
            $makePrimary = $request->boolean('make_new_image_primary') || $pg->images()->where('is_primary', true)->doesntExist();
            $this->storePgImages($pg, $request->file('images'), $makePrimary);
        }

        return redirect()->route('admin.pgs.edit', $pg)->with('success', 'PG updated successfully!');
    }

    public function destroy(PG $pg): RedirectResponse
    {
        foreach ($pg->images as $image) {
            $this->removeImageFile($image->image);
        }

        $pg->delete();

        return redirect()->route('admin.pgs.index')->with('success', 'PG deleted successfully!');
    }

    public function setPrimaryImage(PG $pg, PGImage $image): RedirectResponse
    {
        if ($image->pg_id !== $pg->id) {
            abort(403, 'Unauthorized image modification.');
        }

        $pg->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return redirect()->back()->with('success', 'Primary cover photo updated successfully!');
    }

    public function deleteImage(PG $pg, PGImage $image): RedirectResponse
    {
        if ($image->pg_id !== $pg->id) {
            abort(403, 'Unauthorized image deletion.');
        }

        $wasPrimary = $image->is_primary;
        $this->removeImageFile($image->image);
        $image->delete();

        if ($wasPrimary) {
            $firstRemaining = $pg->images()->first();
            if ($firstRemaining) {
                $firstRemaining->update(['is_primary' => true]);
            }
        }

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }

    protected function storePgImages(PG $pg, array $images, bool $makeFirstPrimary = false): void
    {
        $hasPrimary = $pg->images()->where('is_primary', true)->exists();

        if ($makeFirstPrimary) {
            $pg->images()->update(['is_primary' => false]);
        }

        foreach ($images as $index => $image) {
            $path = $image->store('pg-images', 'public');

            $isPrimary = false;
            if ($makeFirstPrimary && $index === 0) {
                $isPrimary = true;
            } elseif (! $hasPrimary && $index === 0) {
                $isPrimary = true;
            }

            $pg->images()->create([
                'image' => $path,
                'is_primary' => $isPrimary,
            ]);
        }
    }

    protected function removeImageFile(?string $imagePath): void
    {
        if (! $imagePath) {
            return;
        }

        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return;
        }

        if (str_starts_with($imagePath, 'images/')) {
            return;
        }

        $cleanPath = preg_replace('#^/?storage/#', '', $imagePath);
        if (Storage::disk('public')->exists($cleanPath)) {
            Storage::disk('public')->delete($cleanPath);
        }
    }
}
