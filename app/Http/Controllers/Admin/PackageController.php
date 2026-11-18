<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Read: List all vacation packages.
     */
    public function index(Request $request)
    {
        $query = Package::with(['hotel', 'flight']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('destination', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $packages = $query->withCount('reservations')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Create: Show package creation form.
     */
    public function create()
    {
        $hotels = Hotel::where('status', 'active')->orderBy('name')->get();
        $flights = Flight::where('status', 'scheduled')->orderBy('flight_number')->get();

        return view('admin.packages.create', compact('hotels', 'flights'));
    }

    /**
     * Create: Store new package.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'hotel_id' => 'nullable|exists:hotels,id',
            'flight_id' => 'nullable|exists:flights,id',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:90',
            'max_capacity' => 'required|integer|min:1',
            'available_slots' => 'required|integer|min:0',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'itinerary' => 'nullable|string', // raw text or line by line
            'inclusions' => 'nullable|string', // comma or line separated
            'exclusions' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('packages', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['discount_percent'] = $validated['discount_percent'] ?? 0;

        // Process inclusions & exclusions arrays
        if (!empty($validated['inclusions'])) {
            $validated['inclusions'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['inclusions']))));
        } else {
            $validated['inclusions'] = ['Hotel Accommodation', 'Guided Tours', 'Daily Breakfast', 'Airport Transfers'];
        }

        if (!empty($validated['exclusions'])) {
            $validated['exclusions'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['exclusions']))));
        } else {
            $validated['exclusions'] = ['Personal Expenses', 'Visa Fees (if applicable)'];
        }

        // Process itinerary
        if (!empty($validated['itinerary'])) {
            $lines = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['itinerary']))));
            $days = [];
            $i = 1;
            foreach ($lines as $line) {
                $days[] = ['day' => $i++, 'details' => $line];
            }
            $validated['itinerary'] = $days;
        }

        Package::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Vacation package created successfully!');
    }

    /**
     * Read: Show specific package details.
     */
    public function show(Package $package)
    {
        $package->load(['hotel', 'flight', 'reservations.user']);
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Update: Show edit form.
     */
    public function edit(Package $package)
    {
        $hotels = Hotel::where('status', 'active')->orderBy('name')->get();
        $flights = Flight::where('status', 'scheduled')->orderBy('flight_number')->get();

        return view('admin.packages.edit', compact('package', 'hotels', 'flights'));
    }

    /**
     * Update: Save edited package.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'hotel_id' => 'nullable|exists:hotels,id',
            'flight_id' => 'nullable|exists:flights,id',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:90',
            'max_capacity' => 'required|integer|min:1',
            'available_slots' => 'required|integer|min:0',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:2048',
            'description' => 'required|string',
            'itinerary' => 'nullable|string',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('packages', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['discount_percent'] = $validated['discount_percent'] ?? 0;

        if (!empty($validated['inclusions'])) {
            $validated['inclusions'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['inclusions']))));
        }

        if (!empty($validated['exclusions'])) {
            $validated['exclusions'] = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['exclusions']))));
        }

        if (!empty($validated['itinerary'])) {
            $lines = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $validated['itinerary']))));
            $days = [];
            $i = 1;
            foreach ($lines as $line) {
                $days[] = ['day' => $i++, 'details' => $line];
            }
            $validated['itinerary'] = $days;
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Vacation package updated successfully!');
    }

    /**
     * Delete: Delete package.
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Vacation package deleted successfully.');
    }
}
