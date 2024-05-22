<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $pagetitle = 'Orders';
        $orders = Orders::where('is_deleted', 0)->get();
        return view('order.index', compact('pagetitle','orders'));
    }

}