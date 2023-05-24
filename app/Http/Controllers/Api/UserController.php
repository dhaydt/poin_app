<?php

namespace App\Http\Controllers\Api;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Poin;
use App\Models\PoinHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function update_fcm(Request $request){
        $user = $request->user();
        if($user){
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
            return response()->json(['status' => 'success', 'message' => 'Firebase token saved successfully!'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }


    public function profile(Request $request){
        $user = $request->user();

        $role = Helpers::checkRole($user, 'customer');
        if($role){
            return response()->json(['status' => 'success', 'data' => $user], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);

    }

    public function level(Request $request){
        $user = $request->user();

        $belanja = Poin::where('user_id', $user->id)->first();
        $total = Helpers::refresh_total($user->id);
        $belanja->total_pembelian = array_sum($total);
        $belanja->save();
        $level = Helpers::getLevel($user->id);

        return response()->json(['status' => 'success', 'data' => $level], 200);
    }
}
