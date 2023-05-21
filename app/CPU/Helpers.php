<?php

namespace App\CPU;

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

  public static function level($id){

    return $id;
  }

  public static function checkRole($user, $role){
    return $user->hasRole([$role]);
  }
}
