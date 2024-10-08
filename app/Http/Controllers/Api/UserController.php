<?php

namespace App\Http\Controllers\Api;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\NotifReceiver;
use App\Models\Poin;
use App\Models\PoinHistory;
use App\Models\PoinView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function list_notif(Request $request)
    {
        $user = $request->user();
        $notif = NotifReceiver::with('notif')->where(['user_id' => $user->id])->orderBy('created_at', 'desc')->get();

        $newNotif = [];
        foreach($notif as $n){
            if(isset($n['notif'])){
                array_push($newNotif, $n);
            }
        }

        return response()->json(['status' => 'success', 'data' => $newNotif], 200);
    }

    public function notif_details(Request $request, $id)
    {
        // $user = $request->user();
        $notif = NotifReceiver::find($id);
        if ($notif) {
            $notif->is_read = 1;
            $notif->save();
            return response()->json(['status' => 'success', 'data' => $notif], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Notifikasi tidak ditemukan'], 403);
    }
    public function change_image(Request $request)
    {
        $user = $request->user();
        $user = User::find($user->id);
        if ($user) {
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
        return response()->json(['status' => 'error', 'message' => 'Customer tidak ditemukan!'], 403);
    }
    public function is_notify(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'is_receive' => 'required'
        ], [
            'is_receive.required' => 'Masukan nilai 1 untuk menerima, atau 0 untuk tidak menerima pada field is_receive!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $us = User::find($user->id);
        $us->is_notify = $request->is_receive;
        $us->save();

        return response()->json(['status' => 'success', 'message' => 'Notifikasi berhasil diubah!'], 200);
    }
    public function total_stamp(Request $request)
    {
        $user = $request->user();
        Helpers::singleExpire($user['id']);
        $poin = Helpers::calc_poin($user->id);


        $history = PoinHistory::with('outlet', 'user')->where(['user_id' => $user->id, 'type' => 'add', "isexpired" => 0])->orderBy('created_at', 'desc')->get();

        $view = PoinView::where('user_id', $user->id)->get();

        foreach ($view as $v) {
            $v->delete();
        }

        $bilangan = count($history);

        $pembagi = 6;
        $sisaBagi = $bilangan % $pembagi;

        if ($sisaBagi == 0) {
            $show = PoinHistory::with('outlet', 'user')->where(['user_id' => $user->id, 'type' => 'add'])->orderBy('created_at', 'desc')->limit(6)->get();
        } else {
            $show = PoinHistory::with('outlet', 'user')->where(['user_id' => $user->id, 'type' => 'add'])->orderBy('created_at', 'desc')->limit($sisaBagi)->get();
        }

        foreach ($show as $n) {
            $nView = new PoinView();
            $nView->user_id = $user->id;
            $nView->ph_id = $n['id'];
            $nView->updated_at = $n['created_at'];
            $nView->save();
        }

        $view = PoinView::with('history')->where('user_id', $user->id)->get();

        $poinNew = [];
        $redeem = [];
        foreach ($view as $s) {
            if ($s['history']['isredeem'] == 1) {
                array_push($redeem, $s['history']['poin']);
            } else {
                array_push($poinNew, $s['history']['poin']);
            }
        }

        $data = [
            "id" => $poin['id'],
            "user_id" => $poin ? $poin['user_id'] : null,
            "poin" => array_sum($poinNew),
            "total_pembelian" => $poin['total_pembelian'],
            "created_at" => $poin['created_at'],
            "updated_at" => $poin['updated_at'],
            "redeemed" => array_sum($redeem),
        ];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    public function stamp_history(Request $request)
    {
        $user = $request->user();
        Helpers::singleExpire($user['id']);
        $history = PoinHistory::with('outlet', 'user')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        // dd($bilangan . " dibagi dengan " . $pembagi . " adalah " . $hasilBagi . " sisa " . $sisaBagi);

        $data = [];
        foreach ($history as $h) {
            $dat = [
                "nama" => $h['user'] ? $h['user']['name'] : 'Invalid user',
                "outlet" => $h['outlet'] ? $h['outlet']['name'] : 'Invalid outlet',
                "type" => $h['type'],
                "no_receipt" => $h['no_receipt'],
                "pembelian" => $h['pembelian'],
                "poin" => $h['poin'],
                "tanggal" => $h['created_at'],
                'is_redeemed' => $h['isredeem'],
                'is_expired' => $h['isexpired'],
                "expire" => $h['created_at']->addDays(365)
            ];

            array_push($data, $dat);
        }

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    public function update_fcm(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $validator = Validator::make($request->all(), [
                'fcm' => 'required'
            ], [
                'fcm.required' => 'Masukan fcm!',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $users = User::find($user['id']);
            $users->fcm = $request->fcm;
            $users->save();

            if($user['is_admin'] == 0){
                if($user['birthday'] == null || $user['gender'] == null || $user['occupation'] == null || $user['province_id'] == null || $user['city_id'] == null || $user['address'] == null){
                    // dd($data);
                    if($request->fcm && $user['is_notify'] == 1){
                        $data = [
                            'title' => 'Information your profile!',
                            'description' => 'Please complete your profile to get a promo from us!'
                        ];
                        $notif = new Notifications();
                        $notif->title = $data['title'];
                        $notif->description = $data['description'];
                        $notif->save();

                        $id = $notif->id ?? $notif['id'];

                        $notifSave = new NotifReceiver();
                        $notifSave->notification_id = $id;
                        $notifSave->user_id = $user['id'];
                        $notifSave->is_read = 0;
                        $notifSave->save();

                        Helpers::send_push_notif_to_device($request->fcm, $data,null);

                    }

                }
            }

            return response()->json(['status' => 'success', 'message' => 'Firebase token saved successfully!'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }


    public function profile(Request $request)
    {
        $user = $request->user();

        Helpers::singleExpire($user['id']);

        $role = Helpers::checkRole($user, 'customer');
        if ($role) {
            $user['image'] = config('app.url') . '/storage/profile/' . $user['image'];
            return response()->json(['status' => 'success', 'data' => $user], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }

    public function update_profile(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users,phone,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'birthday' => 'required',
            'gender' => 'required',
            'occupation' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
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
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if ($user) {
            $user = User::find($user['id']);

            $user->name = $request['name'];
            $user->phone = $request['phone'];
            $user->email = $request['email'];
            $user->birthday = $request['birthday'];
            $user->gender = $request['gender'];
            $user->occupation = $request['occupation'];
            $user->province_id = $request['province_id'];
            $user->city_id = $request['city_id'];
            $user->address = $request['address'];
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Profil customer berhasil di update'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'user tidak ditemukan!'], 403);
    }

    public function update_pin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required'
        ], [
            'pin.required' => 'Masukan pin baru!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $user = $request->user();
        $user = User::find($user->id);
        if ($user) {
            $user->password = Hash::make($request->pin);
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Password berhasil di update'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Customer tidak ditemukan!'], 403);
    }

    public function level(Request $request)
    {
        $user = $request->user();
        Helpers::singleExpire($user['id']);

        $belanja = Poin::where('user_id', $user->id)->first();
        $total = Helpers::refresh_total($user->id);
        $belanja->total_pembelian = array_sum($total);
        $belanja->save();
        $level = Helpers::getLevel($user->id);

        return response()->json(['status' => 'success', 'data' => $level], 200);
    }
}
