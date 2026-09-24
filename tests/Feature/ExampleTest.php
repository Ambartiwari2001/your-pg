<?php

use App\Models\Amenity;
use App\Models\PG;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('admin can create a pg with uploaded images', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'role' => 'admin',
    ]);

    $amenity = Amenity::create(['name' => 'Wi-Fi']);

    $response = $this->actingAs($user)
        ->post('/admin/pgs', [
            'name' => 'Sunrise Residency',
            'description' => 'Comfortable student-friendly PG.',
            'address' => 'MG Road',
            'city' => 'Delhi',
            'state' => 'Delhi',
            'pincode' => '110001',
            'gender' => 'male',
            'monthly_rent' => 12000,
            'security_deposit' => 20000,
            'food_available' => true,
            'amenities' => [$amenity->id],
            'images' => [
                UploadedFile::fake()->image('main.jpg', 800, 600),
                UploadedFile::fake()->image('second.jpg', 800, 600),
            ],
        ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('pgs', ['name' => 'Sunrise Residency']);
    $this->assertDatabaseHas('pg_images', ['image' => 'pg-images/'.basename(Storage::disk('public')->files('pg-images')[0] ?? '')]);
});

it('shows a fallback image when a pg has no uploaded gallery images', function () {
    $pg = PG::create([
        'name' => 'Demo PG Without Images',
        'slug' => 'demo-pg-without-images',
        'description' => 'A demo PG with no gallery images.',
        'address' => 'Demo Road',
        'city' => 'Ahmedabad',
        'state' => 'Gujarat',
        'pincode' => '380001',
        'gender' => 'female',
        'monthly_rent' => 5000,
        'security_deposit' => 12000,
        'food_available' => true,
        'status' => 'active',
    ]);

    $response = $this->get(route('pgs.show', $pg));

    $response->assertOk();
    $response->assertSee('default-pg.jpg', false);
});

it('admin can set an image as primary and delete an image', function () {
    Storage::fake('public');

    $admin = User::factory()->create(['role' => 'admin']);

    $pg = PG::create([
        'name' => 'Test PG Residency',
        'slug' => 'test-pg-residency',
        'description' => 'Great place to stay',
        'address' => 'Test Street',
        'city' => 'Ahmedabad',
        'state' => 'Gujarat',
        'pincode' => '380015',
        'gender' => 'male',
        'monthly_rent' => 8000,
        'security_deposit' => 15000,
        'food_available' => true,
        'status' => 'active',
    ]);

    $img1 = $pg->images()->create(['image' => 'pg-images/test1.jpg', 'is_primary' => true]);
    $img2 = $pg->images()->create(['image' => 'pg-images/test2.jpg', 'is_primary' => false]);

    // Set img2 as primary
    $setPrimaryResponse = $this->actingAs($admin)->post(route('admin.pgs.images.set-primary', [$pg, $img2]));
    $setPrimaryResponse->assertRedirect();
    expect($img2->fresh()->is_primary)->toBeTrue();
    expect($img1->fresh()->is_primary)->toBeFalse();

    // Delete img2
    $deleteResponse = $this->actingAs($admin)->delete(route('admin.pgs.images.destroy', [$pg, $img2]));
    $deleteResponse->assertRedirect();
    $this->assertDatabaseMissing('pg_images', ['id' => $img2->id]);
    expect($img1->fresh()->is_primary)->toBeTrue();
});
