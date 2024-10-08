<?php

namespace App\CPU;

use App\Models\Banner;
use App\Models\Notifications;
use App\Models\NotifReceiver;
use App\Models\Poin;
use App\Models\PoinHistory;
use App\Models\PoinView;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Helpers
{
    public static function getRole(): bool
    {
        $id = auth()->id();
        $user = User::find($id);
        if ($user->hasRole('admin')) {
            return true;
        } else {
            return false;
        }
    }
    public static function getPoinHistory($uid)
    {
        $ph = PoinHistory::with('user', 'outlet')->where(['user_id' => $uid])->orderBy('created_at', 'desc')->get();

        return $ph;
    }
    public static function poinAwal($id)
    {
        $redeem = PoinHistory::where(['type' => 'add', 'user_id' => $id])->get()->pluck('poin')->toArray();
        if (count($redeem) > 0) {
            return array_sum($redeem);
        } else {
            return 0;
        }
    }
    public static function getRedeem($id)
    {
        $redeem = PoinHistory::where(['type' => 'redeem', 'user_id' => $id])->get()->pluck('poin')->toArray();
        if (count($redeem) > 0) {
            return array_sum($redeem);
        } else {
            return 0;
        }
    }
    public static function getLevel($id)
    {
        $total = Poin::where('user_id', $id)->first();
        if ($total) {
            $total = $total['total_pembelian'];
        } else {
            $total = 0;
        }
        $level = 'silver';
        $persentase = $total / 2000000 * 100;
        if ($total >= 2000000 && $total <= 5000000) {
            $level = 'gold';
            $persentase = $total / 5000000 * 100;
        }
        if ($total > 5000000) {
            $level = 'diamond';
            $persentase = 100;
        }

        $data = [
            'level' => $level,
            'persentase' => round($persentase) . ' %',
            'total' => $total
        ];
        return $data;
    }

    public static function saveNotif($title, $desc, $id, $type = null)
    {
        $img = null;
        if ($type == "banner") {
            $banner = Banner::find($id);
            $img = $banner['image'];
        }

        $notif = new Notifications();
        $notif->title = $title;
        $notif->description = $desc;
        $notif->image = $img;
        $notif->save();

        $users = User::where(['is_admin' => 0, 'is_notify' => 1])->get();
        $data = [
            'title' => $title,
            'description' => $desc
        ];

        $img = getenv('APP_URL') . '/storage/' . $img;
        foreach ($users as $u) {
            $token = $u['fcm'];
            if ($token && $u['is_notify'] == 1) {
                Helpers::send_push_notif_to_device($token, $data, $img);
                $receive = new NotifReceiver();
                $receive->notification_id = $notif->id;
                $receive->user_id = $u['id'];
                $receive->is_read = 0;
                $receive->save();
            }
        }
    }

    public static function send_push_notif_to_device($fcm_token, $data, $img)
    {
        $key = getenv('FCM_KEY');
        $url = 'https://fcm.googleapis.com/fcm/send';
        $header = [
            'authorization: key=' . $key . '',
            'content-type: application/json',
        ];

        if (isset($data['order_id']) == false) {
            $data['order_id'] = null;
        }

        // $img = asset('assets/front-end/img/notif.png');
        // $img = 'https://adminbmi.com/assets/images/logo2.png';
        // $img = 'https://ezren.id/assets/front-end/img/ejren.jpg';

        $notif = [
            'title' => $data['title'],
            'body' => $data['description'],
            'image' => $img,
            'order_id' => $data['title'],
            'title_loc_key' => $data['title'],
            'is_read' => 0,
            'icon' => $img,
            'sound' => 'default',
        ];

        $postdata = '{
            "to" : "' . $fcm_token . '",
            "data" : {
                "title" :"' . $data['title'] . '",
                "body" : "' . $data['description'] . '",
                "image" : "' . $img . '",
                "icon" : "' . $img . '",
                "order_id":"' . $data['title'] . '",
                "is_read": 0
                },
            "notification" : ' . json_encode($notif) . '
        }';

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Get URL content
        $result = curl_exec($ch);
        // close handle to release resources
        curl_close($ch);

        return $result;
    }
    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }

        return $err_keeper;
    }

    public static function level($id)
    {

        return $id;
    }

    public static function checkRole($user, $role)
    {
        return $user->hasRole([$role]);
    }

    public static function check_receipt($no)
    {
        $check = PoinHistory::where('no_receipt', $no)->first();
        if ($check) {
            return true;
        } else {
            return false;
        }
    }

    public static function check_customer($phone)
    {
        $user = User::where('phone', $phone)->first();

        return $user;
    }

    public static function poin_counter($amount)
    {
        if ($amount > 100000) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function checkExpire()
    {
        $date = Carbon::now()->addDay();
        $to = $date->format('Y-m-d');
        $from = $date->subDays(365)->format('Y-m-d');

        $ph = PoinHistory::whereDate('created_at', '<', $from)->get();
        foreach ($ph as $p) {
            if ($p->isexpired == 0) {
                $p->isexpired = 1;
                $p->save();

                $user = User::find($p['user_id']);
                if ($user && $user['fcm']) {
                    $data = [
                        'title' => 'Stamp Expired',
                        'description' => 'Your stamp was expired'
                    ];
                    Helpers::send_push_notif_to_device($user['fcm'], $data, null);
                }
            }
        }
    }

    public static function singleExpire($id)
    {
        $date = Carbon::now()->addDay();
        $to = $date->format('Y-m-d');
        $from = $date->subDays(365)->format('Y-m-d');
        // $from = $date->subDay()->format('Y-m-d');

        $ph = PoinHistory::where('user_id', $id)->whereDate('created_at', '<', $from)->get();
        if (count($ph) > 0) {
            foreach ($ph as $p) {
                if ($p->isexpired == 0) {
                    $p->isexpired = 1;
                    $p->save();

                    $user = User::find($id);
                    $data = [
                        'title' => 'Stamp Expired',
                        'description' => 'Your stamp was expired'
                    ];
                    Helpers::send_push_notif_to_device($user['fcm'], $data, null);
                }
            }
        }
        return $ph;
    }

    public static function poin_history($receipt, $amount, $user, $admin, $type, $poin)
    {
        $data = new PoinHistory();
        $data->user_id = $user['id'];
        $data->admin_id = $admin['id'];
        $data->outlet_id = $admin['outlet_id'];
        $data->no_receipt = $receipt;
        $data->pembelian = $amount;
        $data->type = $type;
        $data->poin = $poin;
        $data->isredeem = 0;
        $data->isexpired = 0;
        $data->save();

        if ($type == 'redeem') {
            $date = Carbon::now()->addDay();
            $to = $date->format('Y-m-d');
            $from = $date->subDays(365)->format('Y-m-d');
            $poins = PoinHistory::where(['user_id' => $user['id'], 'type' => 'add', 'isredeem' => 0, 'isexpired' => 0, 'isreset' => 0])->whereBetween('created_at', [$from, $to])->orderBy('created_at', 'asc')->limit($poin)->get();
            // return $poins;
            foreach ($poins as $p) {
                $p->isredeem = 1;
                $p->save();
            }
        } else {
            $nView = new PoinView();
            $nView->user_id = $user['id'];
            $nView->ph_id = $data['id'];
            $nView->updated_at = $data['created_at'];
            $nView->save();
        }
    }

    public static function upload(string $dir, string $format, $image = null)
    {
        if ($image != null) {
            $imageName = Carbon::now()->toDateString() . '-' . uniqid() . '.' . $format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
        } else {
            $imageName = 'def.png';
        }

        return $imageName;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        // dd($dir.$old_image);
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = Helpers::upload($dir, $format, $image);

        return $imageName;
    }

    public static function calc_poin($id)
    {
        // $date = Carbon::now()->addDay();
        // $to = $date->format('Y-m-d');
        // $from = $date->subDays(365)->format('Y-m-d');
        // $poin = PoinHistory::where(['user_id' => $id, 'type' => 'add'])->whereBetween('created_at', [$from, $to])->pluck('poin')->toArray();

        $poin = PoinHistory::where(['user_id' => $id, 'type' => 'add', 'isredeem' => 0, ])->pluck('poin')->toArray();
        $redeem = PoinHistory::where(['user_id' => $id, 'type' => 'add', 'isredeem' => 1, ])->pluck('poin')->toArray();

        $p = Poin::where('user_id', $id)->first();
        if (!$p) {
            $p = new Poin();
            $p->user_id = $id;
            $p->total_pembelian = 0;
        }
        $p->poin = array_sum($poin);
        $p->redeemed = array_sum($redeem);
        $p->save();

        return $p;
    }

    public static function countPoint($id) {
        $poin = PoinHistory::where(['user_id' => $id, 'type' => 'add', 'isredeem' => 0])->pluck('poin')->toArray();
        $redeem = PoinHistory::where(['user_id' => $id, 'type' => 'add', 'isredeem' => 1])->pluck('poin')->toArray();
        $redeemed = PoinHistory::where(['user_id' => $id, 'type' => 'redeem'])->pluck('poin')->toArray();
        // dd($id,$poin, $redeem, $redeemed);
        $p = Poin::where('user_id', $id)->first();
        if (!$p) {
            $p = new Poin();
            $p->user_id = $id;
            $p->total_pembelian = 0;
        }
        $p->poin = array_sum($poin);
        $p->redeemed = array_sum($redeem);
        $p->save();
    }

    public static function refresh_total($user_id)
    {
        $total = PoinHistory::where(['user_id' => $user_id, 'type' => 'add', 'isreset' => 0])->pluck('pembelian')->toArray();
        return $total;
    }

    public static function refresh_all_total()
    {
        $ph =  Poin::get();
        foreach ($ph as $p) {
            $poin = PoinHistory::where(['user_id' => $p['user_id'], 'type' => 'add', 'isreset' => 0])->pluck('pembelian')->toArray();

            $p->total_pembelian = array_sum($poin);
            $p->save();
        }
    }

    public static function getPekerjaan()
    {
        $work = Work::get();
        return $work;
    }

    public function getCountry()
    {
        return \Indonesia::allProvinces();
    }
}
