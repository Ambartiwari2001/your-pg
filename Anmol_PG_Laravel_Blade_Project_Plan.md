# Anmol PG — Laravel + Blade PG Booking Application

## 1. Project Overview

**Project Name:** Anmol PG

**Goal:** Ek clean, modern aur beginner-friendly PG (Paying Guest) listing + booking web application banana hai using:

- Laravel
- Blade Templates
- Laravel Breeze
- MySQL
- Tailwind CSS
- JavaScript / Alpine.js (jahan zarurat ho)

Application me users register/login karenge, available PGs dekh sakenge, kisi PG ki details open kar sakenge aur booking request submit kar sakenge.

---

# 2. Main User Roles

Application ko initially 2 roles me divide karna best rahega:

### User / Tenant

User ye kaam kar sake:

- Register
- Login / Logout
- Home page dekhna
- PG listings browse karna
- PG details dekhna
- Room/bed availability dekhna
- Booking request submit karna
- Apni bookings dekhna
- Booking status dekhna
- Profile update karna

### Admin

Admin ye kaam kar sake:

- Login
- Dashboard dekhna
- PG add karna
- PG edit/delete karna
- PG images manage karna
- Rooms/beds manage karna
- Availability manage karna
- Booking requests dekhna
- Booking approve/reject karna
- Users dekhna
- Booking status update karna

> **Recommendation:** Pehle user-side + basic admin functionality banao. Payment gateway aur advanced features baad me add karo.

---

# 3. Application Pages

## Public Pages

### 3.1 Home Page

Home page sabse important page hoga.

Sections:

1. Navbar
   - Anmol PG logo/name
   - Home
   - PGs
   - About
   - Contact
   - Login
   - Register

2. Hero Section
   - Large PG image
   - Heading:
     **"Find Your Perfect PG in Ahmedabad"**
   - Short description
   - Search button

3. Search Section
   - Location
   - Minimum price
   - Maximum price
   - Gender
   - Search button

4. Featured PGs
   - PG image
   - PG name
   - Location
   - Starting price
   - Facilities
   - Rating
   - View Details button

5. Why Choose Anmol PG?
   - Verified PGs
   - Affordable pricing
   - Easy booking
   - Safe accommodation

6. How It Works
   - Search PG
   - View details
   - Submit booking request
   - Get confirmation

7. Footer

---

# 4. PG Listing Page

Route example:

`/pgs`

Is page par saare active PGs show honge.

Har card me:

- Main image
- PG name
- Location
- Price/month
- Deposit
- Room type
- Available beds
- Facilities
- Gender
- View Details button

Filters:

- Location
- Price range
- Gender
- Room type
- AC / Non-AC
- Food available
- Attached bathroom
- Wi-Fi

Pagination use karo.

---

# 5. PG Details Page

Route example:

`/pgs/{pg}`

Ye page booking se pehle user ko complete information dega.

## Required Sections

### Image Gallery

- Main image
- Multiple PG images
- Room images
- Bathroom image
- Common area image
- Building/exterior image

### Basic Information

- PG name
- Location
- Address
- Monthly rent
- Security deposit
- Gender
- Available beds
- Room types

### Facilities

Example:

- Wi-Fi
- Food
- AC
- Washing Machine
- CCTV
- Power Backup
- Parking
- Housekeeping
- Hot Water
- Attached Bathroom

### Rules

Example:

- No smoking
- No illegal activities
- Visitor timing
- Check-in/check-out timing
- Notice period
- Deposit rules

### Contact Information

- Phone
- WhatsApp
- Email

### Location

Later Google Maps integration add ki ja sakti hai.

### Booking Card

Right side/sticky card:

- Monthly rent
- Security deposit
- Select room type
- Select move-in date
- Number of occupants
- Book Now button

---

# 6. Booking Flow

User ko booking karte waqt ye information leni chahiye:

## Step 1 — Select Room

User select kare:

- Single
- Double sharing
- Triple sharing

Room availability database se dynamically show hogi.

## Step 2 — Personal Details

Fields:

- Full name
- Phone
- Email
- Gender
- Date of birth (optional)
- Current address
- Emergency contact name
- Emergency contact phone

## Step 3 — Stay Details

Fields:

- Move-in date
- Expected duration
- Room preference
- Food required? Yes/No

## Step 4 — Documents

