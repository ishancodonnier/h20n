<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $pagetitle = 'Billing Staff';
        $staffs = Admin::where('email', '!=', 'super@admin.com')->get();
        return view('staff.index', compact('pagetitle', 'staffs'));
    }

    public function create()
    {
        $pagetitle = 'Create Billing Staff';
        return view('staff.create', compact('pagetitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        Admin::create($data);

        return redirect()->route('staff.index')->with('success', 'Staff created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pagetitle = 'Edit Billing Staff';
        $staff = Admin::where('id', $id)->first();

        if (!$staff) {
            return redirect()->route('staff.index')->with('error', 'Staff Not Found');
        }

        return view('staff.edit', compact('pagetitle', 'staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Admin::where('id', $id)->first();

        if (!$staff) {
            return redirect()->route('staff.index')->with('error', 'Staff Not Found');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:admins,email,'.$id.',id',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if($request->password) {
            $data = [
                'password' => Hash::make($request->password),
            ];
        }

        $staff->update($data);

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully!');
    }

    public function change_password($id)
    {
        $pagetitle = 'Edit Billing Staff Password';
        $staff = Admin::where('id', $id)->first();

        if (!$staff) {
            return redirect()->route('staff.index')->with('error', 'Staff Not Found');
        }

        return view('staff.password', compact('pagetitle', 'staff'));
    }

    public function update_password(Request $request, $id)
    {
        $staff = Admin::where('id', $id)->first();

        if (!$staff) {
            return redirect()->route('staff.index')->with('error', 'Staff Not Found');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $data = [
            'password' => Hash::make($request->password),
        ];

        $staff->update($data);

        return redirect()->route('staff.index')->with('success', 'Staff password updated successfully!');
    }

    public function destroy($id)
    {
        $staff = Admin::where('id', $id)->first();
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully!');
    }
}
