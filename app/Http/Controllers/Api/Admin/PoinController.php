<?php

namespace App\Http\Controllers\Api\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Models\NotifReceiver;
use App\Models\Poin;
use App\Models\PoinHistory;
use Carbon\Carbon;
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
                if ($customer) {
                    $poin = Helpers::poin_counter($request->amount);
                    $total = PoinHistory::where('user_id', $customer['id'])->where(['isexpired' => 0, 'type' => 'add'])->get()->pluck('poin')->toArray();
                    // dd(array_sum($total));
                    $token = $customer['fcm'];
                    if (array_sum($total) >= 6) {
                        Helpers::calc_poin($customer['id']);
                        if ($token) {
                            $data = [
                                "title" => "Stamp status",
                                "description" => "Your points have reached the limit!"
                            ];
                            $notif = new Notifications();
                            $notif->title = $data['title'];
                            $notif->description = $data['description'];
                            $notif->save();

                            Helpers::send_push_notif_to_device($token, $data, null);

                            $receive = new NotifReceiver();
                            $receive->notification_id = $notif->id;
                            $receive->user_id = $customer['id'];
                            $receive->is_read = 0;
                            $receive->save();
                        }
                        return response()->json(['status' => 'error', 'message' => 'Poin anda sudah mencapai limit'], 403);
                    }
                    if ($poin > 0) {
                        $check_poin = Poin::where("user_id", $customer['id'])->first();
                        $total = Helpers::refresh_total($customer['id']);
                        if (!$check_poin) {
                            $check_poin = new Poin();
                            $check_poin->poin = 0;
                            $check_poin->user_id = $customer['id'];
                        }
                        $check_poin->poin += $poin;
                        $check_poin->total_pembelian = array_sum($total);


                        $check_poin->save();
                        Helpers::poin_history($request->receipt, $request->amount, $customer, $user, 'add', $poin);
                        Helpers::calc_poin($customer['id']);
                        if ($token) {
                            $data = [
                                "title" => "Stamp status",
                                "description" => "Your points have been added successfully!"
                            ];
                            $notif = new Notifications();
                            $notif->title = $data['title'];
                            $notif->description = $data['description'];
                            $notif->save();

                            Helpers::send_push_notif_to_device($token, $data, null);

                            $receive = new NotifReceiver();
                            $receive->notification_id = $notif->id;
                            $receive->user_id = $customer['id'];
                            $receive->is_read = 0;
                            $receive->save();
                        }
                        return response()->json(['status' => 'success', 'message' => 'Poin berhasil berhasilkan ditambahkan sebanyak ' . $poin], 200);
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Customer tidak ditemukan'], 200);
                }
            }
        }

        return response()->json(['status' => 'error', 'message' => 'not authorized'], 200);
    }

    public function before_redeem(Request $request)
    {
        $user = $request->user();
        $role = Helpers::checkRole($user, 'karyawan');
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ], [
            'phone.required' => 'Masukan nomor handphone!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        if ($role) {
            $customer = Helpers::check_customer($request->phone);
            if ($customer) {
                Helpers::calc_poin($customer['id']);
                $total_poin = Poin::where('user_id', $customer['id'])->first();
                $poin = $total_poin['poin'];
                $redeem = 0;

                if (in_array($poin, [1, 2])) {
                    $redeem = 2;
                }

                if (in_array($poin, [3, 4, 5])) {
                    $redeem = 4;
                }

                if ($poin > 5) {
                    $redeem = 6;
                }

                $data = [
                    "poin" => $poin,
                    "redeem" => $redeem
                ];
                return response()->json(['status' => 'success', 'data' => $data], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Customer tidak ditemukan'], 403);
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 403);
    }

    public function redeem_stamp(Request $request)
    {
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

        if ($role) {
            $customer = Helpers::check_customer($request->phone);
            if ($customer) {
                $total_poin = Poin::where('user_id', $customer['id'])->first();
                if ($total_poin) {
                    if ($total_poin['poin'] !== $request->total_stamp) {
                        return response()->json(['status' => 'error', 'message' => 'Total poin tidak sesuai! poin saat ini adalah ' . $total_poin['poin']], 200);
                    }
                    if (in_array($request->redeem_stamp, [2, 4, 6])) {
                        if ($total_poin['poin'] < $request->redeem_stamp) {
                            return response()->json(['status' => 'error', 'message' => 'Stamp tidak mencukupi'], 200);
                        }
                        Helpers::poin_history(null, 0, $customer, $user, 'redeem', $request->redeem_stamp);
                        Helpers::calc_poin($customer['id']);
                        $token = $customer['fcm'];
                        if ($token) {
                            $total_poin = Poin::where('user_id', $customer['id'])->first();
                            $data = [
                                "title" => "Stamp redeem",
                                "description" => "Your points have been successfully redeemed by " . $request->redeem_stamp
                            ];
                            $notif = new Notifications();
                            $notif->title = $data['title'];
                            $notif->description = $data['description'];
                            $notif->save();

                            Helpers::send_push_notif_to_device($token, $data, null);

                            $receive = new NotifReceiver();
                            $receive->notification_id = $notif->id;
                            $receive->user_id = $customer['id'];
                            $receive->is_read = 0;
                            $receive->save();
                        }

                        return response()->json(['status' => 'success', 'message' => 'Poin berhasil di redeem'], 200);
                    } else {
                        return response()->json(['status' => 'error', 'message' => 'Nilai stamp yang diredeem hanya bisa 2, 4 atau 6'], 403);
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Customer tidak memiliki poin'], 403);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Customer tidak ditemukan'], 403);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'not authorized'], 403);
    }
}