Optional future feature:

- Aadhaar/ID upload
- Student ID
- Company ID

**Important:** Documents ko secure/private storage me rakhna aur public URL se expose nahi karna.

## Step 5 — Booking Summary

Show:

- PG name
- Room type
- Monthly rent
- Deposit
- Move-in date
- Selected services
- Total initial amount

Then:

**Submit Booking Request**

---

# 7. Booking Status

Booking ke statuses:

- Pending
- Approved
- Rejected
- Cancelled
- Completed

User dashboard me booking card show ho:

### Example

**Anmol Premium PG**

Status: `Pending`

Move-in: `01 September 2026`

Room: `Double Sharing`

Rent: `₹8,000/month`

Admin approve karega to:

Status: `Approved`

---

# 8. User Dashboard

Route:

`/dashboard`

Dashboard sections:

### Overview

- Total bookings
- Pending bookings
- Approved bookings
- Cancelled bookings

### My Bookings

Each booking:

- PG image
- PG name
- Room
- Booking date
- Move-in date
- Amount
- Status
- View button

### Profile

- Name
- Email
- Phone
- Address
- Profile photo

---

# 9. Authentication — Laravel Breeze

Authentication ke liye **Laravel Breeze** use karna hai.

Required pages:

- Login
- Register
- Forgot Password
- Reset Password
- Verify Email (agar enable karo)
- Confirm Password
- Profile

Basic setup:

```bash
composer create-project laravel/laravel anmol-pg
cd anmol-pg

composer require laravel/breeze --dev

php artisan breeze:install blade

npm install
npm run build

php artisan migrate
```

Development me:

```bash
php artisan serve
```

Aur frontend assets ke liye:

```bash
npm run dev
```

---

# 10. Database Design

Recommended tables:

## users

Laravel Breeze ki default users table:

- id
- name
- email
- password
- phone
- role
- timestamps

Role:

- user
- admin

---

## pgs

Fields:

- id
- name
- slug
- description
- address
- city
- state
- pincode
- latitude
- longitude
- gender
- monthly_rent
- security_deposit
- food_available
- status
- timestamps

Status:

- active
- inactive

---

## pg_images

Fields:

- id
- pg_id
- image
- is_primary
- timestamps

Relationship:

`PG hasMany PGImages`

---

## rooms

Fields:

- id
- pg_id
- room_number
- room_type
- total_beds
- available_beds
- monthly_rent
- status
- timestamps

Room types:

- single
- double
- triple
- four_sharing

---

## amenities

Fields:

- id
- name
- icon
- timestamps

---

## amenity_pg

Pivot table:

- pg_id
- amenity_id

Relationship:

`PG belongsToMany Amenities`

---

## bookings

Fields:

- id
- user_id
- pg_id
- room_id
- booking_number
- move_in_date
- duration_months
- occupants
- monthly_rent
- security_deposit
- total_amount
- status
- notes
- timestamps

---

## booking_documents

Fields:

- id
- booking_id
- document_type
- document_path
- verification_status
- timestamps

---

## payments

Future feature:

- id
- booking_id
- user_id
- amount
- payment_method
- transaction_id
- status
- paid_at
- timestamps

---

# 11. Laravel Models

Create models:

```bash
php artisan make:model PG -m
php artisan make:model PGImage -m
php artisan make:model Room -m
php artisan make:model Amenity -m
php artisan make:model Booking -m
php artisan make:model BookingDocument -m
php artisan make:model Payment -m
```

Controllers:

```bash
php artisan make:controller HomeController
php artisan make:controller PGController
php artisan make:controller BookingController
php artisan make:controller DashboardController
```

Admin controllers:

```bash
php artisan make:controller Admin/AdminDashboardController
php artisan make:controller Admin/AdminPGController
php artisan make:controller Admin/AdminBookingController
php artisan make:controller Admin/AdminUserController
```

---

# 12. Recommended Model Relationships

## User

```php
public function bookings()
{
    return $this->hasMany(Booking::class);
}
```

## PG

```php
public function images()
{
    return $this->hasMany(PGImage::class);
}

public function rooms()
{
    return $this->hasMany(Room::class);
}

public function amenities()
{
    return $this->belongsToMany(Amenity::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}
```

## Room

```php
public function pg()
{
    return $this->belongsTo(PG::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}
```

