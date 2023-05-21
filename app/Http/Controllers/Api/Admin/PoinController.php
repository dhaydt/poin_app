<?php

namespace App\Http\Controllers\Api\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Poin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoinController extends Controller
{
    public function add_stamp(Request $request)
    {
        $user = $request->user();
        $role = Helpers::checkRole($user, 'karyawan');
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'receipt' => 'required',
            'amount' => 'required',
        ], [
            'phone.required' => 'Masukan nomor handphone!',
            'receipt.required' => 'Masukan no receipt!',
            'amount.required' => 'Masukan nilai belanja!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if ($role) {
            $check = Helpers::check_receipt($request->receipt);
            if ($check) {
                return response()->json(['status' => 'error', 'message' => 'No receipt sudah pernah di masukkan!'], 200);
            } else {
                $customer = Helpers::check_customer($request->phone);
                $check_poin = Poin::where("user_id", $customer['id'])->first();
                $poin = Helpers::poin_counter($request->amount);

                if(!$check_poin){
                    $check_poin = new Poin();
                    $check_poin->poin = 0;
                    $check_poin->user_id = $customer['id'];
                }
                $check_poin->poin += $poin;
                $check_poin->total_pembelian = $request->amount;
                Helpers::poin_history($request, $customer, $user, 'add', $poin);
                $check_poin->save();

                return response()->json(['status' => 'success', 'message' => 'Poin berhasil berhasilkan ditambahkan sebanyak '.$poin], 200);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }
}
