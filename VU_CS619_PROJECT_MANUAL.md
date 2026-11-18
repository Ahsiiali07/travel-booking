# Travel Booking Application using MVC-based Framework
## Virtual University of Pakistan &bull; CS619 Final Year Project Manual

---

### Project Information
- **Project Title:** Travel Booking Application using MVC-based Framework
- **Course Code:** CS619 - Final Year Project
- **Project Domain / Category:** Web Application / MVC-based Framework Project
- **Target Framework:** Laravel (PHP 8.2+, MySQL, Blade, Bootstrap 5)
- **Project Supervisor:**
  - **Name:** Sheikh Israr Ahmad
  - **Email ID:** `israr.ahmad@vu.edu.pk`
  - **Teams ID:** `israr.ahmad.vu@outlooks.com`

---

## 1. Abstract & Architectural Overview
Object-Oriented Programming (OOP) is a software design paradigm that structures an application around modular data objects rather than disjointed procedural functions. The Model-View-Controller (MVC) architectural pattern establishes a distinct three-layered separation of concerns:
1. **Presentation Layer (Views):** Blade templates formatted with modern, responsive Bootstrap 5 styling to present interfaces for visitors, registered travelers, and administrators.
2. **Controller (Business) Layer:** Service and mediation controllers (`AuthController`, `FlightScheduleController`, `HotelScheduleController`, `PackageBookingController`, `CheckoutController`, `RefundController`, and Admin CRUD Controllers) validating user input and orchestrating business logic.
3. **Data Access Layer (Models):** Eloquent ORM interacting with the MySQL database server using typed schemas, foreign key relationships, model mutators, and accessors.

This application provides an end-to-end travel portal managing flights, luxury hotels, and full vacation packages, complete with scheduling, checkout simulation, automated electronic ticketing, vouchers, invoice generation, and full administrative oversight.

---

## 2. Functional Requirements Implementation Matrix

### Admin Role Requirements

| # | Functional Requirement | Controller | Route | Blade View |
|---|------------------------|------------|-------|------------|
| 1 | **Admin registration** | `Auth\AuthController@showAdminRegisterForm`<br>`@adminRegister` | `GET/POST /admin/register` | `admin.auth.register` (Secured with Security Key `VU-CS619-ADMIN`) |
| 2 | **Admin logs in to the application** | `Auth\AuthController@showAdminLoginForm`<br>`@adminLogin` | `GET/POST /admin/login` | `admin.auth.login` (Includes 1-click viva test credential autofill) |
| 3 | **Admin forgets password** | `Auth\ForgotPasswordController@showAdminLinkRequestForm`<br>`@sendAdminResetLinkEmail`<br>`@showAdminResetForm`<br>`@reset` | `GET/POST /admin/forgot-password`<br>`GET/POST /admin/reset-password/{token}` | `admin.auth.forgot-password`<br>`admin.auth.reset-password` |
| 4 | **Admin manages (Read-Update-Delete) user details** | `Admin\UserController` | `GET /admin/users`<br>`GET /admin/users/{user}`<br>`PUT /admin/users/{user}`<br>`DELETE /admin/users/{user}` | `admin.users.index`<br>`admin.users.show`<br>`admin.users.edit` |
| 5 | **Admin manages (CRUD) hotel details** | `Admin\HotelController` | `Resource: /admin/hotels` | `admin.hotels.index`<br>`admin.hotels.create`<br>`admin.hotels.edit`<br>`admin.hotels.show` |
| 6 | **Admin manages (CRUD) flight details** | `Admin\FlightController` | `Resource: /admin/flights` | `admin.flights.index`<br>`admin.flights.create`<br>`admin.flights.edit`<br>`admin.flights.show` |
| 7 | **Admin manages (CRUD) package details** | `Admin\PackageController` | `Resource: /admin/packages` | `admin.packages.index`<br>`admin.packages.create`<br>`admin.packages.edit`<br>`admin.packages.show` |
| 8 | **Admin manages (Read-Update-Delete) user reservation details** | `Admin\ReservationController` | `GET /admin/reservations`<br>`GET /admin/reservations/{res}`<br>`PUT /admin/reservations/{res}`<br>`DELETE /admin/reservations/{res}` | `admin.reservations.index`<br>`admin.reservations.show`<br>`admin.reservations.edit` |
| 9 | **Admin manages (Create-Read-Update-Delete) refund details** | `Admin\RefundController` | `Resource: /admin/refunds` | `admin.refunds.index`<br>`admin.refunds.create`<br>`admin.refunds.edit`<br>`admin.refunds.show` |
| 10 | **Admin logs out of the application** | `Auth\AuthController@logout` | `POST /logout` | Invalides session, clears tokens, redirects to login |

---

### User Role Requirements