## Booking

```php
public function user()
{
    return $this->belongsTo(User::class);
}

public function pg()
{
    return $this->belongsTo(PG::class);
}

public function room()
{
    return $this->belongsTo(Room::class);
}
```

---

# 13. Blade Folder Structure

Recommended structure:

```text
resources/views/

├── layouts/
│   ├── app.blade.php
│   ├── guest.blade.php
│   └── navigation.blade.php
│
├── home.blade.php
│
├── pgs/
│   ├── index.blade.php
│   └── show.blade.php
│
├── bookings/
│   ├── create.blade.php
│   ├── show.blade.php
│   └── success.blade.php
│
├── dashboard/
│   └── index.blade.php
│
├── profile/
│   └── edit.blade.php
│
├── components/
│   ├── pg-card.blade.php
│   ├── button.blade.php
│   ├── badge.blade.php
│   └── alert.blade.php
│
└── admin/
    ├── dashboard.blade.php
    ├── pgs/
    ├── rooms/
    ├── bookings/
    └── users/
```

---

# 14. Routes

`routes/web.php`

Public:

```php
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/pgs', [PGController::class, 'index'])
    ->name('pgs.index');

Route::get('/pgs/{pg}', [PGController::class, 'show'])
    ->name('pgs.show');
```

Authenticated:

```php
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/pgs/{pg}/book', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/pgs/{pg}/book', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');
});
```

Breeze auth routes:

```php
require __DIR__.'/auth.php';
```

---

# 15. Admin Authentication

Admin ke liye starting me separate login page banana compulsory nahi hai.

Simple approach:

- Same Laravel authentication
- `users.role = admin`
- Admin middleware

Example middleware:

```php
if (auth()->user()->role !== 'admin') {
    abort(403);
}
```

Better implementation ke liye custom `AdminMiddleware` banao.

Admin routes:

```text
/admin
/admin/pgs
/admin/pgs/create
/admin/pgs/{pg}/edit
/admin/bookings
/admin/users
```

---

# 16. Admin Dashboard

Dashboard me cards:

- Total PGs
- Active PGs
- Total Users
- Pending Bookings
- Approved Bookings
- Total Revenue

Recent bookings table:

| Booking | User | PG | Room | Date | Status |
|---|---|---|---|---|---|

Actions:

- View
- Approve
- Reject
- Cancel

---

# 17. PG Create Form

Admin ko PG create karte waqt:

### Basic Information

- PG Name
- Description
- Address
- City
- State
- Pincode
- Gender

### Pricing

- Monthly Rent
- Security Deposit

### Facilities

Checkboxes:

- Wi-Fi
- Food
- AC
- Parking
- CCTV
- Washing Machine
- Power Backup
- Hot Water
- Housekeeping

### Images

Multiple image upload:

- Main image
- Room images
- Bathroom
- Common area
- Exterior

### Status

- Active
- Inactive

---

# 18. Image Upload

Laravel storage use karo:

```bash
php artisan storage:link
```

Upload example:

```php
$path = $request->file('image')
    ->store('pg-images', 'public');
```

Database me path store karo.

Blade:

```php
<img src="{{ asset('storage/' . $image->image) }}">
```

Validation:

```php
'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
```

Multiple images ke liye array validation use karo.

---

# 19. Home Page Dummy Data

Development ke liye initially 6–10 dummy PGs banao.

Example:

### Anmol Premium PG

Location:
Ahmedabad, Gujarat

Rent:
₹8,500/month

Room:
Double Sharing

Facilities:
Wi-Fi, Food, AC, CCTV

---

### Anmol Student House

Location:
Navrangpura, Ahmedabad

Rent:
₹6,500/month

Room:
Triple Sharing

Facilities:
Wi-Fi, Food, Laundry

---

### Anmol Executive Stay

Location:
Satellite, Ahmedabad

Rent:
₹12,000/month

Room:
Single Sharing

Facilities:
AC, Wi-Fi, Parking, Housekeeping

> Images ke liye local `storage` images use karna better hai, taaki application external image URLs par dependent na ho.

---

# 20. Database Seeder

Dummy PGs ke liye seeders banao:

```bash
php artisan make:seeder PGSeeder
php artisan make:seeder AmenitySeeder
php artisan make:seeder RoomSeeder
```

Then:

