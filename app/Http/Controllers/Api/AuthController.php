<?php

namespace App\Http\Controllers\Api;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6'
        ], [
            'phone.required' => 'Masukan nomor handphone!',
            'password.required' => 'Masukan Password / PIN!',
            'password.min' => 'Password Minimal 6 angka!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        if (!Auth::attempt($request->only('phone', 'password'))) {
            return response()
                ->json(['message' => 'Nomor Handphone atau password salah'], 401);
        }

        $user = User::where('phone', $request['phone'])->firstOrFail();
        if($user->is_admin == 1){
            return response()->json(['message' => 'Kamu memiliki hak akses admin, tidak bisa memasuki aplikasi ini!']);
        }

        if($user->hasRole('customer')){
            $type = 'customer';
        }
        
        if($user->hasRole('karyawan')){
            $type = 'karyawan';
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer', 'Role' => $type]);
    }
}
