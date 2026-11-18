<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::with(['hotel', 'flight'])->where('status', 'active');

        if ($request->filled('destination')) {
            $query->where('destination', 'like', '%' . $request->destination . '%');
        }
        if ($request->filled('days')) {
            $query->where('duration_days', '<=', $request->days);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $packages = $query->orderBy('is_featured', 'desc')->paginate(9);

        return view('packages.index', compact('packages'));
    }

    public function show(Package $package)
    {
        $package->load(['hotel', 'flight']);

        $otherPackages = Package::where('id', '!=', $package->id)
            ->where('status', 'active')
            ->take(3)
            ->get();

        return view('packages.show', compact('package', 'otherPackages'));
    }
}
