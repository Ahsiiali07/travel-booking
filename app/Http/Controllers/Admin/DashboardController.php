<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Hotel;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_bookings' => Reservation::count(),
            'confirmed_bookings' => Reservation::where('status', 'confirmed')->count(),
            'total_revenue' => Payment::where('status', 'successful')->sum('amount'),
            'total_hotels' => Hotel::count(),
            'total_flights' => Flight::count(),
            'total_packages' => Package::count(),
            'pending_refunds' => Refund::where('status', 'pending')->count(),
        ];

        $recentReservations = Reservation::with(['user', 'flight', 'hotel', 'package', 'payment'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $pendingRefundRequests = Refund::with(['reservation.user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentUsers = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReservations', 'pendingRefundRequests', 'recentUsers'));
    }
}