```bash
php artisan db:seed
```

Ya development me:

```bash
php artisan migrate:fresh --seed
```

---

# 21. UI Design

Application ka design modern aur mobile-friendly hona chahiye.

Recommended style:

- White background
- Rounded cards
- Large PG images
- Clean typography
- Soft shadows
- Responsive navbar
- Mobile-first layout

PG card:

```text
┌───────────────────────────────┐
│                               │
│          PG IMAGE             │
│                               │
├───────────────────────────────┤
│ Anmol Premium PG              │
│ Ahmedabad                     │
│                               │
│ ₹8,500 / month                │
│ ✓ Wi-Fi  ✓ Food  ✓ AC         │
│                               │
│ [ View Details ]              │
└───────────────────────────────┘
```

---

# 22. Booking UI

Booking page ko multi-step form banana best rahega.

### Step 1
Room Selection

### Step 2
Personal Details

### Step 3
Stay Details

### Step 4
Documents

### Step 5
Review & Submit

Progress indicator:

```text
1 Room → 2 Details → 3 Stay → 4 Documents → 5 Confirm
```

Alpine.js se step switching easily manage ki ja sakti hai.

---

# 23. Booking Validation

Server-side validation compulsory hai.

Example:

```php
$request->validate([
    'room_id' => 'required|exists:rooms,id',
    'move_in_date' => 'required|date|after_or_equal:today',
    'duration_months' => 'required|integer|min:1|max:24',
]);
```

Important:

**Sirf frontend validation par depend mat karo.**

---

# 24. Availability Logic

Booking create karte waqt check karo:

```text
Room total beds
-
Active/approved bookings
=
Available beds
```

Agar available bed 0 hai:

```text
This room is currently full.
```

Booking approve karte waqt availability dobara check karni chahiye.

**Race condition avoid karne ke liye approval/update ko database transaction ke andar karna best rahega.**

---

# 25. Booking Security

User kisi aur user ki booking directly access nahi kar sake.

Example:

```php
if ($booking->user_id !== auth()->id()) {
    abort(403);
}
```

Better approach:

**Laravel Policies** use karo.

Create:

```bash
php artisan make:policy BookingPolicy --model=Booking
```

---

# 26. Payment — Phase 2

Pehle booking request system complete karo.

Uske baad payment add karo.

Possible flow:

```text
User submits booking
        ↓
Admin approves
        ↓
Payment required
        ↓
User pays
        ↓
Payment success
        ↓
Booking confirmed
```

Payment table me transaction details save karo.

Production me payment gateway integration ke liye trusted provider ka official SDK/API use karo.

---

# 27. Notifications — Phase 2

Booking create hone par:

```text
Your booking request has been submitted.
```

Admin approve kare:

```text
Your booking has been approved.
```

Admin reject kare:

```text
Your booking has been rejected.
```

Laravel Notifications use ki ja sakti hain.

Future options:

- Email
- Database notifications
- WhatsApp/SMS integration

---

# 28. Search & Filters

PG listing page par query parameters use karo.

Example:

```text
/pgs?city=ahmedabad&min_price=5000&max_price=10000
```

Filters:

- City
- Price
- Gender
- Room type
- Amenities
- Availability

Search ko GET request ke through implement karna useful rahega, kyunki filtered page share/bookmark kiya ja sakta hai.

---

# 29. Important Security Requirements

Application complete karte waqt:

- CSRF protection
- Authentication middleware
- Authorization / Policies
- Form Request validation
- File upload validation
- Private document storage
- Mass assignment protection
- Rate limiting where useful
- SQL injection safe Eloquent/query builder usage
- XSS-safe Blade output
- Password hashing
- Secure `.env`
- Production me `APP_DEBUG=false`

Sensitive documents ko `public` disk par directly store mat karo.

---

# 30. Recommended Laravel Development Order

## Phase 1 — Setup

- [ ] Laravel install
- [ ] MySQL database create
- [ ] `.env` configure
- [ ] Breeze install
- [ ] Blade setup
- [ ] Tailwind setup
- [ ] Authentication test

## Phase 2 — Database

- [ ] users update
- [ ] PG migration
- [ ] PG images migration
- [ ] rooms migration
- [ ] amenities migration
- [ ] bookings migration
- [ ] booking documents migration
- [ ] payments migration
- [ ] relationships

