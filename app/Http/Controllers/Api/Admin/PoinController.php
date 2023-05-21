<?php

namespace App\Http\Controllers\Api\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Poin;
use App\Models\PoinHistory;
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
                if($customer){
                    $check_poin = Poin::where("user_id", $customer['id'])->first();
                    $poin = Helpers::poin_counter($request->amount);
                    
                    if(!$check_poin){
                        $check_poin = new Poin();
                        $check_poin->poin = 0;
                        $check_poin->user_id = $customer['id'];
                    }
                    Helpers::poin_history($request->receipt, $request->amount, $customer, $user, 'add', $poin);
                    $total = PoinHistory::where(['user_id' => $customer['id'], 'type' => 'add'])->pluck('pembelian')->toArray();
    
                    $check_poin->poin += $poin;
                    $check_poin->total_pembelian = array_sum($total);
                    $check_poin->save();
    
                    return response()->json(['status' => 'success', 'message' => 'Poin berhasil berhasilkan ditambahkan sebanyak '.$poin], 200);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Customer tidak ditemukan'], 200);
                }
            }
        }

        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }

    public function redeem_stamp(Request $request){
        $user = $request->user();
        $role = Helpers::checkRole($user, 'karyawan');
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'total_stamp' => 'required',
            'redeem_stamp' => 'required',
        ], [
            'phone.required' => 'Masukan nomor handphone!',
            'total_stamp.required' => 'Masukan total stamp!',
            'redeem_stamp.required' => 'Masukan stamp yang akan di redeem!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if($role){
            $customer = Helpers::check_customer($request->phone);
            if($customer){
                $total_poin = Poin::where('user_id', $customer['id'])->first();
                if($total_poin){
                    if($total_poin['poin'] !== $request->total_stamp){
                        return response()->json(['status' => 'error', 'message' => 'Total poin tidak sesuai! poin saat ini adalah '.$total_poin['poin']], 200);
                    }
                    if($total_poin['poin'] < $request->redeem_stamp){
                        return response()->json(['status' => 'error', 'message' => 'Stamp tidak mencukupi'], 200);
                    }
                    Helpers::poin_history(null, 0, $customer, $user, 'redeem', $request->redeem_stamp);
                    $total_poin->poin -= $request['redeem_stamp'];
                    $total_poin->save();

                    return response()->json(['status' => 'success', 'message' => 'Poin berhasil di redeem. sisa poin '.$total_poin->poin], 200);
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Customer tidak memiliki poin'], 200);
                }
                
            }else{
                return response()->json(['status' => 'error', 'message' => 'Customer tidak ditemukan'], 200);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }
}