| # | Functional Requirement | Controller | Route | Blade View |
|---|------------------------|------------|-------|------------|
| 1 | **User registration** | `Auth\AuthController@showRegisterForm`<br>`@register` | `GET/POST /register` | `auth.register` |
| 2 | **User logs in to the application** | `Auth\AuthController@showLoginForm`<br>`@login` | `GET/POST /login` | `auth.login` (Includes 1-click viva test credential autofill) |
| 3 | **User forgets password** | `Auth\ForgotPasswordController@showLinkRequestForm`<br>`@sendResetLinkEmail`<br>`@showResetForm`<br>`@reset` | `GET/POST /forgot-password`<br>`GET/POST /reset-password/{token}` | `auth.forgot-password`<br>`auth.reset-password` |
| 4 | **User searches for flights, hotels, or full vacation packages** | `SearchController@search`<br>`HomeController@index` | `GET /`<br>`GET /search?tab=packages/flights/hotels` | `home`<br>`search` |
| 5 | **User manages (Create-Read-Delete) specific flight schedule** | `User\FlightScheduleController` | `GET /user/flights/{flight}/schedule` (Create)<br>`GET /user/flight-schedules` (Read all)<br>`GET /user/flight-schedules/{res}` (Read e-ticket)<br>`DELETE /user/flight-schedules/{res}` (Delete/Cancel) | `user.flights.create`<br>`user.flights.index`<br>`user.flights.show` (Boarding pass / E-Ticket) |
| 6 | **User manages (Create-Read-Delete) specific hotel schedule** | `User\HotelScheduleController` | `GET /user/hotels/{hotel}/schedule` (Create)<br>`GET /user/hotel-schedules` (Read all)<br>`GET /user/hotel-schedules/{res}` (Read voucher)<br>`DELETE /user/hotel-schedules/{res}` (Delete/Cancel) | `user.hotels.create`<br>`user.hotels.index`<br>`user.hotels.show` (Hotel stay voucher) |
| 7 | **User manages (Book-Read-Delete) specific package** | `User\PackageBookingController` | `GET /user/packages/{pkg}/book` (Book)<br>`GET /user/package-bookings` (Read all)<br>`GET /user/package-bookings/{res}` (Read tour voucher)<br>`DELETE /user/package-bookings/{res}` (Delete/Cancel) | `user.packages.create`<br>`user.packages.index`<br>`user.packages.show` (Tour voucher with daily itinerary) |
| 8 | **User pays and checks out for specific services** | `User\CheckoutController` | `GET /user/checkout/{res}` (Checkout page)<br>`POST /user/checkout/{res}/pay` (Process)<br>`GET /user/invoice/{res}` (Printable invoice)<br>`GET /user/payments` (Transaction history) | `user.checkout`<br>`user.invoice`<br>`user.payments.index` |
| 9 | **User logs out of the application** | `Auth\AuthController@logout` | `POST /logout` | Invalidates session, regenerates CSRF token |

---

## 3. Database Architecture & Entity Relationships

The MySQL database `travel-booking` contains 7 relational domain tables:

```
[users] 1 <─── M [reservations] 1 <─── 1 [payments]
   │                     │
   │                     ├── 1 <─── 1 [refunds]
   │                     │
   │                     ├── M ───> 1 [hotels] 1 <─── M [packages]
   │                     └── M ───> 1 [flights] 1 <─── M [packages]
```

### Table Specifications:
1. **`users`:** `id`, `name`, `email`, `password`, `role` ('admin', 'user'), `phone`, `city`, `address`, `status` ('active', 'blocked'), timestamps.
2. **`hotels`:** `id`, `name`, `city`, `country`, `address`, `star_rating`, `price_per_night`, `total_rooms`, `available_rooms`, `room_types` (JSON), `amenities` (JSON), `image`, `description`, `contact_phone`, `contact_email`, `status`.
3. **`flights`:** `id`, `airline`, `flight_number`, `origin_city`, `destination_city`, `origin_airport`, `destination_airport`, `departure_time`, `arrival_time`, `duration`, `seat_class`, `total_seats`, `available_seats`, `price_per_seat`, `baggage_allowance`, `aircraft_type`, `status`.
4. **`packages`:** `id`, `name`, `destination`, `country`, `duration_days`, `duration_nights`, `hotel_id` (FK nullable), `flight_id` (FK nullable), `price`, `discount_percent`, `max_capacity`, `available_slots`, `image`, `description`, `itinerary` (JSON), `inclusions` (JSON), `exclusions` (JSON), `is_featured`, `status`.
5. **`reservations`:** `id`, `booking_reference` (e.g. `TRV-2026-XXXXXX`), `user_id` (FK), `type` ('flight', 'hotel', 'package'), `flight_id` (FK nullable), `hotel_id` (FK nullable), `package_id` (FK nullable), `travel_date`, `check_in_date`, `check_out_date`, `guests_count`, `room_type`, `seat_class`, `contact_name`, `contact_email`, `contact_phone`, `passenger_details` (JSON), `subtotal`, `tax_amount`, `discount_amount`, `total_amount`, `payment_status` ('unpaid', 'paid', 'refunded', 'partial_refund'), `status` ('confirmed', 'pending', 'cancelled', 'completed'), `special_requests`.
6. **`payments`:** `id`, `transaction_id` (e.g. `TXN-XXXXXXXXXX`), `reservation_id` (FK), `user_id` (FK), `amount`, `payment_method` ('credit_card', 'debit_card', 'easypaisa', 'jazzcash', 'bank_transfer'), `card_holder_name`, `card_last_four`, `status`, `paid_at`.
7. **`refunds`:** `id`, `refund_reference` (e.g. `REF-2026-XXXXXX`), `reservation_id` (FK), `user_id` (FK), `amount`, `reason`, `status` ('pending', 'approved', 'processed', 'rejected'), `refund_method`, `admin_remarks`, `processed_at`.

