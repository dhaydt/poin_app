<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Models\PoinHistory;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function broadcast(Request $request){
        // dd($request);
        $province = null;
        $city = null;
        $kelamin = [];
        $pekerjaan = [];

        $users = User::where('is_admin', 0);

        if($request->province){
            $province = $request->province;
            $users = $users->where('province', '!=', null );
            $users = $users->where('province', $province);
        }

        if($request->city){
            $city = $request->city;
            $users = $users->where('city', $city);
        }

        if($request->kelamin){
            $kelamin = $request->kelamin;
            $users = $users->where('gender', '!=', null );
            if(count($kelamin) > 0){
                foreach($kelamin as $k){
                    $users = $users->orWhere('gender', $k);
                }
            }
        }

        if($request->pekerjaan){
            $pekerjaan = $request->pekerjaan;
            $users = $users->where('occupation', '!=', null );
            if(count($pekerjaan) > 0){
                foreach($pekerjaan as $p){
                    $users = $users->orWhere('occupation','like','%'.$p.'%');
                }
            }
        }

        dd($users->get(), $request);
    }

    public function reset($is_admin)
    {
        // dd();
        $check = auth()->user();
        if ($check) {
            $user = User::find($check['id']);
            $role = $user->hasRole(['admin', 'manager']);
            if ($role) {
                $ph = PoinHistory::where(['type' => 'add', 'isreset' => 0])->get();
                foreach ($ph as $p) {
                    $p->isreset = 1;
                    $p->save();
                }

                Helpers::refresh_all_total();
                Notification::make()
                    ->title('Data belanja berhasil direset!')
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('success')
                    ->send();
                return redirect()->back();
            } else {
                Notification::make()
                    ->title('Anda tidak memiliki Akses untuk Reset data belanja!')
                    ->icon('heroicon-o-x-circle')
                    ->iconColor('danger')
                    ->send();
                return redirect()->back();
            }
        } else {
            Notification::make()
                ->title('Anda tidak terautentikasi!')
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->send();
            return redirect()->back();
        }
    }
}
