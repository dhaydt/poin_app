<?php

namespace App\Http\Controllers\Api;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

        $level = Helpers::getLevel($user->id);

        return response()->json(['status' => 'success', 'data' => $level], 200);
    }
}