---

## 4. Test Credentials & Demo Accounts

### Administrator Account
- **Portal URL:** `http://localhost/travel-booking/public/admin/login` or `http://127.0.0.1:8000/admin/login`
- **Email:** `admin@travelbooking.com`
- **Password:** `password123`
- **Admin Registration Key:** `VU-CS619-ADMIN`
- *(Convenient "Auto Fill" button provided on login page)*

### Demo Customer Account
- **Portal URL:** `http://localhost/travel-booking/public/login` or `http://127.0.0.1:8000/login`
- **Email:** `user@travelbooking.com`
- **Password:** `password123`
- *(Convenient "Auto Fill" button provided on login page)*

### Payment Simulation Data
- **Card Number:** `4242 4242 4242 4242`
- **Expiry:** Any future month/year (e.g. `12 / 2028`)
- **CVV:** `123`
- *(Convenient "Auto Fill Test Card" button provided on checkout page)*

---

## 5. How to Run & Present the Project

### Option A: Using XAMPP (Apache + MySQL)
1. Ensure Apache and MySQL are running in the XAMPP Control Panel.
2. The project is situated at: `C:\xampp\htdocs\travel-booking`.
3. Open your browser and navigate to:
   ```
   http://localhost/travel-booking/public/
   ```

### Option B: Using PHP Artisan Development Server
1. Open PowerShell / Command Prompt inside `C:\xampp\htdocs\travel-booking`:
   ```bash
   php artisan serve
   ```
2. Open your browser and navigate to:
   ```
   http://127.0.0.1:8000
   ```

### Database Backup / phpMyAdmin Import
- A full SQL dump is located at: `database/travel_booking.sql`.
- You can import it into phpMyAdmin by creating a database named `travel-booking` and selecting **Import** &bull; `database/travel_booking.sql`.

---

## 6. Comprehensive Viva / Defense Questions & Answers

### Q1: What is the MVC architectural pattern and how is it implemented in this project?
**Answer:** MVC separates application concerns into three layers:
- **Model:** Represents database tables and business logic (`app/Models/User.php`, `Hotel.php`, `Flight.php`, `Package.php`, `Reservation.php`, `Payment.php`, `Refund.php`).
- **View:** Blade templates (`resources/views/`) displaying data, layout hierarchies, and UI controls using Bootstrap 5.
- **Controller:** Mediatary classes (`app/Http/Controllers/`) receiving HTTP requests, validating inputs, executing business workflows via Models, and returning Blade views or redirects.

### Q2: How does this project demonstrate Object-Oriented Programming (OOP) principles?
**Answer:**
- **Encapsulation:** Models encapsulate database schema attributes, casts (e.g. `json` to PHP `array`), accessors (e.g. `final_price`, `item_name`), and static generation methods (`generateReference()`).
- **Inheritance:** Models extend `Illuminate\Database\Eloquent\Model`; controllers extend `App\Http\Controllers\Controller`.
- **Polymorphic / Relational Abstraction:** Eloquent relationships (`belongsTo`, `hasMany`, `hasOne`) abstract complex SQL joins into readable OOP expressions like `$reservation->payment->transaction_id`.

### Q3: How is Role-Based Access Control (RBAC) enforced?
**Answer:**
- The `users` table contains a `role` enum (`admin`, `user`).
- Custom middlewares (`AdminMiddleware` and `UserMiddleware`) protect administrative routes (`/admin/*`) and customer workspace routes (`/user/*`).
- If an unauthenticated user or regular user attempts to access an admin URL, they are blocked with an HTTP 403 or redirected to `/admin/login`.

### Q4: How is the checkout and payment simulation processed safely?
**Answer:**
- Reservations are initially created with `payment_status = 'unpaid'` and `status = 'pending'`.
- The user is forwarded to the `/user/checkout/{id}` screen where they select their payment instrument (Card, Easypaisa, JazzCash, Bank Transfer).
- Upon submission, validation verifies the inputs, records a new entry in `payments` with a unique transaction reference (`TXN-...`), and atomically updates the reservation status to `paid` and `confirmed`.
- An electronic invoice is rendered with an option to print.

### Q5: How does the refund workflow operate?
**Answer:**
- If a user cancels a confirmed and paid flight, hotel, or tour reservation, the reservation status is changed to `cancelled`.
- The user can submit a refund claim via `RefundController@store` stating the cancellation reason and preferred payment reversal channel.
- The administrator receives the claim on the Admin Dashboard under **Pending Refunds**, reviews the rationale, and updates the status to **Approved**, **Processed**, or **Rejected** with audit remarks.
