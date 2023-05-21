<?php

namespace App\CPU;

use App\Models\PoinHistory;
use App\Models\User;

class Helpers
{
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
    $data->save();
  }
}
