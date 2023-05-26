<?php

namespace App\Http\Controllers\Api;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Mail\ReserPasswordMail;
use App\Mail\ResetPasswordMail;
use App\Models\Outlet;
use App\Models\Poin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $check = User::where(['phone' => $request->phone, 'is_admin' => 0]);
        if(!$check){
            return response()
                ->json(['status' => 'error', 'message' => 'Nomor HP tidak terdaftar'], 401);
        }
        if (!Auth::attempt($request->only('phone', 'password'))) {
            return response()
                ->json(['status' => 'error', 'message' => 'Password salah'], 401);
        }

        $user = User::where('phone', $request['phone'])->firstOrFail();
        if($user->is_admin == 1 && $user->hasRole(['admin', 'manager'])){
            return response()->json(['message' => 'Kamu memiliki hak akses admin atau manager, tidak bisa memasuki aplikasi ini!']);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        if($user->hasRole('customer')){
            $type = 'customer';
            return response()
            ->json(['message' => 'Hi ' . $user->name . ', welcome to home', 'access_token' => $token, 'token_type' => 'Bearer', 'Role' => $type]);
        }
        
        if($user->hasRole('karyawan')){
            $type = 'karyawan';
            $outlet = Outlet::find($user['outlet_id']);

            $data = [
                'name' => $user['name'],
                'phone' => $user['phone'],
                'email' => $user['email'],
                'outlet' => $outlet ? $outlet['name'] : 'invalid outlet',
            ];

            return response()
            ->json(['message' => 'Hi ' . $user->name . ', welcome to admin', 'access_token' => $token, 'token_type' => 'Bearer', 'Role' => $type, 'data' => $data]);
        }


        return response()
            ->json(['message' => 'Your Account is not rollable']);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users',
            'birthday' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'Masukan nama!',
            'phone.required' => 'Masukan nomor handphone!',
            'phone.unique' => 'Nomor handphone sudah ada!',
            'email.required' => 'Masukan email!',
            'email.unique' => 'Email sudah ada!',
            'birthday.required' => 'Masukan tanggal lahir!',
            'gender.required' => 'Masukan jenis kelamin!',
            'occupation.required' => 'Masukan pekerjaan!',
            'province_id.required' => 'Masukan provinsi tempat tinggal!',
            'city_id.required' => 'Masukan kota tempat tinggal!',
            'address.required' => 'Masukan alamat tempat tinggal!',
            'password.required' => 'Masukan Password / PIN!',
            'password.min' => 'Password Minimal 6 angka!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = new User();
        $user->name = $request['name'];
        $user->phone = $request['phone'];
        $user->email = $request['email'];
        $user->birthday = $request['birthday'];
        $user->gender = $request['gender'];
        $user->occupation = $request['occupation'];
        $user->province_id = $request['province_id'];
        $user->city_id = $request['city_id'];
        $user->address = $request['address'];
        $user->is_admin = 0;
        $user->password = Hash::make($request['password']);
        $user->assignRole('customer');
        $user->save();


        $poin = new Poin();
        $poin->poin = 0;
        $poin->total_pembelian = 0;
        $poin->user_id = $user['id'];
        $poin->save();

        return response()->json(['status' => 'success', 'message' => 'Pendaftaran berhasil!'], 200);
    }

    public function forgot(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ], [
            'email.required' => 'Masukan email untuk reset password!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json(['status' => 'error', 'message' => 'Email tidak ditemukan!'], 401);
        }else{
            $email = $user['email'];
            // $email = '1992dayat@gmail.com';
            $pass = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
            $user['password'] = Hash::make($pass);
            $user->save();
            Mail::to($email)->send(new ResetPasswordMail($pass));
            return response()->json(['status' => 'success', 'message' => 'Password baru sudah dikirimkan ke email anda!'], 200);
        }
    }
}
