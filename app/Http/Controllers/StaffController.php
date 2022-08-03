<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;
use App\Models\Staff;
use Carbon\Carbon;

class StaffController extends Controller
{
    // Home page
    public function home()
    {
        $current = Carbon::now();
        $current_time = Carbon::now()->format("h:i");
        $noon = Carbon::createFromTime("12");
        $is_closed = Carbon::parse($current)->isClosed();

        // Difference between opening/closing hour from now
        if ($is_closed) {
            $next_open_or_close = Carbon::nextOpen();
        } else {
            $next_open_or_close = Carbon::nextClose();
        }

        $diff_hour_next = Carbon::parse($current)->diffInRealHours(
            $next_open_or_close
        );
        $diff_min_next = Carbon::parse($current)->diffInRealMinutes(
            $next_open_or_close
        );

        if ($diff_min_next > 1) {
            if ($diff_hour_next > 1) {
                $diff_next = $diff_hour_next . " hours";
            } elseif ($diff_hour_next === 1) {
                $diff_next = $diff_hour_next . " hour";
            } else {
                $diff_next = $diff_min_next . " minutes";
            }
        } else {
            $diff_next = $diff_min_next . " minute";
        }

        // Greet type
        if ($current < $noon) {
            $greet = "morning";
        } else {
            $greet = "afternoon";
        }

        // Greet message
        if (Carbon::isBusinessClosed()) {
            $message = "Hey, " . Auth::user()->name . ". Take a rest.";
        } else {
            $message = "Good " . $greet . ", " . Auth::user()->name . ".";
        }

        return view("staff.index", [
            "staff" => Auth::user(),
            "message" => $message,
            "time_now" => $current_time,
            "next_open_or_close" => $next_open_or_close->format("h:i"),
            "diff_next" => $diff_next,
            "is_closed" => $is_closed,
        ]);
    }

    // Profile page
    public function profile()
    {
        return view("staff.profile", [
            "staff" => Auth::user(),
        ]);
    }
}
