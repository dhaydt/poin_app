<?php

namespace App\CPU;

use App\Models\Poin;
use App\Models\PoinHistory;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;

class Helpers
{
  public static function getLevel($id){
    $total = Poin::where('user_id', $id)->first();
    if($total){
      $total = $total['total_pembelian'];
    }else{
      $total = 0;
    }
    $level = 'silver';
    $persentase = $total / 2000000 * 100;
    if($total >= 2000000 && $total <= 5000000){
      $level = 'gold';
      $persentase = $total / 5000000 * 100;
    }
    if($total > 5000000){
      $level = 'bronze';
      $persentase = 100;
    }
    
    $data = [
      'level' => $level,
      'persentase' => $persentase.' %',
      'total' => $total
    ];
    return $data;
  }
  public static function send_push_notif_to_device($fcm_token, $data)
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
        $img = 'https://ezren.id/assets/front-end/img/e.ico';
        $img = 'https://ezren.id/assets/front-end/img/ejren.jpg';

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
    }
  }

  public static function calc_poin($id)
  {
    // $date = Carbon::now()->addDay();
    // $to = $date->format('Y-m-d');
    // $from = $date->subDays(365)->format('Y-m-d');
    // $poin = PoinHistory::where(['user_id' => $id, 'type' => 'add'])->whereBetween('created_at', [$from, $to])->pluck('poin')->toArray();

    $poin = PoinHistory::where(['user_id' => $id, 'type' => 'add', 'isredeem' => 0, 'isexpired' => 0, 'isreset' => 0])->pluck('poin')->toArray();

    $p = Poin::where('user_id', $id)->first();
    $p->poin = array_sum($poin);
    $p->save();

    return $p;
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

  public static function getPekerjaan(){
    $work = Work::get();
    return $work;
  }

  public function getCountry(){
    return \Indonesia::allProvinces();
  }
}
