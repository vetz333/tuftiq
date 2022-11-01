<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function index()
    {
        $adminData = Admin::find(1);

        return view('admin.admin_profile', compact('adminData'));
    }

    public function edit()
    {
        $editData = Admin::find(1);

        return view('admin.admin_profile_edit', compact('editData'));
    }

    public function store(Request $request)
    {
        $data = Admin::find(1);
        $data->name = $request->name;
        $data->email = $request->email;


        if ($request->file('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            @unlink(public_path('upload/admin_images/'.$data->profile_photo_path));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_photo_path'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.profile')->with($notification);
    }


    public function changePassword()
    {
        return view('admin.admin_change_password');
    }

    public function change(Request $request)
    {
        $validateData = $request->validate([
            'oldPassword' =>'required',
            'password' =>'required|confirmed',
        ]);

        $hashedPassword = Admin::find(1)->password;
        if (Hash::check($request->oldPassword, $hashedPassword)) {
           $admin = Admin::find(1);
           $admin->password = Hash::make($request->password);
           $admin->save();
            Auth::logout();
            return redirect()->route('admin.logout');
        } else {
            return redirect()->back();
        }
    }
}