## Phase 3 — Home

- [ ] Navbar
- [ ] Hero
- [ ] Search UI
- [ ] Featured PGs
- [ ] Why choose us
- [ ] How it works
- [ ] Footer

## Phase 4 — PG Module

- [ ] PG listing
- [ ] Filters
- [ ] Pagination
- [ ] PG details
- [ ] Image gallery
- [ ] Amenities
- [ ] Room availability

## Phase 5 — Booking

- [ ] Booking form
- [ ] Room selection
- [ ] Personal details
- [ ] Stay details
- [ ] Validation
- [ ] Booking summary
- [ ] Create booking
- [ ] Booking status

## Phase 6 — User Dashboard

- [ ] Dashboard
- [ ] My bookings
- [ ] Booking details
- [ ] Profile
- [ ] Status badges

## Phase 7 — Admin

- [ ] Admin middleware
- [ ] Admin dashboard
- [ ] PG CRUD
- [ ] Image management
- [ ] Room management
- [ ] Booking management
- [ ] User management

## Phase 8 — Production Features

- [ ] Payment gateway
- [ ] Email notifications
- [ ] Document verification
- [ ] Google Maps
- [ ] Reviews/ratings
- [ ] Favorites
- [ ] Advanced search
- [ ] Reports

---

# 31. Suggested Routes Summary

```text
GET     /                       Home
GET     /pgs                    PG listing
GET     /pgs/{pg}              PG details

GET     /dashboard              User dashboard

GET     /pgs/{pg}/book          Booking form
POST    /pgs/{pg}/book          Submit booking

GET     /bookings/{booking}     Booking details

GET     /profile                Profile
PATCH   /profile                Update profile

GET     /admin                   Admin dashboard

GET     /admin/pgs              PG management
GET     /admin/pgs/create       Create PG
POST    /admin/pgs              Store PG
GET     /admin/pgs/{pg}/edit    Edit PG
PUT     /admin/pgs/{pg}         Update PG
DELETE  /admin/pgs/{pg}         Delete PG

GET     /admin/bookings         Booking management
GET     /admin/users            User management
```

---

# 32. Final Project Structure

```text
anmol-pg/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Models/
│   │   └── User.php
│   │
│   └── Policies/
│
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── auth.php
│
├── storage/
│   └── app/
│
└── public/
```

---

# 33. MVP — Pehle Itna Complete Karo

Agar project beginner level par hai, to pehle ye features complete karo:

1. Laravel setup
2. Breeze authentication
3. Home page
4. PG listing
5. PG details
6. PG images
7. Room availability
8. Booking form
9. Booking submission
10. User dashboard
11. Admin login/role
12. Admin PG CRUD
13. Admin booking approval/rejection

**Payment, WhatsApp, Google Maps, reviews aur advanced notifications ko baad me add karo.**

---

# 34. Development Strategy

Ek saath pura project mat banana.

Recommended order:

```text
Laravel Setup
      ↓
Breeze Authentication
      ↓
Database + Models
      ↓
Home Page
      ↓
PG CRUD
      ↓
PG Listing
      ↓
PG Details
      ↓
Booking System
      ↓
User Dashboard
      ↓
Admin Dashboard
      ↓
Booking Approval
      ↓
Payment
      ↓
Notifications
      ↓
Deployment
```

Har phase complete hone ke baad application run karke test karo.

---

# 35. Definition of Done

Project ko MVP complete tab consider karo jab:

- User register kar sake
- User login/logout kar sake
- Home page properly load ho
- PGs database se aa rahe hon
- PG images show hon
- PG details properly show hon
- Available rooms/beds show hon
- Authenticated user booking request bhej sake
- User apni booking dekh sake
- Admin PG create/edit/delete kar sake
- Admin bookings dekh sake
- Admin booking approve/reject kar sake
- Unauthorized user admin pages access na kar sake
- User kisi doosre user ki booking access na kar sake
- Forms server-side validate hon
- Mobile responsive UI ho

---

# 36. Next Step

Is project ko banate waqt sabse pehle **Laravel + Breeze + MySQL setup** complete karo.

Uske baad:

**Database → Models → Relationships → Seeders → Home → PG Listing → PG Details → Booking → Dashboard → Admin**

Isi sequence me development karne se project manageable rahega aur debugging bhi easy hogi.

