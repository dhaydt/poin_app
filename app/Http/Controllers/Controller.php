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

    public function broadcast(Request $request)
    {
        $users = User::where('is_admin', 0)
            ->where(function ($query) use ($request) {
                if ($request->province_id !== null) {
                    $query->where('province_id', $request->province_id);
                }
            })->where(function ($query) use ($request) {
                if ($request->city_id !== null) {
                    $query->where('city_id', $request->city_id);
                }
            })->where(function ($q) use($request){
                if($request->pekerjaan){
                    $q->whereIn('occupation', $request->pekerjaan);
                }
            })->where(function ($q) use($request){
                if($request->kelamin){
                    $q->whereIn('gender', $request->kelamin);
                }
            })->get();

        Notification::make()
            ->title('Broadcast berhasil dikirim ke '. count($users).' customer!')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
        return redirect()->back();
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
