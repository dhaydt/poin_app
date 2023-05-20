<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Outlet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function outlet(){
        $outlet = Outlet::orderBy('created_at', 'desc')->get();

        foreach($outlet as $b){
            $b['image'] = getenv('APP_URL').'/storage/'.$b['image'];
        }

        return response()->json(['status' => 'success', 'data' => $outlet], 200);
    }
    public function banner(){
        $banner = Banner::orderBy('updated_at', 'desc')->get();

        $banners = [];

        foreach($banner as $b){
            $d['id'] = $b['id'];
            $d['title'] = $b['title'];
            $d['image'] = getenv('APP_URL').'/storage/'.$b['image'];
            array_push($banners, $d);
        }

        return response()->json(['status' => 'success', 'data' => $banners], 200);
    }

    public function banner_details($id){
        $banner = Banner::find($id);
        if($banner){
            $banner['image'] = getenv('APP_URL').'/storage/'.$banner['image'];
        }else{
            $banner = [];
        }
        return response()->json(['status' => 'success', 'data' => $banner], 200);

    }
    public function outlet_details($id){
        $banner = Outlet::find($id);
        if($banner){
            $banner['image'] = getenv('APP_URL').'/storage/'.$banner['image'];
        }else{
            $banner = [];
        }
        return response()->json(['status' => 'success', 'data' => $banner], 200);

    }
}
