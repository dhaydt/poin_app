<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\PoinHistory;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    protected function getCards(): array
    {
        $now = Carbon::now();
        $nowMonth = $now->month;
        $nowYear = $now->year;
        // $yest = $now - 1;

        $usersplit = \DB::table('users')->where('is_admin', 0)->whereYear('created_at',$nowYear)->select(DB::raw('count(id) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                    ->groupby('year','month')
                    ->get();
        $arrayUser = [];

        foreach($usersplit as $u){
            for($i = 1; $i <= $nowMonth; $i++){
                // dd('call',$i, $u->month);
                if($i === $u->month){
                    $arrayUser[$i] = $u->total;
                }else{
                    if(!isset($arrayUser[$i])){
                        $arrayUser[$i] = 0;
                    }
                }
            }
        }

        $stampsplit = \DB::table('poin_histories')->where('type', 'add')->whereYear('created_at',$nowYear)->select(DB::raw('count(poin) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                    ->groupby('year','month')
                    ->get();

        $arrayStamp = [];
        foreach($stampsplit as $u){
            for($i = 1; $i <= $nowMonth; $i++){
                // dd('call',$i, $u->month);
                if($i === $u->month){
                    $arrayStamp[$i] = $u->total;
                }else{
                    if(!isset($arrayStamp[$i])){
                        $arrayStamp[$i] = 0;
                    }
                }
            }
        }
        
        $redeemsplit = \DB::table('poin_histories')->where('type', 'redeem')->whereYear('created_at',$nowYear)->select(DB::raw('count(poin) as `total`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                    ->groupby('year','month')
                    ->get();

        $redeemStamp = [];
        foreach($redeemsplit as $u){
            for($i = 1; $i <= $nowMonth; $i++){
                // dd('call',$i, $u->month);
                if($i === $u->month){
                    $redeemStamp[$i] = $u->total;
                }else{
                    if(!isset($redeemStamp[$i])){
                        $redeemStamp[$i] = 0;
                    }
                }
            }
        }

        $cust = count(User::where('is_admin', 0)->get());
        $custNew = count(User::where('is_admin', 0)->whereMonth('created_at', $nowMonth)->get());

        $stamp = array_sum(PoinHistory::where('type', 'add')->get()->pluck('poin')->toArray());
        $stampNew = array_sum(PoinHistory::where('type', 'add')->whereMonth('created_at', $nowMonth)->get()->pluck('poin')->toArray());
        
        $redeem = array_sum(PoinHistory::where('type', 'redeem')->get()->pluck('poin')->toArray());
        $redeemNew = array_sum(PoinHistory::where('type', 'redeem')->whereMonth('created_at', $nowMonth)->get()->pluck('poin')->toArray());

        return [
            Card::make('Total Customer '.$nowYear, $cust)
                ->description($custNew . ' customer bertambah pada bulan '.$nowMonth)
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($arrayUser)
                ->color('success'),
            Card::make('Total Stamps '.$nowYear, $stamp)
                ->description($stampNew.' stamp bertambah pada bulan '.$nowMonth)
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($arrayStamp)
                ->color('success'),
            Card::make('Total Redeem '.$nowYear, $redeem)
                ->description($redeemNew.' redeem bertambah pada bulan '.$nowMonth)
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($redeemStamp)
                ->color('success'),
        ];
    }
}
