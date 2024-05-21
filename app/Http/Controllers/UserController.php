<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $pagetitle = 'User';
        $users = Users::where('user_type', 'USER')->get();
        return view('user.index', compact('pagetitle', 'users'));
    }

    public function create()
    {
        $pagetitle = 'User Create';
        return view('user.create', compact('pagetitle'));
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
            'user_type' => 'USER',
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

        return redirect()->route('user.index')->with('success', 'User created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pagetitle = 'User Edit';
        $user = Users::where('user_id', $id)->first();

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User Not Found');
        }

        return view('user.edit', compact('pagetitle', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = Users::where('user_id', $id)->first();

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User Not Found');
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

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = Users::where('user_id', $id)->first();
        if($user->is_deleted == 0) {
            $user->update([
                'is_deleted' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('user.index')->with('success', 'User deleted successfully!');
        } else {
            $user->update([
                'is_deleted' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('user.index')->with('success', 'User restored successfully!');
        }
    }

    public function status($id)
    {
        $user = Users::where('user_id', $id)->first();
        if($user->is_active == 0) {
            $user->update([
                'is_active' => 1,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('user.index')->with('success', 'User enabled successfully!');
        } else {
            $user->update([
                'is_active' => 0,
                'updated_date' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('user.index')->with('success', 'User disabled successfully!');
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
