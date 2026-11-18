<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_bookings' => Reservation::where('user_id', $user->id)->count(),
            'flight_schedules' => Reservation::where('user_id', $user->id)->where('type', 'flight')->count(),
            'hotel_schedules' => Reservation::where('user_id', $user->id)->where('type', 'hotel')->count(),
            'package_bookings' => Reservation::where('user_id', $user->id)->where('type', 'package')->count(),
            'total_spent' => Payment::where('user_id', $user->id)->where('status', 'successful')->sum('amount'),
            'pending_refunds' => Refund::where('user_id', $user->id)->where('status', 'pending')->count(),
        ];

        $recentReservations = Reservation::with(['flight', 'hotel', 'package', 'payment'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('stats', 'recentReservations'));
    }
}
