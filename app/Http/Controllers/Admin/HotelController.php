<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Read: List all hotels.
     */
    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $hotels = $query->withCount('reservations')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.hotels.index', compact('hotels'));
    }

    /**
     * Create: Show form.
     */
    public function create()
    {
        return view('admin.hotels.create');
    }

    /**
     * Create: Store new hotel.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'room_types' => 'nullable|string', // comma-separated or JSON
            'amenities' => 'nullable|array',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:2048',
            'contact_phone' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('hotels', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        // Parse room types
        if (!empty($validated['room_types'])) {
            $validated['room_types'] = array_map('trim', explode(',', $validated['room_types']));
        } else {
            $validated['room_types'] = ['Standard Room', 'Deluxe Room', 'Executive Suite'];
        }

        Hotel::create($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel created successfully!');
    }

    /**
     * Read: Show specific hotel.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load(['reservations.user', 'packages']);
        return view('admin.hotels.show', compact('hotel'));
    }

    /**
     * Update: Show edit form.
     */
    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    /**
     * Update: Save changes.
     */
    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'required|integer|min:0',
            'room_types' => 'nullable|string',
            'amenities' => 'nullable|array',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:2048',
            'contact_phone' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('hotels', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        if (!empty($validated['room_types'])) {
            $validated['room_types'] = array_map('trim', explode(',', $validated['room_types']));
        }

        $hotel->update($validated);

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel updated successfully!');
    }

    /**
     * Delete: Remove hotel.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()->route('admin.hotels.index')
            ->with('success', 'Hotel deleted successfully.');
    }
}
