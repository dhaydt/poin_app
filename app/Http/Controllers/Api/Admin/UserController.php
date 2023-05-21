<?php

namespace App\Http\Controllers\Api\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request){
        $user = $request->user();

        $role = Helpers::checkRole($user, 'karyawan');
        if($role){
            $outlet = Outlet::find($user['outlet_id']);
            $data = [
                'name' => $user['name'],
                'phone' => $user['phone'],
                'email' => $user['email'],
                'outlet' => $outlet ? $outlet['name'] : 'invalid outlet',
            ];
            return response()->json(['status' => 'success', 'data' => $data], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);

    }
}
