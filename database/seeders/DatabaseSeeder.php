<?php

namespace Database\Seeders;

use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@travelbooking.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+92-300-1112233',
                'city' => 'Islamabad',
                'address' => 'VU Headquarters / Travel Admin Office, Blue Area',
                'status' => 'active',
            ]
        );

        // 2. Seed Regular Demo Users
        $user1 = User::updateOrCreate(
            ['email' => 'user@travelbooking.com'],
            [
                'name' => 'Ali Ahmed Khan',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+92-321-9876543',
                'city' => 'Lahore',
                'address' => 'House 42, Block C, Model Town',
                'status' => 'active',
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'sara.malik@example.com'],
            [
                'name' => 'Sara Malik',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+92-333-5554433',
                'city' => 'Karachi',
                'address' => 'Flat 5B, Clifton Block 4',
                'status' => 'active',
            ]
        );

        // 3. Seed Hotels
        $hotelsData = [
            [
                'name' => 'Serena Hotel Islamabad',
                'city' => 'Islamabad',
                'country' => 'Pakistan',
                'address' => 'Khayaban-e-Suhrawardy, Sector G-5/1',
                'star_rating' => 5,
                'price_per_night' => 28000.00,
                'total_rooms' => 50,
                'available_rooms' => 38,
                'room_types' => ['Deluxe Room', 'Executive Suite', 'Presidential Suite'],
                'amenities' => ['Free High-Speed Wi-Fi', 'Swimming Pool', 'Buffet Breakfast', 'Valet Parking', 'Spa & Wellness Center', 'Fitness Center', '24/7 Room Service'],
                'description' => 'A five-star luxury hotel set amidst 14 acres of landscaped gardens, offering traditional Islamic architecture combined with modern comfort in the capital city.',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1000&q=80',
                'contact_phone' => '+92-51-2874000',
                'contact_email' => 'info.islamabad@serena.com.pk',
                'status' => 'active',
            ],
            [
                'name' => 'Pearl Continental Hotel Lahore',
                'city' => 'Lahore',
                'country' => 'Pakistan',
                'address' => 'Mall Road, GOR 1',
                'star_rating' => 5,
                'price_per_night' => 22000.00,
                'total_rooms' => 60,
                'available_rooms' => 45,
                'room_types' => ['Standard Room', 'Deluxe Room', 'Business Suite'],
                'amenities' => ['Free Wi-Fi', 'Complimentary Breakfast', 'Swimming Pool', 'Fitness Club', 'Airport Shuttle', 'Fine Dining Restaurants'],
                'description' => 'The iconic PC Lahore combines heritage hospitality with modern executive amenities in the heart of historical Lahore on Mall Road.',
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1000&q=80',
                'contact_phone' => '+92-42-111505505',
                'contact_email' => 'pchl@hashoogroup.com',
                'status' => 'active',
            ],
            [
                'name' => 'Luxus Grand Hotel',
                'city' => 'Lahore',
                'country' => 'Pakistan',
                'address' => '4 Egerton Road, Opposite LDA Plaza',
                'star_rating' => 4,
                'price_per_night' => 14000.00,
                'total_rooms' => 40,
                'available_rooms' => 29,
                'room_types' => ['Standard Twin', 'King Deluxe', 'Executive Suite'],
                'amenities' => ['Free Wi-Fi', 'Cinema Hall', 'Buffet Breakfast', 'Modern Gym', 'Concierge Service'],
                'description' => 'Modern luxury hotel with state-of-the-art facilities, cinematic entertainment, and panoramic skyline views of Lahore.',
                'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1000&q=80',
                'contact_phone' => '+92-42-36314001',
                'contact_email' => 'reservations@luxusgrand.com',
                'status' => 'active',
            ],
            [
                'name' => 'Hunza Serena Inn',
                'city' => 'Hunza',
                'country' => 'Pakistan',
                'address' => 'Karimabad, Hunza Valley, Gilgit-Baltistan',
                'star_rating' => 5,
                'price_per_night' => 32000.00,
                'total_rooms' => 30,
                'available_rooms' => 21,
                'room_types' => ['Mountain View Deluxe', 'Valley Suite', 'Heritage Cottage'],
                'amenities' => ['Breathtaking Mountain Views', 'Organic Orchard Dining', 'High-speed Wi-Fi', 'Guided Treks', 'Heated Rooms', 'Traditional Music Nights'],
                'description' => 'Perched high in Karimabad facing the magnificent Ultar glacier and Rakaposhi peaks, offering unmatched traditional Hunza hospitality.',
                'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1000&q=80',
                'contact_phone' => '+92-5813-457671',
                'contact_email' => 'hunza@serena.com.pk',
                'status' => 'active',
            ],
            [
                'name' => 'Shangrila Resort Skardu',
                'city' => 'Skardu',
                'country' => 'Pakistan',
                'address' => 'Lower Kachura Lake, Skardu',
                'star_rating' => 4,
                'price_per_night' => 26000.00,
                'total_rooms' => 35,
                'available_rooms' => 24,
                'room_types' => ['Lakeside Swiss Cottage', 'VIP Suite', 'Airplane Suite'],
                'amenities' => ['Lakefront Access', 'Boating & Fishing', 'Garden Dining', 'Free Wi-Fi', 'Sightseeing Transfers'],
                'description' => 'Known as "Heaven on Earth", Shangrila surrounds the heart-shaped Lower Kachura Lake surrounded by the majestic Karakoram Range.',
                'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&w=1000&q=80',
                'contact_phone' => '+92-5815-454941',
                'contact_email' => 'booking@shangrilaresorts.com.pk',
                'status' => 'active',
            ],
            [
                'name' => 'Movenpick Hotel Karachi',
                'city' => 'Karachi',
                'country' => 'Pakistan',
                'address' => 'Club Road, Civil Lines',
                'star_rating' => 5,
                'price_per_night' => 25000.00,
                'total_rooms' => 50,
                'available_rooms' => 34,
                'room_types' => ['Classic Room', 'Deluxe Room', 'Executive Suite'],
                'amenities' => ['Outdoor Heated Pool', 'Free Wi-Fi', 'Tennis Court', '5 Award-Winning Restaurants', 'Fitness Center'],
                'description' => 'Prime 5-star hotel in the business hub of Karachi, within walking distance of government and financial landmarks.',
                'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1000&q=80',
                'contact_phone' => '+92-21-35633333',
                'contact_email' => 'hotel.karachi@movenpick.com',
                'status' => 'active',
            ],
        ];

        $hotels = [];
        foreach ($hotelsData as $data) {
            $hotels[] = Hotel::create($data);
        }

        // 4. Seed Flights
        $flightsData = [
            [
                'airline' => 'Pakistan International Airlines (PIA)',
                'flight_number' => 'PK-302',
                'origin_city' => 'Karachi',
                'destination_city' => 'Islamabad',
                'origin_airport' => 'Jinnah International Airport (KHI)',
                'destination_airport' => 'Islamabad International Airport (ISB)',
                'departure_time' => now()->addDays(2)->setHour(9)->setMinute(30),
                'arrival_time' => now()->addDays(2)->setHour(11)->setMinute(25),
                'duration' => '1h 55m',
                'seat_class' => 'Economy',
                'total_seats' => 180,
                'available_seats' => 142,
                'price_per_seat' => 19500.00,
                'baggage_allowance' => '20 KG Checked + 7 KG Hand Carry',
                'aircraft_type' => 'Airbus A320',
                'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1000&q=80',
                'status' => 'scheduled',
            ],
            [
                'airline' => 'Airblue',
                'flight_number' => 'PA-401',
                'origin_city' => 'Lahore',
                'destination_city' => 'Karachi',
                'origin_airport' => 'Allama Iqbal International Airport (LHE)',
                'destination_airport' => 'Jinnah International Airport (KHI)',
                'departure_time' => now()->addDays(3)->setHour(14)->setMinute(15),
                'arrival_time' => now()->addDays(3)->setHour(16)->setMinute(05),
                'duration' => '1h 50m',
                'seat_class' => 'Economy',
                'total_seats' => 170,
                'available_seats' => 120,
                'price_per_seat' => 18000.00,
                'baggage_allowance' => '20 KG Checked + 7 KG Hand Carry',
                'aircraft_type' => 'Airbus A321neo',
                'image' => 'https://images.unsplash.com/photo-1540339832862-474599807836?auto=format&fit=crop&w=1000&q=80',
                'status' => 'scheduled',
            ],
            [
                'airline' => 'Pakistan International Airlines (PIA)',
                'flight_number' => 'PK-451',
                'origin_city' => 'Islamabad',
                'destination_city' => 'Skardu',
                'origin_airport' => 'Islamabad International Airport (ISB)',
                'destination_airport' => 'Skardu International Airport (KDU)',
                'departure_time' => now()->addDays(4)->setHour(8)->setMinute(00),
                'arrival_time' => now()->addDays(4)->setHour(9)->setMinute(10),
                'duration' => '1h 10m',
                'seat_class' => 'Economy',
                'total_seats' => 150,
                'available_seats' => 95,
                'price_per_seat' => 24500.00,
                'baggage_allowance' => '20 KG Checked + 7 KG Hand Carry',
                'aircraft_type' => 'ATR 72-500',
                'image' => 'https://images.unsplash.com/photo-1506015391300-4802dc74de2e?auto=format&fit=crop&w=1000&q=80',
                'status' => 'scheduled',
            ],
            [
                'airline' => 'Fly Jinnah',
                'flight_number' => '9P-672',
                'origin_city' => 'Islamabad',
                'destination_city' => 'Quetta',
                'origin_airport' => 'Islamabad International Airport (ISB)',
                'destination_airport' => 'Quetta International Airport (UET)',
                'departure_time' => now()->addDays(5)->setHour(11)->setMinute(00),
                'arrival_time' => now()->addDays(5)->setHour(12)->setMinute(30),
                'duration' => '1h 30m',
                'seat_class' => 'Economy',
                'total_seats' => 160,
                'available_seats' => 110,
                'price_per_seat' => 15500.00,
                'baggage_allowance' => '15 KG Checked + 7 KG Hand Carry',
                'aircraft_type' => 'Airbus A320',
                'image' => 'https://images.unsplash.com/photo-1474302770737-173ee21bab63?auto=format&fit=crop&w=1000&q=80',
                'status' => 'scheduled',
            ],
            [
                'airline' => 'SereneAir',
                'flight_number' => 'ER-502',
                'origin_city' => 'Lahore',
                'destination_city' => 'Islamabad',
                'origin_airport' => 'Allama Iqbal International Airport (LHE)',
                'destination_airport' => 'Islamabad International Airport (ISB)',
                'departure_time' => now()->addDays(6)->setHour(17)->setMinute(30),
                'arrival_time' => now()->addDays(6)->setHour(18)->setMinute(25),
                'duration' => '0h 55m',
                'seat_class' => 'Business',
                'total_seats' => 32,
                'available_seats' => 24,
                'price_per_seat' => 28000.00,
                'baggage_allowance' => '32 KG Checked + 10 KG Hand Carry',
                'aircraft_type' => 'Boeing 737-800',
                'image' => 'https://images.unsplash.com/photo-1529070538774-1843cb3265df?auto=format&fit=crop&w=1000&q=80',
                'status' => 'scheduled',
            ],
            [
                'airline' => 'Emirates Airlines',
                'flight_number' => 'EK-613',
                'origin_city' => 'Islamabad',
                'destination_city' => 'Dubai',
                'origin_airport' => 'Islamabad International Airport (ISB)',
                'destination_airport' => 'Dubai International Airport (DXB)',
                'departure_time' => now()->addDays(7)->setHour(22)->setMinute(15),
                'arrival_time' => now()->addDays(8)->setHour(00)->setMinute(45),
                'duration' => '3h 30m',
                'seat_class' => 'Economy',
                'total_seats' => 250,
                'available_seats' => 180,
                'price_per_seat' => 78000.00,
                'baggage_allowance' => '30 KG Checked + 7 KG Hand Carry',
                'aircraft_type' => 'Boeing 777-300ER',
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1000&q=80',
                'status' => 'scheduled',
            ],
        ];

        $flights = [];
        foreach ($flightsData as $data) {
            $flights[] = Flight::create($data);
        }

        // 5. Seed Vacation Packages
        $packagesData = [
            [
                'name' => 'Hunza & Attabad Lake Alpine Escape',
                'destination' => 'Hunza Valley',
                'country' => 'Pakistan',
                'duration_days' => 6,
                'duration_nights' => 5,
                'hotel_id' => $hotels[3]->id, // Hunza Serena Inn
                'flight_id' => null,
                'price' => 75000.00,
                'discount_percent' => 10,
                'max_capacity' => 25,
                'available_slots' => 18,
                'image' => 'https://images.unsplash.com/photo-1627894006566-bf5ecf36bfa7?auto=format&fit=crop&w=1000&q=80',
                'description' => 'Experience the legendary beauty of the Hunza valley, historical Baltit and Altit forts, turquoise Attabad Lake boating, Passu Cones, and the majestic Karakoram Highway.',
                'itinerary' => [
                    ['day' => 1, 'details' => 'Departure from Islamabad, drive through scenic Hazara Motorway & Naran-Kaghan or KKH to Chilas.'],
                    ['day' => 2, 'details' => 'Drive along the Indus River to Hunza. Sunset view of Rakaposhi peak.'],
                    ['day' => 3, 'details' => 'Explore Karimabad, visit 900-year-old Baltit Fort and historical Altit Fort.'],
                    ['day' => 4, 'details' => 'Excursion to Attabad Lake with jet ski/boating, Passu Cones, and Hussaini Suspension Bridge.'],
                    ['day' => 5, 'details' => 'Visit Khunjerab Pass (Pak-China border at 15,397 ft). Evening musical bonfire.'],
                    ['day' => 6, 'details' => 'Return journey back to Islamabad with lifetime memories.'],
                ],
                'inclusions' => [
                    'Luxury 4x4 Prado / Coaster Transport',
                    '5 Nights accommodation at Hunza Serena Inn / Quality Hotels',
                    'Daily Breakfast & Dinner',
                    'Professional Tour Guide & Tolls',
                    'Attabad Lake Boating passes',
                ],
                'exclusions' => [
                    'Lunch & Personal expenses',
                    'Laundry and tips',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Skardu, Deosai & Shangrila Dream Tour',
                'destination' => 'Skardu & Deosai',
                'country' => 'Pakistan',
                'duration_days' => 7,
                'duration_nights' => 6,
                'hotel_id' => $hotels[4]->id, // Shangrila Skardu
                'flight_id' => $flights[2]->id, // PK-451 ISB to KDU
                'price' => 110000.00,
                'discount_percent' => 15,
                'max_capacity' => 20,
                'available_slots' => 12,
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1000&q=80',
                'description' => 'A royal expedition to Skardu: Fly directly between snow-capped giants, stroll through Katpana Cold Desert, boat on Lower & Upper Kachura Lakes, and traverse Deosai National Park.',
                'itinerary' => [
                    ['day' => 1, 'details' => 'Morning flight from Islamabad to Skardu. Check-in at Shangrila Resort, lake stroll.'],
                    ['day' => 2, 'details' => 'Visit Lower Kachura Lake, Upper Kachura Lake, and Soq Valley.'],
                    ['day' => 3, 'details' => 'Full day 4x4 expedition across Deosai Plains (The Land of Giants) and Sheosar Lake.'],
                    ['day' => 4, 'details' => 'Visit ancient Kharpocho Fort and stroll through organic Sadpara Lake.'],
                    ['day' => 5, 'details' => 'Explore Shigar Valley, visit the historical 400-year-old Serena Shigar Fort.'],
                    ['day' => 6, 'details' => 'Sunset at Katpana Desert with bonfire and local Balti cuisine.'],
                    ['day' => 7, 'details' => 'Transfer to Skardu Airport and fly back to Islamabad.'],
                ],
                'inclusions' => [
                    'Islamabad-Skardu Return Air Tickets',
                    '6 Nights stay at Shangrila Resort & Shigar Fort',
                    'Daily buffet breakfast & traditional dinners',
                    '4x4 Jeep for Deosai Plains expedition',
                    'Airport pickup and drop-off',
                ],
                'exclusions' => [
                    'Personal shopping & drinks',
                    'Optional paragliding fees',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Murree Hills & Nathia Gali Weekend Retreat',
                'destination' => 'Murree & Galiyat',
                'country' => 'Pakistan',
                'duration_days' => 3,
                'duration_nights' => 2,
                'hotel_id' => $hotels[0]->id,
                'flight_id' => null,
                'price' => 28000.00,
                'discount_percent' => 5,
                'max_capacity' => 30,
                'available_slots' => 25,
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1000&q=80',
                'description' => 'A refreshing weekend getaway to the pine-scented hills of Murree, Mall Road, Patriata chairlift, and scenic nature hiking trails in Nathia Gali.',
                'itinerary' => [
                    ['day' => 1, 'details' => 'Pickup from Islamabad/Rawalpindi, drive to Murree via Expressway. Evening stroll on Mall Road.'],
                    ['day' => 2, 'details' => 'Day excursion to Nathia Gali, hike on Pipeline Track or Mukshpuri peak, visit St. Matthew Church.'],
                    ['day' => 3, 'details' => 'Ride New Murree / Patriata Chairlift & Cable car, return drive to Islamabad.'],
                ],
                'inclusions' => [
                    'Air-conditioned private transport',
                    '2 Nights hotel stay with breakfast',
                    'Driver allowances and toll taxes',
                ],
                'exclusions' => [
                    'Patriata cable car tickets',
                    'Meals other than breakfast',
                ],
                'is_featured' => false,
                'status' => 'active',
            ],
            [
                'name' => 'Dubai 5-Day Mega Vacation & Desert Safari',
                'destination' => 'Dubai',
                'country' => 'United Arab Emirates',
                'duration_days' => 5,
                'duration_nights' => 4,
                'hotel_id' => null,
                'flight_id' => $flights[5]->id, // EK-613 Dubai
                'price' => 210000.00,
                'discount_percent' => 10,
                'max_capacity' => 20,
                'available_slots' => 15,
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1000&q=80',
                'description' => 'Discover futuristic Dubai: Burj Khalifa 124th floor observation, Dubai Mall fountains, red dunes Desert Safari with BBQ dinner and belly dance, and Marina Dhow cruise.',
                'itinerary' => [
                    ['day' => 1, 'details' => 'Arrival at DXB Airport, luxury airport transfer, hotel check-in.'],
                    ['day' => 2, 'details' => 'Dubai City Tour: Dubai Frame, Palm Jumeirah, Burj Al Arab photo-stop.'],
                    ['day' => 3, 'details' => 'Afternoon 4x4 Desert Safari: Dune bashing, camel riding, BBQ dinner under the stars.'],
                    ['day' => 4, 'details' => 'Burj Khalifa Top level visit, Dubai Aquarium & Dubai Mall shopping.'],
                    ['day' => 5, 'details' => 'Morning Marina Dhow Cruise, afternoon transfer to Dubai Airport for departure.'],
                ],
                'inclusions' => [
                    '4-Star Hotel accommodation in Downtown Dubai',
                    'Daily International Breakfast Buffet',
                    'Red Dune Desert Safari with BBQ Dinner',
                    'Burj Khalifa At The Top tickets',
                    'All airport and sightseeing transfers',
                ],
                'exclusions' => [
                    'UAE Tourist Visa fees',
                    'Tourism Dirham tax paid at hotel',
                ],
                'is_featured' => true,
                'status' => 'active',
            ],
            [
                'name' => 'Swat Valley, Malam Jabba & Kalam Tour',
                'destination' => 'Swat & Kalam',
                'country' => 'Pakistan',
                'duration_days' => 5,
                'duration_nights' => 4,
                'hotel_id' => $hotels[1]->id,
                'flight_id' => null,
                'price' => 55000.00,
                'discount_percent' => 0,
                'max_capacity' => 25,
                'available_slots' => 20,
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80',
                'description' => 'Known as the "Switzerland of the East", explore the lush Swat riverbanks, Malam Jabba ski resort chairlift, Kalam pine forests, and Mahodand Lake.',
                'itinerary' => [
                    ['day' => 1, 'details' => 'Drive through Swat Motorway, visit White Palace Marghazar, night stay in Mingora.'],
                    ['day' => 2, 'details' => 'Full day thrill at Malam Jabba Ski Resort and Zipline.'],
                    ['day' => 3, 'details' => 'Travel along scenic Swat river to Kalam valley, explore Ushu forest.'],
                    ['day' => 4, 'details' => 'Jeep safari to the enchanting Mahodand Lake and Saifullah Lake.'],
                    ['day' => 5, 'details' => 'Shopping at Mingora Bazaar, return journey back.'],
                ],
                'inclusions' => [
                    'Dedicated transport with experienced mountain driver',
                    '4 Nights hotel stay with breakfast',
                    '4x4 Jeep for Mahodand Lake',
                ],
                'exclusions' => [
                    'Malam Jabba zipline and chairlift tickets',
                ],
                'is_featured' => false,
                'status' => 'active',
            ],
        ];

        $packages = [];
        foreach ($packagesData as $data) {
            $packages[] = Package::create($data);
        }

        // 6. Seed Sample Reservations (User Flight Schedule, Hotel Schedule, and Package Booking)
        // 6a. Flight Schedule reservation (Paid & Confirmed)
        $res1 = Reservation::create([
            'booking_reference' => 'TRV-2026-F79210',
            'user_id' => $user1->id,
            'type' => 'flight',
            'flight_id' => $flights[0]->id, // PK-302
            'travel_date' => now()->addDays(2),
            'guests_count' => 1,
            'seat_class' => 'Economy',
            'seat_number' => '14A',
            'contact_name' => $user1->name,
            'contact_email' => $user1->email,
            'contact_phone' => $user1->phone,
            'passenger_details' => [
                ['name' => 'Ali Ahmed Khan', 'cnic' => '35202-1234567-1', 'seat' => 'Economy-14A']
            ],
            'subtotal' => 19500.00,
            'tax_amount' => 975.00,
            'discount_amount' => 0.00,
            'total_amount' => 20475.00,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'special_requests' => 'Window seat preferred, diabetic meal.',
        ]);

        Payment::create([
            'transaction_id' => 'TXN-' . time() . '-8821',
            'reservation_id' => $res1->id,
            'user_id' => $user1->id,
            'amount' => 20475.00,
            'payment_method' => 'credit_card',
            'card_holder_name' => 'Ali Ahmed Khan',
            'card_last_four' => '4242',
            'status' => 'successful',
            'paid_at' => now()->subDay(),
        ]);

        // 6b. Hotel Schedule reservation (Paid, Cancelled with Refund request)
        $res2 = Reservation::create([
            'booking_reference' => 'TRV-2026-H44192',
            'user_id' => $user1->id,
            'type' => 'hotel',
            'hotel_id' => $hotels[0]->id, // Serena Islamabad
            'check_in_date' => now()->addDays(5),
            'check_out_date' => now()->addDays(7),
            'guests_count' => 2,
            'room_type' => 'Deluxe Room',
            'contact_name' => $user1->name,
            'contact_email' => $user1->email,
            'contact_phone' => $user1->phone,
            'subtotal' => 56000.00,
            'tax_amount' => 4480.00,
            'discount_amount' => 0.00,
            'total_amount' => 60480.00,
            'payment_status' => 'paid',
            'status' => 'cancelled',
            'special_requests' => 'High floor, quiet room.',
        ]);

        Payment::create([
            'transaction_id' => 'TXN-' . (time() - 3600) . '-1942',
            'reservation_id' => $res2->id,
            'user_id' => $user1->id,
            'amount' => 60480.00,
            'payment_method' => 'easypaisa',
            'card_holder_name' => 'Ali Ahmed Khan',
            'card_last_four' => '7890',
            'status' => 'successful',
            'paid_at' => now()->subDays(2),
        ]);

        // Refund request for reservation #2
        Refund::create([
            'refund_reference' => 'REF-2026-981240',
            'reservation_id' => $res2->id,
            'user_id' => $user1->id,
            'amount' => 60480.00,
            'reason' => 'Family medical emergency, need to reschedule travel plans to next month.',
            'status' => 'pending',
            'refund_method' => 'original_payment_method',
            'admin_remarks' => 'Reviewing booking cancellation policy for 48h prior notice.',
        ]);

        // 6c. Package Booking reservation (Paid & Confirmed)
        $res3 = Reservation::create([
            'booking_reference' => 'TRV-2026-P33109',
            'user_id' => $user2->id,
            'type' => 'package',
            'package_id' => $packages[0]->id, // Hunza Alpine Escape
            'hotel_id' => $packages[0]->hotel_id,
            'flight_id' => null,
            'travel_date' => now()->addDays(10),
            'guests_count' => 2,
            'contact_name' => $user2->name,
            'contact_email' => $user2->email,
            'contact_phone' => $user2->phone,
            'passenger_details' => [
                ['name' => 'Sara Malik', 'cnic' => '42201-9876543-2'],
                ['name' => 'Zain Malik', 'cnic' => '42201-1122334-1'],
            ],
            'subtotal' => 135000.00,
            'tax_amount' => 6750.00,
            'discount_amount' => 15000.00,
            'total_amount' => 141750.00,
            'payment_status' => 'paid',
            'status' => 'confirmed',
            'special_requests' => 'Vegetarian meals preferred.',
        ]);

        Payment::create([
            'transaction_id' => 'TXN-' . (time() - 7200) . '-7712',
            'reservation_id' => $res3->id,
            'user_id' => $user2->id,
            'amount' => 141750.00,
            'payment_method' => 'credit_card',
            'card_holder_name' => 'Sara Malik',
            'card_last_four' => '1199',
            'status' => 'successful',
            'paid_at' => now()->subDays(3),
        ]);
    }
}
