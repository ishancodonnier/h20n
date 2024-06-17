<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Users;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $pagetitle = 'Dashboard';
        $user_count = Users::where('user_type', 'USER')->where('is_active', 1)->where('is_deleted', 0)->count();
        $driver_count = Users::where('user_type', 'DRIVER')->where('is_active', 1)->where('is_deleted', 0)->count();
        return view('dashboard', compact('pagetitle', 'user_count', 'driver_count'));
    }
}
