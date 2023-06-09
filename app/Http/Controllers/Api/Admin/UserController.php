<?php

namespace App\Http\Controllers\Api\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function change_image_karyawan(Request $request){
        $user = $request->user();
        $user = User::find($user->id);
        $role = Helpers::checkRole($user, 'karyawan');
        if($role){
            $validator = Validator::make($request->all(), [
                'image' => 'required'
            ], [
                'image.required' => 'Masukan foto!',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

        $user->image = Helpers::update('profile/', $user->image, 'png', $request->file('image'));
        $user->save();

            return response()->json(['status' => 'success', 'message' => 'Foto profil berhasil diubah!'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Anda tidak memiliki akses!'], 403);
    }

    public function profile(Request $request){
        $user = $request->user();

        $role = Helpers::checkRole($user, 'karyawan');
        if($role){
            $outlet = Outlet::find($user['outlet_id']);
            $data = [
                'name' => $user['name'],
                'phone' => $user['phone'],
                'email' => $user['email'],
                'image' => config('app.url').'/storage/profile/'.$user['image'],
                'outlet' => $outlet ? $outlet['name'] : 'invalid outlet',
            ];
            return response()->json(['status' => 'success', 'data' => $data], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }

    public function pin_edit(Request $request){
        $user = $request->user();

        $role = Helpers::checkRole($user, 'karyawan');
        if($role){
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:6'
            ], [
                'password.required' => 'Masukan Password / PIN!',
                'password.min' => 'Password Minimal 6 angka!',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $user = User::find($user['id']);
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'PIN Berhasil diganti!'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }
}
