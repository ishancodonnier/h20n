<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Models\Universities;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $pagetitle = 'Driver';
        $drivers = Users::where('user_type', 'DRIVER')->get();
        return view('driver.index', compact('pagetitle', 'drivers'));
    }

    public function create()
    {
        $pagetitle = 'Driver Create';
        return view('driver.create', compact('pagetitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:user,email',
            'password' => 'required',
            'is_active' => 'required',
        ]);

        $data = [
            'user_token' => '',
            'auth_token' => '',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'user_type' => 'DRIVER',
            'user_profile_photo' => '',
            'password' => Hash::make($request->password),
            'social_id' => '',
            'login_type' => 'email',
            'country_code' => '',
            'phone_number' => '',
            'device_push_token' => '',
            'device_type' => '',
            'verify_forgot_code' => '',
            'is_logged_out' => 0,
            'is_active' => 1,
            'is_deleted' => 0,
            'created_date' => date('Y-m-d H:i:s'),
            'updated_date' => date('Y-m-d H:i:s'),
        ];

        $user = Users::create($data);

        $unique_id = $this->get_unique_id();
        $user_token = $user->user_id . $unique_id . $user->user_id;

        Users::where('user_id', $user->user_id)->update([
            'user_token' => $user_token,
        ]);

        return redirect()->route('driver.index')->with('success', 'Driver created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pagetitle = 'Driver Edit';
        $driver = Users::where('user_id', $id)->first();

        if (!$driver) {
            return redirect()->route('driver.index')->with('error', 'Driver Not Found');
        }

        return view('driver.edit', compact('pagetitle', 'driver'));
    }

    public function update(Request $request, $id)
    {
        $driver = Users::where('user_id', $id)->first();

        if (!$driver) {
            return redirect()->route('driver.index')->with('error', 'Driver Not Found');
        }

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:user,email,'.$id.',user_id',
            'is_active' => 'required',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'updated_date' => date('Y-m-d H:i:s')
        ];

        $driver->update($data);

        return redirect()->route('driver.index')->with('success', 'Driver updated successfully!');
    }

    public function destroy($id)
    {
        $driver = Users::where('user_id', $id)->first();
        if($driver->is_deleted == 0) {
            $driver->update([
                'is_deleted' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('driver.index')->with('success', 'Driver deleted successfully!');
        } else {
            $driver->update([
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('driver.index')->with('success', 'Driver restored successfully!');
        }
    }

    public function get_unique_id($forcedIncrement = null)
    {
        $machine = str_pad(dechex(rand(0, 16777215)), 6, "0", STR_PAD_LEFT);
        $pid = str_pad(dechex(rand(0, 32767)), 4, "0", STR_PAD_LEFT);
        $increment = rand(0, 16777215);
        $datetime = new \DateTime();

        if (is_null($forcedIncrement)) {
            $increment++;
            if ($increment > 0xffffff) {
                $increment = 0;
            }
        } else {
            $increment = $forcedIncrement;
        }
        $timestamp = $datetime->getTimestamp();

        $timestamp_final = str_pad(dechex($timestamp), 8, "0", STR_PAD_LEFT);
        $increment_final = str_pad(dechex($increment), 6, "0", STR_PAD_LEFT);
        return $timestamp_final . $machine . $pid . $increment_final;
    }
}
