<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Exports\UsersExport;
use App\Models\Notifications;
use App\Models\NotifReceiver;
use App\Models\PoinHistory;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkExpire(){
        Helpers::checkExpire();
    }
    public function export(){
        return Excel::download(new UsersExport, 'user.xlsx');
    }

    public function changePassword(Request $request){
        $user = auth()->user();
        if($user){
            $validator = Validator::make($request->all(), [
                'password' => 'required|min:8',
                'c_password' => 'required|same:password'
            ], [
                'password.required' => 'Masukan password baru!',
                'password.min' => 'Minimal 8 karakter!',
                'c_password.required' => 'Masukan konfirmasi password!',
                'c_password.same' => 'Password konfirmasi tidak sama!',
            ]);
            if ($validator->fails()) {
                $messages = Helpers::error_processor($validator);
    
                foreach($messages as $m){
                    Notification::make()
                    ->title($m['message'])
                    ->icon('heroicon-o-check-circle')
                    ->iconColor('danger')
                    ->send();
                }
                return redirect()->back();
            }

            $user = User::find(auth()->id());
            $user->password = Hash::make($request['password']);
            $user->save();

            Notification::make()
                ->title('Password berhasil diganti!')
                ->icon('heroicon-o-check-circle')
                ->iconColor('success')
                ->send();
            return redirect()->back();
        }

        Notification::make()
            ->title('Anda tidak terautentikasi!')
            ->icon('heroicon-o-check-circle')
            ->iconColor('danger')
            ->send();
        return redirect()->back();
    }
    public function export_poin(Request $request){
        dd($request);
    }
    public function broadcast(Request $request)
    {
        $notif = new Notifications();
        $notif->title = $request->title;
        $notif->description = $request->description;
        $notif->save();

        $users = User::where(['is_admin' => 0, 'is_notify' => 1])
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

            $data = [
                'title' => $request->title,
                'description' => $request->description
            ];

            $count = [];

            foreach($users as $u){
                $token = $u['fcm'];
                if($token){
                    Helpers::send_push_notif_to_device($token, $data, null);
                    array_push($count, 1);
                    $receive = new NotifReceiver();
                    $receive->notification_id = $notif->id;
                    $receive->user_id = $u['id'];
                    $receive->is_read = 0;
                    $receive->save();
                }

            }


        Notification::make()
            ->title('Broadcast berhasil dikirim ke '. count($users).' customer! diterima oleh '.count($count),' Customer!')
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
